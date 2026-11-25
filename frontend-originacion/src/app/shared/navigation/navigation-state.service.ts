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
  findItem(items: MenuItem[], path: string): MenuItem | undefined {
    for (const item of items) {
      if (item.routerLink === path) return item;
      const child = this.findItem(item.children ?? [], path);
      if (child) return child;
    }
    return undefined;
  }
  getHeaderState(url: string): Observable<HeaderState> {
    const path = url.split(/[?#]/, 1)[0];
    return this.getMenuItems().pipe(map(items => ({
      title: this.findItem(items, path)?.text ?? 'Panel principal',
      subtitle: 'Originación de Crédito',
    })));
  }
}
