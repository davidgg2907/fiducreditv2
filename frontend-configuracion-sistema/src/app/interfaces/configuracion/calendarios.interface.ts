import {Item} from '../../modules/configuracion/shared/schema';
export interface CalendariosRecord extends Item {
 company_id: string;
 code: string;
 name: string;
 timezone?: string|null;
 non_business_weekdays: unknown;
 due_date_adjustment?: string|null;
 enabled?: boolean|null;
}
