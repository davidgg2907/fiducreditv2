import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { AnalisisCrediticioService } from '../../../servicios/originacion/analisis_crediticio.service';
import { AnalisisCrediticioRecord } from '../../../interfaces/originacion/analisis_crediticio.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
@Component({
  selector: 'app-analisis-crediticio-detail',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './analisis_crediticio-detail.component.html',
  styleUrls: ['./analisis_crediticio-detail.component.scss']
})
export class AnalisisCrediticioDetailComponent implements OnInit {
  private readonly service = inject(AnalisisCrediticioService);
  private readonly route = inject(ActivatedRoute);
  readonly permissions = inject(OriginacionPermissionsService);
  record?: AnalisisCrediticioRecord;
  error = '';
  loading = true;

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (!id || !this.permissions.can('analisis_crediticio', 'detalle')) {
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
