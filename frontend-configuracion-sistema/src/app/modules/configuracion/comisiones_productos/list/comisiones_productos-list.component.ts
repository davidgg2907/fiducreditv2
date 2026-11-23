import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {ListPage} from '../../shared/pages';
import {ComisionesProductosService} from '../../../../servicios/configuracion/comisiones_productos.service';
@Component({selector:'app-comisiones-productos-list',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./comisiones_productos-list.component.html',styleUrls:['./comisiones_productos-list.component.scss']})
export class ComisionesProductosListComponent extends ListPage{
 readonly moduleService=inject(ComisionesProductosService);
 constructor(){super(setting('comisiones_productos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}