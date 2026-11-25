import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { ConsultasBuroService } from '../../../servicios/originacion/consultas_buro.service';
import { ConsultasBuroRecord } from '../../../interfaces/originacion/consultas_buro.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
import { FormsModule } from '@angular/forms';
import { finalize } from 'rxjs';

@Component({
  selector: 'app-consultas-buro-list',
  standalone: true,
  imports: [CommonModule, RouterModule, FormsModule],
  templateUrl: './consultas_buro-list.component.html',
  styleUrls: ['./consultas_buro-list.component.scss']
})
export class ConsultasBuroListComponent implements OnInit {
  private readonly service = inject(ConsultasBuroService);
  readonly permissions = inject(OriginacionPermissionsService);
  rows: ConsultasBuroRecord[] = [];
  search = '';
  page = 1;
  lastPage = 1;
  total = 0;
  loading = false;
  error = '';

  ngOnInit(): void {
    this.load();
  }

  load(page = 1): void {
    if (this.loading || !this.permissions.can('consultas_buro', 'ver')) {
      return;
    }
    this.loading = true;
    this.error = '';
    this.service.list(page, this.search).pipe(
      finalize(() => this.loading = false)
    ).subscribe({
      next: result => {
        this.rows = result.data;
        this.page = result.meta.current_page;
        this.lastPage = result.meta.last_page;
        this.total = result.meta.total;
      },
      error: error => {
        this.rows = [];
        this.error = originacionError(error);
      }
    });
  }

  clearSearch(): void {
    this.search = '';
    this.load();
  }
}
