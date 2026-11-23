import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {ListPage} from '../../shared/pages';
import {SucursalesService} from '../../../../servicios/configuracion/sucursales.service';
@Component({selector:'app-sucursales-list',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./sucursales-list.component.html',styleUrls:['./sucursales-list.component.scss']})
export class SucursalesListComponent extends ListPage{
 readonly moduleService=inject(SucursalesService);
 constructor(){super(setting('sucursales'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}