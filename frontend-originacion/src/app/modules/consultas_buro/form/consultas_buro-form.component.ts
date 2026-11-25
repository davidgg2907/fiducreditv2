import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { ConsultasBuroService } from '../../../servicios/originacion/consultas_buro.service';
import { ConsultasBuroRecord } from '../../../interfaces/originacion/consultas_buro.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { finalize } from 'rxjs';
import { ConsultasBuroPayload } from '../../../interfaces/originacion/consultas_buro.interface';
import { OriginacionLookupsService } from '../../../servicios/originacion/originacion-lookups.service';
import { LookupOption } from '../../../interfaces/originacion/api-response.interface';

@Component({
  selector: 'app-consultas-buro-form',
  standalone: true,
  imports: [CommonModule, RouterModule, ReactiveFormsModule],
  templateUrl: './consultas_buro-form.component.html',
  styleUrls: ['./consultas_buro-form.component.scss']
})
export class ConsultasBuroFormComponent implements OnInit {
  private readonly service = inject(ConsultasBuroService);
  private readonly route = inject(ActivatedRoute);
  private readonly router = inject(Router);
  private readonly fb = inject(FormBuilder);
  readonly permissions = inject(OriginacionPermissionsService);
  private readonly lookups = inject(OriginacionLookupsService);
  application_idOptions: LookupOption[] = [];
  readonly id = this.route.snapshot.paramMap.get('id');
  readonly form = this.fb.group({
    application_id: ['', [Validators.required, Validators.pattern(/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i)]],
    provider: ['', [Validators.required, Validators.maxLength(255)]],
    score: this.fb.control<number | null>(null, [Validators.pattern(/^\d+$/)]),
    external_reference: this.fb.control<string | null>(null, [Validators.maxLength(255)]),
    result: this.fb.control<string | null>(null, [Validators.maxLength(255)]),
    consulted_at: this.fb.control<string | null>(null, [])
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
            provider: record.provider ?? null,
            score: record.score == null ? null : Number(record.score),
            external_reference: record.external_reference ?? null,
            result: record.result ?? null,
            consulted_at: record.consulted_at?.slice(0, 10) ?? null
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
        !this.permissions.can('consultas_buro', this.id ? 'editar' : 'crear')) {
      return;
    }
    this.form.markAllAsTouched();
    if (this.form.invalid) {
      return;
    }
    const values = this.form.getRawValue();
    const payload: ConsultasBuroPayload = {
      application_id: values.application_id,
      provider: values.provider,
      score: values.score,
      external_reference: values.external_reference || null,
      result: values.result || null,
      consulted_at: values.consulted_at || null
    };
    this.saving = true;
    this.error = '';
    const request = this.id
      ? this.service.update(this.id, payload)
      : this.service.create(payload);
    request.pipe(finalize(() => this.saving = false)).subscribe({
      next: record => void this.router.navigate(
        this.permissions.can('consultas_buro', 'detalle') ? ['/consultas_buro', record.id] : ['/consultas_buro']
      ),
      error: error => this.error = originacionError(error)
    });
  }
}
