import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { AuthService } from 'src/app/servicios/auth/auth.service';
import { map } from 'rxjs';

export const authGuard: CanActivateFn = (_route, state) => {
  const auth = inject(AuthService);
  const router = inject(Router);
  return auth.ensureAuthenticated().pipe(map((valid) => valid ? true : router.createUrlTree(['/login'], { queryParams: { returnUrl: state.url } })));
};

export const guestGuard: CanActivateFn = () => {
  const auth = inject(AuthService);
  const router = inject(Router);
  return auth.ensureAuthenticated().pipe(map((valid) => valid ? router.createUrlTree(['/home']) : true));
};
