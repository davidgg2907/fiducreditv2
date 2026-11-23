import {Item} from '../../modules/configuracion/shared/schema';
export interface AccionesRecord extends Item {
 module_id: string;
 permission: string;
 name: string;
}
