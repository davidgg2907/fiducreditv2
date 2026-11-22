import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { BrowserAnimationsModule, provideAnimations } from '@angular/platform-browser/animations';
import { HttpClientModule, HTTP_INTERCEPTORS } from "@angular/common/http";

import { SharedModule } from './shared/shared.module';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';


import { FullLayoutComponent } from "./layouts/full/full-layout.component";

import { MatModule } from './appModules/mat.module';
import { ToastrModule, provideToastr } from 'ngx-toastr';

import { NgxSpinnerModule } from 'ngx-spinner';

import { InterceptorService }  from './interceptors/interceptor.service';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';


@NgModule({
  declarations: [
    AppComponent,
    FullLayoutComponent,
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    NgxSpinnerModule,
    HttpClientModule,
    AppRoutingModule,
    SharedModule,
    MatModule,
    NgbModule,
  ],

  providers: [{
      provide: HTTP_INTERCEPTORS,
      useClass: InterceptorService ,
      multi: true
    },
    provideAnimations(),
    provideToastr({
      timeOut: 3000,
      positionClass: 'toast-top-right',
      preventDuplicates: true,
    }),
  ],
  bootstrap: [AppComponent]
})
export class AppModule {}
