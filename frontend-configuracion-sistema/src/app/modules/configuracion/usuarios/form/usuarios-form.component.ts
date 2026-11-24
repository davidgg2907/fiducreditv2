import {SYSTEMS,roleSystems} from '../../shared/access-systems';
import {Item} from '../../shared/schema';
import {Component,inject} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormsModule} from '@angular/forms';
import {RouterModule,Router,ActivatedRoute} from '@angular/router';
import {ConfigApi} from '../../shared/api.service';
import {ConfigPermissions} from '../../shared/permissions.service';
import {setting} from '../../shared/schema';
import {FormPage} from '../../shared/pages';
import {UsuariosService} from '../../../../servicios/configuracion/usuarios.service';
@Component({selector:'app-usuarios-form',standalone:true,imports:[CommonModule,FormsModule,RouterModule],templateUrl:'./usuarios-form.component.html',styleUrls:['./usuarios-form.component.scss']})
export class UsuariosFormComponent extends FormPage{
 readonly systems=SYSTEMS;
 allRoles:Item[]=[];
 rolesLoading=true;
 rolesFailed=false;
 private chosenSystem:string|null=null;
 override ngOnInit(){
   super.ngOnInit();
   if(this.can(this.id?'editar':'crear'))this.loadRoles(1);
 }
 private loadRoles(page:number){
   this.api.list('access/roles',page).subscribe({
     next:r=>{this.allRoles=[...this.allRoles,...r.data];if(page<r.last_page)this.loadRoles(page+1);else this.rolesLoading=false;},
     error:()=>{this.rolesLoading=false;this.rolesFailed=true;this.error='No se pudo cargar el catálogo completo de roles.';}
   });
 }
 get selectedSystem():string{
   if(this.chosenSystem!==null)return this.chosenSystem;
   const role=this.allRoles.find(r=>String(r.id)===String(this.data['role_id']));
   return role?(roleSystems(role['permissions'])[0]??'general'):'';
 }
 get filteredRoles():Item[]{
   if(!this.selectedSystem)return [];
   return this.allRoles.filter(r=>this.selectedSystem==='general'?roleSystems(r['permissions']).length===0:roleSystems(r['permissions']).includes(this.selectedSystem));
 }
 selectSystem(code:string){
   this.chosenSystem=code;
   if(!this.filteredRoles.some(r=>String(r.id)===String(this.data['role_id'])))this.data['role_id']='';
 }
 override save(){
   if(this.rolesLoading||this.rolesFailed)return;
   if(this.data['role_id']&&!this.filteredRoles.some(r=>String(r.id)===String(this.data['role_id']))){
     this.error='Selecciona un rol del sistema elegido.';return;
   }
   if(this.selectedSystem&&!this.data['role_id']){this.error='Selecciona un rol para el sistema elegido.';return;}
   if(this.id&&!this.data['role_id']){this.error='Selecciona un rol; la retirada de roles existentes no está habilitada en este formulario.';return;}
   super.save();
 }
 readonly moduleService=inject(UsuariosService);
 constructor(){super(setting('usuarios'),inject(ConfigApi),inject(ConfigPermissions),inject(Router),inject(ActivatedRoute));}
}