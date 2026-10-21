import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import {
  GraduationCap,
  Users,
  Building2,
  BookOpen,
  ArrowRight,
  CheckCircle2,
  Calendar,
  User,
  Bell
} from 'lucide-react';
import { schoolService } from '../api/schoolService';
import { SchoolProfile, Post } from '../types/school';
import { useAuth } from '../context/AuthContext';

export const LandingPage: React.FC = () => {
  const [profile, setProfile] = useState<SchoolProfile | null>(null);
  const [news, setNews] = useState<Post[]>([]);
  const [announcements, setAnnouncements] = useState<Post[]>([]);
  const [isLoading, setIsLoading] = useState<boolean>(true);
  const { isAuthenticated } = useAuth();

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
    <div className="space-y-0 pb-0">
      {/* Hero Section (Following Blade Reference) */}
      <section className="relative bg-gradient-to-b from-[#F0F4FA] via-[#F8FAFD] to-[#FFFFFF] pt-12 pb-20 lg:pt-20 lg:pb-32 border-b border-slate-200/80 overflow-hidden">
        {/* Subtle Vector Wave & Decorative Background Shapes */}
        <svg
          className="absolute top-0 right-0 w-1/2 h-full opacity-35 pointer-events-none text-indigo-300"
          viewBox="0 0 500 500"
          fill="none"
          preserveAspectRatio="none"
        >
          <path
            d="M50 0 C150 120 50 250 200 350 C300 420 400 480 500 500 L500 0 Z"
            stroke="currentColor"
            strokeWidth="1.2"
            strokeDasharray="3 3"
          />
          <path
            d="M120 0 C220 150 140 280 280 390 C360 450 440 480 500 500"
            stroke="currentColor"
            strokeWidth="1"
          />
        </svg>

        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
          <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            {/* Hero Left: Typography & Dual CTAs */}
            <div className="lg:col-span-6 space-y-6 text-center lg:text-left">
              <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-[11px] font-extrabold uppercase tracking-widest text-[#233DFF] bg-[#E5ECFF] border border-blue-200/80 shadow-xs">
                <span className="w-2 h-2 rounded-full bg-[#233DFF] animate-pulse" />
                <span>Portal Resmi Sistem Informasi Satu-Sekolah</span>
              </div>

              <h1 className="text-4xl sm:text-6xl lg:text-[58px] font-normal text-[#20211F] tracking-tight leading-[1.12]">
                Wujudkan <span className="font-extrabold text-[#171B61]">Masa Depan</span>
                <br />
                <span className="font-extrabold text-[#233DFF]">Generasi Unggul</span> Berkarakter
              </h1>

              <p className="text-base sm:text-lg text-[#707581] leading-relaxed max-w-xl mx-auto lg:mx-0 font-normal">
                Platform pendidikan terpadu satu pintu untuk pembelajaran vokasi modern, presensi digital presisi, transparansi nilai, serta sistem pemantauan Praktik Kerja Lapangan (PKL) presisi tinggi berbasis GPS.
              </p>

              {/* CTAs: Warm Yellow Button + Circular Play Action */}
              <div className="flex flex-wrap items-center justify-center lg:justify-start gap-5 pt-3">
                {isAuthenticated ? (
                  <Link
                    to="/dashboard"
                    className="px-8 py-4 rounded-full font-extrabold text-sm text-[#171B61] bg-[#F4CF52] hover:bg-[#e5be42] shadow-md shadow-amber-300/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-150 cursor-pointer"
                  >
                    Ke Dashboard
                  </Link>
                ) : (
                  <Link
                    to="/login"
                    className="px-8 py-4 rounded-full font-extrabold text-sm text-[#171B61] bg-[#F4CF52] hover:bg-[#e5be42] shadow-md shadow-amber-300/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-150 cursor-pointer"
                  >
                    Masuk Portal Guru &amp; Admin
                  </Link>
                )}

                <Link
                  to="/about"
                  className="inline-flex items-center gap-3 text-xs sm:text-sm font-extrabold uppercase tracking-wider text-[#171B61] hover:text-[#233DFF] group transition-colors cursor-pointer"
                >
                  <span className="w-11 h-11 rounded-full bg-[#233DFF] text-white flex items-center justify-center shadow-md shadow-indigo-600/30 group-hover:scale-110 transition-transform duration-200">
                    <svg className="w-4 h-4 translate-x-0.5" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M8 5v14l11-7z" />
                    </svg>
                  </span>
                  <span className="underline decoration-2 underline-offset-4">LIHAT PROFIL SEKOLAH</span>
                </Link>
              </div>

              {/* Trust Indicators */}
              <div className="pt-6 flex flex-wrap items-center justify-center lg:justify-start gap-6 text-xs text-[#707581] font-semibold border-t border-slate-200/80">
                <div className="flex items-center gap-2">
                  <CheckCircle2 className="w-4 h-4 text-emerald-600" />
                  <span>Terakreditasi A BAN-S/M</span>
                </div>
                <div className="flex items-center gap-2">
                  <CheckCircle2 className="w-4 h-4 text-[#233DFF]" />
                  <span>Kemitraan Industri DUDI Aktif</span>
                </div>
                <div className="flex items-center gap-2">
                  <CheckCircle2 className="w-4 h-4 text-amber-500" />
                  <span>Geofencing Presensi PKL</span>
                </div>
              </div>
            </div>

            {/* Hero Right: Asymmetrical Collage */}
            <div className="lg:col-span-6 relative">
              {/* Decorative Graphic Shapes */}
              <div className="absolute -top-6 right-8 w-32 h-32 rounded-full bg-[#F4CF52] -z-10" />
              <div className="absolute bottom-6 -left-6 w-10 h-10 rounded-full bg-[#233DFF]/20 -z-10" />
              <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-[#ECEBFA] -z-10" />

              {/* 4-Piece Asymmetrical Image Collage */}
              <div className="grid grid-cols-2 gap-4 max-w-lg mx-auto relative z-10">
                {/* Top Left: Circular Frame */}
                <div className="flex justify-end items-end p-2">
                  <div className="w-44 h-44 sm:w-52 sm:h-52 rounded-full overflow-hidden border-4 border-white shadow-xl shadow-indigo-950/10 relative group bg-gradient-to-tr from-indigo-100 to-blue-50">
                    <img
                      src="https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=600&q=80"
                      alt="Siswa Berprestasi"
                      className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    />
                  </div>
                </div>

                {/* Top Right: Rounded Rectangle with Yellow Accent */}
                <div className="flex justify-start items-end p-2">
                  <div className="w-44 h-52 sm:w-52 sm:h-60 rounded-3xl overflow-hidden border-4 border-white shadow-xl shadow-indigo-950/10 relative group bg-gradient-to-br from-amber-50 to-indigo-50">
                    <img
                      src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=600&q=80"
                      alt="Aktivitas Belajar"
                      className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    />
                  </div>
                </div>

                {/* Bottom Left: Rounded Square */}
                <div className="flex justify-end items-start p-2">
                  <div className="w-44 h-52 sm:w-52 sm:h-56 rounded-3xl overflow-hidden border-4 border-white shadow-xl shadow-indigo-950/10 relative group bg-gradient-to-tr from-purple-50 to-indigo-50">
                    <img
                      src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=600&q=80"
                      alt="Kerja Sama Tim Siswa"
                      className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    />
                  </div>
                </div>

                {/* Bottom Right: Pill-Curved Card */}
                <div className="flex justify-start items-start p-2">
                  <div className="w-44 h-48 sm:w-52 sm:h-52 rounded-t-[50px] rounded-b-3xl overflow-hidden border-4 border-white shadow-xl shadow-indigo-950/10 relative group bg-gradient-to-br from-emerald-50 to-blue-50">
                    <img
                      src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=600&q=80"
                      alt="Praktik Kerja Lapangan"
                      className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Institutional Statistics & Bento Metrics Showcase */}
      <section className="py-16 sm:py-24 bg-[#F4F6FB] border-b border-slate-200/80 relative overflow-hidden">
        {/* Subtle Glow & Accents */}
        <div className="absolute -top-32 right-10 w-96 h-96 bg-blue-200/30 rounded-full blur-3xl pointer-events-none" />
        <div className="absolute -bottom-32 left-10 w-96 h-96 bg-amber-100/40 rounded-full blur-3xl pointer-events-none" />

        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
          {/* Section Header */}
          <div className="flex flex-col md:flex-row md:items-end justify-between mb-12 sm:mb-16 gap-6">
            <div className="max-w-2xl">
              <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-widest text-[#233DFF] bg-[#E5ECFF] border border-blue-200/80 mb-3">
                <span className="w-2 h-2 rounded-full bg-[#233DFF]" />
                <span>STATISTIK &amp; KINERJA SATU-SEKOLAH</span>
              </div>
              <h2 className="text-3xl sm:text-4xl lg:text-[42px] font-normal text-[#20211F] tracking-tight leading-tight">
                Pencapaian Nyata &amp; <span className="font-black text-[#171B61]">Standar Mutu Vokasi</span>
              </h2>
              <p className="text-sm sm:text-base text-[#707581] mt-3 leading-relaxed">
                Data riil terintegrasi dari sistem manajemen akademik, kehadiran digital, dan monitoring kemitraan industri Praktik Kerja Lapangan (PKL) Satu-Sekolah.
              </p>
            </div>

            <div className="flex items-center gap-3">
              <span className="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white border border-slate-200/80 shadow-xs text-xs font-bold text-slate-700">
                <span className="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse" />
                Data Terverifikasi Real-Time
              </span>
            </div>
          </div>

          {/* Bento Grid 4-Card Layout */}
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-6">
            {/* Card 1: Featured Indigo Card (Students) */}
            <div className="lg:col-span-4 rounded-3xl bg-[#171B61] text-white p-8 relative overflow-hidden shadow-xl shadow-indigo-950/20 flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300">
              <div className="absolute -right-6 -bottom-6 w-40 h-40 bg-white/5 rounded-full blur-xl pointer-events-none" />
              <div className="space-y-4 relative z-10">
                <div className="flex items-center justify-between">
                  <span className="px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-white/10 text-[#F4CF52] border border-white/15">
                    Siswa Vokasi
                  </span>
                  <div className="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center text-[#F4CF52]">
                    <Users className="w-5 h-5" />
                  </div>
                </div>

                <div>
                  <span className="text-4xl sm:text-5xl font-black text-white tracking-tight block">
                    {isLoading ? '...' : (profile?.statistics.total_students ?? 850)}+
                  </span>
                  <h3 className="text-lg font-bold text-slate-100 mt-1">Peserta Didik Aktif</h3>
                  <p className="text-xs text-indigo-200 mt-2 leading-relaxed">
                    Tersebar di jurusan unggulan RPL &amp; TKJ dengan pembinaan kurikulum link-and-match dan sertifikasi keahlian.
                  </p>
                </div>
              </div>

              <div className="pt-6 mt-6 border-t border-white/10 flex items-center justify-between text-xs text-indigo-200 relative z-10">
                <span>Konsentrasi: RPL &amp; TKJ</span>
                <span className="font-bold text-[#F4CF52]">100% Aktif Belajar</span>
              </div>
            </div>

            {/* Card 2: White Surface Card (Teachers) */}
            <div className="lg:col-span-4 rounded-3xl bg-white border border-slate-200/90 p-8 shadow-xs hover:shadow-card hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
              <div className="space-y-4">
                <div className="flex items-center justify-between">
                  <span className="px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-blue-50 text-[#233DFF] border border-blue-100">
                    Tenaga Pendidik
                  </span>
                  <div className="w-10 h-10 rounded-2xl bg-[#E5ECFF] flex items-center justify-center text-[#233DFF]">
                    <GraduationCap className="w-5 h-5" />
                  </div>
                </div>

                <div>
                  <span className="text-4xl sm:text-5xl font-black text-[#171B61] tracking-tight block">
                    {isLoading ? '...' : (profile?.statistics.total_teachers ?? 48)}+
                  </span>
                  <h3 className="text-lg font-bold text-[#171B61] mt-1">Guru &amp; Instruktur Ahli</h3>
                  <p className="text-xs text-[#707581] mt-2 leading-relaxed">
                    Tenaga pendidik bergelar sarjana/magister serta instruktur tamu dari kalangan praktisi industri digital.
                  </p>
                </div>
              </div>

              <div className="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Sertifikasi Pendidik</span>
                <span className="font-bold text-[#233DFF]">100% Terakreditasi</span>
              </div>
            </div>

            {/* Card 3: White Surface Card (Industry Partners) */}
            <div className="lg:col-span-4 rounded-3xl bg-white border border-slate-200/90 p-8 shadow-xs hover:shadow-card hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
              <div className="space-y-4">
                <div className="flex items-center justify-between">
                  <span className="px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-100">
                    Kemitraan DUDI
                  </span>
                  <div className="w-10 h-10 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <Building2 className="w-5 h-5" />
                  </div>
                </div>

                <div>
                  <span className="text-4xl sm:text-5xl font-black text-[#171B61] tracking-tight block">
                    {isLoading ? '...' : (profile?.statistics.total_companies ?? 35)}+
                  </span>
                  <h3 className="text-lg font-bold text-[#171B61] mt-1">Mitra Industri Aktif</h3>
                  <p className="text-xs text-[#707581] mt-2 leading-relaxed">
                    Perusahaan mitra resmi penempatan magang PKL, uji sertifikasi kompetensi, dan rekrutmen kerja langsung.
                  </p>
                </div>
              </div>

              <div className="pt-6 mt-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Penempatan PKL</span>
                <span className="font-bold text-emerald-600">100% Terfasilitasi</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Announcements Banner if any */}
      {announcements.length > 0 && (
        <section className="py-8 bg-white border-b border-slate-200/80">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="bg-[#ECEBFA] border border-indigo-200/80 rounded-3xl p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
              <div className="flex items-center gap-4">
                <div className="w-10 h-10 rounded-2xl bg-[#233DFF] text-white flex items-center justify-center shrink-0 shadow-md shadow-indigo-600/20">
                  <Bell className="w-5 h-5" />
                </div>
                <div>
                  <span className="text-[10px] font-extrabold uppercase tracking-wider text-[#233DFF] bg-white px-2 py-0.5 rounded-full border border-indigo-100">
                    Pengumuman Resmi
                  </span>
                  <h4 className="text-sm font-bold text-[#171B61] mt-1">{announcements[0].title}</h4>
                </div>
              </div>
              <Link
                to="/news"
                className="inline-flex items-center gap-1.5 px-5 py-2 rounded-full text-xs font-bold text-white bg-[#171B61] hover:bg-[#233DFF] transition shrink-0"
              >
                <span>Baca Selengkapnya</span>
                <ArrowRight className="w-3.5 h-3.5" />
              </Link>
            </div>
          </div>
        </section>
      )}

      {/* Latest News & Articles */}
      <section className="py-16 sm:py-24 bg-[#F4F6FB] relative">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4">
            <div>
              <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-widest text-[#233DFF] bg-[#E5ECFF] border border-blue-200/80 mb-3">
                <span className="w-2 h-2 rounded-full bg-[#233DFF]" />
                <span>WARTA &amp; INFORMASI TERKINI</span>
              </div>
              <h2 className="text-3xl sm:text-4xl font-normal text-[#20211F] tracking-tight">
                Kabar Terbaru <span className="font-black text-[#171B61]">Satu-Sekolah</span>
              </h2>
            </div>
            <Link
              to="/news"
              className="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-[#233DFF] hover:text-[#171B61] transition"
            >
              <span>Lihat Semua Berita</span>
              <ArrowRight className="w-4 h-4" />
            </Link>
          </div>

          {news.length === 0 && !isLoading ? (
            <div className="bg-white rounded-3xl border border-dashed border-slate-200 p-12 text-center text-slate-500 text-xs">
              Belum ada berita yang dipublikasikan saat ini.
            </div>
          ) : (
            <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
              {news.map((item) => (
                <article
                  key={item.id}
                  className="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-card hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group"
                >
                  <div>
                    {item.image_url ? (
                      <div className="w-full h-48 overflow-hidden bg-slate-100">
                        <img
                          src={item.image_url}
                          alt={item.title}
                          className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        />
                      </div>
                    ) : (
                      <div className="w-full h-48 bg-gradient-to-tr from-[#171B61] to-[#233DFF] flex items-center justify-center text-white/50">
                        <BookOpen className="w-12 h-12" />
                      </div>
                    )}
                    <div className="p-6">
                      <div className="flex items-center gap-2 mb-3">
                        <span className="text-[10px] font-extrabold uppercase tracking-wider text-[#233DFF] bg-[#E5ECFF] px-2.5 py-0.5 rounded-full">
                          {item.type}
                        </span>
                        <span className="text-[11px] text-[#707581] flex items-center gap-1 font-medium">
                          <Calendar className="w-3 h-3 text-slate-400" />
                          {new Date(item.published_at).toLocaleDateString('id-ID')}
                        </span>
                      </div>
                      <h3 className="text-base font-bold text-[#171B61] group-hover:text-[#233DFF] transition-colors leading-snug line-clamp-2">
                        {item.title}
                      </h3>
                      <p className="text-xs text-[#707581] mt-2.5 line-clamp-3 leading-relaxed">
                        {item.excerpt || item.content}
                      </p>
                    </div>
                  </div>

                  <div className="px-6 py-4 border-t border-slate-100 flex items-center justify-between text-xs text-[#707581]">
                    <span className="flex items-center gap-1 font-medium">
                      <User className="w-3.5 h-3.5 text-slate-400" />
                      {item.author.name}
                    </span>
                    <Link
                      to="/news"
                      className="font-bold text-[#233DFF] hover:underline flex items-center gap-1"
                    >
                      Baca &rarr;
                    </Link>
                  </div>
                </article>
              ))}
            </div>
          )}
        </div>
      </section>
    </div>
  );
};
