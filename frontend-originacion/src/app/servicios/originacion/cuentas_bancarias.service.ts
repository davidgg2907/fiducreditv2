import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { runtimeConfig } from '../../config/runtime-config';
import { ApiResponse, Paginated } from '../../interfaces/originacion/api-response.interface';
import { CuentasBancariasRecord, CuentasBancariasPayload } from '../../interfaces/originacion/cuentas_bancarias.interface';

@Injectable({ providedIn: 'root' })
export class CuentasBancariasService {
  private readonly http = inject(HttpClient);
  private readonly url = runtimeConfig().appUrl + 'v1/credit-client-bank-accounts';

  list(page: number, search: string): Observable<Paginated<CuentasBancariasRecord>> {
    let params = new HttpParams().set('page', page).set('per_page', 25);
    if (search.trim()) {
      params = params.set('filter[bank_name]', search.trim());
    }
    return this.http.get<ApiResponse<Paginated<CuentasBancariasRecord>>>(this.url, { params })
      .pipe(map(response => response.data));
  }

  detail(id: string): Observable<CuentasBancariasRecord> {
    return this.http.get<ApiResponse<CuentasBancariasRecord>>(this.url + '/' + encodeURIComponent(id))
      .pipe(map(response => response.data));
  }

  create(payload: CuentasBancariasPayload): Observable<CuentasBancariasRecord> {
    return this.http.post<ApiResponse<CuentasBancariasRecord>>(this.url, payload)
      .pipe(map(response => response.data));
  }

  update(id: string, payload: Partial<CuentasBancariasPayload>): Observable<CuentasBancariasRecord> {
    return this.http.put<ApiResponse<CuentasBancariasRecord>>(this.url + '/' + encodeURIComponent(id), payload)
      .pipe(map(response => response.data));
  }

}
