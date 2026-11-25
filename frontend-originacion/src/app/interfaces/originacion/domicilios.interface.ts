export interface DomiciliosRecord {
  id: string;
  client_id?: string | null;
  address_type?: string | null;
  primary?: boolean | null;
  active?: boolean | null;
  created_at?: string;
  updated_at?: string;
}

export interface DomiciliosPayload {
  client_id: string;
  address_type?: string | null;
  primary?: boolean | null;
  active?: boolean | null;
}
