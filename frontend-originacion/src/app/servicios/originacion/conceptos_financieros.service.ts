import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { runtimeConfig } from '../../config/runtime-config';
import { ApiResponse, Paginated } from '../../interfaces/originacion/api-response.interface';
import { ConceptosFinancierosRecord, ConceptosFinancierosPayload } from '../../interfaces/originacion/conceptos_financieros.interface';

@Injectable({ providedIn: 'root' })
export class ConceptosFinancierosService {
  private readonly http = inject(HttpClient);
  private readonly url = runtimeConfig().appUrl + 'v1/credit-application-financial-items';

  list(page: number, search: string): Observable<Paginated<ConceptosFinancierosRecord>> {
    let params = new HttpParams().set('page', page).set('per_page', 25);
    if (search.trim()) {
      params = params.set('filter[concept]', search.trim());
    }
    return this.http.get<ApiResponse<Paginated<ConceptosFinancierosRecord>>>(this.url, { params })
      .pipe(map(response => response.data));
  }

  detail(id: string): Observable<ConceptosFinancierosRecord> {
    return this.http.get<ApiResponse<ConceptosFinancierosRecord>>(this.url + '/' + encodeURIComponent(id))
      .pipe(map(response => response.data));
  }

  create(payload: ConceptosFinancierosPayload): Observable<ConceptosFinancierosRecord> {
    return this.http.post<ApiResponse<ConceptosFinancierosRecord>>(this.url, payload)
      .pipe(map(response => response.data));
  }

  update(id: string, payload: Partial<ConceptosFinancierosPayload>): Observable<ConceptosFinancierosRecord> {
    return this.http.put<ApiResponse<ConceptosFinancierosRecord>>(this.url + '/' + encodeURIComponent(id), payload)
      .pipe(map(response => response.data));
  }

}
