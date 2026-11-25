import {Component,inject,OnInit} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting,Field,Item} from '../../shared/schema';

type Row=Record<string,any>;
type Mode='step'|'rules'|'roles';
@Component({selector:'app-flujos-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./flujos-form.component.html',styleUrls:['./flujos-form.component.scss']})
export class FlujosFormComponent implements OnInit {
 private api=inject(ConfigApi);private permissions=inject(ConfigPermissions);private router=inject(Router);private route=inject(ActivatedRoute);
 config=setting('flujos');home='/flujos';id=this.route.snapshot.paramMap.get('id');readonlyMode=this.route.snapshot.data['readonly']===true;
 tab=0;tabs=['Información general','Etapas del flujo'];tabIcons=['info','account_tree'];
 data:Row={enabled:true};steps:Row[]=[];version:Row|null=null;refs:Record<string,Item[]>={};busy=false;saving=false;loadFailed=false;error='';
 modal:Mode|null=null;selected=-1;draft:Row={};entries:Row[]=[];modalError='';dragIndex=-1;
 generalFields=this.config.fields.filter(f=>f.key!=='created_by');
 stepFields=setting('etapas_flujos').fields.filter(f=>!['workflow_version_id','sort_order'].includes(f.key));
 ruleFields=setting('reglas_flujos').fields.filter(f=>f.key!=='step_id');
 roleFields=setting('roles_flujos').fields.filter(f=>f.key!=='step_id');
 labels:Record<string,string>={code:'Clave',name:'Nombre',company_id:'Empresa',product_id:'Producto',description:'Descripción',enabled:'Habilitado',step_type:'Tipo de etapa',application_status:'Estatus de solicitud',application_substatus:'Subestatus',is_initial:'Etapa inicial',is_terminal:'Etapa terminal',allow_manual_assignment:'Permite asignación manual',metadata:'Metadatos',transition_id:'Transición (opcional)',rule_type:'Tipo de regla',operator:'Operador',parameters:'Parámetros',blocking:'Bloqueante',role_id:'Rol',can_view:'Consultar',can_claim:'Tomar tarea',can_process:'Procesar',can_assign:'Asignar'};
 get allowed(){return this.permissions.can(this.config,this.readonlyMode?'detalle':this.id?'editar':'crear');}
 get editable(){return !this.readonlyMode&&!this.saving&&!this.loadFailed;}
 get modalTitle(){return this.modal==='step'?'Información de la etapa':this.modal==='rules'?'Reglas de la etapa':'Roles de la etapa';}
 get childFields(){return this.modal==='rules'?this.ruleFields:this.roleFields;}
 ngOnInit(){if(!this.allowed)return;for(const key of ['empresas','productos','roles']){this.refs[key]=[];this.loadRefs(key,1);}if(this.id){this.busy=true;this.api.detail(this.config.api,this.id).subscribe({next:r=>{this.data=r;this.version=r['configuration_version']??null;this.steps=(this.version?.['credit_workflow_steps']??[]).map((s:Row)=>({...s,rules:s['credit_workflow_step_rules']??[],roles:s['credit_workflow_step_roles']??[]}));this.busy=false;},error:e=>{this.loadFailed=true;this.busy=false;this.fail(e);}});}}
 loadRefs(key:string,page:number){this.api.list(setting(key).api,page).subscribe({next:r=>{this.refs[key].push(...r.data);if(page<r.last_page)this.loadRefs(key,page+1);},error:e=>{this.loadFailed=true;this.fail(e);}});}
 label(r:Item){return r['name']??r['legal_name']??r['code']??r.id;}
 fieldLabel(f:Field){return this.labels[f.key]??f.label;}
 options(f:Field){if(f.key==='transition_id')return (this.version?.['credit_workflow_transitions']??[]).filter((r:Row)=>r['from_step_id']===this.steps[this.selected]?.['id']);const list=this.refs[f.reference??'']??[];return f.key==='product_id'?list.filter(r=>r['company_id']===this.data['company_id']):list;}
 roleLabel(id:any){const r=this.refs['roles']?.find(x=>String(x.id)===String(id));return r?this.label(r):id;}
 add(){this.steps.push({name:'',code:'',is_initial:false,is_terminal:false,allow_manual_assignment:true,rules:[],roles:[]});}
 open(index:number,mode:Mode){this.selected=index;this.modal=mode;this.modalError='';const s=this.steps[index];this.draft={...s};this.entries=structuredClone(s[mode==='rules'?'rules':'roles']??[]);}
 close(){this.modal=null;this.selected=-1;this.modalError='';}
 addEntry(){this.entries.push(this.modal==='rules'?{blocking:true,enabled:true,parameters:{}}:{can_view:true,can_claim:false,can_process:false,can_assign:false});}
 saveModal(){try{if(this.modal==='step'){this.payload(this.stepFields,this.draft);Object.assign(this.steps[this.selected],this.draft);}else if(this.modal){for(const row of this.entries)this.payload(this.childFields,row);this.steps[this.selected][this.modal]=this.entries;}this.close();}catch(e){this.modalError=e instanceof Error?e.message:'Revisa los datos.';}}
 startDrag(event:DragEvent,index:number){if(!this.editable)return;this.dragIndex=index;event.dataTransfer?.setData('text/plain',String(index));if(event.dataTransfer)event.dataTransfer.effectAllowed='move';}
 drop(event:DragEvent,index:number){event.preventDefault();if(this.dragIndex>=0)this.move(this.dragIndex,index);this.dragIndex=-1;}
 move(from:number,to:number){if(!this.editable||to<0||to>=this.steps.length||from===to)return;const [row]=this.steps.splice(from,1);this.steps.splice(to,0,row);}
 jsonValue(v:any){return typeof v==='string'?v:JSON.stringify(v??{},null,2);}
 payload(fields:Field[],row:Row){const result:Row={};for(const f of fields){let v=row[f.key];if(v===undefined||v===null||v===''){if(f.required)throw Error('Completa '+this.fieldLabel(f));if(['product_id','description','application_substatus','transition_id','metadata'].includes(f.key))result[f.key]=null;continue;}if(f.type==='json'&&typeof v==='string')v=JSON.parse(v);if(f.type==='bool')v=v===true||v===1||v==='1';result[f.key]=v;}return result;}
 save(){if(!this.editable||!this.allowed||this.busy||this.modal)return;try{const p=this.payload(this.generalFields,this.data);p['source_version_id']=this.version?.['id']??null;p['steps']=this.steps.map((s,i)=>{try{return {...this.payload(this.stepFields,s),...(s['id']?{id:s['id']}:{}),rules:s['rules'].map((r:Row)=>this.payload(this.ruleFields,r)),roles:s['roles'].map((r:Row)=>this.payload(this.roleFields,r))};}catch(e){throw Error('Etapa '+(i+1)+': '+(e instanceof Error?e.message:'Datos inválidos'));}});this.saving=true;this.error='';this.api.save(this.config.api,p,this.id??undefined).subscribe({next:()=>void this.router.navigate([this.home]),error:e=>{this.saving=false;this.fail(e);}});}catch(e){this.error=e instanceof Error?e.message:'Revisa los datos.';}}
 fail(e:any){this.error=Object.values(e.error?.errors??{}).flat().join(' · ')||e.error?.message||'No fue posible completar la operación.';}
}
