import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { MatModule } from 'src/app/appModules/mat.module';
@Component({selector:'app-home',standalone:true,imports:[CommonModule,RouterModule,MatModule],
templateUrl:'./home.component.html',styleUrls:['./home.component.scss']})
export class HomeComponent {}
