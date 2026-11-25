export interface CuentasBancariasRecord {
  id: string;
  client_id?: string | null;
  bank_code?: string | null;
  bank_name?: string | null;
  holder_name?: string | null;
  clabe?: string | null;
  account_last4?: string | null;
  account_type?: string | null;
  primary?: boolean | null;
  active?: boolean | null;
  created_at?: string;
  updated_at?: string;
}

export interface CuentasBancariasPayload {
  client_id: string;
  bank_code?: string | null;
  bank_name: string;
  holder_name: string;
  clabe?: string | null;
  account_last4?: string | null;
  account_type?: string | null;
  primary?: boolean | null;
  active?: boolean | null;
}
