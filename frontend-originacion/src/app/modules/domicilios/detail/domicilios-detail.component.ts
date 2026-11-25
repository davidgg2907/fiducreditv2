import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { DomiciliosService } from '../../../servicios/originacion/domicilios.service';
import { DomiciliosRecord } from '../../../interfaces/originacion/domicilios.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
@Component({
  selector: 'app-domicilios-detail',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './domicilios-detail.component.html',
  styleUrls: ['./domicilios-detail.component.scss']
})
export class DomiciliosDetailComponent implements OnInit {
  private readonly service = inject(DomiciliosService);
  private readonly route = inject(ActivatedRoute);
  readonly permissions = inject(OriginacionPermissionsService);
  record?: DomiciliosRecord;
  error = '';
  loading = true;

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (!id || !this.permissions.can('domicilios', 'detalle')) {
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
