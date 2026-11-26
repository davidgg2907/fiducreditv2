import { Component, OnInit, ViewChild, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule, FormBuilder, Validators, AbstractControl } from '@angular/forms';
import { ActivatedRoute, Router, RouterModule } from '@angular/router';
import { finalize } from 'rxjs';
import { SolicitudesService } from '../../../servicios/originacion/solicitudes.service';
import { CaptureConfiguration } from '../../../interfaces/originacion/solicitudes.interface';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
import { ClientesRelacionesComponent } from '../../clientes/relaciones/clientes-relaciones.component';

@Component({selector:'app-solicitudes-capture',standalone:true,imports:[CommonModule,FormsModule,ReactiveFormsModule,RouterModule,ClientesRelacionesComponent],templateUrl:'./solicitudes-capture.component.html',styleUrls:['./solicitudes-capture.component.scss']})
export class SolicitudesCaptureComponent implements OnInit {
 private readonly fb=inject(FormBuilder).nonNullable;
 private readonly service=inject(SolicitudesService);
 private readonly route=inject(ActivatedRoute);
 private readonly router=inject(Router);
 @ViewChild(ClientesRelacionesComponent) relations?: ClientesRelacionesComponent;
 readonly editId=this.route.snapshot.paramMap.get('id');
 initialRelations?: {address:any;account:any};
 existingFiles:Record<string,{id:string;original_filename:string}[]>={};
 replacements:Record<string,File>={};
 config?:CaptureConfiguration; error=''; saving=false; loading=true; tab=0;
 tabs=['Cliente','Obligado solidario','Información financiera','Documentos'];
 tabIcons=['person','group','payments','description'];
 furthestTab=0; assignmentAttempted=false; financialAttempted=false; documentsAttempted=false;
 validationMessage(control:AbstractControl):string {
  if(control.hasError('required'))return 'Este campo es obligatorio.';
  if(control.hasError('email'))return 'Ingrese un correo electrónico válido.';
  if(control.hasError('maxlength'))return 'Longitud máxima excedida.';
  if(control.hasError('min')||control.hasError('max'))return 'El valor está fuera del rango permitido.';
  return 'Ingrese un valor válido.';
 }
 selectTab(index:number):void {
  if(this.saving||index>this.furthestTab)return;
  if(index<=this.tab){this.tab=index;this.error='';return;}
  while(this.tab<index){const previous=this.tab;this.next();if(this.tab===previous)break;}
 }
 branchId=''; advisorId=''; hasGuarantor=false;
 readonly client=this.fb.group({first_name:['',Validators.required],middle_name:'',last_name:['',Validators.required],second_last_name:'',birth_date:'',rfc:['',Validators.maxLength(13)],curp:['',Validators.maxLength(18)],ine_folio:'',passport_number:'',nss:'',health_provider:'',email:['',Validators.email],phone:['',Validators.maxLength(20)],status:'active'});
 readonly guarantor=this.fb.group({full_name:['',Validators.required],relationship:['',Validators.required],rfc:['',Validators.maxLength(13)],phone:['',Validators.maxLength(20)],monthly_income:''});
 readonly financial=this.fb.group({requested_amount:[0,Validators.required],requested_term:[0,Validators.required],unidad_plazo:['',Validators.required],frecuencia_pago:['',Validators.required]});
 items:{entry_type:'income'|'expense';concept:string;amount:number|null;frequency:string}[]=[];
 values:Record<string,string>={}; files:Record<string,File[]>={};
 ngOnInit():void {
  if(this.editId){
   this.service.editConfiguration(this.editId).pipe(finalize(()=>this.loading=false)).subscribe({next:result=>{
    const a=result.application;this.applyConfiguration(result);this.branchId=a['branch_id'];this.advisorId=a['advisor_id'];
    this.client.patchValue(a['client']??{});this.client.controls.birth_date.setValue(a['client']?.birth_date?.slice(0,10)??'');
    this.initialRelations={address:a['address_version'],account:a['bank_account']};
    this.financial.patchValue({requested_amount:Number(a['requested_amount']),requested_term:Number(a['requested_term']),unidad_plazo:a['unidad_plazo']??this.financial.controls.unidad_plazo.value,frecuencia_pago:a['frecuencia_pago']??this.financial.controls.frecuencia_pago.value});
    this.items=(a['credit_application_financial_items']??[]).map((i:any)=>({entry_type:i.entry_type,concept:i.concept,amount:Number(i.amount),frequency:i.frequency}));
    if(!this.items.some(i=>i.entry_type==='income')&&Number(a['declared_income'])>0)this.items.push({entry_type:'income',concept:'Ingreso declarado',amount:Number(a['declared_income']),frequency:'monthly'});
    if(!this.items.some(i=>i.entry_type==='expense')&&Number(a['declared_expenses'])>0)this.items.push({entry_type:'expense',concept:'Egreso declarado',amount:Number(a['declared_expenses']),frequency:'monthly'});
    const g=a['credit_application_guarantors']?.[0];if(g){this.hasGuarantor=true;this.guarantor.patchValue(g);}
    for(const f of a['credit_application_fields']??[])this.values[f.custom_field_id]=String(f.field_value?.value??'');
    for(const d of a['credit_application_documents']??[])(this.existingFiles[d.document_type_id]??=[]).push(d);
    this.furthestTab=3;
   },error:e=>this.error=originacionError(e)});return;
  }
  const id=this.route.snapshot.queryParamMap.get('product'); if(!id){void this.router.navigate(['/solicitudes']);return;}
  this.service.configuration(id).pipe(finalize(()=>this.loading=false)).subscribe({next:c=>this.applyConfiguration(c),error:e=>this.error=originacionError(e)});
 }
 private applyConfiguration(c:CaptureConfiguration):void {
    this.config=c;this.branchId=c.assignment?.branch_id??'';this.advisorId=c.assignment?.id??'';
    this.financial.controls.requested_amount.setValidators([Validators.required,Validators.min(Number(c.configuration.min_amount)),Validators.max(Number(c.configuration.max_amount))]);
    this.financial.controls.requested_term.setValidators([Validators.required,Validators.min(1)]);
    this.financial.patchValue({unidad_plazo:c.configuration.configuracion_plazos.plazos.length===1?c.configuration.configuracion_plazos.plazos[0].unidad_plazo:'',frecuencia_pago:c.configuration.configuracion_plazos.frecuencia_pago_predeterminada});
    this.financial.controls.requested_amount.updateValueAndValidity();this.financial.controls.requested_term.updateValueAndValidity();
 }
 get plazosDisponibles():number[]{const p=this.config?.configuration.configuracion_plazos.plazos.find(v=>v.unidad_plazo===this.financial.controls.unidad_plazo.value);if(!p)return [];return Array.from({length:Math.floor((p.plazo_maximo-p.plazo_minimo)/p.incremento)+1},(_,i)=>p.plazo_minimo+i*p.incremento);}
 get advisors(){return this.config?.advisors.filter(a=>a.branch_id===this.branchId)??[];}
 total(kind:string){return this.items.filter(i=>i.entry_type===kind).reduce((s,i)=>s+Number(i.amount||0),0);}
 readonly financialGroups=[{kind:'income' as const,title:'Ingresos',icon:'trending_up'},{kind:'expense' as const,title:'Egresos',icon:'trending_down'}];
 itemsFor(kind:string){return this.items.filter(i=>i.entry_type===kind);}
 removeItem(item:(typeof this.items)[number]){this.items=this.items.filter(i=>i!==item);}
 documentCount(id:string){return (this.files[id]?.length??0)+(this.existingFiles[id]?.length??0);}
 replaceFile(id:string,index:number,event:Event){const input=event.target as HTMLInputElement;const file=input.files?.[0];if(file)this.files[id][index]=file;input.value='';}
 replaceExisting(id:string,event:Event){const input=event.target as HTMLInputElement;const file=input.files?.[0];if(file)this.replacements[id]=file;input.value='';}
 addItem(kind:'income'|'expense'){this.items.push({entry_type:kind,concept:'',amount:null,frequency:'monthly'});}
 addFile(id:string,event:Event,max:number){const input=event.target as HTMLInputElement;const file=input.files?.[0];if(file){const list=this.files[id]??[];if(this.documentCount(id)<max)this.files[id]=[...list,file];}input.value='';}
 removeFile(id:string,i:number){this.files[id].splice(i,1);}
 options(value:unknown):string[]{return Array.isArray(value)?value.map(v=>typeof v==='object'&&v!==null?String((v as {value?:unknown;label?:unknown}).value??(v as {label?:unknown}).label??''):String(v)):[];}
 private validateStep(index:number):boolean {
  if(index===0){
   this.client.markAllAsTouched();
   const r=this.relations?.payload();
   return this.client.valid && !!r?.addresses?.length && !!r?.bank_accounts?.length;
  }
  if(index===1){if(!this.hasGuarantor)return true;this.guarantor.markAllAsTouched();return this.guarantor.valid;}
  if(index===2){this.financialAttempted=true;this.financial.markAllAsTouched();return this.financial.valid && this.plazosDisponibles.includes(this.financial.controls.requested_term.value) && !this.items.some(i=>!i.concept.trim()||!i.amount||i.amount<=0) && !this.config?.fields.some(f=>f.required&&!this.values[f.custom_field_id]);}
  this.documentsAttempted=true;
  return !this.config?.documents.some(d=>d.required&&this.documentCount(d.document_type_id)<d.min_files);
 }
 next(){this.error='';if(!this.validateStep(this.tab))return;this.tab=Math.min(3,this.tab+1);this.furthestTab=Math.max(this.furthestTab,this.tab);}
 save(){if(this.saving||!this.config)return;this.error='';this.assignmentAttempted=true;
  if(!this.branchId||!this.advisorId)return;
  for(let i=0;i<4;i++){if(!this.validateStep(i)){this.tab=i;return;}}
  const r=this.relations?.payload();if(!r)return;
 const data=new FormData();
 const append=(key:string,value:unknown):void=>{if(value===undefined)return;if(value===null||value===''){if(this.editId&&key.startsWith('client['))data.append(key,'');return;}if(value instanceof File){data.append(key,value);return;}if(typeof value==='object'){Object.entries(value).forEach(([k,v])=>append(key+'['+k+']',v));return;}data.append(key,typeof value==='boolean'?(value?'1':'0'):String(value));};
 const documents=Object.entries(this.files).flatMap(([document_type_id,files])=>files.map(file=>({document_type_id,file})));
 Object.entries({product_id:this.config.product.id,product_version_id:this.config.configuration.id,branch_id:this.branchId,advisor_id:this.advisorId,client:{...this.client.getRawValue(),...r},...this.financial.getRawValue(),financial_items:this.items,guarantor:this.hasGuarantor?this.guarantor.getRawValue():null,fields:this.values,documents}).forEach(([k,v])=>append(k,v));
 if(this.editId){Object.entries(this.replacements).forEach(([id,file])=>data.append('replacements['+id+']',file));data.append('has_guarantor',this.hasGuarantor?'1':'0');}
 this.saving=true;(this.editId?this.service.updateCapture(this.editId,data):this.service.captureApplication(data)).pipe(finalize(()=>this.saving=false)).subscribe({next:()=>void this.router.navigate(['/solicitudes']),error:e=>this.error=originacionError(e)});
 }
}
