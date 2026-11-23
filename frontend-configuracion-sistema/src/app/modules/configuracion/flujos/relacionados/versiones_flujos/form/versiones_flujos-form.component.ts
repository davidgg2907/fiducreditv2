import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../../../shared/api.service';
import {ConfigPermissions} from '../../../../shared/permissions.service';
import {setting} from '../../../../shared/schema';
import {FormPage} from '../../../../shared/pages';
import {VersionesFlujosService} from '../../../../../../servicios/configuracion/versiones_flujos.service';
@Component({selector:'app-versiones-flujos-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./versiones_flujos-form.component.html',styleUrls:['./versiones_flujos-form.component.scss']})
export class VersionesFlujosFormComponent extends FormPage{
 readonly moduleService=inject(VersionesFlujosService);
 constructor(){super(setting('versiones_flujos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}