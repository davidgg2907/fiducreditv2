import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { ConsentimientosService } from '../../../servicios/originacion/consentimientos.service';
import { ConsentimientosRecord } from '../../../interfaces/originacion/consentimientos.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
@Component({
  selector: 'app-consentimientos-detail',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './consentimientos-detail.component.html',
  styleUrls: ['./consentimientos-detail.component.scss']
})
export class ConsentimientosDetailComponent implements OnInit {
  private readonly service = inject(ConsentimientosService);
  private readonly route = inject(ActivatedRoute);
  readonly permissions = inject(OriginacionPermissionsService);
  record?: ConsentimientosRecord;
  error = '';
  loading = true;

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (!id || !this.permissions.can('consentimientos', 'detalle')) {
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
