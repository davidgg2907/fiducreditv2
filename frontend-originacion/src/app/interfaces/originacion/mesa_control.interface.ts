export interface MesaControlRecord {
  id: string;
  application_id?: string | null;
  workflow_version_id?: string | null;
  current_step_id?: string | null;
  status?: string | null;
  started_at?: string | null;
  completed_at?: string | null;
  lock_version?: number | null;
  created_at?: string;
  updated_at?: string;
}

export interface MesaControlPayload {
  application_id: string;
  workflow_version_id: string;
  current_step_id: string;
  status?: string | null;
  started_at?: string | null;
  completed_at?: string | null;
  lock_version?: number | null;
}
