import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { ObligadosSolidariosService } from '../../../servicios/originacion/obligados_solidarios.service';
import { ObligadosSolidariosRecord } from '../../../interfaces/originacion/obligados_solidarios.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { finalize } from 'rxjs';
import { ObligadosSolidariosPayload } from '../../../interfaces/originacion/obligados_solidarios.interface';
import { OriginacionLookupsService } from '../../../servicios/originacion/originacion-lookups.service';
import { LookupOption } from '../../../interfaces/originacion/api-response.interface';

@Component({
  selector: 'app-obligados-solidarios-form',
  standalone: true,
  imports: [CommonModule, RouterModule, ReactiveFormsModule],
  templateUrl: './obligados_solidarios-form.component.html',
  styleUrls: ['./obligados_solidarios-form.component.scss']
})
export class ObligadosSolidariosFormComponent implements OnInit {
  private readonly service = inject(ObligadosSolidariosService);
  private readonly route = inject(ActivatedRoute);
  private readonly router = inject(Router);
  private readonly fb = inject(FormBuilder);
  readonly permissions = inject(OriginacionPermissionsService);
  private readonly lookups = inject(OriginacionLookupsService);
  application_idOptions: LookupOption[] = [];
  readonly id = this.route.snapshot.paramMap.get('id');
  readonly form = this.fb.group({
    application_id: ['', [Validators.required, Validators.pattern(/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i)]],
    full_name: ['', [Validators.required, Validators.maxLength(255)]],
    rfc: [null, [Validators.maxLength(13)]],
    relationship: ['', [Validators.required, Validators.maxLength(255)]],
    phone: [null, [Validators.maxLength(20)]],
    monthly_income: [null, []]
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
            application_id: record.application_id ?? null,
            full_name: record.full_name ?? null,
            rfc: record.rfc ?? null,
            relationship: record.relationship ?? null,
            phone: record.phone ?? null,
            monthly_income: record.monthly_income == null ? null : Number(record.monthly_income)
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
    this.lookups.options('credit-applications', 'application_number').subscribe({
      next: options => {
        this.application_idOptions = options;
        remaining--;
        this.ready = remaining === 0;
      },
      error: error => this.error = originacionError(error)
    });
  }

  save(): void {
    if (this.saving || this.loading || !this.ready || this.form.disabled ||
        !this.permissions.can('obligados_solidarios', this.id ? 'editar' : 'crear')) {
      return;
    }
    this.form.markAllAsTouched();
    if (this.form.invalid) {
      return;
    }
    const values = this.form.getRawValue();
    const payload: ObligadosSolidariosPayload = {
      application_id: values.application_id,
      full_name: values.full_name,
      rfc: values.rfc || null,
      relationship: values.relationship,
      phone: values.phone || null,
      monthly_income: values.monthly_income
    };
    this.saving = true;
    this.error = '';
    const request = this.id
      ? this.service.update(this.id, payload)
      : this.service.create(payload);
    request.pipe(finalize(() => this.saving = false)).subscribe({
      next: record => void this.router.navigate(
        this.permissions.can('obligados_solidarios', 'detalle') ? ['/obligados_solidarios', record.id] : ['/obligados_solidarios']
      ),
      error: error => this.error = originacionError(error)
    });
  }
}
