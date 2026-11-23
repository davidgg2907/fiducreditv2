import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {ListPage} from '../../shared/pages';
import {PermisosService} from '../../../../servicios/configuracion/permisos.service';
@Component({selector:'app-permisos-list',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./permisos-list.component.html',styleUrls:['./permisos-list.component.scss']})
export class PermisosListComponent extends ListPage{
 readonly moduleService=inject(PermisosService);
 constructor(){super(setting('permisos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}