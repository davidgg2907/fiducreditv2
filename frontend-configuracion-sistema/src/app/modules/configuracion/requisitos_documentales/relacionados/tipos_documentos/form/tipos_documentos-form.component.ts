import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../../../shared/api.service';
import {ConfigPermissions} from '../../../../shared/permissions.service';
import {setting} from '../../../../shared/schema';
import {FormPage} from '../../../../shared/pages';
import {TiposDocumentosService} from '../../../../../../servicios/configuracion/tipos_documentos.service';
@Component({selector:'app-tipos-documentos-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./tipos_documentos-form.component.html',styleUrls:['./tipos_documentos-form.component.scss']})
export class TiposDocumentosFormComponent extends FormPage{
 readonly moduleService=inject(TiposDocumentosService);
 constructor(){super(setting('tipos_documentos'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}