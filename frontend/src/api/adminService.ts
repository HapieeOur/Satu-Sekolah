import api from './axios';

export interface DashboardStats {
  total_students: number;
  total_teachers: number;
  total_classrooms: number;
  total_companies: number;
  total_users: number;
  total_subjects: number;
  total_rooms: number;
  active_academic_year: string;
}

export interface UserItem {
  id: number;
  name: string;
  email: string;
  phone: string | null;
  nis: string | null;
  nisn: string | null;
  is_active: boolean;
  roles: string[];
  created_at: string;
}

export interface TeacherItem {
  id: number;
  user_id: number;
  name: string;
  email: string;
  nip: string;
  nuptk: string;
  gender: string;
  phone: string;
  address: string;
  roles: string[];
  is_walas: boolean;
  is_mentor: boolean;
  subjects: { id: number; code: string; name: string }[];
}

export interface StudentItem {
  id: number;
  user_id: number | null;
  name: string;
  nis: string;
  nisn: string | null;
  gender: 'L' | 'P';
  classroom_id: number | null;
  classroom_name: string;
  phone: string;
  address: string;
  parent_name: string;
  parent_phone: string;
  status: string;
}

export interface ClassroomItem {
  id: number;
  name: string;
  grade_level: number;
  major: string;
  academic_year_id: number | null;
  academic_year_name: string;
  teacher_id: number | null;
  walas_name: string;
  walas_nip: string;
  students_count: number;
}

export interface AcademicYearItem {
  id: number;
  name: string;
  semester: string;
  is_active: boolean;
  start_date: string;
  end_date: string;
  classrooms_count: number;
}

export interface SubjectItem {
  id: number;
  code: string;
  name: string;
  description: string;
  teachers: { id: number; name: string }[];
}

export interface RoomItem {
  id: number;
  code: string;
  name: string;
  capacity: number;
  description: string;
}

export interface CompanyItem {
  id: number;
  name: string;
  address: string;
  contact_person: string;
  phone: string;
  email: string;
  teacher_id: number | null;
  mentor_name: string;
  radius_meters: number;
}

export interface PostItem {
  id: number;
  title: string;
  slug: string;
  category: 'berita' | 'pengumuman' | 'agenda';
  excerpt: string;
  content: string;
  is_published: boolean;
  published_at: string;
  author: string;
}

