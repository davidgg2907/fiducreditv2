import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute } from '@angular/router';
import { TareasOriginacionService } from '../../../servicios/originacion/tareas_originacion.service';
import { TareasOriginacionRecord } from '../../../interfaces/originacion/tareas_originacion.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
@Component({
  selector: 'app-tareas-originacion-detail',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './tareas_originacion-detail.component.html',
  styleUrls: ['./tareas_originacion-detail.component.scss']
})
export class TareasOriginacionDetailComponent implements OnInit {
  private readonly service = inject(TareasOriginacionService);
  private readonly route = inject(ActivatedRoute);
  readonly permissions = inject(OriginacionPermissionsService);
  record?: TareasOriginacionRecord;
  error = '';
  loading = true;

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (!id || !this.permissions.can('tareas_originacion', 'detalle')) {
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
