import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../../../shared/api.service';
import {ConfigPermissions} from '../../../../shared/permissions.service';
import {setting} from '../../../../shared/schema';
import {DetailPage} from '../../../../shared/pages';
import {PrioridadesPagoService} from '../../../../../../servicios/configuracion/prioridades_pago.service';
@Component({selector:'app-prioridades-pago-detalle',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./prioridades_pago-detalle.component.html',styleUrls:['./prioridades_pago-detalle.component.scss']})
export class PrioridadesPagoDetalleComponent extends DetailPage{
 readonly moduleService=inject(PrioridadesPagoService);
 constructor(){super(setting('prioridades_pago'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}