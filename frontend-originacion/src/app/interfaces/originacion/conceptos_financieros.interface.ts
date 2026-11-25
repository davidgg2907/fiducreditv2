export interface ConceptosFinancierosRecord {
  id: string;
  application_id?: string | null;
  entry_type?: string | null;
  concept?: string | null;
  counterparty?: string | null;
  amount?: number | string | null;
  frequency?: string | null;
  observations?: string | null;
  created_at?: string;
  updated_at?: string;
}

export interface ConceptosFinancierosPayload {
  application_id: string;
  entry_type: string;
  concept: string;
  counterparty?: string | null;
  amount: number | string;
  frequency: string;
  observations?: string | null;
}
