import { CommonModule } from '@angular/common';
import { Component, ElementRef, Input, OnInit, ViewChild, inject } from '@angular/core';
import { FormBuilder, ReactiveFormsModule, Validators, AbstractControl } from '@angular/forms';
import { finalize } from 'rxjs';
import { ClienteCuenta, ClienteDomicilio, ClienteDomicilioRegistro, ClienteRelaciones } from '../../../interfaces/originacion/clientes.interface';
import { ClientesService } from '../../../servicios/originacion/clientes.service';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';

@Component({
  selector: 'app-clientes-relaciones',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './clientes-relaciones.component.html',
  styleUrls: ['./clientes-relaciones.component.scss']
})
export class ClientesRelacionesComponent implements OnInit {
  @Input() clientId: string | null = null;
  @Input() staged = false;
  @Input() applicationCapture = false;
  @Input() compact = false;
  @Input() readOnly = false;
  modalEditing = false;
  get isNewClient(): boolean { return this.staged && !this.clientId; }
  @ViewChild('dialog', { static: true }) dialog!: ElementRef<HTMLDialogElement>;
  private readonly fb = inject(FormBuilder).nonNullable;
  private readonly service = inject(ClientesService);
  readonly permissions = inject(OriginacionPermissionsService);
  loading = false;
  saving = false;
  loaded = false;
  error = '';
  validationMessage(control:AbstractControl):string {
    if(control.hasError('required'))return 'Este campo es obligatorio.';
    if(control.hasError('maxlength'))return 'Longitud máxima excedida.';
    if(control===this.accountForm.controls.clabe)return 'Ingrese una CLABE de 18 dígitos.';
    if(control===this.accountForm.controls.account_last4)return 'Ingrese 4 dígitos.';
    if(control===this.addressForm.controls.country)return 'Ingrese un código de país de dos letras.';
    return 'Ingrese un valor válido.';
  }
  mode: 'addresses' | 'bank_accounts' = 'addresses';
  addresses: ClienteDomicilio[] = [];
  accounts: ClienteCuenta[] = [];
  histories: ClienteDomicilioRegistro[] = [];
  private pendingAddresses = new Map<number, ClienteDomicilio>();
  private pendingAccounts = new Map<number, ClienteCuenta>();
  selectedAddress = -1;
  selectedAccount = -1;
  showAddress = false;
  showAccount = false;

  readonly addressForm = this.fb.group({
    address_type: ['home', Validators.required], primary: false, active: true,
    street: ['', [Validators.required, Validators.maxLength(255)]],
    exterior_number: ['', Validators.maxLength(255)], interior_number: ['', Validators.maxLength(255)],
    neighborhood: ['', [Validators.required, Validators.maxLength(255)]],
    city: ['', [Validators.required, Validators.maxLength(255)]],
    municipality: ['', [Validators.required, Validators.maxLength(255)]],
    state: ['', [Validators.required, Validators.maxLength(255)]],
    postal_code: ['', [Validators.required, Validators.maxLength(10)]],
    country: ['MX', [Validators.required, Validators.pattern(/^[A-Za-z]{2}$/)]]
  });
  readonly accountForm = this.fb.group({
    bank_code: ['', Validators.maxLength(5)],
    bank_name: ['', [Validators.required, Validators.maxLength(255)]],
    holder_name: ['', [Validators.required, Validators.maxLength(255)]],
    clabe: ['', Validators.pattern(/^\d{18}$/)],
    account_last4: ['', Validators.pattern(/^\d{4}$/)],
    account_type: ['checking', Validators.required], primary: false, active: true
  });

  ngOnInit(): void {
    if (this.staged || !this.compact) this.load();
    if (this.isNewClient) {
      if (this.canWrite('addresses', false)) this.editAddress(-1);
      if (this.canWrite('bank_accounts', false)) this.editAccount(-1);
    }
  }

  canView(kind: 'addresses' | 'bank_accounts'): boolean {
    if (this.applicationCapture) return this.permissions.can('solicitudes','crear');
    return this.permissions.can(kind === 'addresses' ? 'domicilios' : 'cuentas_bancarias', 'ver');
  }
  canWrite(kind: 'addresses' | 'bank_accounts', existing: boolean): boolean {
    if (this.applicationCapture) return !this.readOnly && this.permissions.can('solicitudes','crear');
    return !this.readOnly && this.canView(kind) &&
      this.permissions.can(kind === 'addresses' ? 'domicilios' : 'cuentas_bancarias', existing ? 'editar' : 'crear') &&
      this.permissions.can('clientes', this.clientId ? 'editar' : 'crear');
  }

