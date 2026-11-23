import {Item} from '../../modules/configuracion/shared/schema';
export interface ReglasDocumentalesRecord extends Item {
 document_type_id: string;
 rule_code: string;
 rule_type: string;
 parameters?: unknown|null;
 required?: boolean|null;
}
