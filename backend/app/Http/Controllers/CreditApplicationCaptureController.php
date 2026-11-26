<?php

namespace App\Http\Controllers;

use App\Models\{CreditAdvisor, CreditApplication, CreditApplicationField, CreditApplicationGuarantor, CreditApplicationStatusHistory, CreditBranch, CreditClient, CreditProduct, CreditWorkflowInstance, CreditWorkflowTask, CreditWorkflowVersion};
use App\Http\Requests\StoreCreditClientRequest;
use App\Http\Requests\UpdateCreditClientRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use App\Services\{CreditApplicationService, CreditClientService};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Gate, Validator};
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

final class CreditApplicationCaptureController extends Controller
{
    private function permit(string $action): void
    {
        Gate::authorize('use-permission', 'credit_originacion_solicitudes.'.$action);
    }

    private function advisors(Request $request)
    {
        return CreditAdvisor::query()->where('active', true)->whereIn('branch_id', CreditBranch::query()->where('active', true)->select('id'))
            ->when(!$request->user()->is_superadmin, fn ($q) => $q->where('user_id', $request->user()->id));
    }

    private function products(Request $request)
    {
        return CreditProduct::query()->where('status', 'active')->whereHas('currentVersion')
            ->when(!$request->user()->is_superadmin, fn ($q) => $q->whereIn('company_id', $this->advisors($request)->select('company_id')));
    }

    private function applications(Request $request)
    {
        return CreditApplication::query()->when(!$request->user()->is_superadmin,fn ($q)=>$q->whereIn('advisor_id',$this->advisors($request)->select('id')));
    }

    public function index(Request $request)
    {
        $this->permit('ver');
        $filter = $request->validate(['filter.application_number'=>'nullable|string|max:255','per_page'=>'nullable|integer|between:1,100']);
        $page = $this->applications($request)->with('client')->when($filter['filter']['application_number'] ?? null,fn ($q,$folio)=>$q->where('application_number',$folio))->orderByDesc('created_at')->paginate($filter['per_page'] ?? 25);
        $page->through(fn ($a)=>['id'=>$a->id,'application_number'=>$a->application_number,'client_name'=>trim(($a->client?->first_name ?? '').' '.($a->client?->last_name ?? '')),'requested_amount'=>$a->requested_amount,'status'=>$a->status]);
        return response()->json(['data'=>['data'=>$page->items(),'meta'=>['current_page'=>$page->currentPage(),'last_page'=>$page->lastPage(),'total'=>$page->total()]]]);
    }

    public function productsList(Request $request)
    {
        $this->permit('crear');
        return response()->json(['data' => $this->products($request)->orderBy('name')->get(['id','name'])]);
    }

    public function configuration(Request $request, string $id)
    {
        $this->permit('crear');
        $product = $this->products($request)->findOrFail($id);
        $version = $product->currentVersion()->firstOrFail();
        return response()->json(['data'=>$this->configurationData($request,$product,$version)]);
    }

    private function configurationData(Request $request, $product, $version): array
    {
        $advisors = $this->advisors($request)->where('company_id', $product->company_id)->get();
        $own = $advisors->where('user_id', $request->user()->id);
        return [
            'product' => $product, 'configuration' => $version,
            'fields' => $version->creditProductFields()->where('visible', true)->with('customField')->orderBy('display_order')->get(),
            'documents' => $version->creditProductDocuments()->with('documentType')->orderBy('display_order')->get(),
            'advisors' => $advisors->map(fn ($a) => ['id'=>$a->id,'branch_id'=>$a->branch_id,'name'=>DB::table('users')->where('id',$a->user_id)->value('name') ?? $a->employee_code])->values(),
            'branches' => CreditBranch::query()->where('company_id',$product->company_id)->whereIn('id',$advisors->pluck('branch_id'))->get(['id','name']),
            'assignment' => $own->count() === 1 ? $own->first()->only(['id','branch_id']) : null,
        ];
    }

