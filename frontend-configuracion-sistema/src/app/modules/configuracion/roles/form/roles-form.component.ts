import {SYSTEMS,systemOf,roleSystems} from '../../shared/access-systems';
import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {FormPage} from '../../shared/pages';
import {RolesService} from '../../../../servicios/configuracion/roles.service';
@Component({selector:'app-roles-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./roles-form.component.html',styleUrls:['./roles-form.component.scss']})
export class RolesFormComponent extends FormPage{
 readonly systems=SYSTEMS;
 private chosen:string[]|null=null;
 get selectedSystems():string[]{return this.chosen??roleSystems(this.data['permissions']);}
 get visibleSystems(){return this.systems.filter(s=>this.selectedSystems.includes(s.code));}
 toggleSystem(code:string,on:boolean){
   this.chosen=on?[...new Set([...this.selectedSystems,code])]:this.selectedSystems.filter(s=>s!==code);
   if(!on)this.data['permissions']=(this.data['permissions']??[]).filter((p:string)=>systemOf(p)!==code);
 }
 modulesFor(code:string){
   const groups=new Map<string,{name:string;actions:typeof this.catalog}>();
   for(const action of this.catalog.filter(p=>systemOf(p.permission)===code)){
     const key=action.permission.split('.')[0];
     if(!groups.has(key))groups.set(key,{name:action.module,actions:[]});
     groups.get(key)!.actions.push(action);
   }
   return [...groups.values()];
 }
 override save(){
   if(this.selectedSystems.some(s=>!roleSystems(this.data['permissions']).includes(s))){
     this.error='Selecciona al menos una acción por cada sistema elegido.';return;
   }
   super.save();
 }
 readonly moduleService=inject(RolesService);
 constructor(){super(setting('roles'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}