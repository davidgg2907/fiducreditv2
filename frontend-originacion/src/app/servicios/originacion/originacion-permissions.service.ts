import { Injectable, inject } from '@angular/core';
import { AuthService } from '../auth/auth.service';

export type OriginacionAction = 'ver' | 'detalle' | 'crear' | 'editar' | 'eliminar';

@Injectable({ providedIn: 'root' })
export class OriginacionPermissionsService {
  private readonly auth = inject(AuthService);

  can(module: string, action: OriginacionAction): boolean {
    const user = this.auth.user();
    return user?.isAdmin === true ||
      (user?.permissions ?? []).includes('credit_originacion_' + module + '.' + action);
  }
}
