import React from 'react';
import {
  Calendar,
  CheckCircle2,
  Clock,
  PlusCircle,
  Users,
  Award,
  BookOpen,
} from 'lucide-react';
import { User } from '../../types/auth';

interface TeacherPortalProps {
  user: User;
}

export const TeacherPortal: React.FC<TeacherPortalProps> = ({ user }) => {
  // Mock classrooms taught by this teacher for UI demonstration matching Blade
  const sampleClassrooms = [
    { id: 1, name: 'XII RPL 1', subject: 'Pemrograman Web & Mobile', students: 32, rate: '96%' },
    { id: 2, name: 'XI RPL 2', subject: 'Basis Data & SQL', students: 30, rate: '94%' },
    { id: 3, name: 'X PPLG 1', subject: 'Dasar-Dasar Pemrograman', students: 36, rate: '98%' },
  ];

  return (
    <div className="space-y-8">
      {/* Top Class Row: "Kelas yang Diampu" matching Blade */}
      <div>
        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
          <div className="flex items-center gap-2">
            <h2 className="text-base font-extrabold text-[#171B61] tracking-tight">
              Kelas yang Diampu
            </h2>
            <span className="text-xs font-semibold text-slate-400">
              ({sampleClassrooms.length} Rombel Aktif)
            </span>
          </div>
          <div className="flex items-center gap-2">
            <span className="text-xs font-bold text-[#233DFF] flex items-center gap-1">
              <span>NIP Guru:</span>
              <span className="font-mono bg-blue-50 px-2 py-0.5 rounded text-slate-700">
                {user.teacher?.nip || '198507202010011005'}
              </span>
            </span>
          </div>
        </div>

        {/* Horizontal Carousel of Class Cards (Reference Image A Deep Indigo-Blue Cards) */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
          {sampleClassrooms.map((cls) => (
            <div
              key={cls.id}
              className="rounded-3xl p-6 bg-[#2F3DB6] hover:bg-[#2532A6] text-white shadow-md shadow-indigo-950/10 flex flex-col justify-between transition-all duration-200 group"
            >
              <div className="space-y-3">
                <div className="flex items-start justify-between">
                  <h3 className="text-2xl font-black tracking-tight group-hover:scale-105 transition-transform">
                    {cls.name}
                  </h3>
                  <span className="w-2.5 h-2.5 rounded-full bg-emerald-400" />
                </div>
                <p className="text-xs text-indigo-100 font-medium">{cls.subject}</p>

                {/* Metrics */}
                <div className="flex items-center gap-4 text-xs text-indigo-100 font-medium pt-1">
                  <div className="flex items-center gap-1.5">
                    <Users className="w-4 h-4 text-amber-300" />
                    <span className="font-bold">{cls.students} Siswa</span>
                  </div>
                  <div className="flex items-center gap-1.5">
                    <CheckCircle2 className="w-4 h-4 text-blue-200" />
                    <span className="font-bold">{cls.rate} Kehadiran</span>
                  </div>
                </div>
              </div>

              {/* Footer */}
              <div className="pt-5 mt-4 border-t border-white/15 flex items-center justify-between text-xs">
                <span className="text-[11px] text-indigo-200 font-semibold">T.A. 2026/2027</span>
                <button
                  type="button"
                  className="px-3 py-1.5 rounded-full bg-white/15 hover:bg-white/25 text-white text-xs font-bold transition cursor-pointer"
                >
                  Kelola Kelas &rarr;
                </button>
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* Teacher Actions & Schedule Preview */}
      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {/* Jadwal Hari Ini */}
        <div className="lg:col-span-2 bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-4">
          <div className="flex items-center justify-between pb-3 border-b border-slate-100">
            <div className="flex items-center gap-2">
              <Calendar className="w-5 h-5 text-[#233DFF]" />
              <h3 className="text-sm font-extrabold text-[#171B61]">Jadwal Mengajar Hari Ini</h3>
            </div>
            <span className="text-[11px] font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full">
              Rabu, Sesi Aktif
            </span>
          </div>

          <div className="space-y-3">
            <div className="p-4 rounded-2xl bg-indigo-50/60 border border-indigo-100 flex items-center justify-between">
              <div className="flex items-center gap-3">
                <div className="w-10 h-10 rounded-xl bg-[#233DFF] text-white flex items-center justify-center font-bold text-xs">
                  07:30
                </div>
                <div>
                  <h4 className="text-xs font-bold text-slate-800">XII RPL 1 &bull; Lab Komputer 2</h4>
                  <p className="text-[11px] text-slate-500">Pemrograman Web &amp; Mobile (4 Jam Pelajaran)</p>
                </div>
              </div>
              <span className="text-xs font-bold text-emerald-600 bg-white px-2.5 py-1 rounded-full border border-emerald-200">
                Berlangsung
              </span>
            </div>

            <div className="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
              <div className="flex items-center gap-3">
                <div className="w-10 h-10 rounded-xl bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs">
                  11:00
                </div>
                <div>
                  <h4 className="text-xs font-bold text-slate-800">XI RPL 2 &bull; Ruang Teori 4</h4>
                  <p className="text-[11px] text-slate-500">Basis Data &amp; SQL Query (2 Jam Pelajaran)</p>
                </div>
              </div>
              <span className="text-xs font-bold text-slate-400">Menunggu</span>
            </div>
          </div>
        </div>

        {/* Quick Tools */}
        <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-4">
          <h3 className="text-sm font-extrabold text-[#171B61] flex items-center gap-2">
            <Award className="w-4 h-4 text-[#233DFF]" />
            <span>Aksi Cepat Pengajar</span>
          </h3>
          <div className="space-y-2.5">
            <button
              type="button"
              className="w-full py-3 px-4 rounded-2xl text-xs font-bold text-left bg-slate-50 hover:bg-blue-50 text-slate-800 hover:text-[#233DFF] border border-slate-200/80 transition flex items-center justify-between cursor-pointer"
            >
              <span>Catat Presensi Kelas</span>
              <Clock className="w-4 h-4 text-[#233DFF]" />
            </button>
            <button
              type="button"
              className="w-full py-3 px-4 rounded-2xl text-xs font-bold text-left bg-slate-50 hover:bg-blue-50 text-slate-800 hover:text-[#233DFF] border border-slate-200/80 transition flex items-center justify-between cursor-pointer"
            >
              <span>Buat Tugas Baru</span>
              <PlusCircle className="w-4 h-4 text-[#233DFF]" />
            </button>
            <button
              type="button"
              className="w-full py-3 px-4 rounded-2xl text-xs font-bold text-left bg-slate-50 hover:bg-blue-50 text-slate-800 hover:text-[#233DFF] border border-slate-200/80 transition flex items-center justify-between cursor-pointer"
            >
              <span>Input Nilai Ulangan</span>
              <BookOpen className="w-4 h-4 text-[#233DFF]" />
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};