    public function store(Request $request, CreditClientService $clients, CreditApplicationService $applications)
    {
        $this->permit('crear');
        $data = $request->validate($this->captureRules());
        $stored = [];
        try {
            $record = DB::transaction(function () use ($request,$data,$clients,$applications,&$stored) {
                $product = $this->products($request)->lockForUpdate()->findOrFail($data['product_id']);
                $version = $product->currentVersion()->firstOrFail();
                abort_unless($version->id === $data['product_version_id'], 409, 'El producto cambió. Vuelva a seleccionarlo.');
                $own = $this->advisors($request)->where('company_id',$product->company_id)->where('user_id',$request->user()->id)->get();
                $advisor = $own->count() === 1 ? $own->first() : $this->advisors($request)->where('company_id',$product->company_id)->where('branch_id',$data['branch_id'] ?? null)->findOrFail($data['advisor_id'] ?? '');
                $branch = CreditBranch::query()->where('company_id',$product->company_id)->where('active',true)->findOrFail($advisor->branch_id);
                Validator::make($data, ['requested_amount'=>'numeric|between:'.$version->min_amount.','.$version->max_amount,'requested_term'=>'integer|between:'.$version->min_term.','.$version->max_term])->validate();
                $rules = (new StoreCreditClientRequest())->rules();
                $rules['addresses'] = ['required','array','size:1'];
                $rules['bank_accounts'] = ['required','array','size:1'];
                $clientData = Validator::make(array_merge($data['client'], ['company_id'=>$product->company_id]), $rules)->validate();
                foreach (['curp','rfc'] as $key) {
                    if (!empty($clientData[$key]) && CreditClient::query()->where('company_id',$product->company_id)->where($key,$clientData[$key])->exists()) {
                        throw ValidationException::withMessages(['client.'.$key=>'El cliente ya existe. No se permite duplicar su identidad.']);
                    }
                }
                $clientData['addresses'][0]['primary'] = $clientData['addresses'][0]['active'] = true;
                $clientData['bank_accounts'][0]['primary'] = $clientData['bank_accounts'][0]['active'] = true;
                $fields = $version->creditProductFields()->where('visible',true)->with('customField')->get();
                $values = $data['fields'] ?? [];
                foreach ($fields as $field) {
                    $value = $values[$field->custom_field_id] ?? null;
                    if ($field->required && ($value === null || $value === '')) throw ValidationException::withMessages(['fields'=>'Complete '.$field->customField->label]);
                }
                if (array_diff(array_keys($values),$fields->pluck('custom_field_id')->all())) throw ValidationException::withMessages(['fields'=>'Campo ajeno al producto.']);
                $docs = collect($data['documents'] ?? []);
                $requirements = $version->creditProductDocuments()->get();
                if ($docs->pluck('document_type_id')->diff($requirements->pluck('document_type_id'))->isNotEmpty()) throw ValidationException::withMessages(['documents'=>'Documento ajeno al producto.']);
                foreach ($requirements as $requirement) {
                    $count = $docs->where('document_type_id',$requirement->document_type_id)->count();
                    if (($requirement->required && $count < $requirement->min_files) || $count > $requirement->max_files) throw ValidationException::withMessages(['documents'=>'Cantidad de archivos inválida para un requisito.']);
                }
                $workflow = CreditWorkflowVersion::query()->where('status','published')->whereHas('workflow',fn ($q)=>$q->where('company_id',$product->company_id)->where('enabled',true)->where(fn ($q)=>$q->where('product_id',$product->id)->orWhereNull('product_id')))
                    ->orderByRaw('CASE WHEN workflow_id IN (SELECT id FROM credit_workflows WHERE product_id = ?) THEN 0 ELSE 1 END',[$product->id])->orderByDesc('is_default')->orderByDesc('version')->first();
                abort_unless($workflow,422,'No hay workflow publicado para este producto.');
                $step = $workflow->creditWorkflowSteps()->where('is_initial',true)->sole();
                $client = $clients->create($clientData);
                $address = $client->creditClientAddresses()->firstOrFail()->creditClientAddressVersions()->firstOrFail();
                $account = $client->creditClientBankAccounts()->firstOrFail();
                $items = collect($data['financial_items'] ?? []);
                $application = $applications->create([
                    'client_id'=>$client->id,'product_version_id'=>$version->id,'advisor_id'=>$advisor->id,'branch_id'=>$branch->id,
                    'address_version_id'=>$address->id,'bank_account_id'=>$account->id,'application_number'=>'SOL-'.Str::ulid(),
                    'requested_amount'=>$data['requested_amount'],'requested_term'=>$data['requested_term'],
                    'declared_income'=>$items->where('entry_type','income')->sum('amount'),'declared_expenses'=>$items->where('entry_type','expense')->sum('amount'),
                    'financial_items'=>$items->all(),'documents'=>$docs->all(),
                ], $request->user()->id);
                $stored = $application->creditApplicationDocuments->pluck('storage_path')->all();
                foreach ($values as $key=>$value) CreditApplicationField::create(['application_id'=>$application->id,'custom_field_id'=>$key,'field_value'=>['value'=>$value]]);
                if (!empty($data['guarantor'])) CreditApplicationGuarantor::create(['application_id'=>$application->id,...$data['guarantor']]);
                $instance = CreditWorkflowInstance::create(['application_id'=>$application->id,'workflow_version_id'=>$workflow->id,'current_step_id'=>$step->id,'started_at'=>now(),'started_by'=>$request->user()->id]);
                CreditWorkflowTask::create(['instance_id'=>$instance->id,'step_id'=>$step->id,'branch_id'=>$branch->id,'assigned_to'=>$advisor->user_id,'task_type'=>$step->step_type,'assigned_at'=>now()]);
                CreditApplicationStatusHistory::create(['application_id'=>$application->id,'to_status'=>'captured','changed_by'=>$request->user()->id,'changed_at'=>now()]);
                return $application;
            });
        } catch (\Throwable $e) {
            if ($stored) \Illuminate\Support\Facades\Storage::disk('local')->delete($stored);
            throw $e;
        }
        return response()->json(['data'=>['id'=>$record->id]],201);
    }

