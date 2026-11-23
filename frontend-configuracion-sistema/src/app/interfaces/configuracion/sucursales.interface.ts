import {Item} from '../../modules/configuracion/shared/schema';
export interface SucursalesRecord extends Item {
 company_id: string;
 code: string;
 name: string;
 municipality: string;
 state: string;
 active?: boolean|null;
}
