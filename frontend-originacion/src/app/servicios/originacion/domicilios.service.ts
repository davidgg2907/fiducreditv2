import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { runtimeConfig } from '../../config/runtime-config';
import { ApiResponse, Paginated } from '../../interfaces/originacion/api-response.interface';
import { DomiciliosRecord, DomiciliosPayload } from '../../interfaces/originacion/domicilios.interface';

@Injectable({ providedIn: 'root' })
export class DomiciliosService {
  private readonly http = inject(HttpClient);
  private readonly url = runtimeConfig().appUrl + 'v1/credit-client-addresses';

  list(page: number, search: string): Observable<Paginated<DomiciliosRecord>> {
    let params = new HttpParams().set('page', page).set('per_page', 25);
    if (search.trim()) {
      params = params.set('filter[client_id]', search.trim());
    }
    return this.http.get<ApiResponse<Paginated<DomiciliosRecord>>>(this.url, { params })
      .pipe(map(response => response.data));
  }

  detail(id: string): Observable<DomiciliosRecord> {
    return this.http.get<ApiResponse<DomiciliosRecord>>(this.url + '/' + encodeURIComponent(id))
      .pipe(map(response => response.data));
  }

  create(payload: DomiciliosPayload): Observable<DomiciliosRecord> {
    return this.http.post<ApiResponse<DomiciliosRecord>>(this.url, payload)
      .pipe(map(response => response.data));
  }

  update(id: string, payload: Partial<DomiciliosPayload>): Observable<DomiciliosRecord> {
    return this.http.put<ApiResponse<DomiciliosRecord>>(this.url + '/' + encodeURIComponent(id), payload)
      .pipe(map(response => response.data));
  }

}
