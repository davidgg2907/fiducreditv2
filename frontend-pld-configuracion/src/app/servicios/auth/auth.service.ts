import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject, Observable, catchError, defer, finalize, firstValueFrom, from, map, of, shareReplay, tap } from 'rxjs';
import { runtimeConfig } from 'src/app/config/runtime-config';
import { LoginResponse, SessionUser } from 'src/app/interfaces/auth/session';

@Injectable({ providedIn: 'root' })
export class AuthService {
  private readonly sessionUser$ = new BehaviorSubject<SessionUser | null>(null);
  private readonly options = { headers: { 'X-Auth-Request': '1' }, withCredentials: true };
  private readonly apiUrl = runtimeConfig().appUrl;
  private accessToken: string | null = null;
  private accessExpiresAt = 0;
  private refreshRequest$?: Observable<boolean>;

  constructor(private readonly http: HttpClient) {
    for (const key of ['auth.user', 'auth.access_token', 'auth.access_token_expires_at', 'auth.refresh_token', 'auth.remember', 'auth.last_activity_at']) {
      sessionStorage.removeItem(key);
      localStorage.removeItem(key);
    }
  }

  login(email: string, password: string, remember: boolean, mfaCode?: string): Observable<LoginResponse> {
    return this.serializeCookieRequest(() => this.http.post<LoginResponse>(
      this.apiUrl + 'login', { email, password, remember, mfa_code: mfaCode }, this.options,
    )).pipe(tap(response => this.persist(response)));
  }

  logout(): Observable<unknown> {
    return this.serializeCookieRequest(() => this.http.post(this.apiUrl + 'logout', {}, {
      ...this.options,
      headers: this.accessToken
        ? { ...this.options.headers, Authorization: 'Bearer ' + this.accessToken }
        : this.options.headers,
    })).pipe(tap(() => this.clear()));
  }

  forgotPassword(email: string): Observable<{ message: string }> {
    return this.http.post<{ message: string }>(this.apiUrl + 'password/forgot', { email }, this.options);
  }

  resetPassword(email: string, token: string, password: string, confirmation: string): Observable<{ message: string }> {
    return this.http.post<{ message: string }>(
      this.apiUrl + 'password/reset', { email, token, password, password_confirmation: confirmation }, this.options,
    );
  }

  clear(): void {
    this.accessToken = null;
    this.accessExpiresAt = 0;
    this.sessionUser$.next(null);
  }

  isAuthenticated(): boolean { return !!this.accessToken; }
  token(): string | null { return this.accessToken; }
  user(): SessionUser | null { return this.sessionUser$.value; }
  sessionUserChanges(): Observable<SessionUser | null> { return this.sessionUser$.asObservable(); }
  updateSessionUser(user: SessionUser): void { this.sessionUser$.next(user); }

  ensureAuthenticated(): Observable<boolean> {
    if (this.accessToken && this.accessExpiresAt > Date.now() + 60000) {
      return of(true);
    }

    return this.refresh().pipe(catchError(() => {
      this.clear();
      return of(false);
    }));
  }

  refresh(): Observable<boolean> {
    this.refreshRequest$ ??= this.serializeCookieRequest(() =>
      this.http.post<LoginResponse>(this.apiUrl + 'login/refresh', {}, this.options),
    ).pipe(
      tap(response => this.persist(response)),
      map(() => true),
      finalize(() => this.refreshRequest$ = undefined),
      shareReplay({ bufferSize: 1, refCount: false }),
    );

    return this.refreshRequest$;
  }

  private serializeCookieRequest<T>(request: () => Observable<T>): Observable<T> {
    return defer(() => navigator.locks
      ? from(navigator.locks.request('archetype-auth:' + this.apiUrl, () => firstValueFrom(request())))
      : request());
  }

  private persist(response: LoginResponse): void {
    const { user, tokens } = response.data;
    this.accessToken = tokens.accessToken;
    this.accessExpiresAt = Date.parse(tokens.accessTokenExpiresAt);
    this.updateSessionUser(user);
  }
}
