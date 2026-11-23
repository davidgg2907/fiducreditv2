import {Item} from '../../modules/configuracion/shared/schema';
export interface CamposDinamicosRecord extends Item {
 company_id: string;
 field_key: string;
 label: string;
 data_type: string;
 options?: unknown|null;
 sensitive?: boolean|null;
}
