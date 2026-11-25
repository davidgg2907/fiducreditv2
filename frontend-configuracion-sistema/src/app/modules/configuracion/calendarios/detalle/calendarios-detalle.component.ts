import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {DetailPage} from '../../shared/pages';
import {CalendariosService} from '../../../../servicios/configuracion/calendarios.service';
@Component({selector:'app-calendarios-detalle',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./calendarios-detalle.component.html',styleUrls:['./calendarios-detalle.component.scss']})
export class CalendariosDetalleComponent extends DetailPage{
 weekdayNames(value:unknown):string{const names=['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];return Array.isArray(value)?(value.length?value.map(d=>names[d]??String(d)).join(', '):'Ninguno'):'Sin configurar';}

 readonly moduleService=inject(CalendariosService);
 constructor(){super(setting('calendarios'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}