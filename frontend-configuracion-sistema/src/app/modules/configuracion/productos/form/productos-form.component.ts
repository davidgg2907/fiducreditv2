import {Component,inject,OnInit} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting,Field,Item} from '../../shared/schema';

@Component({selector:'app-productos-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./productos-form.component.html',styleUrls:['./productos-form.component.scss']})
export class ProductosFormComponent implements OnInit {
 private api=inject(ConfigApi); private permissions=inject(ConfigPermissions); private router=inject(Router); private route=inject(ActivatedRoute);
 config=setting('productos'); home='/productos'; id=this.route.snapshot.paramMap.get('id'); readonlyMode=this.route.snapshot.data['readonly']===true;
 tabs=['Información general','Condiciones financieras','Costos y comisiones','Documentación','Reglas de negocio','Campos configurables','Versionamiento'];
 tabIcons=['info','tune','payments','description','verified_user','dynamic_form','history'];
 sectionTabs:Record<string,number>={fees:2,documents:3,rules:4,fields:5};
 sectionTitles:Record<string,string>={fees:'Comisiones y cargos',documents:'Requisitos documentales',rules:'Reglas y validaciones',fields:'Campos configurables'};
 sectionIcons:Record<string,string>={fees:'payments',documents:'description',rules:'verified_user',fields:'dynamic_form'};
 tab=0;
 unidadesPlazo=['dia','semana','mes','anio'];
 frecuenciasPago=['unico','diario','semanal','catorcenal','quincenal','mensual','bimestral','trimestral','cuatrimestral','semestral','anual'];
 plazos:{unidad_plazo:string;plazo_minimo:number;plazo_maximo:number;incremento:number}[]=[];
 frecuencias:string[]=[]; frecuenciaPredeterminada='mensual';
 agregarPlazo(){const unidad=this.unidadesPlazo.find(u=>!this.plazos.some(p=>p.unidad_plazo===u));if(unidad)this.plazos.push({unidad_plazo:unidad,plazo_minimo:1,plazo_maximo:12,incremento:1});}
 cargarPlazos(){const c=this.configuration['configuracion_plazos'];const unidades:Record<string,string>={day:'dia',week:'semana',month:'mes',year:'anio'};const frecuencias:Record<string,string>={single:'unico',daily:'diario',weekly:'semanal',biweekly:'catorcenal',fortnightly:'quincenal',monthly:'mensual',bimonthly:'bimestral',quarterly:'trimestral',semiannual:'semestral',annual:'anual',yearly:'anual'};this.plazos=c?.plazos??[{unidad_plazo:unidades[this.configuration['term_unit']]??this.configuration['term_unit']??'mes',plazo_minimo:Number(this.configuration['min_term']??1),plazo_maximo:Number(this.configuration['max_term']??12),incremento:1}];this.frecuencias=c?.frecuencias_pago??[frecuencias[this.configuration['payment_frequency']]??this.configuration['payment_frequency']??'mensual'];this.frecuenciaPredeterminada=c?.frecuencia_pago_predeterminada??this.frecuencias[0];}
 marcarFrecuencia(f:string,activa:boolean){this.frecuencias=activa?[...new Set([...this.frecuencias,f])]:this.frecuencias.filter(v=>v!==f);if(!this.frecuencias.includes(this.frecuenciaPredeterminada))this.frecuenciaPredeterminada=this.frecuencias[0]??'';}
 fieldLabels:Record<string,string>={company_id:'Empresa',parent_product_id:'Producto padre',code:'Clave',name:'Nombre del producto',description:'Descripción',status:'Producto activo',min_amount:'Monto mínimo',max_amount:'Monto máximo',min_term:'Plazo mínimo',max_term:'Plazo máximo',min_annual_rate:'Tasa anual mínima',max_annual_rate:'Tasa anual máxima',currency:'Moneda',term_unit:'Unidad de plazo',payment_frequency:'Frecuencia de pago',rate_type:'Tipo de tasa',interest_method:'Método de interés',amortization_method:'Método de amortización',min_dti:'DTI mínimo',max_dti:'DTI máximo',min_bureau_score:'Puntaje mínimo de buró',requires_bureau:'Requiere consulta de buró',calculation_type:'Tipo de cálculo',amount:'Importe o tasa',taxable:'Aplica impuesto',active:'Activo',document_type_id:'Tipo de documento',required:'Obligatorio',min_files:'Mínimo de archivos',max_files:'Máximo de archivos',display_order:'Orden de presentación',rule_code:'Clave de regla',operator:'Operador',rule_value:'Valor de regla',rejection_reason:'Motivo de rechazo',mandatory:'Obligatoria',custom_field_id:'Campo configurable',scope:'Ámbito',visible:'Visible'};
 fieldLabel(f:Field){return this.fieldLabels[f.key]??f.label;}
 recordLabel(s:typeof this.sections[number],row:Record<string,any>,i:number){const key=s.fields.find(f=>f.reference);const ref=key?.reference?this.refs[key.reference]?.find(r=>r.id===row[key.key]):undefined;return row['name']||row['rule_code']||(ref?this.label(ref):'')||'Registro '+(i+1);}
 
