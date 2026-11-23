import {Item} from '../../modules/configuracion/shared/schema';
export interface PoliticasLineaRecord extends Item {
 product_version_id: string;
 line_type?: string|null;
 replenish_principal?: boolean|null;
 max_simultaneous_loans?: number|null;
 max_utilization_pct?: number|null;
 min_draw_amount?: number|null;
 require_new_approval_per_draw?: boolean|null;
 enabled?: boolean|null;
}
