import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute } from '@angular/router';
import { DocumentosService } from '../../../servicios/originacion/documentos.service';
import { DocumentosRecord } from '../../../interfaces/originacion/documentos.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';

@Component({
  selector: 'app-documentos-form',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './documentos-form.component.html',
  styleUrls: ['./documentos-form.component.scss']
})
export class DocumentosFormComponent implements OnInit {
  private readonly service = inject(DocumentosService);
  private readonly route = inject(ActivatedRoute);
  readonly permissions = inject(OriginacionPermissionsService);
  record?: DocumentosRecord;
  error = '';

  ngOnInit(): void {
    const id = this.route.snapshot.paramMap.get('id');
    if (id && this.permissions.can('documentos', 'detalle')) {
      this.service.detail(id).subscribe({
        next: record => this.record = record,
        error: error => this.error = originacionError(error)
      });
    }
  }
}
