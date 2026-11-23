import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {ListPage} from '../../shared/pages';
import {FlujosService} from '../../../../servicios/configuracion/flujos.service';
@Component({selector:'app-flujos-list',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./flujos-list.component.html',styleUrls:['./flujos-list.component.scss']})
export class FlujosListComponent extends ListPage{
 readonly moduleService=inject(FlujosService);
 constructor(){super(setting('flujos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}