import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { map, take } from 'rxjs';
import { NavigationStateService } from '../shared/navigation/navigation-state.service';

export const pendingModuleGuard: CanActivateFn = (_route, state) => {
  const navigation = inject(NavigationStateService);
  const router = inject(Router);
  const path = state.url.split(/[?#]/, 1)[0];
  return navigation.getMenuItems().pipe(take(1), map(items =>
    navigation.findItem(items, path) ? true : router.createUrlTree(['/home'])
  ));
};
