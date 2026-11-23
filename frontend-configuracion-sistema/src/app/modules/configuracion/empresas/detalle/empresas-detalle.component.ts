import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {DetailPage} from '../../shared/pages';
import {EmpresasService} from '../../../../servicios/configuracion/empresas.service';
@Component({selector:'app-empresas-detalle',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./empresas-detalle.component.html',styleUrls:['./empresas-detalle.component.scss']})
export class EmpresasDetalleComponent extends DetailPage{
 readonly moduleService=inject(EmpresasService);
 constructor(){super(setting('empresas'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}