    private function captureRules(): array
    {
        return [
            'product_id'=>'required|uuid', 'product_version_id'=>'required|uuid',
            'client'=>'required|array', 'advisor_id'=>'nullable|uuid', 'branch_id'=>'nullable|uuid',
            'requested_amount'=>'required|numeric|gt:0', 'requested_term'=>'required|integer|min:1',
            'financial_items'=>'array|max:200', 'financial_items.*.entry_type'=>'required|in:income,expense',
            'financial_items.*.concept'=>'required|string|max:255', 'financial_items.*.amount'=>'required|numeric|gt:0',
            'financial_items.*.frequency'=>'required|in:monthly,weekly,biweekly,fortnightly,annual,daily,quarterly,yearly',
            'guarantor'=>'nullable|array:full_name,rfc,relationship,phone,monthly_income',
            'guarantor.full_name'=>'required_with:guarantor|string|max:255', 'guarantor.relationship'=>'required_with:guarantor|string|max:255',
            'guarantor.rfc'=>'nullable|string|max:13','guarantor.phone'=>'nullable|string|max:20','guarantor.monthly_income'=>'nullable|numeric|min:0',
            'fields'=>'array', 'documents'=>'array|max:30', 'documents.*.document_type_id'=>'required|uuid',
            'documents.*.file'=>'required|file|max:10240|mimes:pdf,jpg,jpeg,png',
        ];
    }

    public function edit(Request $request,string $id)
    {
        $this->permit('editar');
        $record = $this->applications($request)->findOrFail($id);
        abort_unless($record->status === 'captured',422,'Solo se pueden editar solicitudes en captura.');
        $record->load(['client','addressVersion.address','bankAccount','productVersion.product','creditApplicationGuarantors','creditApplicationFields','creditApplicationFinancialItems','creditApplicationDocuments']);
        $data=$record->toArray();
        $data['credit_application_documents']=$record->creditApplicationDocuments()->whereDoesntHave('creditApplicationDocuments')->get(['id','document_type_id','original_filename','status'])->toArray();
        return response()->json(['data'=>array_merge($this->configurationData($request,$record->productVersion->product,$record->productVersion),['application'=>$data])]);
    }

