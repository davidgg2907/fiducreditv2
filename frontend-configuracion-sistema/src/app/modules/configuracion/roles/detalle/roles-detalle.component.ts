import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {DetailPage} from '../../shared/pages';
import {RolesService} from '../../../../servicios/configuracion/roles.service';
@Component({selector:'app-roles-detalle',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./roles-detalle.component.html',styleUrls:['./roles-detalle.component.scss']})
export class RolesDetalleComponent extends DetailPage{
 readonly moduleService=inject(RolesService);
 constructor(){super(setting('roles'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}