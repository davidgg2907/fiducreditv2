import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {DetailPage} from '../../shared/pages';
import {ReglasFlujosService} from '../../../../servicios/configuracion/reglas_flujos.service';
@Component({selector:'app-reglas-flujos-detalle',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./reglas_flujos-detalle.component.html',styleUrls:['./reglas_flujos-detalle.component.scss']})
export class ReglasFlujosDetalleComponent extends DetailPage{
 readonly moduleService=inject(ReglasFlujosService);
 constructor(){super(setting('reglas_flujos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}