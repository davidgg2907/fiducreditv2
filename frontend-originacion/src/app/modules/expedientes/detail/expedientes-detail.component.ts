import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute } from '@angular/router';
import { ExpedientesService } from '../../../servicios/originacion/expedientes.service';
import { ExpedientesRecord } from '../../../interfaces/originacion/expedientes.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
@Component({
  selector: 'app-expedientes-detail',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './expedientes-detail.component.html',
  styleUrls: ['./expedientes-detail.component.scss']
})
export class ExpedientesDetailComponent implements OnInit {
  private readonly service = inject(ExpedientesService);
  private readonly route = inject(ActivatedRoute);
  readonly permissions = inject(OriginacionPermissionsService);
  record?: ExpedientesRecord;
  error = '';
  loading = true;

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (!id || !this.permissions.can('expedientes', 'detalle')) {
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
