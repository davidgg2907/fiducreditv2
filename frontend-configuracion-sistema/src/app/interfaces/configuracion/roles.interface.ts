import {Item} from '../../modules/configuracion/shared/schema';
export interface RolesRecord extends Item {
 name: string;
 permissions?: string[]|null;
}
