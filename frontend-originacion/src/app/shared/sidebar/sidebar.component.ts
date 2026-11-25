import { ToastrService } from 'ngx-toastr';
import { Component, DestroyRef, OnInit, inject } from '@angular/core';
import { takeUntilDestroyed } from '@angular/core/rxjs-interop';
import { Router } from '@angular/router';

import { MenuItem } from 'src/app/interfaces/auth/session';
import { NavigationStateService } from '../navigation/navigation-state.service';
import { SidebarService } from './sidebar.service';
import { AuthService } from 'src/app/servicios/auth/auth.service';

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.scss']
})
export class SidebarComponent implements OnInit {
  menuItems: MenuItem[] = [];
  private readonly toast = inject(ToastrService);
  private readonly destroyRef = inject(DestroyRef);

  constructor(
    public sidebarservice: SidebarService,
    private router: Router,
    private navigationStateService: NavigationStateService,
    private authService: AuthService
  ) {}

  getSideBarSate() {
    return this.sidebarservice.getSidebarState();
  }

  ngOnInit() {
    this.navigationStateService.getMenuItems()
      .pipe(takeUntilDestroyed(this.destroyRef))
      .subscribe((response) => {
        this.menuItems = response;
      });
  }

  closeOnMobile(): void {
    if (typeof window !== 'undefined' && window.matchMedia('(max-width: 900px)').matches) {
      this.sidebarservice.setSidebarState(false);
    }
  }

  logOut = (): void => { this.authService.logout().subscribe({ next: () => void this.router.navigate(['/login']), error: () => this.toast.error('No se pudo cerrar la sesión. Intenta de nuevo.') }); }

  isActive(item: MenuItem): boolean {
    const path = this.router.url.split(/[?#]/, 1)[0];
    return item.routerLink === path || (item.children ?? []).some(child => this.isActive(child));
  }

  trackByCode(_index: number, item: MenuItem): string {
    return item.code;
  }
}
