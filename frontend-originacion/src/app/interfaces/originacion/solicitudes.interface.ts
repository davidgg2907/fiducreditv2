export interface SolicitudesRecord {
  id: string;
  client_name?: string;
  client_id?: string | null;
  product_version_id?: string | null;
  advisor_id?: string | null;
  branch_id?: string | null;
  address_version_id?: string | null;
  bank_account_id?: string | null;
  application_number?: string | null;
  requested_amount?: number | string | null;
  requested_term?: number | null;
  declared_income?: number | string | null;
  declared_expenses?: number | string | null;
  status?: string | null;
  created_at?: string;
  updated_at?: string;
}

export interface SolicitudesPayload {
  client_id: string;
  product_version_id: string;
  advisor_id: string;
  branch_id: string;
  address_version_id: string;
  bank_account_id?: string | null;
  application_number: string;
  requested_amount: number | string;
  requested_term: number;
  declared_income?: number | string | null;
  declared_expenses?: number | string | null;
}

export interface CaptureConfiguration {
 product: {id:string;name:string;description?:string};
 configuration: {configuracion_plazos:{plazos:{unidad_plazo:string;plazo_minimo:number;plazo_maximo:number;incremento:number}[];frecuencias_pago:string[];frecuencia_pago_predeterminada:string};id:string;min_amount:number;max_amount:number;min_term:number;max_term:number;term_unit:string;currency:string;min_annual_rate:number;max_annual_rate:number;payment_frequency:string;rate_type:string;amortization_method:string};
 fields: {custom_field_id:string;required:boolean;custom_field:{label:string;data_type:string;options:unknown}}[];
 documents: {document_type_id:string;required:boolean;min_files:number;max_files:number;document_type:{name:string}}[];
 branches:{id:string;name:string}[];
 advisors:{id:string;name:string;branch_id:string}[];
 assignment:{id:string;branch_id:string}|null;
}
export interface CaptureDetail {application: Record<string, any>;steps:{id:string;name:string}[];current_step_id:string|null;completed_step_ids?:string[];}
