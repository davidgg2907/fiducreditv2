import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { MatDialog } from '@angular/material/dialog';
import { HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from '@angular/common/http';
import { Observable, of, throwError } from 'rxjs';
import { catchError, finalize, switchMap } from 'rxjs/operators';

import { runtimeConfig } from '../config/runtime-config';
import { SpinnerService } from '../servicios/utilerias/spinner.service';
import { AuthService } from '../servicios/auth/auth.service';

@Injectable({ providedIn: 'root' })
export class InterceptorService implements HttpInterceptor {
  private readonly skipLoadingHeader = 'X-Skip-Loading';
  private readonly api = new URL(runtimeConfig().appUrl, document.baseURI);

  constructor(
    private readonly spinnerService: SpinnerService,
    private readonly authService: AuthService,
    private readonly router: Router,
    private readonly dialogs: MatDialog,
  ) {}

  intercept(req: HttpRequest<unknown>, next: HttpHandler): Observable<HttpEvent<unknown>> {
    const skipLoading = req.headers.get(this.skipLoadingHeader) === 'true';
    const request = skipLoading ? req.clone({ headers: req.headers.delete(this.skipLoadingHeader) }) : req;
    const target = new URL(request.url, document.baseURI);
    const apiPath = target.origin === this.api.origin && target.pathname.startsWith(this.api.pathname)
      ? target.pathname.slice(this.api.pathname.length)
      : null;
    const protectedApi = apiPath !== null && !/^(?:login|logout|password)(?:\/|$)/.test(apiPath);
    const token = protectedApi ? this.authService.token() : null;

    if (!skipLoading) this.spinnerService.loadingOn();

    return next.handle(token ? this.withToken(request, token) : request).pipe(
      catchError(error => {
        if (error.status !== 401 || !protectedApi) {
          return throwError(() => error);
        }

        const current = this.authService.token();
        const renewal = current && current !== token ? of(true) : this.authService.refresh();

        return renewal.pipe(
          catchError(refreshError => {
            this.dialogs.closeAll();
            this.authService.clear();
            void this.router.navigate(['/login'], { queryParams: { sessionExpired: '1' }, replaceUrl: true });
            return throwError(() => refreshError);
          }),
          switchMap(() => {
            const renewed = this.authService.token();
            return renewed ? next.handle(this.withToken(request, renewed)) : throwError(() => error);
          }),
        );
      }),
      finalize(() => { if (!skipLoading) this.spinnerService.loadingOff(); }),
    );
  }

  private withToken(request: HttpRequest<unknown>, token: string): HttpRequest<unknown> {
    return request.clone({ setHeaders: { Authorization: 'Bearer ' + token } });
  }
}
