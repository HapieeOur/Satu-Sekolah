import React from 'react';
import {
  Users,
  GraduationCap,
  Building2,
  BookOpen,
  ExternalLink,
  ShieldCheck,
  CheckCircle2,
  MapPin,
  Clock
} from 'lucide-react';
import { SchoolProfile } from '../../types/school';

interface AdminPortalProps {
  profile: SchoolProfile | null;
}

export const AdminPortal: React.FC<AdminPortalProps> = ({ profile }) => {
  const stats = profile?.statistics || {
    total_students: 850,
    total_teachers: 48,
    total_classrooms: 18,
    total_companies: 35,
  };

  return (
    <div className="space-y-8">
      {/* Top Class & Metric Row: Ringkasan Operasional matching Blade */}
      <div>
        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
          <div className="flex items-center gap-2">
            <h2 className="text-base font-extrabold text-[#171B61] tracking-tight">
              Ringkasan Operasional Sekolah
            </h2>
            <span className="text-xs font-semibold text-slate-400">
              T.A. {profile?.academic_year?.name ?? '2026/2027'} ({profile?.academic_year?.semester ?? 'Ganjil'})
            </span>
          </div>
          <div className="flex items-center gap-2">
            <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#E5ECFF] text-[#233DFF]">
              <span className="w-2 h-2 rounded-full bg-[#233DFF] animate-pulse" />
              Status Sistem: Operasional Normal
            </span>
          </div>
        </div>

        {/* 4 Deep Indigo Cards matching Blade Reference */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          {/* Card 1: Total Siswa */}
          <div className="rounded-3xl p-5 bg-[#2F3DB6] hover:bg-[#2532A6] text-white shadow-md shadow-indigo-950/10 flex flex-col justify-between transition-all duration-200 group">
            <div className="space-y-3">
              <div className="flex items-start justify-between">
                <span className="text-xs font-bold uppercase tracking-wider text-indigo-200">
                  Total Siswa
                </span>
                <span className="w-2 h-2 rounded-full bg-emerald-400" />
              </div>
              <h3 className="text-3xl font-black tracking-tight group-hover:scale-105 transition-transform">
                {stats.total_students}
              </h3>
              <div className="flex items-center gap-3 text-xs text-indigo-100 font-medium">
                <div className="flex items-center gap-1">
                  <BookOpen className="w-3.5 h-3.5 text-amber-300" />
                  <span>{stats.total_classrooms} Rombel Aktif</span>
                </div>
              </div>
            </div>
            <div className="pt-4 mt-3 border-t border-white/15 flex items-center justify-between text-xs">
              <span className="text-[11px] text-indigo-200 font-semibold">Peserta Didik Aktif</span>
              <span className="text-amber-300 font-bold">100% Terdaftar</span>
            </div>
          </div>

          {/* Card 2: Tenaga Pendidik */}
          <div className="rounded-3xl p-5 bg-[#2F3DB6] hover:bg-[#2532A6] text-white shadow-md shadow-indigo-950/10 flex flex-col justify-between transition-all duration-200 group">
            <div className="space-y-3">
              <div className="flex items-start justify-between">
                <span className="text-xs font-bold uppercase tracking-wider text-indigo-200">
                  Tenaga Pendidik
                </span>
                <span className="w-2 h-2 rounded-full bg-emerald-400" />
              </div>
              <h3 className="text-3xl font-black tracking-tight group-hover:scale-105 transition-transform">
                {stats.total_teachers}
              </h3>
              <div className="flex items-center gap-3 text-xs text-indigo-100 font-medium">
                <div className="flex items-center gap-1">
                  <GraduationCap className="w-3.5 h-3.5 text-blue-200" />
                  <span>Guru &amp; Mentor PKL</span>
                </div>
              </div>
            </div>
            <div className="pt-4 mt-3 border-t border-white/15 flex items-center justify-between text-xs">
              <span className="text-[11px] text-indigo-200 font-semibold">Profil Guru Sinkron</span>
              <span className="text-emerald-300 font-bold">Aktif Mengajar</span>
            </div>
          </div>

          {/* Card 3: Rombongan Belajar */}
          <div className="rounded-3xl p-5 bg-[#2F3DB6] hover:bg-[#2532A6] text-white shadow-md shadow-indigo-950/10 flex flex-col justify-between transition-all duration-200 group">
            <div className="space-y-3">
              <div className="flex items-start justify-between">
                <span className="text-xs font-bold uppercase tracking-wider text-indigo-200">
                  Rombongan Belajar
                </span>
                <span className="w-2 h-2 rounded-full bg-emerald-400" />
              </div>
              <h3 className="text-3xl font-black tracking-tight group-hover:scale-105 transition-transform">
                {stats.total_classrooms}
              </h3>
              <div className="flex items-center gap-3 text-xs text-indigo-100 font-medium">
                <div className="flex items-center gap-1">
                  <Clock className="w-3.5 h-3.5 text-amber-300" />
                  <span>Kelas X, XI, XII</span>
                </div>
              </div>
            </div>
            <div className="pt-4 mt-3 border-t border-white/15 flex items-center justify-between text-xs">
              <span className="text-[11px] text-indigo-200 font-semibold">Wali Kelas Ditetapkan</span>
              <span className="text-amber-300 font-bold">Lengkap</span>
            </div>
          </div>

          {/* Card 4: Mitra DUDI & PKL */}
          <div className="rounded-3xl p-5 bg-[#2F3DB6] hover:bg-[#2532A6] text-white shadow-md shadow-indigo-950/10 flex flex-col justify-between transition-all duration-200 group">
            <div className="space-y-3">
              <div className="flex items-start justify-between">
                <span className="text-xs font-bold uppercase tracking-wider text-indigo-200">
                  Mitra Industri DUDI
                </span>
                <span className="w-2 h-2 rounded-full bg-emerald-400" />
              </div>
              <h3 className="text-3xl font-black tracking-tight group-hover:scale-105 transition-transform">
                {stats.total_companies}
              </h3>
              <div className="flex items-center gap-3 text-xs text-indigo-100 font-medium">
                <div className="flex items-center gap-1">
                  <MapPin className="w-3.5 h-3.5 text-emerald-300" />
                  <span>Radius Map Geofence</span>
                </div>
              </div>
            </div>
            <div className="pt-4 mt-3 border-t border-white/15 flex items-center justify-between text-xs">
              <span className="text-[11px] text-indigo-200 font-semibold">Penempatan Magang</span>
              <span className="text-emerald-300 font-bold">100% Terfasilitasi</span>
            </div>
          </div>
        </div>
      </div>

      {/* Admin Modules Grid */}
      <div>
        <h3 className="text-sm font-extrabold text-[#171B61] tracking-tight mb-4 flex items-center gap-2">
          <ShieldCheck className="w-4 h-4 text-[#233DFF]" />
          <span>Modul Tata Kelola Master Data</span>
        </h3>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          {/* Module 1: Manajemen Pengguna & Guru */}
          <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs hover:shadow-card transition duration-200 space-y-4">
            <div className="w-12 h-12 rounded-2xl bg-[#E5ECFF] text-[#233DFF] flex items-center justify-center">
              <Users className="w-6 h-6" />
            </div>
            <div>
              <h4 className="text-base font-bold text-[#171B61]">Manajemen Pengguna &amp; Guru</h4>
              <p className="text-xs text-slate-500 mt-1 leading-relaxed">
                Pengelolaan akun multi-peran (Admin, Guru, Wali Kelas, Pembimbing PKL) dengan auto-sync profil guru otomatis.
              </p>
            </div>
            <div className="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
              <span className="text-emerald-600 font-bold flex items-center gap-1">
                <CheckCircle2 className="w-3.5 h-3.5" /> Auto-Sync Aktif
              </span>
              <a
                href="https://satu-sekolah-production.up.railway.app/admin/users"
                target="_blank"
                rel="noreferrer"
                className="font-bold text-[#233DFF] hover:underline flex items-center gap-1"
              >
                <span>Kelola</span>
                <ExternalLink className="w-3 h-3" />
              </a>
            </div>
          </div>

          {/* Module 2: Manajemen Kelas & Wali Kelas */}
          <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs hover:shadow-card transition duration-200 space-y-4">
            <div className="w-12 h-12 rounded-2xl bg-[#ECEBFA] text-[#171B61] flex items-center justify-center">
              <BookOpen className="w-6 h-6" />
            </div>
            <div>
              <h4 className="text-base font-bold text-[#171B61]">Rombongan Belajar &amp; Walas</h4>
              <p className="text-xs text-slate-500 mt-1 leading-relaxed">
                Penetapan wali kelas khusus guru ber-role `wali_kelas`, jadwal mata pelajaran, dan penetapan ruang kelas.
              </p>
            </div>
            <div className="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
              <span className="text-indigo-600 font-bold flex items-center gap-1">
                <CheckCircle2 className="w-3.5 h-3.5" /> Strict Filtering
              </span>
              <a
                href="https://satu-sekolah-production.up.railway.app/admin/classrooms"
                target="_blank"
                rel="noreferrer"
                className="font-bold text-[#233DFF] hover:underline flex items-center gap-1"
              >
                <span>Kelola</span>
                <ExternalLink className="w-3 h-3" />
              </a>
            </div>
          </div>

          {/* Module 3: Kemitraan PKL & Pembimbing */}
          <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs hover:shadow-card transition duration-200 space-y-4">
            <div className="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
              <Building2 className="w-6 h-6" />
            </div>
            <div>
              <h4 className="text-base font-bold text-[#171B61]">Mitra DUDI &amp; Penempatan PKL</h4>
              <p className="text-xs text-slate-500 mt-1 leading-relaxed">
                Pencarian map lokasi perusahaan, radius geofence absensi, penetapan guru pembimbing PKL sekolah &amp; mentor industri.
              </p>
            </div>
            <div className="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
              <span className="text-emerald-600 font-bold flex items-center gap-1">
                <CheckCircle2 className="w-3.5 h-3.5" /> Leaflet Map Active
              </span>
              <a
                href="https://satu-sekolah-production.up.railway.app/admin/internship-companies"
                target="_blank"
                rel="noreferrer"
                className="font-bold text-[#233DFF] hover:underline flex items-center gap-1"
              >
                <span>Kelola</span>
                <ExternalLink className="w-3 h-3" />
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
