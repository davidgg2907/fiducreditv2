import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';
import { FullLayoutComponent } from './layouts/full/full-layout.component';
import { Full_ROUTES } from './shared/routes/full-layout.routes';
import { authGuard, guestGuard } from './guards/auth.guard';
const routes:Routes=[
 {path:'',redirectTo:'home',pathMatch:'full'},
 {path:'login',canActivate:[guestGuard],loadComponent:()=>import('./modules/auth/login/login.component').then(m=>m.LoginComponent)},
 {path:'recuperar-acceso',loadComponent:()=>import('./modules/auth/password-recovery/password-recovery.component').then(m=>m.PasswordRecoveryComponent)},
 {path:'',component:FullLayoutComponent,canActivate:[authGuard],children:Full_ROUTES},
 {path:'**',redirectTo:'login'}
];
@NgModule({imports:[RouterModule.forRoot(routes,{preloadingStrategy:PreloadAllModules})],exports:[RouterModule]})
export class AppRoutingModule {}
