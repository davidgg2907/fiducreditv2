import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { runtimeConfig } from '../../config/runtime-config';
import { ApiResponse, Paginated } from '../../interfaces/originacion/api-response.interface';
import { ObligadosSolidariosRecord, ObligadosSolidariosPayload } from '../../interfaces/originacion/obligados_solidarios.interface';

@Injectable({ providedIn: 'root' })
export class ObligadosSolidariosService {
  private readonly http = inject(HttpClient);
  private readonly url = runtimeConfig().appUrl + 'v1/credit-application-guarantors';

  list(page: number, search: string): Observable<Paginated<ObligadosSolidariosRecord>> {
    let params = new HttpParams().set('page', page).set('per_page', 25);
    if (search.trim()) {
      params = params.set('filter[full_name]', search.trim());
    }
    return this.http.get<ApiResponse<Paginated<ObligadosSolidariosRecord>>>(this.url, { params })
      .pipe(map(response => response.data));
  }

  detail(id: string): Observable<ObligadosSolidariosRecord> {
    return this.http.get<ApiResponse<ObligadosSolidariosRecord>>(this.url + '/' + encodeURIComponent(id))
      .pipe(map(response => response.data));
  }

  create(payload: ObligadosSolidariosPayload): Observable<ObligadosSolidariosRecord> {
    return this.http.post<ApiResponse<ObligadosSolidariosRecord>>(this.url, payload)
      .pipe(map(response => response.data));
  }

  update(id: string, payload: Partial<ObligadosSolidariosPayload>): Observable<ObligadosSolidariosRecord> {
    return this.http.put<ApiResponse<ObligadosSolidariosRecord>>(this.url + '/' + encodeURIComponent(id), payload)
      .pipe(map(response => response.data));
  }

}