 data:Record<string,any>={status:'active'}; configuration:Record<string,any>={term_unit:'month',rate_type:'fixed',interest_method:'outstanding_balance',min_dti:0,max_dti:0.4,amortization_method:'french',payment_frequency:'monthly',currency:'MXN',requires_bureau:true};
 financial=setting('versiones_productos').fields.filter(f=>!['product_id','version','active','effective_from','effective_to'].includes(f.key));
 readonly generalFields=this.config.fields.filter(f=>f.key!=='status');
 readonly mainFinancial=this.financial.filter(f=>['min_amount','max_amount','min_annual_rate','max_annual_rate','currency'].includes(f.key));
 readonly financialGroups=[
 {title:'Intereses y amortización',icon:'calculate',keys:['rate_type','interest_method','amortization_method']},
 {title:'Capacidad de pago y buró de crédito',icon:'analytics',keys:['min_dti','max_dti','min_bureau_score','requires_bureau']}
 ].map(g=>({...g,fields:this.financial.filter(f=>g.keys.includes(f.key))}));
 selectTab(index:number):void {if(index<0||index>=this.tabs.length||index===this.tab)return;this.historical=null;this.tab=index;}
 trackField(_index:number,field:Field){return field.key;}
 trackGroup(_index:number,group:{title:string}){return group.title;}
 sections=[{key:'rules',relation:'credit_product_rules',fields:setting('reglas_productos').fields},{key:'fields',relation:'credit_product_fields',fields:setting('campos_productos').fields},{key:'documents',relation:'credit_product_documents',fields:setting('requisitos_documentales').fields},{key:'fees',relation:'credit_product_fees',fields:setting('comisiones_productos').fields}].map(s=>({...s,fields:s.fields.filter(f=>f.key!=='product_version_id')}));
 rows:Record<string,Record<string,any>[]>= {rules:[],fields:[],documents:[],fees:[]}; refs:Record<string,Item[]>={}; history:Item[]=[]; historical:Item|null=null; busy=false;saving=false;loadFailed=false;error='';
 get editable(){return !this.readonlyMode&&!this.historical&&!this.loadFailed;}
 get allowed(){return this.permissions.can(this.config,this.readonlyMode?'detalle':this.id?'editar':'crear');}
 ngOnInit(){
  if(!this.allowed){this.error='Sin permiso para esta operación.';return;}
  const refs=[...this.config.fields,...this.sections.flatMap(s=>s.fields)].filter(f=>f.reference);
  for(const f of refs){const key=f.reference!;if(this.refs[key])continue;this.refs[key]=[];this.loadRefs(key,1);}
  this.cargarPlazos();if(this.id){this.busy=true;this.api.detail(this.config.api,this.id).subscribe({next:r=>{this.data=r;this.configuration=r['current_version']??{};this.cargarPlazos();for(const s of this.sections)this.rows[s.key]=this.configuration[s.relation]??[];this.history=r['credit_product_versions']??[];this.busy=false;},error:e=>{this.loadFailed=true;this.fail(e);this.busy=false;}});}
 }
 loadRefs(key:string,page:number){this.api.list(setting(key).api,page).subscribe({next:r=>{this.refs[key].push(...r.data);if(page<r.last_page)this.loadRefs(key,page+1);},error:e=>this.fail(e)});}
 label(r:Item){return r['name']??r['legal_name']??r['label']??r['code']??r.id;}
 add(s:typeof this.sections[number]){const row:Record<string,any>={};for(const f of s.fields)if(f.type==='bool')row[f.key]=true;this.rows[s.key].push(row);}
 selectVersion(v:Item){this.historical=v;this.tab=6;}
 jsonValue(value:any){return typeof value==='string'?value:JSON.stringify(value??{},null,2);}
 payload(fields:Field[],data:Record<string,any>){const out:Record<string,any>={};for(const f of fields){let v=data[f.key];if(v===undefined||v===''){if(f.required)throw Error('Completa '+f.label);if(f.key==='parent_product_id'||f.key==='description'||f.key==='min_bureau_score'||f.key==='rejection_reason')out[f.key]=null;continue;}if(v===null){if(f.required)throw Error('Completa '+f.label);out[f.key]=null;continue;}if(f.type==='json'&&typeof v==='string')v=JSON.parse(v);if(f.type==='bool')v=v===true||v===1||v==='1';out[f.key]=v;}return out;}
 save(){if(!this.editable||!this.allowed||this.busy||this.saving)return;try{const p=this.payload(this.config.fields,this.data);if(!this.plazos.length||!this.frecuencias.includes(this.frecuenciaPredeterminada))throw Error('Configure plazos y frecuencias de pago.');const primero=this.plazos[0];this.configuration['min_term']=primero.plazo_minimo;this.configuration['max_term']=primero.plazo_maximo;this.configuration['term_unit']=({dia:'day',semana:'week',mes:'month',anio:'year'} as Record<string,string>)[primero.unidad_plazo];p['configuration']=this.payload(this.financial,this.configuration);p['configuration']['configuracion_plazos']={plazos:this.plazos,frecuencias_pago:this.frecuencias,frecuencia_pago_predeterminada:this.frecuenciaPredeterminada};for(const s of this.sections)p[s.key]=this.rows[s.key].map(r=>this.payload(s.fields,r));this.saving=true;this.error='';this.api.save(this.config.api,p,this.id??undefined).subscribe({next:()=>void this.router.navigate([this.home]),error:e=>{this.fail(e);this.saving=false;}});}catch(e){this.error=e instanceof Error?e.message:'Revisa los datos.';}}
 fail(e:any){this.error=Object.values(e.error?.errors??{}).flat().join(' · ')||e.error?.message||'No fue posible completar la operación.';}
}
