import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {FormPage} from '../../shared/pages';
import {ReglasFlujosService} from '../../../../servicios/configuracion/reglas_flujos.service';
@Component({selector:'app-reglas-flujos-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./reglas_flujos-form.component.html',styleUrls:['./reglas_flujos-form.component.scss']})
export class ReglasFlujosFormComponent extends FormPage{
 readonly moduleService=inject(ReglasFlujosService);
 constructor(){super(setting('reglas_flujos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}