import { SessionUser } from './session';

export interface PersonalProfile {
  nombre?: string | null;
  correo?: string | null;
  fotografia?: string | null;
}

export interface ProfileResponse {
  isSuccess: boolean;
  message?: string;
  data: { user: SessionUser; personal?: PersonalProfile | null };
}
