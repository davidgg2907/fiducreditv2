import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {ListPage} from '../../shared/pages';
import {EmpresasService} from '../../../../servicios/configuracion/empresas.service';
@Component({selector:'app-empresas-list',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./empresas-list.component.html',styleUrls:['./empresas-list.component.scss']})
export class EmpresasListComponent extends ListPage{
 readonly moduleService=inject(EmpresasService);
 constructor(){super(setting('empresas'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}