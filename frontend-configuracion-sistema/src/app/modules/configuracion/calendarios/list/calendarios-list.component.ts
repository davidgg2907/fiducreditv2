import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {ListPage} from '../../shared/pages';
import {CalendariosService} from '../../../../servicios/configuracion/calendarios.service';
@Component({selector:'app-calendarios-list',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./calendarios-list.component.html',styleUrls:['./calendarios-list.component.scss']})
export class CalendariosListComponent extends ListPage{
 readonly moduleService=inject(CalendariosService);
 constructor(){super(setting('calendarios'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}