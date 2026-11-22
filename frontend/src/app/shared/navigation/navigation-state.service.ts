import { Injectable } from '@angular/core';
import { Observable, map } from 'rxjs';
import { MenuItem } from 'src/app/interfaces/auth/session';
import { AuthService } from 'src/app/servicios/auth/auth.service';

export interface HeaderState { title: string; subtitle: string }

@Injectable({ providedIn: 'root' })
export class NavigationStateService {
  constructor(private readonly auth: AuthService) {}

  getMenuItems(): Observable<MenuItem[]> {
    return this.auth.sessionUserChanges().pipe(map(user => user?.menu ?? []));
  }

  getHeaderState(url: string): Observable<HeaderState> {
    const path = url.split(/[?#]/, 1)[0];
    return this.getMenuItems().pipe(map(items => {
      const links = items.flatMap(item => item.children ?? [item]);
      const item = links.find(candidate => candidate.routerLink === path);
      return { title: item?.text ?? 'Panel principal', subtitle: 'Administración' };
    }));
  }
}
