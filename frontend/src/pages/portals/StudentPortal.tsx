import React from 'react';
import {
  GraduationCap,
  CheckCircle2,
  Briefcase,
  BookOpen,
  Award,
  MapPin
} from 'lucide-react';
import { User } from '../../types/auth';

interface StudentPortalProps {
  user: User;
}

export const StudentPortal: React.FC<StudentPortalProps> = ({ user }) => {
  return (
    <div className="space-y-8">
      {/* Student Welcome Hero Banner matching Blade Reference */}
      <div className="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#171B61] via-[#1D2275] to-[#233DFF] text-white p-6 sm:p-8 shadow-xl shadow-indigo-950/20 border border-indigo-500/20">
        <div className="absolute -right-12 -top-12 w-64 h-64 rounded-full bg-blue-500/10 blur-3xl pointer-events-none" />
        <div className="absolute right-1/4 -bottom-12 w-48 h-48 rounded-full bg-indigo-400/10 blur-2xl pointer-events-none" />

        <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div className="space-y-2">
            <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-[11px] font-bold text-amber-300">
              <GraduationCap className="w-3.5 h-3.5" />
              <span>Peserta Didik Aktif</span>
              <span>&bull;</span>
              <span>{user.student?.classroom_name || 'XII RPL 1'}</span>
            </div>
            <h1 className="text-2xl sm:text-3xl font-black tracking-tight text-white drop-shadow-xs">
              Halo, {user.name}!
            </h1>
            <p className="text-xs sm:text-sm text-indigo-100/90 max-w-xl font-medium leading-relaxed">
              Selamat datang di portal akademik siswa. Pantau jadwal mata pelajaran harian, statistik presensi kehadiran, dan informasi penempatan PKL Anda di sini.
            </p>
            <div className="flex flex-wrap items-center gap-3 pt-2 text-xs text-indigo-200">
              <span className="inline-flex items-center gap-1 font-mono">
                <strong className="text-white">NISN:</strong> {user.student?.nisn || '0051234567'}
              </span>
              <span>&bull;</span>
              <span className="inline-flex items-center gap-1 font-mono">
                <strong className="text-white">NIS:</strong> {user.student?.nis || '2023101'}
              </span>
              <span>&bull;</span>
              <span className="inline-flex items-center gap-1">
                <strong className="text-white">Semester:</strong> Ganjil 2026/2027
              </span>
            </div>
          </div>

          {/* Quick Action Badges */}
          <div className="flex flex-col gap-2 shrink-0">
            <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-center">
              <span className="text-2xl font-black text-[#F4CF52] block">98.5%</span>
              <span className="text-[10px] text-indigo-200 uppercase font-bold tracking-wider">
                Kehadiran Semester Ini
              </span>
            </div>
          </div>
        </div>
      </div>

      {/* 4 Key Stat Cards */}
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div className="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-xs flex items-center gap-4">
          <div className="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
            <CheckCircle2 className="w-6 h-6" />
          </div>
          <div>
            <span className="text-xs font-bold text-slate-400 uppercase tracking-wider block">Presensi</span>
            <span className="text-lg font-black text-slate-800">Hadir Tepat</span>
          </div>
        </div>

        <div className="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-xs flex items-center gap-4">
          <div className="w-12 h-12 rounded-2xl bg-blue-50 text-[#233DFF] flex items-center justify-center shrink-0">
            <Briefcase className="w-6 h-6" />
          </div>
          <div>
            <span className="text-xs font-bold text-slate-400 uppercase tracking-wider block">Status PKL</span>
            <span className="text-lg font-black text-slate-800">Ditempatkan</span>
          </div>
        </div>

        <div className="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-xs flex items-center gap-4">
          <div className="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
            <BookOpen className="w-6 h-6" />
          </div>
          <div>
            <span className="text-xs font-bold text-slate-400 uppercase tracking-wider block">Tugas Aktif</span>
            <span className="text-lg font-black text-slate-800">2 Tugas</span>
          </div>
        </div>

        <div className="bg-white rounded-3xl border border-slate-200/90 p-5 shadow-xs flex items-center gap-4">
          <div className="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
            <Award className="w-6 h-6" />
          </div>
          <div>
            <span className="text-xs font-bold text-slate-400 uppercase tracking-wider block">Peringkat</span>
            <span className="text-lg font-black text-slate-800">Top 5 Kelas</span>
          </div>
        </div>
      </div>

      {/* Internship Placement Card for Student */}
      <div className="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-4">
        <div className="flex items-center justify-between pb-4 border-b border-slate-100">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
              <Briefcase className="w-5 h-5" />
            </div>
            <div>
              <h3 className="text-base font-extrabold text-[#171B61]">Informasi Penempatan Magang PKL</h3>
              <p className="text-xs text-slate-400">Status verifikasi kemitraan industri</p>
            </div>
          </div>
          <span className="text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
            Aktif Berjalan
          </span>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2 text-xs">
          <div>
            <span className="text-slate-400 font-semibold block uppercase tracking-wider text-[10px]">
              Perusahaan Mitra DUDI
            </span>
            <p className="font-bold text-slate-800 text-sm mt-1">PT Telkom Indonesia (Witel Digital)</p>
            <p className="text-slate-500 mt-0.5 flex items-center gap-1">
              <MapPin className="w-3.5 h-3.5 text-slate-400" />
              <span>Gedung Graha Merah Putih, Lt. 4</span>
            </p>
          </div>

          <div>
            <span className="text-slate-400 font-semibold block uppercase tracking-wider text-[10px]">
              Guru Pembimbing Sekolah
            </span>
            <p className="font-bold text-slate-800 text-sm mt-1">Drs. Bambang Sudiro, M.Pd</p>
            <p className="text-slate-500 mt-0.5">NIP: 197805122005011003</p>
          </div>

          <div>
            <span className="text-slate-400 font-semibold block uppercase tracking-wider text-[10px]">
              Jurnal Magang
            </span>
            <p className="font-bold text-[#233DFF] text-sm mt-1">18 Jurnal Terkirim</p>
            <p className="text-slate-500 mt-0.5">Semua telah disetujui pembimbing</p>
          </div>
        </div>
      </div>
    </div>
  );
};
