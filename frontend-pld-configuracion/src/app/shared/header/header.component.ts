import { ToastrService } from 'ngx-toastr';
import { Component, DestroyRef, OnInit, inject } from '@angular/core';
import { takeUntilDestroyed } from '@angular/core/rxjs-interop';
import { NavigationEnd, Router } from '@angular/router';
import { filter, startWith, switchMap } from 'rxjs/operators';

import { NavigationStateService } from '../navigation/navigation-state.service';
import { SidebarService } from '../sidebar/sidebar.service';
import { AuthService } from 'src/app/servicios/auth/auth.service';
import { ProfileService } from 'src/app/servicios/auth/profile.service';
import { photoUrl } from 'src/app/config/photo-url';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit {
  theme_name = 'dark_mode';
  toggleSearch = false;
  userSession: any;
  user = '';
  userName = '';
  userSecondary = '';
  userPhotoUrl: string | null = null;
  headerTitle = 'Panel principal';

  private readonly toast = inject(ToastrService);
  private readonly destroyRef = inject(DestroyRef);

  constructor(
    public sidebarservice: SidebarService,
    private router: Router,
    private navigationStateService: NavigationStateService,
    private authService: AuthService,
    private profileService: ProfileService,
  ) {}

  darkMode() {
    if (this.theme_name === 'light_mode') {
      document.querySelector('html')?.classList.replace('dark_mode', 'light_mode');
      this.theme_name = 'dark_mode';
    } else if (this.theme_name === 'dark_mode') {
      document.querySelector('html')?.classList.replace('light_mode', 'dark_mode');
      this.theme_name = 'light_mode';
    }

    return this.theme_name;
  }

  getSideBarSate() {
    return this.sidebarservice.getSidebarState();
  }

  toggleSidebar() {
    this.sidebarservice.setSidebarState(!this.sidebarservice.getSidebarState());
  }

  openSearch() {
    this.toggleSearch = true;
  }

  searchClose() {
    this.toggleSearch = false;
  }

  get userInitials(): string {
    const normalized = (this.userName || 'Usuario')
      .split(' ')
      .map((fragment) => fragment.trim())
      .filter(Boolean)
      .slice(0, 2)
      .map((fragment) => fragment.charAt(0).toUpperCase())
      .join('');

    return normalized || 'US';
  }

  logOut = (): void => { this.authService.logout().subscribe({ next: () => void this.router.navigate(['/login']), error: () => this.toast.error('No se pudo cerrar la sesión. Intenta de nuevo.') }); }

  ngOnInit() {
    this.authService.sessionUserChanges().pipe(takeUntilDestroyed(this.destroyRef)).subscribe((sessionUser) => {
      this.userName = sessionUser?.nombre ?? sessionUser?.name ?? sessionUser?.email ?? 'Usuario';
      this.userSecondary = sessionUser?.email ?? '';
      this.userPhotoUrl = photoUrl(sessionUser?.fotografia);
    });
    this.profileService.get().pipe(takeUntilDestroyed(this.destroyRef)).subscribe({ next: response => {
      const user = { ...response.data?.user, fotografia: response.data?.personal?.fotografia ?? null };
      this.authService.updateSessionUser(user);
    }});
    this.router.events.pipe(
      filter((event) => event instanceof NavigationEnd),
      startWith(null),
      switchMap(() => this.navigationStateService.getHeaderState(this.router.url)),
      takeUntilDestroyed(this.destroyRef)
    ).subscribe((headerState) => {
      this.headerTitle = headerState.title;
    });
  }

}
