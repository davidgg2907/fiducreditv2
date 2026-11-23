import {Item} from '../../modules/configuracion/shared/schema';
export interface CamposProductosRecord extends Item {
 product_version_id: string;
 custom_field_id: string;
 scope?: string|null;
 required?: boolean|null;
 visible?: boolean|null;
 display_order?: number|null;
}
