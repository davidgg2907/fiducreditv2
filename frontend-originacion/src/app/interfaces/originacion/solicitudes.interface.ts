export interface SolicitudesRecord {
  id: string;
  client_id?: string | null;
  product_version_id?: string | null;
  advisor_id?: string | null;
  branch_id?: string | null;
  address_version_id?: string | null;
  bank_account_id?: string | null;
  application_number?: string | null;
  requested_amount?: number | string | null;
  requested_term?: number | null;
  declared_income?: number | string | null;
  declared_expenses?: number | string | null;
  status?: string | null;
  created_at?: string;
  updated_at?: string;
}

export interface SolicitudesPayload {
  client_id: string;
  product_version_id: string;
  advisor_id: string;
  branch_id: string;
  address_version_id: string;
  bank_account_id?: string | null;
  application_number: string;
  requested_amount: number | string;
  requested_term: number;
  declared_income?: number | string | null;
  declared_expenses?: number | string | null;
}
