import api from './axios';
import { ApiResponse, LoginResponse, User } from '../types/auth';

export const authService = {
  /**
   * Login pengguna (mendukung Email, NIS, NIP, atau Nomor HP)
   */
  async login(loginInput: string, password: string, deviceName = 'Web React'): Promise<LoginResponse> {
    const response = await api.post<ApiResponse<LoginResponse>>('/auth/login', {
      login: loginInput,
      password,
      device_name: deviceName,
    });
    return response.data.data;
  },

  /**
   * Mengambil data profil user saat ini
   */
  async getMe(): Promise<User> {
    const response = await api.get<ApiResponse<User>>('/auth/me');
    return response.data.data;
  },

  /**
   * Logout user dan revoke token
   */
  async logout(): Promise<void> {
    try {
      await api.post('/auth/logout');
    } finally {
      localStorage.removeItem('token');
      localStorage.removeItem('user');
    }
  },
};
