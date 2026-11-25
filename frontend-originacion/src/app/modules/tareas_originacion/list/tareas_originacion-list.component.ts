import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute } from '@angular/router';
import { TareasOriginacionService } from '../../../servicios/originacion/tareas_originacion.service';
import { TareasOriginacionRecord } from '../../../interfaces/originacion/tareas_originacion.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
import { FormsModule } from '@angular/forms';
import { finalize } from 'rxjs';

@Component({
  selector: 'app-tareas-originacion-list',
  standalone: true,
  imports: [CommonModule, RouterModule, FormsModule],
  templateUrl: './tareas_originacion-list.component.html',
  styleUrls: ['./tareas_originacion-list.component.scss']
})
export class TareasOriginacionListComponent implements OnInit {
  private readonly service = inject(TareasOriginacionService);
  readonly permissions = inject(OriginacionPermissionsService);
  rows: TareasOriginacionRecord[] = [];
  search = '';
  page = 1;
  lastPage = 1;
  total = 0;
  loading = false;
  error = '';

  get pageNumbers(): number[] {
    const last = Math.max(1, this.lastPage);
    const start = Math.max(1, Math.min(this.page - 2, last - 4));
    const end = Math.min(last, start + 4);
    return Array.from({ length: end - start + 1 }, (_, index) => start + index);
  }

  ngOnInit(): void {
    this.load();
  }

  load(page = 1): void {
    if (this.loading || !this.permissions.can('tareas_originacion', 'ver')) {
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
