import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {FormPage} from '../../shared/pages';
import {MenusService} from '../../../../servicios/configuracion/menus.service';
@Component({selector:'app-menus-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./menus-form.component.html',styleUrls:['./menus-form.component.scss']})
export class MenusFormComponent extends FormPage{
 readonly moduleService=inject(MenusService);
 constructor(){super(setting('menus'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}