<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
class OperationalDashboardService {
 private function client($row): string {
  return implode(' ',array_filter([$row->first_name??null,$row->middle_name??null,$row->last_name??null,$row->second_last_name??null]));
 }
 private function events($query,string $date,string $operation,string $reference): Collection {
  return $query->select('e.id',"e.$date as occurred_at","e.$operation as operation",$reference.' as reference','c.first_name','c.middle_name','c.last_name','c.second_last_name')
   ->orderByDesc("e.$date")->orderByDesc('e.id')->limit(50)->get()->map(fn($r)=>[
    'id'=>$r->id,'occurred_at'=>$r->occurred_at,'operation'=>$r->operation,'reference'=>$r->reference,'client'=>$this->client($r),'actor'=>null,'source'=>'Evento de dominio',
   ]);
 }
 public function snapshot(bool $pld): array {
  $online=DB::table('auth_sessions as s')->join('users as u','u.id','=','s.user_id')->leftJoin('roles as r','r.id','=','u.role_id')
   ->where('u.is_active',true)->where('s.expires_at','>',now())->where('s.last_activity_at','>',now()->subMinutes(config('auth_tokens.idle_timeout_minutes')))
   ->orderByDesc('s.last_activity_at')->get(['u.name','r.name as role','s.last_activity_at','s.expires_at']);
  $sessions=DB::table('auth_login_history')->orderByDesc('started_at')->orderByDesc('id')->limit(20)->get(['user_name','frontend','started_at']);
  $applications=DB::table('credit_applications as a')->join('credit_clients as c','c.id','=','a.client_id')->join('credit_product_versions as v','v.id','=','a.product_version_id')->join('credit_products as p','p.id','=','v.product_id')
   ->orderByDesc('a.created_at')->orderByDesc('a.id')->limit(20)->get(['a.application_number','a.created_at','a.status','a.requested_amount','p.name as product','c.first_name','c.middle_name','c.last_name','c.second_last_name'])->map(function($r){$r->client=$this->client($r);unset($r->first_name,$r->middle_name,$r->last_name,$r->second_last_name);return $r;});
  $origin=$this->events(DB::table('credit_application_events as e')->join('credit_applications as a','a.id','=','e.application_id')->join('credit_clients as c','c.id','=','a.client_id'),'occurred_at','event_type','a.application_number')
   ->concat($this->events(DB::table('credit_workflow_task_history as e')->join('credit_workflow_tasks as t','t.id','=','e.task_id')->join('credit_workflow_instances as i','i.id','=','t.instance_id')->join('credit_applications as a','a.id','=','i.application_id')->join('credit_clients as c','c.id','=','a.client_id'),'occurred_at','event_type','a.application_number'));
  $admin=$this->events(DB::table('credit_loan_events as e')->join('credit_loans as l','l.id','=','e.loan_id')->join('credit_applications as a','a.id','=','l.application_id')->join('credit_clients as c','c.id','=','a.client_id'),'occurred_at','event_type','l.loan_number');
  $domains=['originacion'=>$origin,'administracion'=>$admin,'configuracion-sistema'=>collect()];
  if($pld){
   $domains['pld-operacion']=$this->events(DB::table('pld_monitoring_events as e')->join('credit_clients as c','c.id','=','e.client_id')->leftJoin('credit_loans as l','l.id','=','e.loan_id'),'observed_at','event_type','l.loan_number')
   ->concat($this->events(DB::table('pld_case_events as e')->join('pld_cases as k','k.id','=','e.case_id')->join('credit_clients as c','c.id','=','k.client_id'),'occurred_at','action','k.case_number'));
   $domains['pld-configuracion']=collect();
  }
  foreach($domains as $app=>$events){
   $requests=DB::table('operational_request_logs as e')->leftJoin('users as u','u.id','=','e.actor_id')->where('frontend',$app)->orderByDesc('occurred_at')->orderByDesc('e.id')->limit(50)->get(['e.id','e.occurred_at','e.operation','u.name as actor'])->map(fn($r)=>['id'=>'http-'.$r->id,'occurred_at'=>$r->occurred_at,'operation'=>$r->operation,'reference'=>null,'client'=>null,'actor'=>$r->actor,'source'=>'Operación API']);
   $domains[$app]=$events->concat($requests)->sortByDesc('occurred_at')->take(50)->values();
  }
  return ['online'=>$online,'sessions'=>$sessions,'applications'=>$applications,'logs'=>$domains,'generated_at'=>now()->toIso8601String()];
 }
}