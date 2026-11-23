import {Item} from '../../modules/configuracion/shared/schema';
export interface DiasInhabilesRecord extends Item {
 calendar_id: string;
 holiday_date: string;
 description: string;
 recurring?: boolean|null;
}
