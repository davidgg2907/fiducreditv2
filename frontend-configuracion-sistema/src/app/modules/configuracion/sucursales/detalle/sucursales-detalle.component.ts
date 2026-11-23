import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {DetailPage} from '../../shared/pages';
import {SucursalesService} from '../../../../servicios/configuracion/sucursales.service';
@Component({selector:'app-sucursales-detalle',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./sucursales-detalle.component.html',styleUrls:['./sucursales-detalle.component.scss']})
export class SucursalesDetalleComponent extends DetailPage{
 readonly moduleService=inject(SucursalesService);
 constructor(){super(setting('sucursales'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}