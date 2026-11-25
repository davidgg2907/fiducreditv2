import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { DomiciliosService } from '../../../servicios/originacion/domicilios.service';
import { DomiciliosRecord } from '../../../interfaces/originacion/domicilios.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { finalize } from 'rxjs';
import { DomiciliosPayload } from '../../../interfaces/originacion/domicilios.interface';
import { OriginacionLookupsService } from '../../../servicios/originacion/originacion-lookups.service';
import { LookupOption } from '../../../interfaces/originacion/api-response.interface';

@Component({
  selector: 'app-domicilios-form',
  standalone: true,
  imports: [CommonModule, RouterModule, ReactiveFormsModule],
  templateUrl: './domicilios-form.component.html',
  styleUrls: ['./domicilios-form.component.scss']
})
export class DomiciliosFormComponent implements OnInit {
  private readonly service = inject(DomiciliosService);
  private readonly route = inject(ActivatedRoute);
  private readonly router = inject(Router);
  private readonly fb = inject(FormBuilder);
  readonly permissions = inject(OriginacionPermissionsService);
  private readonly lookups = inject(OriginacionLookupsService);
  client_idOptions: LookupOption[] = [];
  readonly id = this.route.snapshot.paramMap.get('id');
  readonly form = this.fb.group({
    client_id: ['', [Validators.required, Validators.pattern(/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i)]],
    address_type: this.fb.control<string | null>(null, [Validators.maxLength(255)]),
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
            address_type: record.address_type ?? null,
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
        !this.permissions.can('domicilios', this.id ? 'editar' : 'crear')) {
      return;
    }
    this.form.markAllAsTouched();
    if (this.form.invalid) {
      return;
    }
    const values = this.form.getRawValue();
    const payload: DomiciliosPayload = {
      client_id: values.client_id,
      address_type: values.address_type || null,
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
        this.permissions.can('domicilios', 'detalle') ? ['/domicilios', record.id] : ['/domicilios']
      ),
      error: error => this.error = originacionError(error)
    });
  }
}
