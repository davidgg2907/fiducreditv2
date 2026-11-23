import {Item} from '../../modules/configuracion/shared/schema';
export interface EmpresasRecord extends Item {
 legal_name: string;
 trade_name: string;
 rfc: string;
 status?: string|null;
}
