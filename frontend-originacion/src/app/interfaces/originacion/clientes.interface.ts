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

export interface ClienteDomicilio {
  id?: string;
  address_type: string;
  primary: boolean;
  active: boolean;
  street: string;
  exterior_number: string | null;
  interior_number: string | null;
  neighborhood: string;
  city: string;
  municipality: string;
  state: string;
  postal_code: string;
  country: string;
  latitude?: number | null;
  longitude?: number | null;
}
export interface ClienteDomicilioVersion extends Omit<ClienteDomicilio, 'id' | 'address_type' | 'primary' | 'active'> {
  id: string;
  version: number;
  valid_from?: string;
  valid_to?: string | null;
}
export interface ClienteDomicilioRegistro {
  id: string;
  address_type: string;
  primary: boolean;
  active: boolean;
  created_at: string;
  credit_client_address_versions: ClienteDomicilioVersion[];
}
export interface ClienteCuenta {
  id?: string;
  bank_code: string | null;
  bank_name: string;
  holder_name: string;
  clabe: string | null;
  account_last4: string | null;
  account_type: string;
  primary: boolean;
  active: boolean;
}
export interface ClienteRelaciones {
  addresses?: ClienteDomicilio[];
  bank_accounts?: ClienteCuenta[];
}
export interface ClienteConRelaciones extends ClientesRecord {
  credit_client_addresses: ClienteDomicilioRegistro[];
  credit_client_bank_accounts: (ClienteCuenta & {id: string; created_at: string; verified: boolean})[];
}
