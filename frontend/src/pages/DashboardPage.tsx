import React, { useState, useEffect } from 'react';
import {
  Heart,
  Activity,
  Smile,
  Mail,
  Plus,
  Search,
  ChevronDown,
  CheckCircle2,
  MoreHorizontal
} from 'lucide-react';
import { useAuth } from '../context/AuthContext';
import { AdminPortal } from './portals/AdminPortal';
import { TeacherPortal } from './portals/TeacherPortal';
import { HomeroomPortal } from './portals/HomeroomPortal';
import { MentorPortal } from './portals/MentorPortal';
import { StudentPortal } from './portals/StudentPortal';
import { schoolService } from '../api/schoolService';
import { SchoolProfile } from '../types/school';

export const DashboardPage: React.FC = () => {
  const { user } = useAuth();
  const [profile, setProfile] = useState<SchoolProfile | null>(null);

  useEffect(() => {
    schoolService.getSchoolProfile().then(setProfile).catch(() => null);
  }, []);

  if (!user) return null;

  const userRole = (() => {
    if (user.roles.includes('admin')) return 'admin';
    if (user.roles.includes('wali_kelas')) return 'homeroom';
    if (user.roles.includes('guru_pembimbing_pkl') || user.roles.includes('pembimbing_dudi')) return 'mentor';
    if (user.roles.includes('guru')) return 'teacher';
    return 'student';
  })();

  // Care team members matching Reference UI
  const careTeam = [
    {
      id: 1,
      name: 'Bambang Sudiro, M.Pd',
      email: 'bambang.s@sekolah.sch.id',
      avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80',
      role: 'Wali Kelas XII RPL 1',
    },
    {
      id: 2,
      name: 'Hendra Gunawan, S.Kom',
      email: 'hendra.g@sekolah.sch.id',
      avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80',
      role: 'Pembimbing PKL DUDI',
    },
    {
      id: 3,
      name: 'Rudy Hartono (PT Telkom)',
      email: 'rudy.h@telkom.co.id',
      avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=120&q=80',
      role: 'Mentor Industri DUDI',
    },
    {
      id: 4,
      name: 'Siti Aminah, S.Pd',
      email: 'siti.a@sekolah.sch.id',
      avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=120&q=80',
      role: 'Guru Produktif RPL',
    },
  ];

  // Tracker records matching Reference UI Table
  const trackerRecords = [
    {
      id: 1,
      name: 'Ahmad Fauzan',
      sub: 'XII RPL 1 • Magang PT Telkom',
      progress: 92,
      date: '21/10/26',
      time: '07:25 WIB',
      status: 'Hadir',
      duration: '3 Bulan',
    },
    {
      id: 2,
      name: 'Budi Santoso',
      sub: 'XII RPL 1 • Magang PT Telkom',
      progress: 88,
      date: '21/10/26',
      time: '07:30 WIB',
      status: 'Hadir',
      duration: '3 Bulan',
    },
    {
      id: 3,
      name: 'Citra Kirana',
      sub: 'XII RPL 2 • CV Inovasi Digital',
      progress: 96,
      date: '21/10/26',
      time: '07:15 WIB',
      status: 'Hadir',
      duration: '6 Bulan',
    },
    {
      id: 4,
      name: 'Eko Prasetyo',
      sub: 'XII RPL 1 • CV Inovasi Digital',
      progress: 74,
      date: '21/10/26',
      time: '08:10 WIB',
      status: 'Izin',
      duration: '3 Bulan',
    },
  ];

  return (
    <div className="space-y-6">
      {/* Top Academic Year & Status Bar */}
      <div className="flex items-center justify-between pb-1">
        <div className="flex items-center gap-2">
          <span className="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse" />
          <span className="text-xs font-bold text-slate-600">
            Status Sistem: Operasional Normal
          </span>
        </div>
        <div className="text-right">
          <span className="text-xs font-bold text-slate-400">
            T.A. {profile?.academic_year?.name ?? '2026/2027'} ({profile?.academic_year?.semester ?? 'Ganjil'})
          </span>
        </div>
      </div>

      {/* Row 1: 3 Soft Tinted Stat Cards (Matching Reference UI Top Cards) */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-5">
        {/* Card 1: Soft Rose Tint */}
        <div className="bg-[#FCF1F3] border border-[#F9DEE3] rounded-3xl p-5 flex items-center gap-4 transition-all hover:shadow-xs">
          <div className="w-12 h-12 rounded-2xl bg-white shadow-xs flex items-center justify-center shrink-0 text-rose-500">
            <Heart className="w-5 h-5 fill-rose-500" />
          </div>
          <div className="min-w-0">
            <span className="text-[11px] font-bold text-slate-500 block truncate">
              Presensi Hari Ini
            </span>
            <div className="flex items-baseline gap-1 mt-0.5">
              <span className="text-2xl font-black text-slate-900">
                {profile?.statistics.total_students ? `${profile.statistics.total_students - 4}/${profile.statistics.total_students}` : '32/32'}
              </span>
              <span className="text-xs font-bold text-slate-500">siswa hadir</span>
            </div>
          </div>
        </div>

        {/* Card 2: Soft Blue Tint */}
        <div className="bg-[#EDF3FF] border border-[#DBE7FF] rounded-3xl p-5 flex items-center gap-4 transition-all hover:shadow-xs">
          <div className="w-12 h-12 rounded-2xl bg-white shadow-xs flex items-center justify-center shrink-0 text-[#233DFF]">
            <Activity className="w-5 h-5" />
          </div>
          <div className="min-w-0">
            <span className="text-[11px] font-bold text-slate-500 block truncate">
              Penempatan PKL &amp; Geofence
            </span>
            <div className="flex items-baseline gap-1 mt-0.5">
              <span className="text-2xl font-black text-slate-900">120/120</span>
              <span className="text-xs font-bold text-slate-500">siswa magang</span>
            </div>
          </div>
        </div>

        {/* Card 3: Soft Lavender Tint */}
        <div className="bg-[#F3EFFB] border border-[#E5DEF7] rounded-3xl p-5 flex items-center gap-4 transition-all hover:shadow-xs">
          <div className="w-12 h-12 rounded-2xl bg-white shadow-xs flex items-center justify-center shrink-0 text-indigo-600">
            <Smile className="w-5 h-5" />
          </div>
          <div className="min-w-0">
            <span className="text-[11px] font-bold text-slate-500 block truncate">
              Capaian Jurnal &amp; Tugas
            </span>
            <div className="flex items-baseline gap-1 mt-0.5">
              <span className="text-2xl font-black text-slate-900">9.5/10</span>
              <span className="text-xs font-bold text-slate-500">skor rata-rata</span>
            </div>
          </div>
        </div>
      </div>

      {/* Row 2: Middle Split Section (Chart 65% + Team List 35% matching Reference UI) */}
      <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        
        {/* Left: Attendance & Performance Bar Chart (Matching Heart Rate Card in Reference) */}
        <div className="lg:col-span-8 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs flex flex-col justify-between">
          <div>
            {/* Chart Header */}
            <div className="flex items-center justify-between mb-6">
              <div className="flex items-center gap-3">
                <h3 className="text-base font-black text-slate-900 tracking-tight">
                  Tingkat Kehadiran
                </h3>
                <div className="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-100 text-xs font-bold text-slate-600">
                  <span>Hari Kerja</span>
                  <ChevronDown className="w-3 h-3 text-slate-400" />
                </div>
              </div>

              <div className="flex items-center gap-2">
                <span className="text-xl font-black text-slate-900">98%</span>
                <span className="text-xs text-slate-400 font-bold">(avg)</span>
                <Activity className="w-4 h-4 text-[#233DFF]" />
              </div>
            </div>

            {/* Custom Bar Chart Canvas matching Reference Graphic */}
            <div className="relative pt-6 pb-2">
              {/* Dashed Target Line */}
              <div className="absolute top-10 left-8 right-0 border-t-2 border-dashed border-rose-300 flex items-center z-0">
                <span className="absolute -top-3.5 -left-8 px-2 py-0.5 rounded-full text-[10px] font-extrabold text-white bg-rose-500 shadow-xs">
                  Target
                </span>
              </div>

              {/* Chart Grid Bars */}
              <div className="grid grid-cols-7 gap-3 sm:gap-6 items-end h-56 pt-8 pb-4 relative z-10">
                {/* Mon */}
                <div className="flex flex-col items-center gap-2 h-full justify-end group">
                  <span className="text-[10px] font-extrabold text-slate-400 opacity-0 group-hover:opacity-100 transition">82%</span>
                  <div className="w-full max-w-[42px] h-[65%] rounded-2xl bg-slate-100 hover:bg-slate-200 transition-all" />
                  <span className="text-xs font-bold text-slate-400">Sen</span>
                </div>

                {/* Tue */}
                <div className="flex flex-col items-center gap-2 h-full justify-end group">
                  <span className="text-[10px] font-extrabold text-slate-400 opacity-0 group-hover:opacity-100 transition">75%</span>
                  <div className="w-full max-w-[42px] h-[55%] rounded-2xl bg-slate-100 hover:bg-slate-200 transition-all" />
                  <span className="text-xs font-bold text-slate-400">Sel</span>
                </div>

                {/* Wed */}
                <div className="flex flex-col items-center gap-2 h-full justify-end group">
                  <span className="text-[10px] font-extrabold text-slate-400 opacity-0 group-hover:opacity-100 transition">90%</span>
                  <div className="w-full max-w-[42px] h-[78%] rounded-2xl bg-slate-100 hover:bg-slate-200 transition-all" />
                  <span className="text-xs font-bold text-slate-400">Rab</span>
                </div>

                {/* Thu (Active Featured Bar matching 110 bpm pill in Reference) */}
                <div className="flex flex-col items-center gap-2 h-full justify-end relative">
                  {/* Floating Pill Tooltip */}
                  <div className="px-3 py-1 rounded-full text-[11px] font-extrabold text-white bg-[#233DFF] shadow-md shadow-blue-500/30 whitespace-nowrap">
                    98.5% Hadir
                  </div>
                  <div className="w-full max-w-[44px] h-[95%] rounded-2xl bg-[#C7D7FE] border border-[#233DFF]/40 shadow-xs" />
                  <span className="text-xs font-extrabold text-[#233DFF]">Kam</span>
                </div>

                {/* Fri */}
                <div className="flex flex-col items-center gap-2 h-full justify-end group">
                  <span className="text-[10px] font-extrabold text-slate-400 opacity-0 group-hover:opacity-100 transition">92%</span>
                  <div className="w-full max-w-[42px] h-[82%] rounded-2xl bg-slate-100 hover:bg-slate-200 transition-all" />
                  <span className="text-xs font-bold text-slate-400">Jum</span>
                </div>

                {/* Sat */}
                <div className="flex flex-col items-center gap-2 h-full justify-end group">
                  <span className="text-[10px] font-extrabold text-slate-400 opacity-0 group-hover:opacity-100 transition">85%</span>
                  <div className="w-full max-w-[42px] h-[70%] rounded-2xl bg-slate-100 hover:bg-slate-200 transition-all" />
                  <span className="text-xs font-bold text-slate-400">Sab</span>
                </div>

                {/* Sun */}
                <div className="flex flex-col items-center gap-2 h-full justify-end">
                  <div className="w-full max-w-[42px] h-[25%] rounded-2xl bg-slate-50 border border-dashed border-slate-200 flex items-center justify-center text-slate-300 text-xs">
                    -
                  </div>
                  <span className="text-xs font-bold text-slate-300">Min</span>
                </div>
              </div>
            </div>
          </div>

          <div className="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <span className="font-semibold">Sinkronisasi Kehadiran GPS Geofence</span>
            <span className="font-bold text-emerald-600">✓ Radius Valid Terverifikasi</span>
          </div>
        </div>

        {/* Right: Care team matching Reference UI */}
        <div className="lg:col-span-4 bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs flex flex-col justify-between">
          <div>
            <div className="flex items-center justify-between mb-5">
              <h3 className="text-base font-black text-slate-900 tracking-tight">
                Tim Pembimbing &amp; Guru
              </h3>
              <button type="button" className="text-xs font-bold text-[#233DFF] hover:underline">
                Lihat Semua
              </button>
            </div>

            {/* List of 4 specialists */}
            <div className="space-y-4">
              {careTeam.map((member) => (
                <div key={member.id} className="flex items-center justify-between gap-3">
                  <div className="flex items-center gap-3 min-w-0">
                    <img
                      src={member.avatar}
                      alt={member.name}
                      className="w-10 h-10 rounded-full object-cover shrink-0 border border-slate-200"
                    />
                    <div className="min-w-0">
                      <h4 className="text-xs font-extrabold text-slate-900 truncate">
                        {member.name}
                      </h4>
                      <p className="text-[10px] text-slate-400 truncate">{member.role}</p>
                    </div>
                  </div>
                  <button
                    type="button"
                    title="Kirim Pesan"
                    className="p-2 rounded-xl text-slate-400 hover:text-[#233DFF] hover:bg-slate-100 transition shrink-0"
                  >
                    <Mail className="w-4 h-4" />
                  </button>
                </div>
              ))}
            </div>
          </div>

          {/* Bottom Pill Button matching "+ Add specialist" in Reference */}
          <div className="pt-6 mt-4 border-t border-slate-100">
            <button
              type="button"
              className="w-full py-3 px-4 rounded-2xl border border-slate-200 hover:border-slate-300 bg-white hover:bg-slate-50 text-xs font-bold text-slate-800 transition flex items-center justify-center gap-2 cursor-pointer shadow-2xs"
            >
              <Plus className="w-4 h-4 text-slate-500" />
              <span>Kontak Pembimbing</span>
            </button>
          </div>
        </div>
      </div>

      {/* Row 3: Bottom Activity Tracker Table (Matching "Medication tracker" in Reference UI) */}
      <div className="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-5">
        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div className="flex items-center gap-2.5">
            <h3 className="text-base font-black text-slate-900 tracking-tight">
              Log Presensi &amp; Aktivitas Terkini
            </h3>
            <span className="text-[11px] font-extrabold text-[#233DFF] bg-[#E5ECFF] px-2.5 py-0.5 rounded-full">
              +4 Baru
            </span>
          </div>

          <div className="flex items-center gap-3">
            <div className="relative">
              <Search className="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
              <input
                type="text"
                placeholder="Cari aktivitas..."
                className="pl-8 pr-3 py-1.5 rounded-full bg-slate-50 border border-slate-200 text-xs text-slate-700 focus:outline-none focus:bg-white"
              />
            </div>
            <div className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-slate-200 text-xs font-bold text-slate-600 bg-white">
              <span>Bulan Ini</span>
              <ChevronDown className="w-3.5 h-3.5 text-slate-400" />
            </div>
          </div>
        </div>

        {/* Table matching reference */}
        <div className="overflow-x-auto">
          <table className="w-full text-left text-xs">
            <thead className="text-slate-400 font-bold uppercase tracking-wider text-[10px] border-b border-slate-100">
              <tr>
                <th className="py-3 px-2 w-8">
                  <input type="checkbox" className="rounded text-[#233DFF] focus:ring-0" />
                </th>
                <th className="py-3 px-4">Nama Siswa / Kegiatan</th>
                <th className="py-3 px-4">Progres PKL</th>
                <th className="py-3 px-4">Tanggal</th>
                <th className="py-3 px-4">Waktu</th>
                <th className="py-3 px-4">Status</th>
                <th className="py-3 px-4">Durasi</th>
                <th className="py-3 px-2 text-right"></th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium text-slate-700">
              {trackerRecords.map((rec) => (
                <tr key={rec.id} className="hover:bg-slate-50/80 transition">
                  <td className="py-4 px-2">
                    <input type="checkbox" className="rounded text-[#233DFF] focus:ring-0" />
                  </td>
                  <td className="py-4 px-4">
                    <span className="font-extrabold text-slate-900 block">{rec.name}</span>
                    <span className="text-[11px] text-slate-400 block">{rec.sub}</span>
                  </td>
                  <td className="py-4 px-4">
                    <div className="flex items-center gap-2">
                      <div className="w-5 h-5 rounded-full border-2 border-rose-500 border-t-transparent animate-spin-none shrink-0 flex items-center justify-center text-[8px] font-bold">
                        •
                      </div>
                      <span className="font-bold text-slate-800">{rec.progress}%</span>
                    </div>
                  </td>
                  <td className="py-4 px-4 text-slate-600 font-medium">{rec.date}</td>
                  <td className="py-4 px-4 font-mono font-bold text-slate-800">{rec.time}</td>
                  <td className="py-4 px-4">
                    <span
                      className={`inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-extrabold ${
                        rec.status === 'Hadir'
                          ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                          : 'bg-rose-50 text-rose-700 border border-rose-200'
                      }`}
                    >
                      <CheckCircle2 className="w-3 h-3" />
                      <span>{rec.status}</span>
                    </span>
                  </td>
                  <td className="py-4 px-4 text-slate-600">{rec.duration}</td>
                  <td className="py-4 px-2 text-right">
                    <button type="button" className="text-slate-400 hover:text-slate-700 p-1">
                      <MoreHorizontal className="w-4 h-4" />
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>

      {/* Role Dedicated Sub-View */}
      <div className="pt-6 border-t border-slate-200">
        {userRole === 'admin' && <AdminPortal profile={profile} />}
        {userRole === 'teacher' && <TeacherPortal user={user} />}
        {userRole === 'homeroom' && <HomeroomPortal user={user} />}
        {userRole === 'mentor' && <MentorPortal user={user} />}
        {userRole === 'student' && <StudentPortal user={user} />}
      </div>
    </div>
  );
};
