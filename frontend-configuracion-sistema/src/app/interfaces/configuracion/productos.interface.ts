import {Item} from '../../modules/configuracion/shared/schema';
export interface ProductosRecord extends Item {
 company_id: string;
 parent_product_id?: string|null;
 code: string;
 name: string;
 description?: string|null;
 status?: string|null;
}
