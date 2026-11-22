import { Routes } from '@angular/router';
export const Full_ROUTES:Routes=[
 {path:'home',loadComponent:()=>import('../../modules/home/home.component').then(m=>m.HomeComponent)},
 {path:'perfil',loadComponent:()=>import('../../modules/profile/profile.component').then(m=>m.ProfileComponent)},
];
