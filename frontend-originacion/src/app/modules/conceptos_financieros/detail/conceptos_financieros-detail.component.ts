import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { ConceptosFinancierosService } from '../../../servicios/originacion/conceptos_financieros.service';
import { ConceptosFinancierosRecord } from '../../../interfaces/originacion/conceptos_financieros.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
@Component({
  selector: 'app-conceptos-financieros-detail',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './conceptos_financieros-detail.component.html',
  styleUrls: ['./conceptos_financieros-detail.component.scss']
})
export class ConceptosFinancierosDetailComponent implements OnInit {
  private readonly service = inject(ConceptosFinancierosService);
  private readonly route = inject(ActivatedRoute);
  readonly permissions = inject(OriginacionPermissionsService);
  record?: ConceptosFinancierosRecord;
  error = '';
  loading = true;

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (!id || !this.permissions.can('conceptos_financieros', 'detalle')) {
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
