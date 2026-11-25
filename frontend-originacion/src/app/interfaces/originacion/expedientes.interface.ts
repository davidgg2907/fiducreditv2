export interface ExpedientesRecord {
  id: string;
  application_number?: string | null;
  client_id?: string | null;
  product_version_id?: string | null;
  requested_amount?: number | string | null;
  requested_term?: number | string | null;
  status?: string | null;
  review_substatus?: string | null;
  declared_income?: number | string | null;
  declared_expenses?: number | string | null;
  created_at?: string;
  updated_at?: string;
}

export interface ExpedientesPayload {
  application_number: string;
  client_id: string;
  product_version_id: string;
  requested_amount: number | string;
  requested_term: number | string;
  status?: string | null;
  review_substatus?: string | null;
  declared_income?: number | string | null;
  declared_expenses?: number | string | null;
}
