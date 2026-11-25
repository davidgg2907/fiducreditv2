import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { SolicitudesService } from '../../../servicios/originacion/solicitudes.service';
import { SolicitudesRecord } from '../../../interfaces/originacion/solicitudes.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
@Component({
  selector: 'app-solicitudes-detail',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './solicitudes-detail.component.html',
  styleUrls: ['./solicitudes-detail.component.scss']
})
export class SolicitudesDetailComponent implements OnInit {
  private readonly service = inject(SolicitudesService);
  private readonly route = inject(ActivatedRoute);
  readonly permissions = inject(OriginacionPermissionsService);
  record?: SolicitudesRecord;
  error = '';
  loading = true;

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (!id || !this.permissions.can('solicitudes', 'detalle')) {
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
