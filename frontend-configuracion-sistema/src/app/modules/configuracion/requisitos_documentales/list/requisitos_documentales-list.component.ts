import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {ListPage} from '../../shared/pages';
import {RequisitosDocumentalesService} from '../../../../servicios/configuracion/requisitos_documentales.service';
@Component({selector:'app-requisitos-documentales-list',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./requisitos_documentales-list.component.html',styleUrls:['./requisitos_documentales-list.component.scss']})
export class RequisitosDocumentalesListComponent extends ListPage{
 readonly moduleService=inject(RequisitosDocumentalesService);
 constructor(){super(setting('requisitos_documentales'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}