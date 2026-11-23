import {Item} from '../../modules/configuracion/shared/schema';
export interface RolesFlujosRecord extends Item {
 step_id: string;
 role_id: string;
 can_view?: boolean|null;
 can_claim?: boolean|null;
 can_process?: boolean|null;
 can_assign?: boolean|null;
}
