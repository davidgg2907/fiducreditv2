import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { ClientesService } from '../../../servicios/originacion/clientes.service';
import { ClientesRecord } from '../../../interfaces/originacion/clientes.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
import { FormsModule } from '@angular/forms';
import { finalize } from 'rxjs';

@Component({
  selector: 'app-clientes-list',
  standalone: true,
  imports: [CommonModule, RouterModule, FormsModule],
  templateUrl: './clientes-list.component.html',
  styleUrls: ['./clientes-list.component.scss']
})
export class ClientesListComponent implements OnInit {
  private readonly service = inject(ClientesService);
  readonly permissions = inject(OriginacionPermissionsService);
  rows: ClientesRecord[] = [];
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
    if (this.loading || !this.permissions.can('clientes', 'ver')) {
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
