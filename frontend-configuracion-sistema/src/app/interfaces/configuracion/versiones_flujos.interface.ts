import {Item} from '../../modules/configuracion/shared/schema';
export interface VersionesFlujosRecord extends Item {
 workflow_id: string;
 version: number;
 status?: string|null;
 is_default?: boolean|null;
}
