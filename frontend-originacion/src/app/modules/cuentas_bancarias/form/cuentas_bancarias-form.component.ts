import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { CuentasBancariasService } from '../../../servicios/originacion/cuentas_bancarias.service';
import { CuentasBancariasRecord } from '../../../interfaces/originacion/cuentas_bancarias.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { finalize } from 'rxjs';
import { CuentasBancariasPayload } from '../../../interfaces/originacion/cuentas_bancarias.interface';
import { OriginacionLookupsService } from '../../../servicios/originacion/originacion-lookups.service';
import { LookupOption } from '../../../interfaces/originacion/api-response.interface';

@Component({
  selector: 'app-cuentas-bancarias-form',
  standalone: true,
  imports: [CommonModule, RouterModule, ReactiveFormsModule],
  templateUrl: './cuentas_bancarias-form.component.html',
  styleUrls: ['./cuentas_bancarias-form.component.scss']
})
export class CuentasBancariasFormComponent implements OnInit {
  private readonly service = inject(CuentasBancariasService);
  private readonly route = inject(ActivatedRoute);
  private readonly router = inject(Router);
  private readonly fb = inject(FormBuilder);
  readonly permissions = inject(OriginacionPermissionsService);
  private readonly lookups = inject(OriginacionLookupsService);
  client_idOptions: LookupOption[] = [];
  readonly id = this.route.snapshot.paramMap.get('id');
  readonly form = this.fb.group({
    client_id: ['', [Validators.required, Validators.pattern(/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i)]],
    bank_code: [null, [Validators.maxLength(5)]],
    bank_name: ['', [Validators.required, Validators.maxLength(255)]],
    holder_name: ['', [Validators.required, Validators.maxLength(255)]],
    clabe: [null, [Validators.maxLength(18), Validators.pattern(/^\d{18}$/)]],
    account_last4: [null, [Validators.maxLength(4), Validators.pattern(/^\d{4}$/)]],
    account_type: [null, [Validators.maxLength(255)]],
    primary: [false, []],
    active: [true, []]
  });
  error = '';
  saving = false;
  loading = false;
  ready = false;

  ngOnInit(): void {
    this.loadOptions();
    if (this.id) {
      this.loading = true;
      this.service.detail(this.id).pipe(finalize(() => this.loading = false)).subscribe({
        next: record => {

          this.form.patchValue({
            client_id: record.client_id ?? null,
            bank_code: record.bank_code ?? null,
            bank_name: record.bank_name ?? null,
            holder_name: record.holder_name ?? null,
            clabe: record.clabe ?? null,
            account_last4: record.account_last4 ?? null,
            account_type: record.account_type ?? null,
            primary: Boolean(record.primary),
            active: Boolean(record.active)
          });

        },
        error: error => {
          this.error = originacionError(error);
          this.form.disable();
        }
      });
    }
  }

  private loadOptions(): void {
    let remaining = 1;
    this.lookups.options('credit-clients', 'first_name').subscribe({
      next: options => {
        this.client_idOptions = options;
        remaining--;
        this.ready = remaining === 0;
      },
      error: error => this.error = originacionError(error)
    });
  }

  save(): void {
    if (this.saving || this.loading || !this.ready || this.form.disabled ||
        !this.permissions.can('cuentas_bancarias', this.id ? 'editar' : 'crear')) {
      return;
    }
    this.form.markAllAsTouched();
    if (this.form.invalid) {
      return;
    }
    const values = this.form.getRawValue();
    const payload: CuentasBancariasPayload = {
      client_id: values.client_id,
      bank_code: values.bank_code || null,
      bank_name: values.bank_name,
      holder_name: values.holder_name,
      clabe: values.clabe || null,
      account_last4: values.account_last4 || null,
      account_type: values.account_type || null,
      primary: Boolean(values.primary),
      active: Boolean(values.active)
    };
    this.saving = true;
    this.error = '';
    const request = this.id
      ? this.service.update(this.id, payload)
      : this.service.create(payload);
    request.pipe(finalize(() => this.saving = false)).subscribe({
      next: record => void this.router.navigate(
        this.permissions.can('cuentas_bancarias', 'detalle') ? ['/cuentas_bancarias', record.id] : ['/cuentas_bancarias']
      ),
      error: error => this.error = originacionError(error)
    });
  }
}
