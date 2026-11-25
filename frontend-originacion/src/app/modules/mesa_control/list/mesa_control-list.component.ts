import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute } from '@angular/router';
import { MesaControlService } from '../../../servicios/originacion/mesa_control.service';
import { MesaControlRecord } from '../../../interfaces/originacion/mesa_control.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
import { FormsModule } from '@angular/forms';
import { finalize } from 'rxjs';

@Component({
  selector: 'app-mesa-control-list',
  standalone: true,
  imports: [CommonModule, RouterModule, FormsModule],
  templateUrl: './mesa_control-list.component.html',
  styleUrls: ['./mesa_control-list.component.scss']
})
export class MesaControlListComponent implements OnInit {
  private readonly service = inject(MesaControlService);
  readonly permissions = inject(OriginacionPermissionsService);
  rows: MesaControlRecord[] = [];
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
    if (this.loading || !this.permissions.can('mesa_control', 'ver')) {
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
