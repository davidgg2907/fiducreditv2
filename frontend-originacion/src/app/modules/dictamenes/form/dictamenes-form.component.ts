import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute } from '@angular/router';
import { DictamenesService } from '../../../servicios/originacion/dictamenes.service';
import { DictamenesRecord } from '../../../interfaces/originacion/dictamenes.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';

@Component({
  selector: 'app-dictamenes-form',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './dictamenes-form.component.html',
  styleUrls: ['./dictamenes-form.component.scss']
})
export class DictamenesFormComponent implements OnInit {
  private readonly service = inject(DictamenesService);
  private readonly route = inject(ActivatedRoute);
  readonly permissions = inject(OriginacionPermissionsService);
  record?: DictamenesRecord;
  error = '';

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (id && this.permissions.can('dictamenes', 'detalle')) {
      this.service.detail(id).subscribe({
        next: record => this.record = record,
        error: error => this.error = originacionError(error)
      });
    }
  }
}
