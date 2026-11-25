export interface DocumentosRecord {
  id: string;
  application_id?: string | null;
  document_type_id?: string | null;
  version?: number | string | null;
  original_filename?: string | null;
  mime_type?: string | null;
  size_bytes?: number | string | null;
  status?: string | null;
  rejection_reason?: string | null;
  validated_at?: string | null;
  created_at?: string;
  updated_at?: string;
}

export interface DocumentosPayload {
  application_id: string;
  document_type_id: string;
  version: number | string;
  original_filename: string;
  mime_type?: string | null;
  size_bytes?: number | string | null;
  status?: string | null;
  rejection_reason?: string | null;
  validated_at?: string | null;
}
