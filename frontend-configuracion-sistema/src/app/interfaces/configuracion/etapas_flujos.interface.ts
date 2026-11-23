import {Item} from '../../modules/configuracion/shared/schema';
export interface EtapasFlujosRecord extends Item {
 workflow_version_id: string;
 code: string;
 name: string;
 step_type: string;
 application_status: string;
 application_substatus?: string|null;
 sort_order: number;
 is_initial?: boolean|null;
 is_terminal?: boolean|null;
 allow_manual_assignment?: boolean|null;
 metadata?: unknown|null;
}