  load(): void {
    if (!this.clientId) { this.loaded = true; return; }
    if (!this.canView('addresses') && !this.canView('bank_accounts')) { this.loaded = true; return; }
    this.loading = true;
    this.error = '';
    this.service.relations(this.clientId).pipe(finalize(() => this.loading = false)).subscribe({
      next: record => {
        this.histories = this.canView('addresses') ? record.credit_client_addresses : [];
        this.addresses = [...this.histories].sort((a, b) => b.created_at.localeCompare(a.created_at)).map(a => {
          const v = a.credit_client_address_versions[0];
          return {id: a.id, address_type: a.address_type, primary: !!a.primary, active: !!a.active,
            street: v?.street ?? '', exterior_number: v?.exterior_number ?? null, interior_number: v?.interior_number ?? null,
            neighborhood: v?.neighborhood ?? '', city: v?.city ?? '', municipality: v?.municipality ?? '',
            state: v?.state ?? '', postal_code: v?.postal_code ?? '', country: v?.country ?? 'MX',
            latitude: v?.latitude ?? null, longitude: v?.longitude ?? null};
        });
        this.accounts = this.canView('bank_accounts') ? [...record.credit_client_bank_accounts]
          .sort((a,b) => b.created_at.localeCompare(a.created_at)).map(a => ({
            id: a.id, bank_code: a.bank_code, bank_name: a.bank_name, holder_name: a.holder_name,
            clabe: a.clabe, account_last4: a.account_last4, account_type: a.account_type,
            primary: !!a.primary, active: !!a.active
          })) : [];
        this.loaded = true;
        if (this.staged && this.addresses.length && this.canWrite('addresses', true)) this.editAddress(0);
        if (this.staged && this.accounts.length && this.canWrite('bank_accounts', true)) this.editAccount(0);
      },
      error: e => { this.error = originacionError(e); this.loaded = false; }
    });
  }

  open(kind: 'addresses' | 'bank_accounts'): void {
    if (this.isNewClient || !this.canView(kind) || this.saving) return;
    if (this.staged) {
      if (kind === 'addresses' && !this.captureAddress()) return;
      if (kind === 'bank_accounts' && !this.captureAccount()) return;
      if (kind === 'addresses') this.cancelAddress(); else this.cancelAccount();
    }
    this.modalEditing = false;
    this.mode = kind;
    if (!this.staged) {
      this.showAddress = false; this.showAccount = false;
      this.load();
    }
    this.dialog.nativeElement.showModal();
  }

  closeModal(): void {
    if (this.saving) return;
    this.backToList();
    this.dialog.nativeElement.close();
    if (this.staged) {
      if (this.mode === 'addresses' && this.addresses.length && this.canWrite('addresses', !!this.addresses[0].id)) this.editAddress(0);
      if (this.mode === 'bank_accounts' && this.accounts.length && this.canWrite('bank_accounts', !!this.accounts[0].id)) this.editAccount(0);
    }
  }

  backToList(): void {
    if (this.saving) return;
    if (this.mode === 'addresses') this.cancelAddress(); else this.cancelAccount();
    this.modalEditing = false;
  }

  editAddress(index: number): void {
    if (this.isNewClient && index < 0 && this.showAddress) return;
    if (!this.canWrite('addresses', index >= 0 && !!this.addresses[index]?.id)) return;
    if (this.staged && !this.captureAddress()) return;
    this.selectedAddress = index;
    const a = this.addresses[index];
    this.addressForm.reset({
      address_type: a?.address_type ?? 'home', primary: a?.primary ?? this.isNewClient, active: a?.active ?? this.isNewClient,
      street: a?.street ?? '', exterior_number: a?.exterior_number ?? '', interior_number: a?.interior_number ?? '',
      neighborhood: a?.neighborhood ?? '', city: a?.city ?? '', municipality: a?.municipality ?? '',
      state: a?.state ?? '', postal_code: a?.postal_code ?? '', country: a?.country ?? 'MX'
    });
    this.showAddress = true;
    if (this.dialog?.nativeElement.open) this.modalEditing = true;
  }

