import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {DetailPage} from '../../shared/pages';
import {ProductosService} from '../../../../servicios/configuracion/productos.service';
@Component({selector:'app-productos-detalle',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./productos-detalle.component.html',styleUrls:['./productos-detalle.component.scss']})
export class ProductosDetalleComponent extends DetailPage{
 readonly moduleService=inject(ProductosService);
 constructor(){super(setting('productos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}