import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { ProfileResponse } from 'src/app/interfaces/auth/profile-response.interface';
import { runtimeConfig } from 'src/app/config/runtime-config';

@Injectable({ providedIn: 'root' })
export class ProfileService {
  constructor(private readonly http: HttpClient) {}
  get(): Observable<ProfileResponse> { return this.http.get<ProfileResponse>(`${runtimeConfig().appUrl}perfil`); }
  update(data: FormData): Observable<any> { return this.http.post(`${runtimeConfig().appUrl}perfil`, data); }
  updatePassword(data: { contrasena_actual: string; contrasena: string; contrasena_confirmation: string }): Observable<any> { return this.http.post(`${runtimeConfig().appUrl}perfil/contrasena`, data); }
}
