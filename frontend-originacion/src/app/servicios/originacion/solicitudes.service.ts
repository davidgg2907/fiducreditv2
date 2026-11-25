import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { runtimeConfig } from '../../config/runtime-config';
import { ApiResponse, Paginated } from '../../interfaces/originacion/api-response.interface';
import { SolicitudesRecord, SolicitudesPayload } from '../../interfaces/originacion/solicitudes.interface';

@Injectable({ providedIn: 'root' })
export class SolicitudesService {
  private readonly http = inject(HttpClient);
  private readonly url = runtimeConfig().appUrl + 'v1/credit-applications';

  list(page: number, search: string): Observable<Paginated<SolicitudesRecord>> {
    let params = new HttpParams().set('page', page).set('per_page', 25);
    if (search.trim()) {
      params = params.set('filter[application_number]', search.trim());
    }
    return this.http.get<ApiResponse<Paginated<SolicitudesRecord>>>(this.url, { params })
      .pipe(map(response => response.data));
  }

  detail(id: string): Observable<SolicitudesRecord> {
    return this.http.get<ApiResponse<SolicitudesRecord>>(this.url + '/' + encodeURIComponent(id))
      .pipe(map(response => response.data));
  }

  create(payload: SolicitudesPayload): Observable<SolicitudesRecord> {
    return this.http.post<ApiResponse<SolicitudesRecord>>(this.url, payload)
      .pipe(map(response => response.data));
  }

  update(id: string, payload: Partial<SolicitudesPayload>): Observable<SolicitudesRecord> {
    return this.http.put<ApiResponse<SolicitudesRecord>>(this.url + '/' + encodeURIComponent(id), payload)
      .pipe(map(response => response.data));
  }

}
