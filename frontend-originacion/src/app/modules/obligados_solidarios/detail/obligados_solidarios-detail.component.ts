import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { ObligadosSolidariosService } from '../../../servicios/originacion/obligados_solidarios.service';
import { ObligadosSolidariosRecord } from '../../../interfaces/originacion/obligados_solidarios.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
@Component({
  selector: 'app-obligados-solidarios-detail',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './obligados_solidarios-detail.component.html',
  styleUrls: ['./obligados_solidarios-detail.component.scss']
})
export class ObligadosSolidariosDetailComponent implements OnInit {
  private readonly service = inject(ObligadosSolidariosService);
  private readonly route = inject(ActivatedRoute);
  readonly permissions = inject(OriginacionPermissionsService);
  record?: ObligadosSolidariosRecord;
  error = '';
  loading = true;

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (!id || !this.permissions.can('obligados_solidarios', 'detalle')) {
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
