import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {FormPage} from '../../shared/pages';
import {EtapasFlujosService} from '../../../../servicios/configuracion/etapas_flujos.service';
@Component({selector:'app-etapas-flujos-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./etapas_flujos-form.component.html',styleUrls:['./etapas_flujos-form.component.scss']})
export class EtapasFlujosFormComponent extends FormPage{
 readonly moduleService=inject(EtapasFlujosService);
 constructor(){super(setting('etapas_flujos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}