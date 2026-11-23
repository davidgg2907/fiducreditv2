import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {ListPage} from '../../shared/pages';
import {AsesoresService} from '../../../../servicios/configuracion/asesores.service';
@Component({selector:'app-asesores-list',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./asesores-list.component.html',styleUrls:['./asesores-list.component.scss']})
export class AsesoresListComponent extends ListPage{
 readonly moduleService=inject(AsesoresService);
 constructor(){super(setting('asesores'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}