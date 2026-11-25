import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { OriginacionAction, OriginacionPermissionsService } from '../servicios/originacion/originacion-permissions.service';

export const originacionPermissionGuard: CanActivateFn = route => {
  const permissions = inject(OriginacionPermissionsService);
  const router = inject(Router);
  return permissions.can(route.data['module'], route.data['action'] as OriginacionAction)
    ? true
    : router.createUrlTree(['/home']);
};
