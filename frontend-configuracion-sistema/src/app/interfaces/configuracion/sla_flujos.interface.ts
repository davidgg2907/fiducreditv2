import {Item} from '../../modules/configuracion/shared/schema';
export interface SlaFlujosRecord extends Item {
 step_id: string;
 target_minutes: number;
 warning_minutes?: number|null;
 escalation_minutes?: number|null;
 calendar_type?: string|null;
 timezone?: string|null;
 escalation_role_id?: string|null;
 enabled?: boolean|null;
}
