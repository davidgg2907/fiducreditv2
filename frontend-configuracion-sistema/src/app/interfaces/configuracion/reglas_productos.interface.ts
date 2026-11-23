import {Item} from '../../modules/configuracion/shared/schema';
export interface ReglasProductosRecord extends Item {
 product_version_id: string;
 rule_code: string;
 operator: string;
 rule_value: unknown;
 rejection_reason?: string|null;
 mandatory?: boolean|null;
}
