export interface DictamenesRecord {
  id: string;
  application_id?: string | null;
  decided_by?: number | null;
  decision?: string | null;
  approved_amount?: number | string | null;
  reason?: string | null;
  decided_at?: string | null;
  created_at?: string;
  updated_at?: string;
}

export interface DictamenesPayload {
  application_id: string;
  decided_by: number;
  decision: string;
  approved_amount?: number | string | null;
  reason?: string | null;
  decided_at?: string | null;
}
