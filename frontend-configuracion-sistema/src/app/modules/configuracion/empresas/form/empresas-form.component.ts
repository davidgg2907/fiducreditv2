import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {FormPage} from '../../shared/pages';
import {EmpresasService} from '../../../../servicios/configuracion/empresas.service';
@Component({selector:'app-empresas-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./empresas-form.component.html',styleUrls:['./empresas-form.component.scss']})
export class EmpresasFormComponent extends FormPage{
 readonly moduleService=inject(EmpresasService);
 constructor(){super(setting('empresas'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}