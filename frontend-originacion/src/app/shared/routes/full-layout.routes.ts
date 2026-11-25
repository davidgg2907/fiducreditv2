import { Routes } from '@angular/router';
import { pendingModuleGuard } from '../../guards/pending-module.guard';
export const Full_ROUTES: Routes = [
  { path: 'home', loadComponent: () => import('../../modules/home/home.component').then(m => m.HomeComponent) },
  { path: 'perfil', loadComponent: () => import('../../modules/profile/profile.component').then(m => m.ProfileComponent) },
  { path: '**', canActivate: [pendingModuleGuard], loadComponent: () => import('../../modules/pending-module/pending-module.component').then(m => m.PendingModuleComponent) },
];
