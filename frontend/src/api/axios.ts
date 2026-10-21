import axios, { AxiosError, InternalAxiosRequestConfig } from 'axios';

/**
 * Axios client instance terpusat.
 * Mengambil base URL dari environment variable (VITE_API_BASE_URL).
 */
const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL || 'https://satu-sekolah-production.up.railway.app/api/v1',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
  timeout: 15000,
});

// Request Interceptor: Menambahkan Bearer Token secara otomatis jika user sudah login
api.interceptors.request.use(
  (config: InternalAxiosRequestConfig) => {
    const token = localStorage.getItem('token');
    if (token && config.headers) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error: AxiosError) => {
    return Promise.reject(error);
  }
);

// Response Interceptor: Menangani status 401 (Unauthorized) otomatis logout
api.interceptors.response.use(
  (response) => response,
  (error: AxiosError) => {
    if (error.response?.status === 401) {
      // Hapus token dan sesi jika token kedaluwarsa atau tidak valid
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      if (window.location.pathname !== '/login') {
        window.location.href = '/login';
      }
    }
    return Promise.reject(error);
  }
);

export default api;
