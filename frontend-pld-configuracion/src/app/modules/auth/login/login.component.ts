import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { runtimeConfig } from 'src/app/config/runtime-config';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { AuthService } from 'src/app/servicios/auth/auth.service';

@Component({ selector: 'app-login', standalone: true, imports: [CommonModule, FormsModule, RouterLink], templateUrl: './login.component.html', styleUrls:['./login.component.scss'] })
export class LoginComponent implements OnInit {
  logoUrl: string | null = null;
  logoFailed = false;
  readonly tituloSistema = 'Sistema de Recursos Humanos';
  imagenFondo = '';
  onIllustrationError(): void { this.imagenFondo = ''; }

  ngOnInit(): void {
    this.http.get<{data:{title:string;logo_url:string|null}}>(`${runtimeConfig().appUrl}login/branding`).subscribe({
      next: ({data}) => { this.logoUrl = data?.logo_url ? `${runtimeConfig().appUrl}${data.logo_url}` : null; },
      error: () => { this.logoUrl = null; }
    });
  }
  onLogoError(): void { this.logoFailed = true; this.logoUrl = null; }

  mfaRequired = false;
  mfaCode = '';
  email = ''; password = ''; remember = false; loading = false; error = '';
  constructor(private readonly auth: AuthService, private readonly router: Router, private readonly route: ActivatedRoute, private readonly http: HttpClient) {}
  get avisoSesion(): boolean { return this.route.snapshot.queryParamMap.get('sessionExpired')==='1'; }
  submit(): void {
    this.error = ''; this.loading = true;
    this.auth.login(this.email, this.password, this.remember, this.mfaRequired ? this.mfaCode : undefined).subscribe({
      next: (response) => { this.loading = false; if (!this.auth.isAuthenticated()) { this.error = response.message ?? 'La respuesta no incluyó un token de acceso.'; return; } void this.router.navigateByUrl(this.route.snapshot.queryParamMap.get('returnUrl') || '/home'); },
      error: (error) => {
        this.loading = false;
        if (error?.status === 401) this.mfaRequired = error?.error?.mfaRequired === true;
        this.mfaCode = '';
        this.error = error?.error?.message
          ?? (error?.status === 401 ? 'Usuario o contraseña incorrectos.' : 'No fue posible iniciar sesión.');
      }
    });
  }
}
