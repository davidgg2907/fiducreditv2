import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../../../shared/api.service';
import {ConfigPermissions} from '../../../../shared/permissions.service';
import {setting} from '../../../../shared/schema';
import {DetailPage} from '../../../../shared/pages';
import {DiasInhabilesService} from '../../../../../../servicios/configuracion/dias_inhabiles.service';
@Component({selector:'app-dias-inhabiles-detalle',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./dias_inhabiles-detalle.component.html',styleUrls:['./dias_inhabiles-detalle.component.scss']})
export class DiasInhabilesDetalleComponent extends DetailPage{
 readonly moduleService=inject(DiasInhabilesService);
 constructor(){super(setting('dias_inhabiles'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}