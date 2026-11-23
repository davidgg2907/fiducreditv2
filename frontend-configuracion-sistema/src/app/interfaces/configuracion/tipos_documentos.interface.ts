import {Item} from '../../modules/configuracion/shared/schema';
export interface TiposDocumentosRecord extends Item {
 company_id: string;
 code: string;
 name: string;
 description?: string|null;
 active?: boolean|null;
}
