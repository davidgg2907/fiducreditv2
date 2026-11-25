import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {HttpErrorResponse} from '@angular/common/http';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {FormPage} from '../../shared/pages';
import {CalendariosService} from '../../../../servicios/configuracion/calendarios.service';
@Component({selector:'app-calendarios-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./calendarios-form.component.html',styleUrls:['./calendarios-form.component.scss']})
interface HolidayRow { id?:string; holiday_date:string; description:string; recurring:boolean; }
export class CalendariosFormComponent extends FormPage{
 readonly weekdays=[{id:1,label:'Lunes'},{id:2,label:'Martes'},{id:3,label:'Miércoles'},{id:4,label:'Jueves'},{id:5,label:'Viernes'},{id:6,label:'Sábado'},{id:0,label:'Domingo'}];
 readonly mexicanZones=[['America/Mexico_City','Ciudad de México / Centro'],['America/Monterrey','Monterrey'],['America/Cancun','Cancún'],['America/Merida','Mérida'],['America/Tijuana','Tijuana'],['America/Hermosillo','Hermosillo'],['America/Mazatlan','Mazatlán'],['America/Chihuahua','Chihuahua'],['America/Ciudad_Juarez','Ciudad Juárez'],['America/Ojinaga','Ojinaga'],['America/Matamoros','Matamoros'],['America/Bahia_Banderas','Bahía de Banderas'],['America/Tepic','Tepic']];
 readonly otherZones=((Intl as any).supportedValuesOf?.('timeZone') as string[]|undefined ?? ['America/New_York','America/Los_Angeles','America/Bogota','Europe/Madrid']).filter(z=>!this.mexicanZones.some(m=>m[0]===z)&&z!=='UTC');
 holidays:HolidayRow[]=[];
 loadFailed=false;
 override ngOnInit(){
   this.id=this.route.snapshot.paramMap.get('id');
   if(!this.id){super.ngOnInit();this.data['timezone']='America/Mexico_City';this.data['non_business_weekdays']='[0,6]';this.data['enabled']=true;this.data['due_date_adjustment']='next_business_day';return;}
   if(!this.can('editar')){this.error='Sin permiso para esta operación.';return;}
   this.busy=true;
   this.api.list(setting('empresas').api).subscribe({next:r=>this.refs['company_id']=r.data,error:()=>this.refs['company_id']=[]});
   this.api.detail(this.config.api,this.id).subscribe({next:r=>{
     for(const f of this.config.fields){const v=r[f.key];this.data[f.key]=f.type==='json'?JSON.stringify(v??[]):v??'';}
     this.data['enabled']=!!r['enabled'];
     const rows=r['credit_business_holidays'];
     if(!Array.isArray(rows)){this.loadFailed=true;this.error='No se pudieron cargar las fechas del calendario.';}
     else this.holidays=rows.map((h:any)=>({id:String(h.id),holiday_date:String(h.holiday_date).slice(0,10),description:String(h.description),recurring:!!h.recurring}));
     this.busy=false;
   },error:()=>{this.loadFailed=true;this.busy=false;this.error='No se pudo cargar el calendario.';}});
 }
 addHoliday(){this.holidays.push({holiday_date:'',description:'',recurring:false});}
 removeHoliday(index:number){if(!this.holidays[index]?.id)this.holidays.splice(index,1);}
 isMexicanZone(zone:string){return this.mexicanZones.some(z=>z[0]===zone);}
 get selectedDays():number[]{try{const v=JSON.parse(this.data['non_business_weekdays']||'[]');return Array.isArray(v)?v:[];}catch{return [];}}
 toggleDay(day:number,checked:boolean){const days=this.selectedDays;this.data['non_business_weekdays']=JSON.stringify(checked?[...new Set([...days,day])].sort((a,b)=>a-b):days.filter(d=>d!==day));}
 override save(){
   if(this.saving||this.busy||this.loadFailed||!this.can(this.id?'editar':'crear'))return;
   this.error='';
   if(!this.data['company_id']||!String(this.data['code']??'').trim()||!String(this.data['name']??'').trim()||!this.data['timezone']){this.error='Completa la información general.';return;}
   if(this.selectedDays.length===7){this.error='Debe existir al menos un día laborable.';return;}
   if(this.holidays.some(h=>!h.holiday_date||!h.description.trim()||h.description.length>150)){this.error='Completa la fecha y el motivo de cada día inhábil.';return;}
   if(new Set(this.holidays.map(h=>h.holiday_date)).size!==this.holidays.length){this.error='No se permiten fechas duplicadas.';return;}
   const payload:Record<string,unknown>={company_id:this.data['company_id'],code:this.data['code'],name:this.data['name'],timezone:this.data['timezone'],non_business_weekdays:this.selectedDays,enabled:!!this.data['enabled'],holidays:this.holidays.map(h=>({...h,description:h.description.trim()}))};
   if(this.data['due_date_adjustment'])payload['due_date_adjustment']=this.data['due_date_adjustment'];
   this.saving=true;
   this.api.save(this.config.api,payload,this.id??undefined).subscribe({next:()=>void this.router.navigate([this.home]),error:(e:HttpErrorResponse)=>{this.error=Object.values(e.error?.errors??{}).flat().join(' · ')||e.error?.message||'No se pudo guardar el calendario.';this.saving=false;}});
 }
 readonly moduleService=inject(CalendariosService);
 constructor(){super(setting('calendarios'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}