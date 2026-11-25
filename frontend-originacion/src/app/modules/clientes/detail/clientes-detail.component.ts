import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { ClientesService } from '../../../servicios/originacion/clientes.service';
import { ClientesRecord } from '../../../interfaces/originacion/clientes.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
@Component({
  selector: 'app-clientes-detail',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './clientes-detail.component.html',
  styleUrls: ['./clientes-detail.component.scss']
})
export class ClientesDetailComponent implements OnInit {
  private readonly service = inject(ClientesService);
  private readonly route = inject(ActivatedRoute);
  readonly permissions = inject(OriginacionPermissionsService);
  record?: ClientesRecord;
  error = '';
  loading = true;

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (!id || !this.permissions.can('clientes', 'detalle')) {
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