  editAccount(index: number): void {
    if (this.isNewClient && index < 0 && this.showAccount) return;
    if (!this.canWrite('bank_accounts', index >= 0 && !!this.accounts[index]?.id)) return;
    if (this.staged && !this.captureAccount()) return;
    this.selectedAccount = index;
    const a = this.accounts[index];
    this.accountForm.reset({
      bank_code: a?.bank_code ?? '', bank_name: a?.bank_name ?? '', holder_name: a?.holder_name ?? '',
      clabe: a?.clabe ?? '', account_last4: a?.account_last4 ?? '', account_type: a?.account_type ?? 'checking',
      primary: a?.primary ?? this.isNewClient, active: a?.active ?? this.isNewClient
    });
    this.showAccount = true;
    if (this.dialog?.nativeElement.open) this.modalEditing = true;
  }

  private addressValue(): ClienteDomicilio {
    const v = this.addressForm.getRawValue();
    const old = this.addresses[this.selectedAddress];
    return {...v, ...(old?.id ? {id: old.id} : {}), country: v.country.toUpperCase(),
      exterior_number: v.exterior_number || null, interior_number: v.interior_number || null,
      latitude: old?.latitude ?? null, longitude: old?.longitude ?? null};
  }
  private accountValue(): ClienteCuenta {
    const v = this.accountForm.getRawValue();
    const old = this.accounts[this.selectedAccount];
    return {...v, ...(old?.id ? {id: old.id} : {}), bank_code: v.bank_code || null,
      clabe: v.clabe || null, account_last4: v.account_last4 || null};
  }

  private captureAddress(): boolean {
    if (!this.showAddress || (!this.addressForm.dirty && (this.selectedAddress >= 0 || (this.isNewClient && !this.applicationCapture)))) return true;
    if (this.addressForm.invalid) { this.addressForm.markAllAsTouched(); this.error = ''; return false; }
    const v = this.addressValue();
    const index = this.selectedAddress < 0 ? this.addresses.length : this.selectedAddress;
    this.addresses[index] = v;
    this.pendingAddresses.set(index, v);
    this.selectedAddress = index;
    this.addressForm.markAsPristine();
    return true;
  }
  private captureAccount(): boolean {
    if (!this.showAccount || (!this.accountForm.dirty && (this.selectedAccount >= 0 || (this.isNewClient && !this.applicationCapture)))) return true;
    if (this.accountForm.invalid) { this.accountForm.markAllAsTouched(); this.error = ''; return false; }
    const v = this.accountValue();
    const index = this.selectedAccount < 0 ? this.accounts.length : this.selectedAccount;
    this.accounts[index] = v;
    this.pendingAccounts.set(index, v);
    this.selectedAccount = index;
    this.accountForm.markAsPristine();
    return true;
  }

  payload(): ClienteRelaciones | null {
    if (this.loading || !this.loaded || this.dialog.nativeElement.open) return null;
    const addressValid = this.captureAddress();
    const accountValid = this.captureAccount();
    if (!addressValid || !accountValid) return null;
    return {addresses: [...this.pendingAddresses.values()], bank_accounts: [...this.pendingAccounts.values()]};
  }

  saveCurrent(): void {
    this.error = '';
    if (this.readOnly || !this.modalEditing) return;
    if (this.staged) {
      if (this.mode === 'addresses' ? this.captureAddress() : this.captureAccount()) this.backToList();
      return;
    }
    if (!this.clientId || this.saving || this.loading || !this.loaded) return;
    const form = this.mode === 'addresses' ? this.addressForm : this.accountForm;
    if (form.invalid) { form.markAllAsTouched(); return; }
    const value = this.mode === 'addresses' ? this.addressValue() : this.accountValue();
    if (!this.canWrite(this.mode, !!value.id)) return;
    const payload = this.mode === 'addresses' ? {addresses: [this.addressValue()]} : {bank_accounts: [this.accountValue()]};
    this.saving = true;
    this.service.saveRelations(this.clientId, payload).pipe(finalize(() => this.saving = false)).subscribe({
      next: () => { this.showAddress = false; this.showAccount = false; this.modalEditing = false; this.load(); },
      error: e => this.error = originacionError(e)
    });
  }

  cancelAddress(): void { this.showAddress = false; this.selectedAddress = -1; this.error = ''; }
  cancelAccount(): void { this.showAccount = false; this.selectedAccount = -1; this.error = ''; }
}
