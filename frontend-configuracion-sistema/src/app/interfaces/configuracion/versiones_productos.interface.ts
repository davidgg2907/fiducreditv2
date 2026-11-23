import {Item} from '../../modules/configuracion/shared/schema';
export interface VersionesProductosRecord extends Item {
 product_id: string;
 version: number;
 min_amount: number;
 max_amount: number;
 min_term: number;
 max_term: number;
 term_unit?: string|null;
 min_annual_rate: number;
 max_annual_rate: number;
 rate_type?: string|null;
 interest_method?: string|null;
 min_dti?: number|null;
 max_dti?: number|null;
 min_bureau_score?: number|null;
 amortization_method?: string|null;
 payment_frequency?: string|null;
 currency?: string|null;
 requires_bureau?: boolean|null;
 active?: boolean|null;
 effective_from?: string|null;
 effective_to?: string|null;
}
