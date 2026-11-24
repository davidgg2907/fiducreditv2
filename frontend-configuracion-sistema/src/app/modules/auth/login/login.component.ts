import { Component } from '@angular/core';
import { catchError, of } from 'rxjs';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { AuthService } from 'src/app/servicios/auth/auth.service';

@Component({ selector: 'app-login', standalone: true, imports: [CommonModule, FormsModule, RouterLink], templateUrl: './login.component.html', styleUrls:['./login.component.scss'] })
export class LoginComponent {
  logoFailed = false;
  heroFailed = false;
  readonly tituloSistema = 'Configuración de Sistema';
  readonly descripcionSistema = 'Parámetros, catálogos, usuarios y control operativo';
  onIllustrationError(): void { this.heroFailed = true; }
  onLogoError(): void { this.logoFailed = true; }

  email = ''; password = ''; remember = false; loading = false; error = '';
  constructor(private readonly auth: AuthService, private readonly router: Router, private readonly route: ActivatedRoute) {}
  get avisoSesion(): boolean { return this.route.snapshot.queryParamMap.get('sessionExpired')==='1'; }
  submit(): void {
    this.error = ''; this.loading = true;
    this.auth.login(this.email, this.password, this.remember).subscribe({
      next: (response) => { this.loading = false; if (!this.auth.isAuthenticated()) { this.error = response.message ?? 'La respuesta no incluyó un token de acceso.'; return; } void this.router.navigateByUrl(this.route.snapshot.queryParamMap.get('returnUrl') || '/home'); },
      error: (error) => {
        if (error?.status === 409) {
          // El servidor tiene una sesión única activa: probar primero la cookie existente.
          this.auth.refresh().pipe(catchError(() => of(false))).subscribe(restored => {
            this.loading = false;
            if (restored) void this.router.navigateByUrl('/home');
            else this.error = 'Existe una sesión activa en el servidor. Cierra la otra sesión o espera su vencimiento; no se ha creado una sesión nueva.';
          });
          return;
        }
        this.loading = false;
        this.error = error?.error?.message
          ?? (error?.status === 401 ? 'Usuario o contraseña incorrectos.' : 'No fue posible iniciar sesión.');
      }
    });
  }
}
