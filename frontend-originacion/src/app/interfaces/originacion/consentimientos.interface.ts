export interface ConsentimientosRecord {
  id: string;
  application_id?: string | null;
  consent_type?: string | null;
  version?: string | null;
  accepted?: boolean | null;
  accepted_at?: string | null;
  created_at?: string;
  updated_at?: string;
}

export interface ConsentimientosPayload {
  application_id: string;
  consent_type: string;
  version: string;
  accepted?: boolean | null;
  accepted_at?: string | null;
}
