import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {ListPage} from '../../shared/pages';
import {MenusService} from '../../../../servicios/configuracion/menus.service';
@Component({selector:'app-menus-list',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./menus-list.component.html',styleUrls:['./menus-list.component.scss']})
export class MenusListComponent extends ListPage{
 readonly moduleService=inject(MenusService);
 constructor(){super(setting('menus'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}