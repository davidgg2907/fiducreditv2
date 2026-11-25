import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { AnalisisCrediticioService } from '../../../servicios/originacion/analisis_crediticio.service';
import { AnalisisCrediticioRecord } from '../../../interfaces/originacion/analisis_crediticio.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { finalize } from 'rxjs';
import { AnalisisCrediticioPayload } from '../../../interfaces/originacion/analisis_crediticio.interface';
import { OriginacionLookupsService } from '../../../servicios/originacion/originacion-lookups.service';
import { LookupOption } from '../../../interfaces/originacion/api-response.interface';

@Component({
  selector: 'app-analisis-crediticio-form',
  standalone: true,
  imports: [CommonModule, RouterModule, ReactiveFormsModule],
  templateUrl: './analisis_crediticio-form.component.html',
  styleUrls: ['./analisis_crediticio-form.component.scss']
})
export class AnalisisCrediticioFormComponent implements OnInit {
  private readonly service = inject(AnalisisCrediticioService);
  private readonly route = inject(ActivatedRoute);
  private readonly router = inject(Router);
  private readonly fb = inject(FormBuilder);
  readonly permissions = inject(OriginacionPermissionsService);
  private readonly lookups = inject(OriginacionLookupsService);
  application_idOptions: LookupOption[] = [];
  readonly id = this.route.snapshot.paramMap.get('id');
  readonly form = this.fb.group({
    application_id: ['', [Validators.required, Validators.pattern(/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i)]],
    analyst_id: this.fb.control<number | null>(null, [Validators.required, Validators.pattern(/^\d+$/)]),
    status: this.fb.control<string | null>(null, [Validators.maxLength(255)]),
    findings: this.fb.control<string | null>(null, []),
    recommendation: this.fb.control<string | null>(null, []),
    completed_at: this.fb.control<string | null>(null, [])
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
            analyst_id: record.analyst_id == null ? null : Number(record.analyst_id),
            status: record.status ?? null,
            findings: record.findings ?? null,
            recommendation: record.recommendation ?? null,
            completed_at: record.completed_at?.slice(0, 10) ?? null
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
        !this.permissions.can('analisis_crediticio', this.id ? 'editar' : 'crear')) {
      return;
    }
    this.form.markAllAsTouched();
    if (this.form.invalid) {
      return;
    }
    const values = this.form.getRawValue();
    const payload: AnalisisCrediticioPayload = {
      application_id: values.application_id,
      analyst_id: values.analyst_id,
      status: values.status || null,
      findings: values.findings || null,
      recommendation: values.recommendation || null,
      completed_at: values.completed_at || null
    };
    this.saving = true;
    this.error = '';
    const request = this.id
      ? this.service.update(this.id, payload)
      : this.service.create(payload);
    request.pipe(finalize(() => this.saving = false)).subscribe({
      next: record => void this.router.navigate(
        this.permissions.can('analisis_crediticio', 'detalle') ? ['/analisis_crediticio', record.id] : ['/analisis_crediticio']
      ),
      error: error => this.error = originacionError(error)
    });
  }
}
