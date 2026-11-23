import {Item} from '../../modules/configuracion/shared/schema';
export interface RequisitosDocumentalesRecord extends Item {
 product_version_id: string;
 document_type_id: string;
 required?: boolean|null;
 min_files?: number|null;
 max_files?: number|null;
 display_order?: number|null;
}
