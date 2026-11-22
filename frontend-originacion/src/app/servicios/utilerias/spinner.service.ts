import { Injectable } from '@angular/core';
import { NgxSpinnerService } from 'ngx-spinner';

@Injectable({
  providedIn: 'root'
})
export class SpinnerService {
  private pendingRequests = 0;

  constructor(private readonly spinner: NgxSpinnerService) {}

  loadingOn(): void {
    this.pendingRequests++;
    if (this.pendingRequests === 1) this.spinner.show();
  }

  loadingOff(): void {
    this.pendingRequests = Math.max(0, this.pendingRequests - 1);
    if (this.pendingRequests === 0) this.spinner.hide();
  }
}
