import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {DetailPage} from '../../shared/pages';
import {ReglasProductosService} from '../../../../servicios/configuracion/reglas_productos.service';
@Component({selector:'app-reglas-productos-detalle',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./reglas_productos-detalle.component.html',styleUrls:['./reglas_productos-detalle.component.scss']})
export class ReglasProductosDetalleComponent extends DetailPage{
 readonly moduleService=inject(ReglasProductosService);
 constructor(){super(setting('reglas_productos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}