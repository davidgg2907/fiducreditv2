import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {ListPage} from '../../shared/pages';
import {ProductosService} from '../../../../servicios/configuracion/productos.service';
@Component({selector:'app-productos-list',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./productos-list.component.html',styleUrls:['./productos-list.component.scss']})
export class ProductosListComponent extends ListPage{
 readonly moduleService=inject(ProductosService);
 constructor(){super(setting('productos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}