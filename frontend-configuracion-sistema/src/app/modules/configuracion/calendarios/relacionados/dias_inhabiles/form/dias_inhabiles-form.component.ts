import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../../../shared/api.service';
import {ConfigPermissions} from '../../../../shared/permissions.service';
import {setting} from '../../../../shared/schema';
import {FormPage} from '../../../../shared/pages';
import {DiasInhabilesService} from '../../../../../../servicios/configuracion/dias_inhabiles.service';
@Component({selector:'app-dias-inhabiles-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./dias_inhabiles-form.component.html',styleUrls:['./dias_inhabiles-form.component.scss']})
export class DiasInhabilesFormComponent extends FormPage{
 preselectedCalendar:any=null;
 get hasPreselectedCalendar(){return (this.refs['calendar_id']||[]).some(r=>r.id===this.preselectedCalendar?.id);}
 private readonly calendarRoute=inject(ActivatedRoute);
 private readonly calendarApi=inject(ConfigApi);
 override ngOnInit(){super.ngOnInit();if(!this.id){const calendar=this.calendarRoute.snapshot.queryParamMap.get('calendar_id');if(calendar){this.data['calendar_id']=calendar;this.calendarApi.detail(setting('calendarios').api,calendar).subscribe({next:r=>{this.preselectedCalendar=r;},error:()=>{}});}}}
 readonly moduleService=inject(DiasInhabilesService);
 constructor(){super(setting('dias_inhabiles'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}