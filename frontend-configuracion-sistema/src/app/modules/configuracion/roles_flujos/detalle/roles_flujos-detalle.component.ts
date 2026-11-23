import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {DetailPage} from '../../shared/pages';
import {RolesFlujosService} from '../../../../servicios/configuracion/roles_flujos.service';
@Component({selector:'app-roles-flujos-detalle',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./roles_flujos-detalle.component.html',styleUrls:['./roles_flujos-detalle.component.scss']})
export class RolesFlujosDetalleComponent extends DetailPage{
 readonly moduleService=inject(RolesFlujosService);
 constructor(){super(setting('roles_flujos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}