import {Component,inject,OnInit} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {forkJoin} from 'rxjs';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting,Field,Item} from '../../shared/schema';

@Component({selector:'app-productos-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./productos-form.component.html',styleUrls:['./productos-form.component.scss']})
export class ProductosFormComponent implements OnInit {
 private api=inject(ConfigApi); private permissions=inject(ConfigPermissions); private router=inject(Router); private route=inject(ActivatedRoute);
 config=setting('productos'); home='/productos'; id=this.route.snapshot.paramMap.get('id'); readonlyMode=this.route.snapshot.data['readonly']===true;
 tabs=['Datos generales','Reglas del producto','Campos configurables','Requisitos documentales','Comisiones','Historial de versiones']; tab=0;
 data:Record<string,any>={status:'active'}; configuration:Record<string,any>={term_unit:'month',rate_type:'fixed',interest_method:'outstanding_balance',min_dti:0,max_dti:0.4,amortization_method:'french',payment_frequency:'monthly',currency:'MXN',requires_bureau:true};
 financial=setting('versiones_productos').fields.filter(f=>!['product_id','version','active','effective_from','effective_to'].includes(f.key));
 sections=[{key:'rules',relation:'credit_product_rules',fields:setting('reglas_productos').fields},{key:'fields',relation:'credit_product_fields',fields:setting('campos_productos').fields},{key:'documents',relation:'credit_product_documents',fields:setting('requisitos_documentales').fields},{key:'fees',relation:'credit_product_fees',fields:setting('comisiones_productos').fields}].map(s=>({...s,fields:s.fields.filter(f=>f.key!=='product_version_id')}));
 rows:Record<string,Record<string,any>[]>= {rules:[],fields:[],documents:[],fees:[]}; refs:Record<string,Item[]>={}; history:Item[]=[]; historical:Item|null=null; busy=false;saving=false;error='';
 get editable(){return !this.readonlyMode&&!this.historical;}
 get allowed(){return this.permissions.can(this.config,this.readonlyMode?'detalle':this.id?'editar':'crear');}
 ngOnInit(){
  if(!this.allowed){this.error='Sin permiso para esta operación.';return;}
  const refs=[...this.config.fields,...this.sections.flatMap(s=>s.fields)].filter(f=>f.reference);
  for(const f of refs){const key=f.reference!;if(this.refs[key])continue;this.refs[key]=[];this.loadRefs(key,1);}
  if(this.id){this.busy=true;this.api.detail(this.config.api,this.id).subscribe({next:r=>{this.data=r;this.configuration=r['current_version']??{};for(const s of this.sections)this.rows[s.key]=this.configuration[s.relation]??[];this.history=r['credit_product_versions']??[];this.busy=false;},error:e=>{this.fail(e);this.busy=false;}});}
 }
 loadRefs(key:string,page:number){this.api.list(setting(key).api,page).subscribe({next:r=>{this.refs[key].push(...r.data);if(page<r.last_page)this.loadRefs(key,page+1);},error:e=>this.fail(e)});}
 label(r:Item){return r['name']??r['legal_name']??r['label']??r['code']??r.id;}
 add(s:typeof this.sections[number]){const row:Record<string,any>={};for(const f of s.fields)if(f.type==='bool')row[f.key]=true;this.rows[s.key].push(row);}
 selectVersion(v:Item){this.historical=v;this.tab=5;}
 jsonValue(value:any){return typeof value==='string'?value:JSON.stringify(value??{},null,2);}
 payload(fields:Field[],data:Record<string,any>){const out:Record<string,any>={};for(const f of fields){let v=data[f.key];if(v===undefined||v===''){if(f.required)throw Error('Completa '+f.label);if(f.key==='parent_product_id'||f.key==='description'||f.key==='min_bureau_score'||f.key==='rejection_reason')out[f.key]=null;continue;}if(v===null){if(f.required)throw Error('Completa '+f.label);out[f.key]=null;continue;}if(f.type==='json'&&typeof v==='string')v=JSON.parse(v);if(f.type==='bool')v=v===true||v===1||v==='1';out[f.key]=v;}return out;}
 save(){if(!this.editable||!this.allowed||this.busy||this.saving)return;try{const p=this.payload(this.config.fields,this.data);p['configuration']=this.payload(this.financial,this.configuration);for(const s of this.sections)p[s.key]=this.rows[s.key].map(r=>this.payload(s.fields,r));this.saving=true;this.error='';this.api.save(this.config.api,p,this.id??undefined).subscribe({next:()=>void this.router.navigate([this.home]),error:e=>{this.fail(e);this.saving=false;}});}catch(e){this.error=e instanceof Error?e.message:'Revisa los datos.';}}
 fail(e:any){this.error=Object.values(e.error?.errors??{}).flat().join(' · ')||e.error?.message||'No fue posible completar la operación.';}
}
