import { Router } from '@angular/router';
import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { MatModule } from 'src/app/appModules/mat.module';
import { ProfileService } from 'src/app/servicios/auth/profile.service';
import { AuthService } from 'src/app/servicios/auth/auth.service';
@Component({standalone:true,imports:[CommonModule,ReactiveFormsModule,MatModule],templateUrl:'./profile.component.html',styleUrls:['./profile.component.scss']})
export class ProfileComponent implements OnInit {
 loading=true; saving=false;passwordSaving=false;error='';success='';
 profileForm=new FormGroup({nombre:new FormControl('',Validators.required),correo:new FormControl('',[Validators.required,Validators.email]),contrasena_actual:new FormControl('')});
 passwordForm=new FormGroup({contrasena_actual:new FormControl('',Validators.required),contrasena:new FormControl('',[Validators.required,Validators.minLength(12),Validators.maxLength(72)]),contrasena_confirmation:new FormControl('',Validators.required)});
 constructor(private readonly api:ProfileService,private readonly auth:AuthService,private readonly router:Router){}
 ngOnInit():void {this.api.get().subscribe({next:r=>{const p=r.data.personal??{};this.profileForm.patchValue({nombre:p.nombre??'',correo:p.correo??r.data.user.email});this.loading=false;},error:e=>{this.error=e.error?.message??'No fue posible cargar tu perfil.';this.loading=false;}})}
 saveProfile():void {
  if(this.profileForm.invalid){this.profileForm.markAllAsTouched();return;}
  this.saving=true;this.error='';this.success='';
  const data=new FormData();Object.entries(this.profileForm.getRawValue()).forEach(([key,value])=>data.append(key,key === 'contrasena_actual' ? value ?? '' : value?.trim() ?? ''));
  this.api.update(data).subscribe({next:r=>{this.saving=false;this.success=r.message;this.auth.updateSessionUser(r.data.user);this.profileForm.controls.contrasena_actual.reset();},error:e=>{this.saving=false;this.error=e.error?.message??'No fue posible actualizar el perfil.';}});
 }
 savePassword():void {
  if(this.passwordForm.invalid){this.passwordForm.markAllAsTouched();return;}
  const v=this.passwordForm.getRawValue();
  if(v.contrasena!==v.contrasena_confirmation){this.passwordForm.get('contrasena_confirmation')?.setErrors({mismatch:true});return;}
  this.passwordSaving=true;this.error='';this.success='';
  this.api.updatePassword(v as {contrasena_actual:string;contrasena:string;contrasena_confirmation:string}).subscribe({next:r=>{this.passwordSaving=false;this.success=r.message;this.passwordForm.reset();this.auth.clear();void this.router.navigate(['/login'],{replaceUrl:true});},error:e=>{this.passwordSaving=false;this.error=e.error?.message??'No fue posible actualizar contraseña.';}});
 }
}
