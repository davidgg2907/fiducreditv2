import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { runtimeConfig } from '../../config/runtime-config';
import { ApiResponse, Paginated } from '../../interfaces/originacion/api-response.interface';
import { DocumentosRecord } from '../../interfaces/originacion/documentos.interface';

@Injectable({ providedIn: 'root' })
export class DocumentosService {
  private readonly http = inject(HttpClient);
  private readonly url = runtimeConfig().appUrl + 'v1/credit-application-documents';

  list(page: number, search: string): Observable<Paginated<DocumentosRecord>> {
    let params = new HttpParams().set('page', page).set('per_page', 25);
    if (search.trim()) {
      params = params.set('filter[application_id]', search.trim());
    }
    return this.http.get<ApiResponse<Paginated<DocumentosRecord>>>(this.url, { params })
      .pipe(map(response => response.data));
  }

  detail(id: string): Observable<DocumentosRecord> {
    return this.http.get<ApiResponse<DocumentosRecord>>(this.url + '/' + encodeURIComponent(id))
      .pipe(map(response => response.data));
  }

}
