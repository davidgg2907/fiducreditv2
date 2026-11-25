import { HttpErrorResponse } from '@angular/common/http';

export function originacionError(error: HttpErrorResponse): string {
  if (error.status === 403) {
    return 'No tiene autorización en el servidor para esta operación.';
  }
  if (error.status === 405) {
    return 'La operación no está habilitada por el servidor.';
  }
  const errors = error.error?.errors;
  if (errors && typeof errors === 'object') {
    return Object.values(errors).flat().join(' ');
  }
  return error.error?.message ?? 'No fue posible completar la operación.';
}
