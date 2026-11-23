import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../../../shared/api.service';
import {ConfigPermissions} from '../../../../shared/permissions.service';
import {setting} from '../../../../shared/schema';
import {ListPage} from '../../../../shared/pages';
import {TiposDocumentosService} from '../../../../../../servicios/configuracion/tipos_documentos.service';
@Component({selector:'app-tipos-documentos-list',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./tipos_documentos-list.component.html',styleUrls:['./tipos_documentos-list.component.scss']})
export class TiposDocumentosListComponent extends ListPage{
 readonly moduleService=inject(TiposDocumentosService);
 constructor(){super(setting('tipos_documentos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}