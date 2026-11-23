import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {FormPage} from '../../shared/pages';
import {SucursalesService} from '../../../../servicios/configuracion/sucursales.service';
@Component({selector:'app-sucursales-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./sucursales-form.component.html',styleUrls:['./sucursales-form.component.scss']})
export class SucursalesFormComponent extends FormPage{
 readonly moduleService=inject(SucursalesService);
 constructor(){super(setting('sucursales'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}