import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { ConsentimientosService } from '../../../servicios/originacion/consentimientos.service';
import { ConsentimientosRecord } from '../../../interfaces/originacion/consentimientos.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { finalize } from 'rxjs';
import { ConsentimientosPayload } from '../../../interfaces/originacion/consentimientos.interface';
import { OriginacionLookupsService } from '../../../servicios/originacion/originacion-lookups.service';
import { LookupOption } from '../../../interfaces/originacion/api-response.interface';

@Component({
  selector: 'app-consentimientos-form',
  standalone: true,
  imports: [CommonModule, RouterModule, ReactiveFormsModule],
  templateUrl: './consentimientos-form.component.html',
  styleUrls: ['./consentimientos-form.component.scss']
})
export class ConsentimientosFormComponent implements OnInit {
  private readonly service = inject(ConsentimientosService);
  private readonly route = inject(ActivatedRoute);
  private readonly router = inject(Router);
  private readonly fb = inject(FormBuilder);
  readonly permissions = inject(OriginacionPermissionsService);
  private readonly lookups = inject(OriginacionLookupsService);
  application_idOptions: LookupOption[] = [];
  readonly id = this.route.snapshot.paramMap.get('id');
  readonly form = this.fb.group({
    application_id: ['', [Validators.required, Validators.pattern(/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i)]],
    consent_type: ['', [Validators.required, Validators.maxLength(255)]],
    version: ['', [Validators.required, Validators.maxLength(255)]],
    accepted: [false, []],
    accepted_at: [null, []]
  });
  error = '';
  saving = false;
  loading = false;
  ready = false;

  ngOnInit(): void {
    this.loadOptions();

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
        !this.permissions.can('consentimientos', this.id ? 'editar' : 'crear')) {
      return;
    }
    this.form.markAllAsTouched();
    if (this.form.invalid) {
      return;
    }
    const values = this.form.getRawValue();
    const payload: ConsentimientosPayload = {
      application_id: values.application_id,
      consent_type: values.consent_type,
      version: values.version,
      accepted: Boolean(values.accepted),
      accepted_at: values.accepted_at || null
    };
    this.saving = true;
    this.error = '';
    const request = this.service.create(payload);
    request.pipe(finalize(() => this.saving = false)).subscribe({
      next: record => void this.router.navigate(
        this.permissions.can('consentimientos', 'detalle') ? ['/consentimientos', record.id] : ['/consentimientos']
      ),
      error: error => this.error = originacionError(error)
    });
  }
}
