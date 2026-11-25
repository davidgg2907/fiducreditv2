import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { CuentasBancariasService } from '../../../servicios/originacion/cuentas_bancarias.service';
import { CuentasBancariasRecord } from '../../../interfaces/originacion/cuentas_bancarias.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
@Component({
  selector: 'app-cuentas-bancarias-detail',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './cuentas_bancarias-detail.component.html',
  styleUrls: ['./cuentas_bancarias-detail.component.scss']
})
export class CuentasBancariasDetailComponent implements OnInit {
  private readonly service = inject(CuentasBancariasService);
  private readonly route = inject(ActivatedRoute);
  readonly permissions = inject(OriginacionPermissionsService);
  record?: CuentasBancariasRecord;
  error = '';
  loading = true;

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (!id || !this.permissions.can('cuentas_bancarias', 'detalle')) {
      this.loading = false;
      return;
    }
    this.service.detail(id).subscribe({
      next: record => {
        this.record = record;
        this.loading = false;
      },
      error: error => {
        this.error = originacionError(error);
        this.loading = false;
      }
    });
  }
}
