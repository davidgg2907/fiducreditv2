import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {FormPage} from '../../shared/pages';
import {CalendariosService} from '../../../../servicios/configuracion/calendarios.service';
@Component({selector:'app-calendarios-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./calendarios-form.component.html',styleUrls:['./calendarios-form.component.scss']})
export class CalendariosFormComponent extends FormPage{
 readonly weekdays=[{id:1,label:'Lunes'},{id:2,label:'Martes'},{id:3,label:'Miércoles'},{id:4,label:'Jueves'},{id:5,label:'Viernes'},{id:6,label:'Sábado'},{id:0,label:'Domingo'}];
 readonly mexicanZones=[['America/Mexico_City','Ciudad de México / Centro'],['America/Monterrey','Monterrey'],['America/Cancun','Cancún'],['America/Merida','Mérida'],['America/Tijuana','Tijuana'],['America/Hermosillo','Hermosillo'],['America/Mazatlan','Mazatlán'],['America/Chihuahua','Chihuahua'],['America/Ciudad_Juarez','Ciudad Juárez'],['America/Ojinaga','Ojinaga'],['America/Matamoros','Matamoros'],['America/Bahia_Banderas','Bahía de Banderas'],['America/Tepic','Tepic']];
 readonly otherZones=((Intl as any).supportedValuesOf?.('timeZone') as string[]|undefined ?? ['America/New_York','America/Los_Angeles','America/Bogota','Europe/Madrid']).filter(z=>!this.mexicanZones.some(m=>m[0]===z)&&z!=='UTC');
 override ngOnInit(){super.ngOnInit();if(!this.id){this.data['timezone']='America/Mexico_City';this.data['non_business_weekdays']='[0,6]';this.data['enabled']=true;this.data['due_date_adjustment']='next_business_day';}}
 isMexicanZone(zone:string){return this.mexicanZones.some(z=>z[0]===zone);}
 get selectedDays():number[]{try{const v=JSON.parse(this.data['non_business_weekdays']||'[]');return Array.isArray(v)?v:[];}catch{return [];}}
 toggleDay(day:number,checked:boolean){const days=this.selectedDays;this.data['non_business_weekdays']=JSON.stringify(checked?[...new Set([...days,day])].sort((a,b)=>a-b):days.filter(d=>d!==day));}
 override save(){if(this.selectedDays.length===7){this.error='Debe existir al menos un día laborable.';return;}super.save();}
 readonly moduleService=inject(CalendariosService);
 constructor(){super(setting('calendarios'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}