import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {FormPage} from '../../shared/pages';
import {VersionesProductosService} from '../../../../servicios/configuracion/versiones_productos.service';
@Component({selector:'app-versiones-productos-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./versiones_productos-form.component.html',styleUrls:['./versiones_productos-form.component.scss']})
export class VersionesProductosFormComponent extends FormPage{
 readonly moduleService=inject(VersionesProductosService);
 constructor(){super(setting('versiones_productos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}