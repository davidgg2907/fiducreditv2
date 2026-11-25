import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute } from '@angular/router';
import { MesaControlService } from '../../../servicios/originacion/mesa_control.service';
import { MesaControlRecord } from '../../../interfaces/originacion/mesa_control.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
@Component({
  selector: 'app-mesa-control-detail',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './mesa_control-detail.component.html',
  styleUrls: ['./mesa_control-detail.component.scss']
})
export class MesaControlDetailComponent implements OnInit {
  private readonly service = inject(MesaControlService);
  private readonly route = inject(ActivatedRoute);
  readonly permissions = inject(OriginacionPermissionsService);
  record?: MesaControlRecord;
  error = '';
  loading = true;

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (!id || !this.permissions.can('mesa_control', 'detalle')) {
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