export const adminService = {
  // Stats
  getStats: async (): Promise<DashboardStats> => {
    const res = await api.get('/admin/stats');
    return res.data.data;
  },

  // Users
  getUsers: async (params?: { search?: string; role?: string; status?: string }): Promise<{ users: UserItem[]; stats?: { total_users: number; active_users: number; teacher_users: number } }> => {
    const res = await api.get('/admin/users', { params });
    return {
      users: res.data.data,
      stats: res.data.stats,
    };
  },
  getRoles: async (): Promise<string[]> => {
    const res = await api.get('/admin/roles');
    return res.data.data;
  },
  createUser: async (payload: {
    name: string;
    email: string;
    password?: string;
    phone?: string;
    nis?: string;
    nisn?: string;
    roles: string[];
    is_active?: boolean;
  }): Promise<UserItem> => {
    const res = await api.post('/admin/users', payload);
    return res.data.data;
  },
  updateUser: async (id: number, payload: {
    name: string;
    email: string;
    password?: string;
    phone?: string;
    nis?: string;
    nisn?: string;
    roles: string[];
    is_active?: boolean;
  }): Promise<UserItem> => {
    const res = await api.put(`/admin/users/${id}`, payload);
    return res.data.data;
  },
  toggleUserStatus: async (id: number): Promise<{ id: number; is_active: boolean }> => {
    const res = await api.post(`/admin/users/${id}/toggle-status`);
    return res.data.data;
  },
  deleteUser: async (id: number): Promise<void> => {
    await api.delete(`/admin/users/${id}`);
  },

  // Teachers
  getTeachers: async (params?: { search?: string }): Promise<TeacherItem[]> => {
    const res = await api.get('/admin/teachers', { params });
    return res.data.data;
  },
  createTeacher: async (payload: {
    name?: string;
    email?: string;
    password?: string;
    nip?: string;
    nuptk?: string;
    gender?: string;
    phone?: string;
    address?: string;
    subject_ids?: number[];
    is_walas?: boolean;
    is_mentor?: boolean;
  }): Promise<any> => {
    const res = await api.post('/admin/teachers', payload);
    return res.data.data;
  },
  updateTeacher: async (id: number, payload: {
    name?: string;
    email?: string;
    nip?: string;
    nuptk?: string;
    gender?: string;
    phone?: string;
    address?: string;
    subject_ids?: number[];
    is_walas?: boolean;
    is_mentor?: boolean;
  }): Promise<any> => {
    const res = await api.put(`/admin/teachers/${id}`, payload);
    return res.data.data;
  },
  deleteTeacher: async (id: number): Promise<void> => {
    await api.delete(`/admin/teachers/${id}`);
  },

  // Students
  getStudents: async (params?: { search?: string; classroom_id?: number; status?: string }): Promise<StudentItem[]> => {
    const res = await api.get('/admin/students', { params });
    return res.data.data;
  },
  createStudent: async (payload: {
    name: string;
    nis: string;
    nisn?: string;
    gender: 'L' | 'P';
    classroom_id?: number | null;
    phone?: string;
    address?: string;
    parent_name?: string;
    parent_phone?: string;
    status?: string;
    email?: string;
    password?: string;
  }): Promise<any> => {
    const res = await api.post('/admin/students', payload);
    return res.data.data;
  },
  updateStudent: async (id: number, payload: {
    name: string;
    nis: string;
    nisn?: string;
    gender: 'L' | 'P';
    classroom_id?: number | null;
    phone?: string;
    address?: string;
    parent_name?: string;
    parent_phone?: string;
    status?: string;
  }): Promise<any> => {
    const res = await api.put(`/admin/students/${id}`, payload);
    return res.data.data;
  },
  deleteStudent: async (id: number): Promise<void> => {
    await api.delete(`/admin/students/${id}`);
  },

  // Classrooms
  getClassrooms: async (params?: { academic_year_id?: number; grade_level?: number }): Promise<ClassroomItem[]> => {
    const res = await api.get('/admin/classrooms', { params });
    return res.data.data;
  },
  createClassroom: async (payload: {
    name: string;
    grade_level: number;
    major: string;
    academic_year_id?: number | null;
    teacher_id?: number | null;
  }): Promise<ClassroomItem> => {
    const res = await api.post('/admin/classrooms', payload);
    return res.data.data;
  },
  updateClassroom: async (id: number, payload: {
    name: string;
    grade_level: number;
    major: string;
    academic_year_id?: number | null;
    teacher_id?: number | null;
  }): Promise<any> => {
    const res = await api.put(`/admin/classrooms/${id}`, payload);
    return res.data.data;
  },
  deleteClassroom: async (id: number): Promise<void> => {
    await api.delete(`/admin/classrooms/${id}`);
  },

  // Academic Years
  getAcademicYears: async (): Promise<AcademicYearItem[]> => {
    const res = await api.get('/admin/academic-years');
    return res.data.data;
  },
  createAcademicYear: async (payload: {
    name: string;
    semester: 'ganjil' | 'genap';
    start_date: string;
    end_date: string;
    is_active?: boolean;
  }): Promise<AcademicYearItem> => {
    const res = await api.post('/admin/academic-years', payload);
    return res.data.data;
  },
  setActiveAcademicYear: async (id: number): Promise<void> => {
    await api.post(`/admin/academic-years/${id}/set-active`);
  },
  updateAcademicYear: async (
    id: number,
    payload: {
      name: string;
      semester: 'ganjil' | 'genap';
      start_date: string;
      end_date: string;
      is_active?: boolean;
    }
  ): Promise<AcademicYearItem> => {
    const res = await api.put(`/admin/academic-years/${id}`, payload);
    return res.data.data;
  },
  deleteAcademicYear: async (id: number): Promise<void> => {
    await api.delete(`/admin/academic-years/${id}`);
  },

  // Subjects
  getSubjects: async (): Promise<SubjectItem[]> => {
    const res = await api.get('/admin/subjects');
    return res.data.data;
  },
  createSubject: async (payload: {
    code: string;
    name: string;
    description?: string;
    teacher_ids?: number[];
  }): Promise<SubjectItem> => {
    const res = await api.post('/admin/subjects', payload);
    return res.data.data;
  },
  updateSubject: async (
    id: number,
    payload: {
      code: string;
      name: string;
      description?: string;
      teacher_ids?: number[];
    }
  ): Promise<SubjectItem> => {
    const res = await api.put(`/admin/subjects/${id}`, payload);
    return res.data.data;
  },
  deleteSubject: async (id: number): Promise<void> => {
    await api.delete(`/admin/subjects/${id}`);
  },

  // Rooms
  getRooms: async (): Promise<RoomItem[]> => {
    const res = await api.get('/admin/rooms');
    return res.data.data;
  },
  createRoom: async (payload: {
    code: string;
    name: string;
    capacity: number;
    description?: string;
  }): Promise<RoomItem> => {
    const res = await api.post('/admin/rooms', payload);
    return res.data.data;
  },
  updateRoom: async (
    id: number,
    payload: {
      code: string;
      name: string;
      capacity: number;
      description?: string;
    }
  ): Promise<RoomItem> => {
    const res = await api.put(`/admin/rooms/${id}`, payload);
    return res.data.data;
  },
  deleteRoom: async (id: number): Promise<void> => {
    await api.delete(`/admin/rooms/${id}`);
  },

  // Companies
  getCompanies: async (params?: { search?: string }): Promise<CompanyItem[]> => {
    const res = await api.get('/admin/companies', { params });
    return res.data.data;
  },
  createCompany: async (payload: {
    name: string;
    address: string;
    contact_person?: string;
    phone?: string;
    email?: string;
    teacher_id?: number | null;
    radius_meters?: number;
  }): Promise<any> => {
    const res = await api.post('/admin/companies', payload);
    return res.data.data;
  },
  updateCompany: async (
    id: number,
    payload: {
      name: string;
      address: string;
      contact_person?: string;
      phone?: string;
      email?: string;
      teacher_id?: number | null;
      radius_meters?: number;
    }
  ): Promise<any> => {
    const res = await api.put(`/admin/companies/${id}`, payload);
    return res.data.data;
  },
  deleteCompany: async (id: number): Promise<void> => {
    await api.delete(`/admin/companies/${id}`);
  },

  // Posts
  getPosts: async (params?: { category?: string; search?: string }): Promise<PostItem[]> => {
    const res = await api.get('/admin/posts', { params });
    return res.data.data;
  },
  createPost: async (payload: {
    title: string;
    category: 'berita' | 'pengumuman' | 'agenda';
    excerpt?: string;
    content: string;
    is_published?: boolean;
    event_date?: string;
    event_time?: string;
    event_location?: string;
  }): Promise<any> => {
    const res = await api.post('/admin/posts', payload);
    return res.data.data;
  },
  updatePost: async (
    id: number,
    payload: {
      title: string;
      category: 'berita' | 'pengumuman' | 'agenda';
      excerpt?: string;
      content: string;
      is_published?: boolean;
      event_date?: string;
      event_time?: string;
      event_location?: string;
    }
  ): Promise<any> => {
    const res = await api.put(`/admin/posts/${id}`, payload);
    return res.data.data;
  },
  deletePost: async (id: number): Promise<void> => {
    await api.delete(`/admin/posts/${id}`);
  },
};
