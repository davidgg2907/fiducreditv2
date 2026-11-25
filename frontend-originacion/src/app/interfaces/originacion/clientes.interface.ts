export interface ClientesRecord {
  id: string;
  company_id?: string | null;
  first_name?: string | null;
  middle_name?: string | null;
  last_name?: string | null;
  second_last_name?: string | null;
  birth_date?: string | null;
  rfc?: string | null;
  curp?: string | null;
  ine_folio?: string | null;
  passport_number?: string | null;
  nss?: string | null;
  health_provider?: string | null;
  email?: string | null;
  phone?: string | null;
  status?: string | null;
  created_at?: string;
  updated_at?: string;
}

export interface ClientesPayload {
  company_id: string;
  first_name: string;
  middle_name?: string | null;
  last_name: string;
  second_last_name?: string | null;
  birth_date?: string | null;
  rfc?: string | null;
  curp?: string | null;
  ine_folio?: string | null;
  passport_number?: string | null;
  nss?: string | null;
  health_provider?: string | null;
  email?: string | null;
  phone?: string | null;
  status?: string | null;
}
