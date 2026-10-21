import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import {
  GraduationCap,
  Users,
  Building2,
  Sparkles,
  ArrowRight,
  BookOpen,
  Briefcase,
  QrCode,
  Newspaper,
  Bell
} from 'lucide-react';
import { schoolService } from '../api/schoolService';
import { SchoolProfile, Post } from '../types/school';
import { Button } from '../components/common/Button';

export const LandingPage: React.FC = () => {
  const [profile, setProfile] = useState<SchoolProfile | null>(null);
  const [news, setNews] = useState<Post[]>([]);
  const [announcements, setAnnouncements] = useState<Post[]>([]);
  const [isLoading, setIsLoading] = useState<boolean>(true);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const [profileData, newsData, annData] = await Promise.all([
          schoolService.getSchoolProfile().catch(() => null),
          schoolService.getNews().catch(() => []),
          schoolService.getAnnouncements().catch(() => []),
        ]);
        setProfile(profileData);
        setNews(newsData.slice(0, 3));
        setAnnouncements(annData.slice(0, 3));
      } finally {
        setIsLoading(false);
      }
    };

    fetchData();
  }, []);

  return (
    <div className="space-y-16 pb-16">
      {/* Hero Section */}
      <section className="relative overflow-hidden bg-gradient-to-b from-indigo-900 via-brand-900 to-slate-900 text-white py-20 lg:py-28">
        <div className="absolute inset-0 bg-[radial-gradient(#6366f1_1px,transparent_1px)] [background-size:24px_24px] opacity-20 pointer-events-none" />
        
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
          <div className="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-medium text-brand-200 mb-6">
            <Sparkles className="w-4 h-4 text-brand-300" />
            <span>Platform Terpadu Sekolah & PKL Berbasis React + Laravel</span>
          </div>

          <h1 className="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight max-w-4xl mx-auto leading-tight">
            Digitalisasi Pendidikan & Manajemen PKL Modern
          </h1>

          <p className="mt-5 text-base sm:text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed">
            Satu ekosistem terpadu untuk absensi pintar, administrasi akademik sekolah, penempatan Praktik Kerja Lapangan (PKL), hingga pemantauan jurnal industri.
          </p>

          <div className="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
            <Link to="/login">
              <Button size="lg" className="w-full sm:w-auto shadow-lg shadow-brand-500/30 space-x-2">
                <span>Masuk ke Portal</span>
                <ArrowRight className="w-4 h-4" />
              </Button>
            </Link>
            <Link to="/news">
              <Button variant="secondary" size="lg" className="w-full sm:w-auto bg-white/10 text-white hover:bg-white/20 border-white/10">
                <Newspaper className="w-4 h-4 mr-2" />
                <span>Lihat Berita Sekolah</span>
              </Button>
            </Link>
          </div>
        </div>
      </section>

      {/* Live Statistics Bento Grid (Real-time from Laravel API) */}
      <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-20">
        <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
          <div className="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-md">
            <div className="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center mb-3">
              <Users className="w-5 h-5" />
            </div>
            <p className="text-2xl font-extrabold text-slate-800">
              {isLoading ? '...' : (profile?.statistics.total_students ?? '500+')}
            </p>
            <p className="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-1">Siswa Terdaftar</p>
          </div>

          <div className="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-md">
            <div className="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
              <GraduationCap className="w-5 h-5" />
            </div>
            <p className="text-2xl font-extrabold text-slate-800">
              {isLoading ? '...' : (profile?.statistics.total_teachers ?? '40+')}
            </p>
            <p className="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-1">Tenaga Pengajar</p>
          </div>

          <div className="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-md">
            <div className="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-3">
              <BookOpen className="w-5 h-5" />
            </div>
            <p className="text-2xl font-extrabold text-slate-800">
              {isLoading ? '...' : (profile?.statistics.total_classrooms ?? '18')}
            </p>
            <p className="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-1">Rombongan Belajar</p>
          </div>

          <div className="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-md">
            <div className="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
              <Building2 className="w-5 h-5" />
            </div>
            <p className="text-2xl font-extrabold text-slate-800">
              {isLoading ? '...' : (profile?.statistics.total_companies ?? '25+')}
            </p>
            <p className="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-1">Mitra DUDI / PKL</p>
          </div>
        </div>
      </section>

      {/* Announcements Banner if any */}
      {announcements.length > 0 && (
        <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="bg-amber-50/80 border border-amber-200 rounded-2xl p-4 flex items-center justify-between gap-4">
            <div className="flex items-center gap-3">
              <div className="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                <Bell className="w-4 h-4" />
              </div>
              <div>
                <span className="text-[10px] font-bold uppercase tracking-wider text-amber-700">Pengumuman Penting</span>
                <p className="text-xs font-semibold text-slate-800">{announcements[0].title}</p>
              </div>
            </div>
            <Link to="/news" className="text-xs font-bold text-amber-700 hover:text-amber-800 shrink-0">
              Lihat Rincian &rarr;
            </Link>
          </div>
        </section>
      )}

      {/* Core Features */}
      <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center max-w-2xl mx-auto mb-12">
          <h2 className="text-xs font-bold text-brand-600 uppercase tracking-widest">Fitur Unggulan</h2>
          <p className="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">
            Solusi Menyeluruh untuk Sekolah Kejuruan & Menengah
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div className="p-6 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div className="w-12 h-12 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center mb-4">
              <QrCode className="w-6 h-6" />
            </div>
            <h3 className="text-base font-bold text-slate-800">Presensi Cerdas & Geofence</h3>
            <p className="text-xs text-slate-600 mt-2 leading-relaxed">
              Presensi kehadiran harian siswa dan guru berbasis scan QR dinamis serta validasi radius lokasi radius map geofence.
            </p>
          </div>

          <div className="p-6 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div className="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4">
              <Briefcase className="w-6 h-6" />
            </div>
            <h3 className="text-base font-bold text-slate-800">Manajemen PKL & DUDI</h3>
            <p className="text-xs text-slate-600 mt-2 leading-relaxed">
              Penempatan siswa magang, monitoring guru pembimbing sekolah, review jurnal kegiatan harian, dan penilaian langsung oleh mentor industri.
            </p>
          </div>

          <div className="p-6 rounded-2xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition">
            <div className="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center mb-4">
              <Users className="w-6 h-6" />
            </div>
            <h3 className="text-base font-bold text-slate-800">Akses Multi-Peran Terpadu</h3>
            <p className="text-xs text-slate-600 mt-2 leading-relaxed">
              Satu login untuk Administrator, Guru Pengajar, Wali Kelas, Guru Pembimbing PKL, Pembimbing DUDI, hingga Siswa.
            </p>
          </div>
        </div>
      </section>

      {/* Latest News & Announcements from API */}
      <section className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between mb-8">
          <div>
            <h2 className="text-xl sm:text-2xl font-bold text-slate-900">Kabar & Pengumuman Terbaru</h2>
            <p className="text-xs text-slate-500 mt-1">Informasi aktual yang disinkronkan langsung dari server</p>
          </div>
          <Link to="/news" className="text-xs font-semibold text-brand-600 hover:text-brand-700 flex items-center space-x-1">
            <span>Lihat Semua</span>
            <ArrowRight className="w-3.5 h-3.5" />
          </Link>
        </div>

        {news.length === 0 && !isLoading ? (
          <div className="bg-white rounded-2xl border border-dashed border-slate-200 p-8 text-center text-slate-500 text-xs">
            Belum ada berita yang dipublikasikan saat ini.
          </div>
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {news.map((item) => (
              <article key={item.id} className="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm flex flex-col hover:shadow-md transition">
                {item.image_url ? (
                  <img src={item.image_url} alt={item.title} className="w-full h-44 object-cover" />
                ) : (
                  <div className="w-full h-44 bg-slate-100 flex items-center justify-center text-slate-400">
                    <Newspaper className="w-10 h-10 opacity-40" />
                  </div>
                )}
                <div className="p-5 flex-1 flex flex-col justify-between">
                  <div>
                    <span className="text-[10px] font-bold uppercase tracking-wider text-brand-600 bg-brand-50 px-2 py-0.5 rounded-full">
                      {item.type}
                    </span>
                    <h3 className="text-sm font-bold text-slate-800 mt-2.5 line-clamp-2 leading-snug">
                      {item.title}
                    </h3>
                    <p className="text-xs text-slate-500 mt-2 line-clamp-3 leading-relaxed">
                      {item.excerpt || item.content.slice(0, 100) + '...'}
                    </p>
                  </div>
                  <div className="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                    <span>Oleh: {item.author.name}</span>
                    <span>{new Date(item.published_at).toLocaleDateString('id-ID')}</span>
                  </div>
                </div>
              </article>
            ))}
          </div>
        )}
      </section>
    </div>
  );
};
