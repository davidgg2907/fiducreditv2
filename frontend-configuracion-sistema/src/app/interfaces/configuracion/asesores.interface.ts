import {Item} from '../../modules/configuracion/shared/schema';
export interface AsesoresRecord extends Item {
 user_id: string;
 company_id: string;
 branch_id: string;
 employee_code: string;
 active?: boolean|null;
}
