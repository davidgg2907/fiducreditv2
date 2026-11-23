import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {DetailPage} from '../../shared/pages';
import {EtapasFlujosService} from '../../../../servicios/configuracion/etapas_flujos.service';
@Component({selector:'app-etapas-flujos-detalle',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./etapas_flujos-detalle.component.html',styleUrls:['./etapas_flujos-detalle.component.scss']})
export class EtapasFlujosDetalleComponent extends DetailPage{
 readonly moduleService=inject(EtapasFlujosService);
 constructor(){super(setting('etapas_flujos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}