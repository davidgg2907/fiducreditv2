import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {DetailPage} from '../../shared/pages';
import {PoliticasPagoService} from '../../../../servicios/configuracion/politicas_pago.service';
@Component({selector:'app-politicas-pago-detalle',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./politicas_pago-detalle.component.html',styleUrls:['./politicas_pago-detalle.component.scss']})
export class PoliticasPagoDetalleComponent extends DetailPage{
 readonly moduleService=inject(PoliticasPagoService);
 constructor(){super(setting('politicas_pago'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}