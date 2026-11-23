import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { AuthService } from 'src/app/servicios/auth/auth.service';

@Component({ selector: 'app-login', standalone: true, imports: [CommonModule, FormsModule, RouterLink], templateUrl: './login.component.html', styleUrls:['./login.component.scss'] })
export class LoginComponent {
  logoFailed = false;
  heroFailed = false;
  readonly tituloSistema = 'Operación PLD';
  readonly descripcionSistema = 'Monitoreo, alertamiento e investigación preventiva';
  onIllustrationError(): void { this.heroFailed = true; }
  onLogoError(): void { this.logoFailed = true; }

  mfaRequired = false;
  mfaCode = '';
  email = ''; password = ''; remember = false; loading = false; error = '';
  constructor(private readonly auth: AuthService, private readonly router: Router, private readonly route: ActivatedRoute) {}
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
