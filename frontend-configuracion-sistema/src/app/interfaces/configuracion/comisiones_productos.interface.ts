import {Item} from '../../modules/configuracion/shared/schema';
export interface ComisionesProductosRecord extends Item {
 product_version_id: string;
 code: string;
 name: string;
 calculation_type: string;
 amount: number;
 taxable?: boolean|null;
 active?: boolean|null;
}
