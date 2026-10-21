export interface Post {
  id: number;
  title: string;
  slug: string;
  content: string;
  excerpt: string;
  type: 'news' | 'announcement' | 'event';
  status: 'published' | 'draft';
  published_at: string;
  image_url: string | null;
  author: {
    id: number;
    name: string;
  };
  event_date?: string | null;
  event_location?: string | null;
}

export interface SchoolProfile {
  school_name: string;
  app_version: string;
  academic_year: {
    id: number;
    name: string;
    semester: string;
  } | null;
  statistics: {
    total_students: number;
    total_teachers: number;
    total_classrooms: number;
    total_companies: number;
  };
}
