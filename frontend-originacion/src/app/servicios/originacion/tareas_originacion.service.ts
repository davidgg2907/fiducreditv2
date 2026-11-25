import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { runtimeConfig } from '../../config/runtime-config';
import { ApiResponse, Paginated } from '../../interfaces/originacion/api-response.interface';
import { TareasOriginacionRecord } from '../../interfaces/originacion/tareas_originacion.interface';

@Injectable({ providedIn: 'root' })
export class TareasOriginacionService {
  private readonly http = inject(HttpClient);
  private readonly url = runtimeConfig().appUrl + 'v1/credit-workflow-tasks';

  list(page: number, search: string): Observable<Paginated<TareasOriginacionRecord>> {
    let params = new HttpParams().set('page', page).set('per_page', 25);
    if (search.trim()) {
      params = params.set('filter[task_type]', search.trim());
    }
    return this.http.get<ApiResponse<Paginated<TareasOriginacionRecord>>>(this.url, { params })
      .pipe(map(response => response.data));
  }

  detail(id: string): Observable<TareasOriginacionRecord> {
    return this.http.get<ApiResponse<TareasOriginacionRecord>>(this.url + '/' + encodeURIComponent(id))
      .pipe(map(response => response.data));
  }

}
