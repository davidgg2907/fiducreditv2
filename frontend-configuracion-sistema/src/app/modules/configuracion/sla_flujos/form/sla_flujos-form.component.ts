import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {FormPage} from '../../shared/pages';
import {SlaFlujosService} from '../../../../servicios/configuracion/sla_flujos.service';
@Component({selector:'app-sla-flujos-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./sla_flujos-form.component.html',styleUrls:['./sla_flujos-form.component.scss']})
export class SlaFlujosFormComponent extends FormPage{
 readonly moduleService=inject(SlaFlujosService);
 constructor(){super(setting('sla_flujos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}