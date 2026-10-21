import api from './axios';
import { ApiResponse } from '../types/auth';
import { Post, SchoolProfile } from '../types/school';

export const schoolService = {
  /**
   * Mengambil profil dan statistik umum sekolah
   */
  async getSchoolProfile(): Promise<SchoolProfile> {
    const response = await api.get<ApiResponse<SchoolProfile>>('/school/profile');
    return response.data.data;
  },

  /**
   * Mengambil daftar berita sekolah
   */
  async getNews(search?: string): Promise<Post[]> {
    const response = await api.get<ApiResponse<Post[]>>('/posts/news', {
      params: { search },
    });
    return response.data.data;
  },

  /**
   * Mengambil daftar pengumuman sekolah
   */
  async getAnnouncements(): Promise<Post[]> {
    const response = await api.get<ApiResponse<Post[]>>('/posts/announcements');
    return response.data.data;
  },

  /**
   * Mengambil daftar agenda kegiatan sekolah
   */
  async getEvents(upcomingOnly = true): Promise<Post[]> {
    const response = await api.get<ApiResponse<Post[]>>('/posts/events', {
      params: { upcoming_only: upcomingOnly },
    });
    return response.data.data;
  },

  /**
   * Mengambil detail berita berdasarkan slug
   */
  async getNewsBySlug(slug: string): Promise<Post> {
    const response = await api.get<ApiResponse<Post>>(`/posts/news/${slug}`);
    return response.data.data;
  },
};
