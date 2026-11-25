import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { runtimeConfig } from '../../config/runtime-config';
import { ApiResponse, Paginated } from '../../interfaces/originacion/api-response.interface';
import { ConsentimientosRecord, ConsentimientosPayload } from '../../interfaces/originacion/consentimientos.interface';

@Injectable({ providedIn: 'root' })
export class ConsentimientosService {
  private readonly http = inject(HttpClient);
  private readonly url = runtimeConfig().appUrl + 'v1/credit-application-consents';

  list(page: number, search: string): Observable<Paginated<ConsentimientosRecord>> {
    let params = new HttpParams().set('page', page).set('per_page', 25);
    if (search.trim()) {
      params = params.set('filter[consent_type]', search.trim());
    }
    return this.http.get<ApiResponse<Paginated<ConsentimientosRecord>>>(this.url, { params })
      .pipe(map(response => response.data));
  }

  detail(id: string): Observable<ConsentimientosRecord> {
    return this.http.get<ApiResponse<ConsentimientosRecord>>(this.url + '/' + encodeURIComponent(id))
      .pipe(map(response => response.data));
  }

  create(payload: ConsentimientosPayload): Observable<ConsentimientosRecord> {
    return this.http.post<ApiResponse<ConsentimientosRecord>>(this.url, payload)
      .pipe(map(response => response.data));
  }

}
