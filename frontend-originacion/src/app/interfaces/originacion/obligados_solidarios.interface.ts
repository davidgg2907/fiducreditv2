export interface ObligadosSolidariosRecord {
  id: string;
  application_id?: string | null;
  full_name?: string | null;
  rfc?: string | null;
  relationship?: string | null;
  phone?: string | null;
  monthly_income?: number | string | null;
  created_at?: string;
  updated_at?: string;
}

export interface ObligadosSolidariosPayload {
  application_id: string;
  full_name: string;
  rfc?: string | null;
  relationship: string;
  phone?: string | null;
  monthly_income?: number | string | null;
}
