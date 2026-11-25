export interface TareasOriginacionRecord {
  id: string;
  instance_id?: string | null;
  step_id?: string | null;
  branch_id?: string | null;
  assigned_to?: number | null;
  assigned_role_id?: number | null;
  task_type?: string | null;
  status?: string | null;
  priority?: number | null;
  due_at?: string | null;
  resolution_notes?: string | null;
  created_at?: string;
  updated_at?: string;
}

export interface TareasOriginacionPayload {
  instance_id: string;
  step_id: string;
  branch_id?: string | null;
  assigned_to?: number | null;
  assigned_role_id?: number | null;
  task_type: string;
  status?: string | null;
  priority?: number | null;
  due_at?: string | null;
  resolution_notes?: string | null;
}
