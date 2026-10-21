export interface User {
  id: number;
  name: string;
  email: string;
  phone: string | null;
  avatar_url: string | null;
  is_active: boolean;
  roles: string[];
  student?: {
    id: number;
    nis: string;
    nisn: string;
    classroom_name?: string;
  } | null;
  teacher?: {
    id: number;
    nip: string | null;
  } | null;
}

export interface LoginResponse {
  token: string;
  token_type: string;
  user: User;
}

export interface ApiResponse<T> {
  success: boolean;
  message: string;
  data: T;
  meta?: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
}
