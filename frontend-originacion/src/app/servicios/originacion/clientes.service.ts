import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { runtimeConfig } from '../../config/runtime-config';
import { ApiResponse, Paginated } from '../../interfaces/originacion/api-response.interface';
import { ClientesRecord, ClientesPayload } from '../../interfaces/originacion/clientes.interface';

@Injectable({ providedIn: 'root' })
export class ClientesService {
  private readonly http = inject(HttpClient);
  private readonly url = runtimeConfig().appUrl + 'v1/credit-clients';

  list(page: number, search: string): Observable<Paginated<ClientesRecord>> {
    let params = new HttpParams().set('page', page).set('per_page', 25);
    if (search.trim()) {
      params = params.set('filter[first_name]', search.trim());
    }
    return this.http.get<ApiResponse<Paginated<ClientesRecord>>>(this.url, { params })
      .pipe(map(response => response.data));
  }

  detail(id: string): Observable<ClientesRecord> {
    return this.http.get<ApiResponse<ClientesRecord>>(this.url + '/' + encodeURIComponent(id))
      .pipe(map(response => response.data));
  }

  create(payload: ClientesPayload): Observable<ClientesRecord> {
    return this.http.post<ApiResponse<ClientesRecord>>(this.url, payload)
      .pipe(map(response => response.data));
  }

  update(id: string, payload: Partial<ClientesPayload>): Observable<ClientesRecord> {
    return this.http.put<ApiResponse<ClientesRecord>>(this.url + '/' + encodeURIComponent(id), payload)
      .pipe(map(response => response.data));
  }

}
