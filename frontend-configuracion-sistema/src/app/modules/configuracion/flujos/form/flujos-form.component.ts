import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {FormPage} from '../../shared/pages';
import {FlujosService} from '../../../../servicios/configuracion/flujos.service';
@Component({selector:'app-flujos-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./flujos-form.component.html',styleUrls:['./flujos-form.component.scss']})
export class FlujosFormComponent extends FormPage{
 readonly moduleService=inject(FlujosService);
 constructor(){super(setting('flujos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}