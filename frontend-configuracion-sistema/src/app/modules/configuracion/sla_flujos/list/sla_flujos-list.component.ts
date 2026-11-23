import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {ListPage} from '../../shared/pages';
import {SlaFlujosService} from '../../../../servicios/configuracion/sla_flujos.service';
@Component({selector:'app-sla-flujos-list',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./sla_flujos-list.component.html',styleUrls:['./sla_flujos-list.component.scss']})
export class SlaFlujosListComponent extends ListPage{
 readonly moduleService=inject(SlaFlujosService);
 constructor(){super(setting('sla_flujos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}