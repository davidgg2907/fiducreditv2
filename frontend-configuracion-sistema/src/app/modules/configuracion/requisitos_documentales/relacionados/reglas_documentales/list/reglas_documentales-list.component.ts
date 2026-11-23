import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../../../shared/api.service';
import {ConfigPermissions} from '../../../../shared/permissions.service';
import {setting} from '../../../../shared/schema';
import {ListPage} from '../../../../shared/pages';
import {ReglasDocumentalesService} from '../../../../../../servicios/configuracion/reglas_documentales.service';
@Component({selector:'app-reglas-documentales-list',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./reglas_documentales-list.component.html',styleUrls:['./reglas_documentales-list.component.scss']})
export class ReglasDocumentalesListComponent extends ListPage{
 readonly moduleService=inject(ReglasDocumentalesService);
 constructor(){super(setting('reglas_documentales'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}