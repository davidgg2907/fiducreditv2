import { Injectable, inject } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, expand, map, reduce, EMPTY } from 'rxjs';
import { runtimeConfig } from '../../config/runtime-config';
import { ApiResponse, LookupOption, Paginated } from '../../interfaces/originacion/api-response.interface';

@Injectable({ providedIn: 'root' })
export class OriginacionLookupsService {
  private readonly http = inject(HttpClient);

  options(resource: string, label: string): Observable<LookupOption[]> {
    const fetch = (page: number) => this.http.get<ApiResponse<Paginated<Record<string, unknown>>>>(
      runtimeConfig().appUrl + 'v1/' + resource,
      { params: { page, per_page: 100 } }
    ).pipe(map(response => response.data));

    return fetch(1).pipe(
      expand(page => page.meta.current_page < page.meta.last_page
        ? fetch(page.meta.current_page + 1)
        : EMPTY),
      reduce((rows, page) => rows.concat(page.data), [] as Record<string, unknown>[]),
      map(rows => rows.map(row => ({
        id: String(row['id']),
        label: String(row[label] ?? row['id']) + ' · ' + String(row['id'])
      })))
    );
  }
}
