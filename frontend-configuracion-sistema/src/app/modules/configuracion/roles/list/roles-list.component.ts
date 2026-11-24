import {SYSTEMS,roleSystems} from '../../shared/access-systems';
import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {ListPage} from '../../shared/pages';
import {RolesService} from '../../../../servicios/configuracion/roles.service';
@Component({selector:'app-roles-list',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./roles-list.component.html',styleUrls:['./roles-list.component.scss']})
export class RolesListComponent extends ListPage{
 systemNames(permissions:unknown):string{
   const codes=roleSystems(permissions);
   return SYSTEMS.filter(system=>codes.includes(system.code)).map(system=>system.name).join(', ') || 'Sin sistema asignado';
 }
 readonly moduleService=inject(RolesService);
 constructor(){super(setting('roles'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}