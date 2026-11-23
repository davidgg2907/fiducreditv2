import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../../../shared/api.service';
import {ConfigPermissions} from '../../../../shared/permissions.service';
import {setting} from '../../../../shared/schema';
import {DetailPage} from '../../../../shared/pages';
import {CamposProductosService} from '../../../../../../servicios/configuracion/campos_productos.service';
@Component({selector:'app-campos-productos-detalle',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./campos_productos-detalle.component.html',styleUrls:['./campos_productos-detalle.component.scss']})
export class CamposProductosDetalleComponent extends DetailPage{
 readonly moduleService=inject(CamposProductosService);
 constructor(){super(setting('campos_productos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}