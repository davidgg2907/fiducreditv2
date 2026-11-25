import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { runtimeConfig } from '../../config/runtime-config';
import { ApiResponse, Paginated } from '../../interfaces/originacion/api-response.interface';
import { ConsultasBuroRecord, ConsultasBuroPayload } from '../../interfaces/originacion/consultas_buro.interface';

@Injectable({ providedIn: 'root' })
export class ConsultasBuroService {
  private readonly http = inject(HttpClient);
  private readonly url = runtimeConfig().appUrl + 'v1/credit-bureau-inquiries';

  list(page: number, search: string): Observable<Paginated<ConsultasBuroRecord>> {
    let params = new HttpParams().set('page', page).set('per_page', 25);
    if (search.trim()) {
      params = params.set('filter[provider]', search.trim());
    }
    return this.http.get<ApiResponse<Paginated<ConsultasBuroRecord>>>(this.url, { params })
      .pipe(map(response => response.data));
  }

  detail(id: string): Observable<ConsultasBuroRecord> {
    return this.http.get<ApiResponse<ConsultasBuroRecord>>(this.url + '/' + encodeURIComponent(id))
      .pipe(map(response => response.data));
  }

  create(payload: ConsultasBuroPayload): Observable<ConsultasBuroRecord> {
    return this.http.post<ApiResponse<ConsultasBuroRecord>>(this.url, payload)
      .pipe(map(response => response.data));
  }

  update(id: string, payload: Partial<ConsultasBuroPayload>): Observable<ConsultasBuroRecord> {
    return this.http.put<ApiResponse<ConsultasBuroRecord>>(this.url + '/' + encodeURIComponent(id), payload)
      .pipe(map(response => response.data));
  }

}
