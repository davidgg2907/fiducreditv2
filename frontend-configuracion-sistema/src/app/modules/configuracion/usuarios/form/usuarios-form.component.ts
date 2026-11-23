import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {FormPage} from '../../shared/pages';
import {UsuariosService} from '../../../../servicios/configuracion/usuarios.service';
@Component({selector:'app-usuarios-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./usuarios-form.component.html',styleUrls:['./usuarios-form.component.scss']})
export class UsuariosFormComponent extends FormPage{
 readonly moduleService=inject(UsuariosService);
 constructor(){super(setting('usuarios'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}