import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { SolicitudesService } from '../../../servicios/originacion/solicitudes.service';
import { SolicitudesRecord } from '../../../interfaces/originacion/solicitudes.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { finalize } from 'rxjs';
import { SolicitudesPayload } from '../../../interfaces/originacion/solicitudes.interface';
import { OriginacionLookupsService } from '../../../servicios/originacion/originacion-lookups.service';
import { LookupOption } from '../../../interfaces/originacion/api-response.interface';

@Component({
  selector: 'app-solicitudes-form',
  standalone: true,
  imports: [CommonModule, RouterModule, ReactiveFormsModule],
  templateUrl: './solicitudes-form.component.html',
  styleUrls: ['./solicitudes-form.component.scss']
})
export class SolicitudesFormComponent implements OnInit {
  private readonly service = inject(SolicitudesService);
  private readonly route = inject(ActivatedRoute);
  private readonly router = inject(Router);
  private readonly fb = inject(FormBuilder);
  readonly permissions = inject(OriginacionPermissionsService);
  private readonly lookups = inject(OriginacionLookupsService);
  client_idOptions: LookupOption[] = [];
  product_version_idOptions: LookupOption[] = [];
  advisor_idOptions: LookupOption[] = [];
  branch_idOptions: LookupOption[] = [];
  address_version_idOptions: LookupOption[] = [];
  bank_account_idOptions: LookupOption[] = [];
  readonly id = this.route.snapshot.paramMap.get('id');
  readonly form = this.fb.group({
    client_id: ['', [Validators.required, Validators.pattern(/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i)]],
    product_version_id: ['', [Validators.required, Validators.pattern(/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i)]],
    advisor_id: ['', [Validators.required, Validators.pattern(/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i)]],
    branch_id: ['', [Validators.required, Validators.pattern(/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i)]],
    address_version_id: ['', [Validators.required, Validators.pattern(/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i)]],
    bank_account_id: [null, [Validators.pattern(/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i)]],
    application_number: ['', [Validators.required, Validators.maxLength(255)]],
    requested_amount: [null, [Validators.required, Validators.min(0.01)]],
    requested_term: [null, [Validators.required, Validators.pattern(/^\d+$/), Validators.min(1)]],
    declared_income: [null, []],
    declared_expenses: [null, []]
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
          if (record.status !== 'captured') {
            this.form.disable();
            this.error = 'Solo se permite modificar solicitudes en captura.';
            return;
          }
          this.form.patchValue({
            client_id: record.client_id ?? null,
            product_version_id: record.product_version_id ?? null,
            advisor_id: record.advisor_id ?? null,
            branch_id: record.branch_id ?? null,
            address_version_id: record.address_version_id ?? null,
            bank_account_id: record.bank_account_id ?? null,
            application_number: record.application_number ?? null,
            requested_amount: record.requested_amount == null ? null : Number(record.requested_amount),
            requested_term: record.requested_term == null ? null : Number(record.requested_term),
            declared_income: record.declared_income == null ? null : Number(record.declared_income),
            declared_expenses: record.declared_expenses == null ? null : Number(record.declared_expenses)
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
    let remaining = 6;
    this.lookups.options('credit-clients', 'first_name').subscribe({
      next: options => {
        this.client_idOptions = options;
        remaining--;
        this.ready = remaining === 0;
      },
      error: error => this.error = originacionError(error)
    });
    this.lookups.options('credit-product-versions', 'version').subscribe({
      next: options => {
        this.product_version_idOptions = options;
        remaining--;
        this.ready = remaining === 0;
      },
      error: error => this.error = originacionError(error)
    });
    this.lookups.options('credit-advisors', 'employee_code').subscribe({
      next: options => {
        this.advisor_idOptions = options;
        remaining--;
        this.ready = remaining === 0;
      },
      error: error => this.error = originacionError(error)
    });
    this.lookups.options('credit-branches', 'name').subscribe({
      next: options => {
        this.branch_idOptions = options;
        remaining--;
        this.ready = remaining === 0;
      },
      error: error => this.error = originacionError(error)
    });
    this.lookups.options('credit-client-address-versions', 'street').subscribe({
      next: options => {
        this.address_version_idOptions = options;
        remaining--;
        this.ready = remaining === 0;
      },
      error: error => this.error = originacionError(error)
    });
    this.lookups.options('credit-client-bank-accounts', 'bank_name').subscribe({
      next: options => {
        this.bank_account_idOptions = options;
        remaining--;
        this.ready = remaining === 0;
      },
      error: error => this.error = originacionError(error)
    });
  }

  save(): void {
    if (this.saving || this.loading || !this.ready || this.form.disabled ||
        !this.permissions.can('solicitudes', this.id ? 'editar' : 'crear')) {
      return;
    }
    this.form.markAllAsTouched();
    if (this.form.invalid) {
      return;
    }
    const values = this.form.getRawValue();
    const payload: SolicitudesPayload = {
      client_id: values.client_id,
      product_version_id: values.product_version_id,
      advisor_id: values.advisor_id,
      branch_id: values.branch_id,
      address_version_id: values.address_version_id,
      bank_account_id: values.bank_account_id || null,
      application_number: values.application_number,
      requested_amount: values.requested_amount,
      requested_term: values.requested_term,
      declared_income: values.declared_income,
      declared_expenses: values.declared_expenses
    };
    this.saving = true;
    this.error = '';
    const request = this.id
      ? this.service.update(this.id, payload)
      : this.service.create(payload);
    request.pipe(finalize(() => this.saving = false)).subscribe({
      next: record => void this.router.navigate(
        this.permissions.can('solicitudes', 'detalle') ? ['/solicitudes', record.id] : ['/solicitudes']
      ),
      error: error => this.error = originacionError(error)
    });
  }
}
