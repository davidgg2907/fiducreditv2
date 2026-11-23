import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../../../shared/api.service';
import {ConfigPermissions} from '../../../../shared/permissions.service';
import {setting} from '../../../../shared/schema';
import {FormPage} from '../../../../shared/pages';
import {TransicionesFlujosService} from '../../../../../../servicios/configuracion/transiciones_flujos.service';
@Component({selector:'app-transiciones-flujos-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./transiciones_flujos-form.component.html',styleUrls:['./transiciones_flujos-form.component.scss']})
export class TransicionesFlujosFormComponent extends FormPage{
 readonly moduleService=inject(TransicionesFlujosService);
 constructor(){super(setting('transiciones_flujos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}