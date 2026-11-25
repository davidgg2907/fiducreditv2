import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { runtimeConfig } from '../../config/runtime-config';
import { ApiResponse, Paginated } from '../../interfaces/originacion/api-response.interface';
import { AnalisisCrediticioRecord, AnalisisCrediticioPayload } from '../../interfaces/originacion/analisis_crediticio.interface';

@Injectable({ providedIn: 'root' })
export class AnalisisCrediticioService {
  private readonly http = inject(HttpClient);
  private readonly url = runtimeConfig().appUrl + 'v1/credit-application-analyses';

  list(page: number, search: string): Observable<Paginated<AnalisisCrediticioRecord>> {
    let params = new HttpParams().set('page', page).set('per_page', 25);
    if (search.trim()) {
      params = params.set('filter[application_id]', search.trim());
    }
    return this.http.get<ApiResponse<Paginated<AnalisisCrediticioRecord>>>(this.url, { params })
      .pipe(map(response => response.data));
  }

  detail(id: string): Observable<AnalisisCrediticioRecord> {
    return this.http.get<ApiResponse<AnalisisCrediticioRecord>>(this.url + '/' + encodeURIComponent(id))
      .pipe(map(response => response.data));
  }

  create(payload: AnalisisCrediticioPayload): Observable<AnalisisCrediticioRecord> {
    return this.http.post<ApiResponse<AnalisisCrediticioRecord>>(this.url, payload)
      .pipe(map(response => response.data));
  }

  update(id: string, payload: Partial<AnalisisCrediticioPayload>): Observable<AnalisisCrediticioRecord> {
    return this.http.put<ApiResponse<AnalisisCrediticioRecord>>(this.url + '/' + encodeURIComponent(id), payload)
      .pipe(map(response => response.data));
  }

}
