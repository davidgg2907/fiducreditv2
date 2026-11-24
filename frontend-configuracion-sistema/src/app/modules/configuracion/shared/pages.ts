import {Directive, OnInit, inject} from '@angular/core';
import {Router,ActivatedRoute} from '@angular/router';
import {HttpErrorResponse} from '@angular/common/http';
import {ConfigApi} from './api.service';
import {ConfigPermissions} from './permissions.service';
import {ModuleConfig,Item,Field,MODULES,setting} from './schema';
import {ReferenceLabelService} from './reference-label.service';
function errorText(e:HttpErrorResponse):string{
 if(e.status===403)return 'Acceso denegado: no cuentas con los permisos requeridos.';
 if(e.status===405)return 'Esta operación no está permitida por el backend.';
 if(e.status===422)return Object.values(e.error?.errors??{}).flat().join(' · ')||e.error?.message||'Datos inválidos.';
 return e.error?.message||'Error del servicio HTTP '+e.status;
}
@Directive()
export class PageBase{
 error='';busy=false;
 protected readonly referenceLabels=inject(ReferenceLabelService);
 constructor(public config:ModuleConfig,public api:ConfigApi,public permissions:ConfigPermissions,public router:Router,public route:ActivatedRoute){}
 can(action:'ver'|'detalle'|'crear'|'editar'|'eliminar'):boolean{return this.permissions.can(this.config,action)&&(action!=='eliminar'||this.config.allowDelete);}
 get home(){return '/'+this.config.key;}
 get columns(){return this.config.fields.filter(x=>x.type!=='password').slice(0,5);}
 value(row:Item,field:Field){
  const value=row[field.key];
  if(field.type==='ref'&&field.reference){return this.referenceLabels.display(field.reference,value);}
  return value==null?'—':typeof value==='object'?JSON.stringify(value):typeof value==='boolean'?(value?'Sí':'No'):String(value);
 }
}
@Directive()
export class ListPage extends PageBase implements OnInit{
 records:Item[]=[];page=1;last=1;total=0;search='';
 ngOnInit(){if(this.can('ver'))this.load();else this.error='Sin permiso para consultar.';}
 load(){this.busy=true;this.error='';this.api.list(this.config.api,this.page,this.search).subscribe({next:r=>{this.records=r.data;
  for(const item of r.data){for(const f of this.config.fields){if(f.type==='ref'&&f.reference)this.referenceLabels.resolve(f.reference,item[f.key]);}}
  this.total=r.total;this.last=r.last_page;this.busy=false;},error:(e:HttpErrorResponse)=>{this.error=errorText(e);this.busy=false;}});}
 get pageNumbers():number[]{const count=Math.min(this.last,7);const start=Math.max(1,Math.min(this.page-3,this.last-count+1));return Array.from({length:count},(_,i)=>start+i);}
 searchRecords(){this.page=1;this.load();}
 clearSearch(){this.search='';this.searchRecords();}
 move(page:number){if(page>=1&&page<=this.last&&page!==this.page){this.page=page;this.load();}}
 remove(item:Item){if(!this.can('eliminar')||!confirm('¿Eliminar el registro?'))return;this.api.remove(this.config.api,String(item.id)).subscribe({next:()=>this.load(),error:(e:HttpErrorResponse)=>this.error=errorText(e)});}
 toggle(item:Item){if(this.config.key!=='usuarios'||!this.can('editar')||item['is_superadmin']||!confirm('¿Cambiar el estado de acceso?'))return;this.api.status(String(item.id),!item['is_active']).subscribe({next:()=>this.load(),error:(e:HttpErrorResponse)=>this.error=errorText(e)});}
}
@Directive()
export class FormPage extends PageBase implements OnInit{
 id:string|null=null;data:Record<string,any>={};refs:Record<string,Item[]>={};saving=false;catalog:{permission:string;name:string;module:string}[]=[];
 ngOnInit(){
 this.id=this.route.snapshot.paramMap.get('id');
 if(!this.can(this.id?'editar':'crear')){this.error='Sin permiso para esta operación.';return;}
 for(const f of this.config.fields){
 this.data[f.key]=f.type==='bool'?false:f.type==='json'?'{}':f.type==='permissions'?[]:'';
 if(f.type==='ref'&&f.reference)this.api.list(setting(f.reference).api).subscribe({next:r=>this.refs[f.key]=r.data,error:()=>this.refs[f.key]=[]});
 }
 if(this.config.key==='roles')this.api.catalog().subscribe({next:r=>this.catalog=r.flatMap(m=>(m.actions??[]).map((a:any)=>({...a,module:m.name}))),error:(e:HttpErrorResponse)=>this.error=errorText(e)});
 if(this.id){this.busy=true;this.api.detail(this.config.api,this.id).subscribe({next:r=>{for(const f of this.config.fields){const v=r[f.key];if(v!==undefined&&v!==null)this.data[f.key]=f.type==='json'?JSON.stringify(v,null,2):v;}this.busy=false;},error:(e:HttpErrorResponse)=>{this.error=errorText(e);this.busy=false;}});}
 }
 checked(k:string){return (this.data['permissions']??[]).includes(k);}
 check(k:string,v:boolean){const curr:string[]=this.data['permissions']??[];this.data['permissions']=v?Array.from(new Set([...curr,k])):curr.filter(s=>s!==k);}
 refLabel(r:Item){return r['name']??r['legal_name']??r['label']??r['code']??r['permission']??String(r.id);}
 save(){
 if(this.saving||!this.can(this.id?'editar':'crear'))return;
 const payload:Record<string,unknown>={};
 try{for(const f of this.config.fields){
 if(f.key==='is_active'||(this.id&&f.type==='password'))continue;
 let val=this.data[f.key];
 if(f.type==='json')val=val?JSON.parse(val):null;
 if(f.type==='number')val=val===''?null:Number(val);
 if(f.type==='ref'&&val==='')val=null;
 if(f.type==='text'&&val==='')val=null;
 if(val!==null||f.required||f.type==='permissions')payload[f.key]=val;
 }}catch{this.error='Revisa la sintaxis de los campos JSON.';return;}
 if(this.config.key==='usuarios'&&!this.id){payload['password_confirmation']=this.data['password'];if(!payload['role_id'])payload['role_id']=null;}
 this.saving=true;this.error='';
 this.api.save(this.config.api,payload,this.id??undefined).subscribe({next:()=>void this.router.navigate([this.home]),error:(e:HttpErrorResponse)=>{this.error=errorText(e);this.saving=false;}});
 }
}
@Directive()
export class DetailPage extends PageBase implements OnInit{
 item:Item|null=null;relations:{config:ModuleConfig;rows:Item[];error:string}[]=[];
 ngOnInit(){
 if(!this.can('detalle')){this.error='Sin permiso para ver el detalle.';return;}
 const id=this.route.snapshot.paramMap.get('id');if(!id)return;this.busy=true;
 this.api.detail(this.config.api,id).subscribe({next:r=>{this.item=r;this.busy=false;
  for(const f of this.config.fields){if(f.type==='ref'&&f.reference)this.referenceLabels.resolve(f.reference,r[f.key]);}
  this.loadRelated();},error:(e:HttpErrorResponse)=>{this.error=errorText(e);this.busy=false;}});
 }
 loadRelated(){
 if(!this.item)return;
 for(const m of MODULES.filter(x=>x.key!==this.config.key && this.permissions.can(x,'ver') && x.fields.some(f=>f.reference===this.config.key))){
 const foreign=m.fields.find(f=>f.reference===this.config.key);if(!foreign)continue;
 const section={config:m,rows:[] as Item[],error:''};this.relations.push(section);
 this.api.list(m.api,1,'',{[foreign.key]:String(this.item.id)}).subscribe({next:r=>section.rows=r.data,error:(e:HttpErrorResponse)=>section.error=errorText(e)});
 }
 }
}
