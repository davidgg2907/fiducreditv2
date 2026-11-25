import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { runtimeConfig } from '../../config/runtime-config';
import { ApiResponse, Paginated } from '../../interfaces/originacion/api-response.interface';
import { MesaControlRecord } from '../../interfaces/originacion/mesa_control.interface';

@Injectable({ providedIn: 'root' })
export class MesaControlService {
  private readonly http = inject(HttpClient);
  private readonly url = runtimeConfig().appUrl + 'v1/credit-workflow-instances';

  list(page: number, search: string): Observable<Paginated<MesaControlRecord>> {
    let params = new HttpParams().set('page', page).set('per_page', 25);
    if (search.trim()) {
      params = params.set('filter[application_id]', search.trim());
    }
    return this.http.get<ApiResponse<Paginated<MesaControlRecord>>>(this.url, { params })
      .pipe(map(response => response.data));
  }

  detail(id: string): Observable<MesaControlRecord> {
    return this.http.get<ApiResponse<MesaControlRecord>>(this.url + '/' + encodeURIComponent(id))
      .pipe(map(response => response.data));
  }

}