    public function updateCapture(Request $request,string $id,CreditClientService $clients)
    {
        $this->permit('editar');
        $data=$request->validate($this->captureRules()+[
            'has_guarantor'=>'required|boolean',
            'replacements'=>'sometimes|array|max:30',
            'replacements.*'=>'required|file|max:10240|mimes:pdf,jpg,jpeg,png',
        ]);
        $stored=[];
        try {
            $record=DB::transaction(function() use($request,$id,$data,$clients,&$stored){
                $record=$this->applications($request)->lockForUpdate()->findOrFail($id);
                abort_unless($record->status==='captured',422,'Solo se pueden editar solicitudes en captura.');
                $record->load(['productVersion.product','client','addressVersion.address','bankAccount']);
                $version=$record->productVersion;
                $product=$version->product;
                abort_unless($data['product_id']===$product->id && $data['product_version_id']===$version->id,422,'No se puede cambiar el producto de una solicitud existente.');
                Validator::make($data,['requested_amount'=>'numeric|between:'.$version->min_amount.','.$version->max_amount,'requested_term'=>'integer|between:'.$version->min_term.','.$version->max_term])->validate();
                $advisor=$this->advisors($request)->where('company_id',$product->company_id)->where('branch_id',$data['branch_id']??null)->findOrFail($data['advisor_id']??'');
                $branch=CreditBranch::query()->where('company_id',$product->company_id)->where('active',true)->findOrFail($advisor->branch_id);
                $rules=(new UpdateCreditClientRequest())->rules();
                $rules['addresses']=['required','array','size:1'];
                $rules['bank_accounts']=['required','array','size:1'];
                $rules['first_name']=['required','string','max:255'];
                $rules['last_name']=['required','string','max:255'];
                $clientData=Validator::make(array_merge($data['client'],['company_id'=>$product->company_id]),$rules)->validate();
                foreach(['rfc','curp'] as $key){
                    if(!empty($clientData[$key])&&CreditClient::query()->where('company_id',$product->company_id)->where($key,$clientData[$key])->where('id','!=',$record->client_id)->exists())throw ValidationException::withMessages(['client.'.$key=>'El identificador pertenece a otro cliente.']);
                }
                $address=$clientData['addresses'][0];
                $account=$clientData['bank_accounts'][0];
                abort_unless(!isset($address['id'])||$address['id']===$record->addressVersion?->address_id,422,'Domicilio ajeno a la solicitud.');
                abort_unless(!isset($account['id'])||$account['id']===$record->bank_account_id,422,'Cuenta ajena a la solicitud.');
                // A changed bank account is a new record; historical operations retain the original.
                if($record->bankAccount){
                    $bankKeys=['bank_code','bank_name','holder_name','clabe','account_last4','account_type'];
                    foreach($bankKeys as $key){if((string)($account[$key]??'')!==(string)($record->bankAccount->$key??'')){unset($account['id']);break;}}
                }
                $clientData['addresses']=[$address];$clientData['bank_accounts']=[$account];
                $fields=$version->creditProductFields()->where('visible',true)->with('customField')->get();
                $values=$data['fields']??[];
                if(array_diff(array_keys($values),$fields->pluck('custom_field_id')->all()))throw ValidationException::withMessages(['fields'=>'Campo ajeno al producto.']);
                foreach($fields as $field){if($field->required&&(!isset($values[$field->custom_field_id])||$values[$field->custom_field_id]===''))throw ValidationException::withMessages(['fields'=>'Complete '.$field->customField->label]);}
                $requirements=$version->creditProductDocuments()->get()->keyBy('document_type_id');
                $current=$record->creditApplicationDocuments()->whereDoesntHave('creditApplicationDocuments')->get()->keyBy('id');
                $docs=collect($data['documents']??[]);
                foreach($docs as $doc){if(!$requirements->has($doc['document_type_id']))throw ValidationException::withMessages(['documents'=>'Documento ajeno al producto.']);}
                foreach($data['replacements']??[] as $docId=>$file){if(!$current->has($docId)||!$requirements->has($current[$docId]->document_type_id))throw ValidationException::withMessages(['documents'=>'Documento ajeno o sustituido.']);}
                foreach($requirements as $req){$count=$current->where('document_type_id',$req->document_type_id)->count()+$docs->where('document_type_id',$req->document_type_id)->count();if(($req->required&&$count<$req->min_files)||$count>$req->max_files)throw ValidationException::withMessages(['documents'=>'Cantidad de archivos inválida.']);}
                $before=Arr::only($record->getAttributes(),['requested_amount','requested_term','declared_income','declared_expenses','advisor_id','branch_id','address_version_id','bank_account_id']);
                $client=$clients->update($record->client_id,$clientData);
                $parent=isset($address['id'])?$client->creditClientAddresses()->findOrFail($address['id']):$client->creditClientAddresses()->latest('created_at')->firstOrFail();
                $addressVersion=$parent->creditClientAddressVersions()->orderByDesc('version')->firstOrFail();
                $bank=isset($account['id'])?$client->creditClientBankAccounts()->findOrFail($account['id']):$client->creditClientBankAccounts()->latest('created_at')->firstOrFail();
                $items=collect($data['financial_items']??[]);
                abort_if($record->creditApplicationFinancialItems()->where('verified',true)->exists(),422,'Existen conceptos financieros verificados; no pueden reemplazarse en captura.');
                $record->creditApplicationFinancialItems()->delete();
                foreach($items as $item)$record->creditApplicationFinancialItems()->create([...$item,'captured_by'=>$request->user()->id,'verified'=>false]);
                $record->fill(['advisor_id'=>$advisor->id,'branch_id'=>$branch->id,'address_version_id'=>$addressVersion->id,'bank_account_id'=>$bank->id,'requested_amount'=>$data['requested_amount'],'requested_term'=>$data['requested_term'],'declared_income'=>$items->where('entry_type','income')->sum('amount'),'declared_expenses'=>$items->where('entry_type','expense')->sum('amount')])->save();
                foreach($fields as $field){$key=$field->custom_field_id;if(isset($values[$key]))$record->creditApplicationFields()->updateOrCreate(['custom_field_id'=>$key],['field_value'=>['value'=>$values[$key]]]);else $record->creditApplicationFields()->where('custom_field_id',$key)->delete();}
                $guarantors=$record->creditApplicationGuarantors();
                abort_if($guarantors->count()>1,422,'La solicitud tiene varios obligados solidarios y requiere revisión.');
                if($data['has_guarantor']){Validator::make($data,['guarantor'=>'required|array','guarantor.full_name'=>'required|string','guarantor.relationship'=>'required|string'])->validate();$g=$guarantors->first();if($g)$g->update($data['guarantor']);else $guarantors->create($data['guarantor']);}else $guarantors->delete();
                $upload=function($file,$type,$previous=null) use($record,$request,&$stored){
                    $path=Storage::disk('local')->putFile('credit/documents/'.$record->id,$file);
                    if(!is_string($path)||$path==='')throw new \RuntimeException('No fue posible guardar el archivo.');
                    $stored[]=$path;
                    $record->creditApplicationDocuments()->create(['document_type_id'=>$type,'previous_document_id'=>$previous?->id,'version'=>$previous?->version+1 ?: 1,'storage_disk'=>'local','storage_path'=>$path,'original_filename'=>$file->getClientOriginalName(),'mime_type'=>$file->getMimeType()??'application/octet-stream','size_bytes'=>$file->getSize(),'sha256'=>hash_file('sha256',$file->getRealPath()),'status'=>'pending','uploaded_by'=>$request->user()->id]);
                };
                foreach($docs as $doc)$upload($doc['file'],$doc['document_type_id']);
                foreach($data['replacements']??[] as $docId=>$file)$upload($file,$current[$docId]->document_type_id,$current[$docId]);
                $record->creditApplicationEvents()->create(['actor_id'=>$request->user()->id,'event_type'=>'application_updated','before_data'=>$before,'after_data'=>Arr::only($record->getAttributes(),array_keys($before)),'ip_address'=>$request->ip(),'occurred_at'=>now()]);
                return $record;
            });
        }catch(\Throwable $e){if($stored)Storage::disk('local')->delete($stored);throw $e;}
        return response()->json(['data'=>['id'=>$record->id]]);
    }

