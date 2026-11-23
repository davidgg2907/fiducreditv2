import {Item} from '../../modules/configuracion/shared/schema';
export interface PrioridadesPagoRecord extends Item {
 policy_id: string;
 component: string;
 priority: number;
 enabled?: boolean|null;
}
