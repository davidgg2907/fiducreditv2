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
 readonly moduleService=inject(CalendariosService);
 constructor(){super(setting('calendarios'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}