export interface ConsultasBuroRecord {
  id: string;
  application_id?: string | null;
  provider?: string | null;
  score?: number | null;
  external_reference?: string | null;
  result?: string | null;
  consulted_at?: string | null;
  created_at?: string;
  updated_at?: string;
}

export interface ConsultasBuroPayload {
  application_id: string;
  provider: string;
  score?: number | null;
  external_reference?: string | null;
  result?: string | null;
  consulted_at?: string | null;
}
