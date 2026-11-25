export interface ApiResponse<T> {
  isSuccess: boolean;
  data: T;
  message?: string;
}

export interface Paginated<T> {
  data: T[];
  meta: {
    current_page: number;
    last_page: number;
    total: number;
  };
}

export interface LookupOption {
  id: string;
  label: string;
}
