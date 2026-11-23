import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {ListPage} from '../../shared/pages';
import {PoliticasLineaService} from '../../../../servicios/configuracion/politicas_linea.service';
@Component({selector:'app-politicas-linea-list',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./politicas_linea-list.component.html',styleUrls:['./politicas_linea-list.component.scss']})
export class PoliticasLineaListComponent extends ListPage{
 readonly moduleService=inject(PoliticasLineaService);
 constructor(){super(setting('politicas_linea'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}