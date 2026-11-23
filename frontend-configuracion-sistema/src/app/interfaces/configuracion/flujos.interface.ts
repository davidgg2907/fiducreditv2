import {Item} from '../../modules/configuracion/shared/schema';
export interface FlujosRecord extends Item {
 company_id: string;
 product_id?: string|null;
 code: string;
 name: string;
 description?: string|null;
 enabled?: boolean|null;
}
