import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { ConsultasBuroService } from '../../../servicios/originacion/consultas_buro.service';
import { ConsultasBuroRecord } from '../../../interfaces/originacion/consultas_buro.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
@Component({
  selector: 'app-consultas-buro-detail',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './consultas_buro-detail.component.html',
  styleUrls: ['./consultas_buro-detail.component.scss']
})
export class ConsultasBuroDetailComponent implements OnInit {
  private readonly service = inject(ConsultasBuroService);
  private readonly route = inject(ActivatedRoute);
  readonly permissions = inject(OriginacionPermissionsService);
  record?: ConsultasBuroRecord;
  error = '';
  loading = true;

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (!id || !this.permissions.can('consultas_buro', 'detalle')) {
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
