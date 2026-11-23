import {Item} from '../../modules/configuracion/shared/schema';
export interface MenusRecord extends Item {
 code: string;
 label: string;
 route?: string|null;
 icon?: string|null;
 position?: number|null;
 parent_id?: string|null;
 module_action_id?: string|null;
 app_code?: string|null;
}
