import { Component, OnInit, ViewChild, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule, FormBuilder, Validators } from '@angular/forms';
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
 config?:CaptureConfiguration; error=''; saving=false; loading=true; tab=0;
 tabs=['Cliente','Obligado solidario','Información financiera','Documentos'];
 branchId=''; advisorId=''; hasGuarantor=false;
 readonly client=this.fb.group({first_name:['',Validators.required],middle_name:'',last_name:['',Validators.required],second_last_name:'',birth_date:'',rfc:['',Validators.maxLength(13)],curp:['',Validators.maxLength(18)],ine_folio:'',passport_number:'',nss:'',health_provider:'',email:['',Validators.email],phone:['',Validators.maxLength(20)],status:'active'});
 readonly guarantor=this.fb.group({full_name:['',Validators.required],relationship:['',Validators.required],rfc:['',Validators.maxLength(13)],phone:['',Validators.maxLength(20)],monthly_income:''});
 readonly financial=this.fb.group({requested_amount:[0,Validators.required],requested_term:[0,Validators.required]});
 items:{entry_type:'income'|'expense';concept:string;amount:number|null;frequency:string}[]=[];
 values:Record<string,string>={}; files:Record<string,File[]>={};
 ngOnInit():void {
  const id=this.route.snapshot.queryParamMap.get('product'); if(!id){void this.router.navigate(['/solicitudes']);return;}
  this.service.configuration(id).pipe(finalize(()=>this.loading=false)).subscribe({next:c=>{
    this.config=c;this.branchId=c.assignment?.branch_id??'';this.advisorId=c.assignment?.id??'';
    this.financial.controls.requested_amount.setValidators([Validators.required,Validators.min(Number(c.configuration.min_amount)),Validators.max(Number(c.configuration.max_amount))]);
    this.financial.controls.requested_term.setValidators([Validators.required,Validators.min(Number(c.configuration.min_term)),Validators.max(Number(c.configuration.max_term)),Validators.pattern(/^\d+$/)]);
    this.financial.updateValueAndValidity();},error:e=>this.error=originacionError(e)});
 }
 get advisors(){return this.config?.advisors.filter(a=>a.branch_id===this.branchId)??[];}
 total(kind:string){return this.items.filter(i=>i.entry_type===kind).reduce((s,i)=>s+Number(i.amount||0),0);}
 addItem(kind:'income'|'expense'){this.items.push({entry_type:kind,concept:'',amount:null,frequency:'monthly'});}
 addFile(id:string,event:Event,max:number){const input=event.target as HTMLInputElement;const file=input.files?.[0];if(file){const list=this.files[id]??[];if(list.length<max)this.files[id]=[...list,file];}input.value='';}
 removeFile(id:string,i:number){this.files[id].splice(i,1);}
 options(value:unknown):string[]{return Array.isArray(value)?value.map(v=>typeof v==='object'&&v!==null?String((v as {value?:unknown;label?:unknown}).value??(v as {label?:unknown}).label??''):String(v)):[];}
 next(){this.error='';if(this.tab===0){this.client.markAllAsTouched();const r=this.relations?.payload();if(this.client.invalid||!r?.addresses?.length||!r?.bank_accounts?.length){this.error='Complete los datos del cliente, domicilio y cuenta bancaria.';return;}}if(this.tab===1&&this.hasGuarantor&&this.guarantor.invalid){this.guarantor.markAllAsTouched();this.error='Complete los datos del obligado solidario.';return;}if(this.tab===2&&(this.financial.invalid||this.items.some(i=>!i.concept.trim()||!i.amount||i.amount<=0)||this.config?.fields.some(f=>f.required&&!this.values[f.custom_field_id]))){this.error='Revise los montos, plazo, conceptos financieros y campos obligatorios.';return;}this.tab=Math.min(3,this.tab+1);}
 save(){if(this.saving||!this.config)return;this.error='';const r=this.relations?.payload();if(this.client.invalid||!r?.addresses?.length||!r?.bank_accounts?.length){this.tab=0;this.error='Complete los datos del cliente.';return;}if(!this.branchId||!this.advisorId){this.error='Seleccione sucursal y asesor.';return;}if(this.hasGuarantor&&this.guarantor.invalid){this.tab=1;this.error='Complete el obligado solidario.';return;}if(this.financial.invalid||this.items.some(i=>!i.concept.trim()||!i.amount||i.amount<=0)||this.config.fields.some(f=>f.required&&!this.values[f.custom_field_id])){this.tab=2;this.error='Revise la información financiera.';return;}if(this.config.documents.some(d=>d.required&&(this.files[d.document_type_id]?.length??0)<d.min_files)){this.error='Cargue todos los documentos obligatorios.';return;}
 const data=new FormData();
 const append=(key:string,value:unknown):void=>{if(value===null||value===undefined||value==='')return;if(value instanceof File){data.append(key,value);return;}if(typeof value==='object'){Object.entries(value).forEach(([k,v])=>append(key+'['+k+']',v));return;}data.append(key,typeof value==='boolean'?(value?'1':'0'):String(value));};
 const documents=Object.entries(this.files).flatMap(([document_type_id,files])=>files.map(file=>({document_type_id,file})));
 Object.entries({product_id:this.config.product.id,product_version_id:this.config.configuration.id,branch_id:this.branchId,advisor_id:this.advisorId,client:{...this.client.getRawValue(),...r},...this.financial.getRawValue(),financial_items:this.items,guarantor:this.hasGuarantor?this.guarantor.getRawValue():null,fields:this.values,documents}).forEach(([k,v])=>append(k,v));
 this.saving=true;this.service.captureApplication(data).pipe(finalize(()=>this.saving=false)).subscribe({next:()=>void this.router.navigate(['/solicitudes']),error:e=>this.error=originacionError(e)});
 }
}
