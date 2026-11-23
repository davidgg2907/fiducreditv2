import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {FormPage} from '../../shared/pages';
import {CamposDinamicosService} from '../../../../servicios/configuracion/campos_dinamicos.service';
@Component({selector:'app-campos-dinamicos-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./campos_dinamicos-form.component.html',styleUrls:['./campos_dinamicos-form.component.scss']})
export class CamposDinamicosFormComponent extends FormPage{
 readonly moduleService=inject(CamposDinamicosService);
 constructor(){super(setting('campos_dinamicos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}