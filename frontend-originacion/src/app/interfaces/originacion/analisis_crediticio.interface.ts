export interface AnalisisCrediticioRecord {
  id: string;
  application_id?: string | null;
  analyst_id?: number | null;
  status?: string | null;
  findings?: string | null;
  recommendation?: string | null;
  completed_at?: string | null;
  created_at?: string;
  updated_at?: string;
}

export interface AnalisisCrediticioPayload {
  application_id: string;
  analyst_id: number;
  status?: string | null;
  findings?: string | null;
  recommendation?: string | null;
  completed_at?: string | null;
}
