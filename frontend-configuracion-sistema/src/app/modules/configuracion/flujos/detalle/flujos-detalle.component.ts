import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {DetailPage} from '../../shared/pages';
import {FlujosService} from '../../../../servicios/configuracion/flujos.service';
@Component({selector:'app-flujos-detalle',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./flujos-detalle.component.html',styleUrls:['./flujos-detalle.component.scss']})
export class FlujosDetalleComponent extends DetailPage{
 readonly moduleService=inject(FlujosService);
 constructor(){super(setting('flujos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}