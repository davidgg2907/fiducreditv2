import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { runtimeConfig } from '../../config/runtime-config';
import { ApiResponse, Paginated } from '../../interfaces/originacion/api-response.interface';
import { ExpedientesRecord } from '../../interfaces/originacion/expedientes.interface';

@Injectable({ providedIn: 'root' })
export class ExpedientesService {
  private readonly http = inject(HttpClient);
  private readonly url = runtimeConfig().appUrl + 'v1/credit-applications';

  list(page: number, search: string): Observable<Paginated<ExpedientesRecord>> {
    let params = new HttpParams().set('page', page).set('per_page', 25);
    if (search.trim()) {
      params = params.set('filter[application_number]', search.trim());
    }
    return this.http.get<ApiResponse<Paginated<ExpedientesRecord>>>(this.url, { params })
      .pipe(map(response => response.data));
  }

  detail(id: string): Observable<ExpedientesRecord> {
    return this.http.get<ApiResponse<ExpedientesRecord>>(this.url + '/' + encodeURIComponent(id))
      .pipe(map(response => response.data));
  }

}
