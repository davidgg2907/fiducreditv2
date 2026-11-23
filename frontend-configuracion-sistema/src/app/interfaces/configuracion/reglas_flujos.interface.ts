import {Item} from '../../modules/configuracion/shared/schema';
export interface ReglasFlujosRecord extends Item {
 step_id: string;
 transition_id?: string|null;
 code: string;
 rule_type: string;
 operator: string;
 parameters: unknown;
 blocking?: boolean|null;
 enabled?: boolean|null;
}
