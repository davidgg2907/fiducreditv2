import {Item} from '../../modules/configuracion/shared/schema';
export interface TransicionesFlujosRecord extends Item {
 workflow_version_id: string;
 from_step_id: string;
 to_step_id: string;
 code: string;
 name: string;
 action: string;
 requires_reason?: boolean|null;
 requires_authorization?: boolean|null;
 enabled?: boolean|null;
}
