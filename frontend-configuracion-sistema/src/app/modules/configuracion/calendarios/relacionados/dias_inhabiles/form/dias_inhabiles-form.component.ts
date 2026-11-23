import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../../../shared/api.service';
import {ConfigPermissions} from '../../../../shared/permissions.service';
import {setting} from '../../../../shared/schema';
import {FormPage} from '../../../../shared/pages';
import {DiasInhabilesService} from '../../../../../../servicios/configuracion/dias_inhabiles.service';
@Component({selector:'app-dias-inhabiles-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./dias_inhabiles-form.component.html',styleUrls:['./dias_inhabiles-form.component.scss']})
export class DiasInhabilesFormComponent extends FormPage{
 readonly moduleService=inject(DiasInhabilesService);
 constructor(){super(setting('dias_inhabiles'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}