import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../../../shared/api.service';
import {ConfigPermissions} from '../../../../shared/permissions.service';
import {setting} from '../../../../shared/schema';
import {FormPage} from '../../../../shared/pages';
import {AccionesService} from '../../../../../../servicios/configuracion/acciones.service';
@Component({selector:'app-acciones-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./acciones-form.component.html',styleUrls:['./acciones-form.component.scss']})
export class AccionesFormComponent extends FormPage{
 readonly moduleService=inject(AccionesService);
 constructor(){super(setting('acciones'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}