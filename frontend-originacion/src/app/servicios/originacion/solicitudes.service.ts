import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { runtimeConfig } from '../../config/runtime-config';
import { ApiResponse, Paginated } from '../../interfaces/originacion/api-response.interface';
import { SolicitudesRecord, SolicitudesPayload, CaptureConfiguration, CaptureDetail } from '../../interfaces/originacion/solicitudes.interface';

@Injectable({ providedIn: 'root' })
export class SolicitudesService {
  private readonly http = inject(HttpClient);
  private readonly url = runtimeConfig().appUrl + 'v1/credit-applications';

  private readonly capture = runtimeConfig().appUrl + 'v1/origination-capture';
  products(): Observable<{id:string;name:string}[]> { return this.http.get<ApiResponse<{id:string;name:string}[]>>(this.capture+'/products').pipe(map(r=>r.data)); }
  configuration(id:string): Observable<CaptureConfiguration> { return this.http.get<ApiResponse<CaptureConfiguration>>(this.capture+'/products/'+encodeURIComponent(id)).pipe(map(r=>r.data)); }
  captureApplication(payload:FormData): Observable<{id:string}> { return this.http.post<ApiResponse<{id:string}>>(this.capture+'/applications',payload).pipe(map(r=>r.data)); }
  captureDetail(id:string): Observable<CaptureDetail> { return this.http.get<ApiResponse<CaptureDetail>>(this.capture+'/applications/'+encodeURIComponent(id)).pipe(map(r=>r.data)); }
  editConfiguration(id:string):Observable<CaptureConfiguration & {application:Record<string,any>}>{return this.http.get<ApiResponse<CaptureConfiguration & {application:Record<string,any>}>>(this.capture+'/applications/'+encodeURIComponent(id)+'/edit').pipe(map(r=>r.data));}
  updateCapture(id:string,payload:FormData):Observable<{id:string}>{return this.http.post<ApiResponse<{id:string}>>(this.capture+'/applications/'+encodeURIComponent(id),payload).pipe(map(r=>r.data));}
  list(page: number, search: string): Observable<Paginated<SolicitudesRecord>> {
    let params = new HttpParams().set('page', page).set('per_page', 25);
    if (search.trim()) {
      params = params.set('filter[application_number]', search.trim());
    }
    return this.http.get<ApiResponse<Paginated<SolicitudesRecord>>>(this.capture+'/applications', { params })
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
