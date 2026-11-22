import { ApplicationConfig } from '@angular/core';
import { provideHttpClient, withFetch } from '@angular/common/http';
import { provideAnimations } from '@angular/platform-browser/animations';
import { provideToastr } from 'ngx-toastr';
export const appConfig: ApplicationConfig = {
  providers:[provideHttpClient(withFetch()),provideAnimations(),provideToastr()]
};
