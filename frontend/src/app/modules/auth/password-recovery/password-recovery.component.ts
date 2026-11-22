import { Component, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ActivatedRoute, RouterLink } from '@angular/router';
import { AuthService } from 'src/app/servicios/auth/auth.service';

@Component({
  standalone: true,
  imports: [CommonModule, FormsModule, RouterLink],
  templateUrl: './password-recovery.component.html',
  styleUrls: ['../login/login.component.scss'],
})
export class PasswordRecoveryComponent {
  private readonly route = inject(ActivatedRoute);
  private readonly auth = inject(AuthService);
  readonly token = this.route.snapshot.queryParamMap.get('token');
  email = this.route.snapshot.queryParamMap.get('email') ?? '';
  password = '';
  confirmation = '';
  loading = false;
  error = '';
  message = '';

  submit(): void {
    this.loading = true;
    this.error = '';

    const request = this.token
      ? this.auth.resetPassword(this.email, this.token, this.password, this.confirmation)
      : this.auth.forgotPassword(this.email);
    request.subscribe({
      next: ({ message }) => {
        this.message = message;
        this.loading = false;
        this.password = '';
        this.confirmation = '';
      },
      error: response => {
        this.error = response.error?.message ?? 'No se pudo procesar la solicitud.';
        this.loading = false;
      },
    });
  }
}
