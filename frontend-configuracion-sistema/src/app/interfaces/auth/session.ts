export interface MenuItem {
  code: string;
  text: string;
  icon: string | null;
  routerLink: string | null;
  children?: MenuItem[];
}

export interface SessionUser {
  userId?: number;
  personalId?: number | null;
  isAdmin?: boolean;
  permissions?: string[];
  role?: { id: number; name: string } | null;
  menu?: MenuItem[];
  nombre?: string;
  name?: string;
  fotografia?: string | null;
  email: string;
}

export interface LoginResponse {
  isSuccess: boolean;
  message?: string;
  data: {
    user: SessionUser;
    tokens: { accessToken: string; accessTokenExpiresAt: string };
  };
}
