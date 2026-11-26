import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute, Router } from '@angular/router';
import { SolicitudesService } from '../../../servicios/originacion/solicitudes.service';
import { SolicitudesRecord } from '../../../interfaces/originacion/solicitudes.interface';
import { OriginacionPermissionsService } from '../../../servicios/originacion/originacion-permissions.service';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
import { FormsModule } from '@angular/forms';
import { finalize } from 'rxjs';

@Component({
  selector: 'app-solicitudes-list',
  standalone: true,
  imports: [CommonModule, RouterModule, FormsModule],
  templateUrl: './solicitudes-list.component.html',
  styleUrls: ['./solicitudes-list.component.scss']
})
export class SolicitudesListComponent implements OnInit {
  private readonly service = inject(SolicitudesService);
  readonly permissions = inject(OriginacionPermissionsService);
  private readonly router = inject(Router);
  products: {id: string; name: string}[] = [];
  productId = '';
  productLoading = false;
  productError = '';
  openProducts(dialog: HTMLDialogElement): void {
    this.productId = ''; this.productError = ''; this.products = []; this.productLoading = true;
    dialog.showModal();
    this.service.products().pipe(finalize(() => this.productLoading = false)).subscribe({
      next: rows => this.products = rows,
      error: e => this.productError = originacionError(e)
    });
  }
  selectProduct(dialog: HTMLDialogElement): void {
    if (!this.productId) return;
    dialog.close();
    void this.router.navigate(['/solicitudes', 'nuevo'], {queryParams: {product: this.productId}});
  }
  rows: SolicitudesRecord[] = [];
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
    if (this.loading || !this.permissions.can('solicitudes', 'ver')) {
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
