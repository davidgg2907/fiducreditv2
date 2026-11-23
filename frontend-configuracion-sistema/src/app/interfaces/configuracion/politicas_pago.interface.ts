import {Item} from '../../modules/configuracion/shared/schema';
export interface PoliticasPagoRecord extends Item {
 product_version_id: string;
 prepayment_mode?: string|null;
 allow_early_payment?: boolean|null;
 recalculate_interest_after_prepayment?: boolean|null;
 allow_overpayment?: boolean|null;
 surplus_handling?: string|null;
 enabled?: boolean|null;
}
