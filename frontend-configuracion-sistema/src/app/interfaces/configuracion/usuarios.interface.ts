import {Item} from '../../modules/configuracion/shared/schema';
export interface UsuariosRecord extends Item {
 name: string;
 email: string;
 password: string;
 role_id?: string|null;
 is_active?: boolean|null;
}
