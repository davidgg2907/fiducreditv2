import { Component } from '@angular/core';
import {catchError,of} from 'rxjs';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { AuthService } from 'src/app/servicios/auth/auth.service';

@Component({ selector: 'app-login', standalone: true, imports: [CommonModule, FormsModule, RouterLink], templateUrl: './login.component.html', styleUrls:['./login.component.scss'] })
export class LoginComponent {
  logoFailed = false;
  heroFailed = false;
  readonly tituloSistema = 'Originación de Crédito';
  readonly descripcionSistema = 'Captura, validación y seguimiento de solicitudes';
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
        if(error?.status===409){
          this.auth.refresh().pipe(catchError(()=>of(false))).subscribe(restored=>{
            this.loading=false;
            if(restored)void this.router.navigateByUrl('/home');
            else if (window.confirm('Existe una sesión activa. ¿Deseas cerrar la sesión anterior e ingresar en este dispositivo?')) {
              this.loading = true;
              this.auth.login(this.email, this.password, this.remember, undefined, true).subscribe({
                next: () => {this.loading = false; void this.router.navigateByUrl('/home');},
                error: (takeoverError) => {this.loading = false; this.error = takeoverError?.error?.message ?? 'No se pudo sustituir la sesión anterior.';}
              });
            } else this.error = 'La sesión anterior permanece activa.';

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
