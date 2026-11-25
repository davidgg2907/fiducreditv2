import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute } from '@angular/router';
import { DictamenesService } from '../../../servicios/originacion/dictamenes.service';
import { DictamenesRecord } from '../../../interfaces/originacion/dictamenes.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
@Component({
  selector: 'app-dictamenes-detail',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './dictamenes-detail.component.html',
  styleUrls: ['./dictamenes-detail.component.scss']
})
export class DictamenesDetailComponent implements OnInit {
  private readonly service = inject(DictamenesService);
  private readonly route = inject(ActivatedRoute);
  readonly permissions = inject(OriginacionPermissionsService);
  record?: DictamenesRecord;
  error = '';
  loading = true;

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (!id || !this.permissions.can('dictamenes', 'detalle')) {
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
