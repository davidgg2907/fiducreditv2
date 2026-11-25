import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
import { MatModule } from 'src/app/appModules/mat.module';

@Component({
  standalone: true,
  imports: [RouterLink, MatModule],
  templateUrl: './pending-module.component.html',
  styleUrls: ['./pending-module.component.scss'],
})
export class PendingModuleComponent {}
