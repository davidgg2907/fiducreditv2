import { SessionUser } from './session';
export interface ProfileResponse {
  isSuccess: boolean;
  message?: string;
  data: { user: SessionUser; personal: { nombre: string; correo: string } };
}
