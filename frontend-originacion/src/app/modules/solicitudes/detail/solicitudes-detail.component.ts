import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, ActivatedRoute } from '@angular/router';
import { SolicitudesService } from '../../../servicios/originacion/solicitudes.service';
import { CaptureDetail } from '../../../interfaces/originacion/solicitudes.interface';
import { originacionError } from '../../../servicios/originacion/originacion-errors';
import { finalize } from 'rxjs';
@Component({selector:'app-solicitudes-detail',standalone:true,imports:[CommonModule,RouterModule],templateUrl:'./solicitudes-detail.component.html',styleUrls:['./solicitudes-detail.component.scss']})
export class SolicitudesDetailComponent implements OnInit{
 private readonly service=inject(SolicitudesService);private readonly route=inject(ActivatedRoute);
 detail?:CaptureDetail;loading=true;error='';
 ngOnInit(){const id=this.route.snapshot.paramMap.get('id');if(!id){this.loading=false;return;}this.service.captureDetail(id).pipe(finalize(()=>this.loading=false)).subscribe({next:r=>this.detail=r,error:e=>this.error=originacionError(e)});}
}