    public function detail(Request $request,string $id)
    {
        $this->permit('detalle');
        $record = CreditApplication::query()->when(!$request->user()->is_superadmin,fn ($q)=>$q->whereIn('advisor_id',$this->advisors($request)->select('id')))->findOrFail($id);
        $record->load(['client','addressVersion','bankAccount','advisor','branch','productVersion.product','creditApplicationGuarantors','creditApplicationFields.customField','creditApplicationFinancialItems','creditApplicationDocuments.documentType','creditWorkflowInstances']);
        $instance = $record->creditWorkflowInstances->first();
        $steps = $instance ? CreditWorkflowVersion::findOrFail($instance->workflow_version_id)->creditWorkflowSteps()->orderBy('sort_order')->get(['id','name']) : [];
        $result = $record->toArray();
        foreach ($result['credit_application_documents'] as &$document) unset($document['storage_path'],$document['storage_disk']);
        unset($document);
        $result['advisor_name'] = DB::table('users')->where('id',$record->advisor?->user_id)->value('name');
        $completed = $instance ? CreditWorkflowTask::query()->where('instance_id',$instance->id)->whereIn('status',['completed','resolved'])->pluck('step_id')->unique()->values() : [];
        return response()->json(['data'=>['application'=>$result,'steps'=>$steps,'current_step_id'=>$instance?->current_step_id,'completed_step_ids'=>$completed]]);
    }
}
