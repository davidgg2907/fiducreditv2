import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { ConceptosFinancierosService } from '../../../servicios/originacion/conceptos_financieros.service';
import { ConceptosFinancierosRecord } from '../../../interfaces/originacion/conceptos_financieros.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { finalize } from 'rxjs';
import { ConceptosFinancierosPayload } from '../../../interfaces/originacion/conceptos_financieros.interface';
import { OriginacionLookupsService } from '../../../servicios/originacion/originacion-lookups.service';
import { LookupOption } from '../../../interfaces/originacion/api-response.interface';

@Component({
  selector: 'app-conceptos-financieros-form',
  standalone: true,
  imports: [CommonModule, RouterModule, ReactiveFormsModule],
  templateUrl: './conceptos_financieros-form.component.html',
  styleUrls: ['./conceptos_financieros-form.component.scss']
})
export class ConceptosFinancierosFormComponent implements OnInit {
  private readonly service = inject(ConceptosFinancierosService);
  private readonly route = inject(ActivatedRoute);
  private readonly router = inject(Router);
  private readonly fb = inject(FormBuilder);
  readonly permissions = inject(OriginacionPermissionsService);
  private readonly lookups = inject(OriginacionLookupsService);
  application_idOptions: LookupOption[] = [];
  readonly id = this.route.snapshot.paramMap.get('id');
  readonly form = this.fb.group({
    application_id: ['', [Validators.required, Validators.pattern(/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i)]],
    entry_type: ['', [Validators.required]],
    concept: ['', [Validators.required, Validators.maxLength(255)]],
    counterparty: this.fb.control<string | null>(null, [Validators.maxLength(255)]),
    amount: this.fb.control<number | null>(null, [Validators.required, Validators.min(0.01)]),
    frequency: ['', [Validators.required]],
    observations: this.fb.control<string | null>(null, [])
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
            entry_type: record.entry_type ?? null,
            concept: record.concept ?? null,
            counterparty: record.counterparty ?? null,
            amount: record.amount == null ? null : Number(record.amount),
            frequency: record.frequency ?? null,
            observations: record.observations ?? null
          });
          this.form.controls.application_id.disable();
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
        !this.permissions.can('conceptos_financieros', this.id ? 'editar' : 'crear')) {
      return;
    }
    this.form.markAllAsTouched();
    if (this.form.invalid) {
      return;
    }
    const values = this.form.getRawValue();
    const payload: ConceptosFinancierosPayload = {
      application_id: values.application_id,
      entry_type: values.entry_type,
      concept: values.concept,
      counterparty: values.counterparty || null,
      amount: values.amount,
      frequency: values.frequency,
      observations: values.observations || null
    };
    this.saving = true;
    this.error = '';
    const { application_id, ...changes } = payload;
    const request = this.id
      ? this.service.update(this.id, changes)
      : this.service.create(payload);
    request.pipe(finalize(() => this.saving = false)).subscribe({
      next: record => void this.router.navigate(
        this.permissions.can('conceptos_financieros', 'detalle') ? ['/conceptos_financieros', record.id] : ['/conceptos_financieros']
      ),
      error: error => this.error = originacionError(error)
    });
  }
}
