import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../../../shared/api.service';
import {ConfigPermissions} from '../../../../shared/permissions.service';
import {setting} from '../../../../shared/schema';
import {ListPage} from '../../../../shared/pages';
import {VersionesFlujosService} from '../../../../../../servicios/configuracion/versiones_flujos.service';
@Component({selector:'app-versiones-flujos-list',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./versiones_flujos-list.component.html',styleUrls:['./versiones_flujos-list.component.scss']})
export class VersionesFlujosListComponent extends ListPage{
 readonly moduleService=inject(VersionesFlujosService);
 constructor(){super(setting('versiones_flujos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}