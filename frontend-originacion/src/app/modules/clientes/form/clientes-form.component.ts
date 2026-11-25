import { ClientesRelacionesComponent } from '../relaciones/clientes-relaciones.component';
import { Component, OnInit, ViewChild, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { ClientesService } from '../../../servicios/originacion/clientes.service';
import { ClientesRecord } from '../../../interfaces/originacion/clientes.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { finalize } from 'rxjs';
import { ClientesPayload } from '../../../interfaces/originacion/clientes.interface';
import { OriginacionLookupsService } from '../../../servicios/originacion/originacion-lookups.service';
import { LookupOption } from '../../../interfaces/originacion/api-response.interface';

@Component({
  selector: 'app-clientes-form',
  standalone: true,
  imports: [ClientesRelacionesComponent, CommonModule, RouterModule, ReactiveFormsModule],
  templateUrl: './clientes-form.component.html',
  styleUrls: ['./clientes-form.component.scss']
})
export class ClientesFormComponent implements OnInit {
  private readonly service = inject(ClientesService);
  private readonly route = inject(ActivatedRoute);
  private readonly router = inject(Router);
  private readonly fb = inject(FormBuilder);
  readonly permissions = inject(OriginacionPermissionsService);
  private readonly lookups = inject(OriginacionLookupsService);
  company_idOptions: LookupOption[] = [];
  readonly id = this.route.snapshot.paramMap.get('id');
  readonly form = this.fb.group({
    company_id: ['', [Validators.required, Validators.pattern(/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i)]],
    first_name: ['', [Validators.required, Validators.maxLength(255)]],
    middle_name: this.fb.control<string | null>(null, [Validators.maxLength(255)]),
    last_name: ['', [Validators.required, Validators.maxLength(255)]],
    second_last_name: this.fb.control<string | null>(null, [Validators.maxLength(255)]),
    birth_date: this.fb.control<string | null>(null, []),
    rfc: this.fb.control<string | null>(null, [Validators.maxLength(13)]),
    curp: this.fb.control<string | null>(null, [Validators.maxLength(18)]),
    ine_folio: this.fb.control<string | null>(null, [Validators.maxLength(255)]),
    passport_number: this.fb.control<string | null>(null, [Validators.maxLength(255)]),
    nss: this.fb.control<string | null>(null, [Validators.maxLength(255)]),
    health_provider: this.fb.control<string | null>(null, [Validators.maxLength(255)]),
    email: this.fb.control<string | null>(null, [Validators.email]),
    phone: this.fb.control<string | null>(null, [Validators.maxLength(20)]),
    status: this.fb.control<string | null>(null, [Validators.maxLength(255)])
  });
  @ViewChild(ClientesRelacionesComponent) relations?: ClientesRelacionesComponent;
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
            company_id: record.company_id ?? null,
            first_name: record.first_name ?? null,
            middle_name: record.middle_name ?? null,
            last_name: record.last_name ?? null,
            second_last_name: record.second_last_name ?? null,
            birth_date: record.birth_date?.slice(0, 10) ?? null,
            rfc: record.rfc ?? null,
            curp: record.curp ?? null,
            ine_folio: record.ine_folio ?? null,
            passport_number: record.passport_number ?? null,
            nss: record.nss ?? null,
            health_provider: record.health_provider ?? null,
            email: record.email ?? null,
            phone: record.phone ?? null,
            status: record.status ?? null
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
    this.lookups.options('credit-companies', 'legal_name').subscribe({
      next: options => {
        this.company_idOptions = options;
        remaining--;
        this.ready = remaining === 0;
      },
      error: error => this.error = originacionError(error)
    });
  }

  save(): void {
    if (this.saving || this.loading || !this.ready || this.form.disabled ||
        !this.permissions.can('clientes', this.id ? 'editar' : 'crear')) {
      return;
    }
    this.form.markAllAsTouched();
    if (this.form.invalid) {
      return;
    }
    const values = this.form.getRawValue();
    const payload: ClientesPayload = {
      company_id: values.company_id,
      first_name: values.first_name,
      middle_name: values.middle_name || null,
      last_name: values.last_name,
      second_last_name: values.second_last_name || null,
      birth_date: values.birth_date || null,
      rfc: values.rfc || null,
      curp: values.curp || null,
      ine_folio: values.ine_folio || null,
      passport_number: values.passport_number || null,
      nss: values.nss || null,
      health_provider: values.health_provider || null,
      email: values.email || null,
      phone: values.phone || null,
      status: values.status || 'active'
    };
    const relations = this.relations?.payload();
    if (!relations) { this.error = 'Revise la captura de domicilios y cuentas bancarias.'; return; }
    this.saving = true;
    this.error = '';
    const request = this.id
      ? this.service.update(this.id, {...payload, ...relations})
      : this.service.create({...payload, ...relations});
    request.pipe(finalize(() => this.saving = false)).subscribe({
      next: record => void this.router.navigate(
        this.permissions.can('clientes', 'detalle') ? ['/clientes', record.id] : ['/clientes']
      ),
      error: error => this.error = originacionError(error)
    });
  }
}
