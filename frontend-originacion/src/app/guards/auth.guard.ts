import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { AuthService } from 'src/app/servicios/auth/auth.service';
import { catchError, map, of, switchMap } from 'rxjs';

export const authGuard: CanActivateFn = (_route, state) => {
  const auth = inject(AuthService);
  const router = inject(Router);
  const login = router.createUrlTree(['/login'], { queryParams: { returnUrl: state.url } });
  return auth.ensureAuthenticated().pipe(
    switchMap(valid => valid ? auth.loadProfile().pipe(map(() => true)) : of(login)),
    catchError(() => { auth.clear(); return of(login); }),
  );
};

export const guestGuard: CanActivateFn = () => {
  const auth = inject(AuthService);
  const router = inject(Router);
  return auth.ensureAuthenticated().pipe(map(valid => valid ? router.createUrlTree(['/home']) : true));
};
