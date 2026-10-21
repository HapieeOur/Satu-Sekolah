import React, { useState } from 'react';
import { useLocation } from 'react-router-dom';
import {
  Briefcase,
  MapPin,
  CheckCircle2,
  FileText,
  Building2,
  UserCheck
} from 'lucide-react';
import { useAuth } from '../../context/AuthContext';

export const MentorModulePage: React.FC = () => {
  const { user } = useAuth();
  const location = useLocation();

  const getTabFromPath = () => {
    if (location.pathname.includes('students')) return 'students';
    if (location.pathname.includes('attendances')) return 'attendances';
    if (location.pathname.includes('journals')) return 'journals';
    if (location.pathname.includes('leaves')) return 'leaves';
    if (location.pathname.includes('tasks')) return 'tasks';
    return 'dashboard';
  };

  const [activeTab, setActiveTab] = useState<'dashboard' | 'students' | 'attendances' | 'journals' | 'leaves' | 'tasks'>(
    getTabFromPath
  );

  const interns = [
    { id: 1, name: 'Ahmad Fauzan', company: 'PT Telkom Indonesia', mentor: 'Ir. Hendra', checkin: '07:45 WIB', radius: '15m (Valid)', status: 'Hadir', journal: 'Sudah Upload' },
    { id: 2, name: 'Budi Santoso', company: 'PT Telkom Indonesia', mentor: 'Ir. Hendra', checkin: '07:50 WIB', radius: '22m (Valid)', status: 'Hadir', journal: 'Sudah Upload' },
    { id: 3, name: 'Citra Kirana', company: 'Bank Jatim Digital', mentor: 'Siti Aminah, S.Kom', checkin: '-', radius: '-', status: 'Izin', journal: 'Dispensasi' },
    { id: 4, name: 'Dewi Lestari', company: 'Software House Inovasi', mentor: 'Eko Wijaya', checkin: '08:00 WIB', radius: '10m (Valid)', status: 'Hadir', journal: 'Menunggu Review' },
  ];

  return (
    <div className="space-y-6">
      {/* Banner */}
      <div className="rounded-3xl bg-gradient-to-r from-[#171B61] to-[#2F3DB6] p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/10 text-sky-300 mb-2">
            <Briefcase className="w-3.5 h-3.5" />
            <span>Portal Pembimbing Praktik Kerja Lapangan (PKL)</span>
          </div>
          <h1 className="text-2xl sm:text-3xl font-black tracking-tight">Monitoring &amp; Bimbingan PKL</h1>
          <p className="text-xs text-indigo-100 mt-1 max-w-xl">
            Pembimbing: <strong>{user?.name}</strong> &bull; Mengawasi 18 Siswa di 4 Perusahaan Mitra
          </p>
        </div>

        <div className="flex items-center gap-4 bg-white/10 backdrop-blur-md px-5 py-3.5 rounded-2xl border border-white/15">
          <div className="text-right">
            <span className="text-2xl sm:text-3xl font-black text-amber-300">100%</span>
            <span className="text-[10px] text-indigo-200 block uppercase font-bold tracking-wider">
              Geofence GPS Valid
            </span>
          </div>
        </div>
      </div>

      {/* Navigation Tabs */}
      <div className="flex items-center gap-2 overflow-x-auto pb-2 border-b border-slate-200">
        <button
          onClick={() => setActiveTab('dashboard')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'dashboard'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Dashboard Pembimbing
        </button>
        <button
          onClick={() => setActiveTab('students')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'students'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Siswa Bimbingan
        </button>
        <button
          onClick={() => setActiveTab('attendances')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'attendances'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Presensi &amp; GPS PKL
        </button>
        <button
          onClick={() => setActiveTab('journals')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'journals'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Jurnal Harian Siswa
        </button>
        <button
          onClick={() => setActiveTab('leaves')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'leaves'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Pengajuan Izin / Sakit
        </button>
        <button
          onClick={() => setActiveTab('tasks')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'tasks'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Tugas &amp; Proyek PKL
        </button>
      </div>

      {/* Main Content Table */}
      <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-4">
        <div className="flex items-center justify-between pb-3 border-b border-slate-100">
          <h3 className="text-sm font-extrabold text-[#171B61] flex items-center gap-2">
            <UserCheck className="w-4 h-4 text-[#233DFF]" />
            <span>Presensi Geofencing &amp; Aktivitas Siswa Magang</span>
          </h3>
          <span className="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
            Realtime GPS Radius
          </span>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-left text-xs">
            <thead className="bg-[#F8FAFD] text-slate-400 font-bold uppercase text-[10px] tracking-wider">
              <tr>
                <th className="py-3 px-4">Nama Siswa</th>
                <th className="py-3 px-4">Perusahaan Mitra</th>
                <th className="py-3 px-4">Waktu Check-In</th>
                <th className="py-3 px-4">Akurasi GPS</th>
                <th className="py-3 px-4">Status</th>
                <th className="py-3 px-4">Jurnal Kegiatan</th>
                <th className="py-3 px-4 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium text-slate-700">
              {interns.map((it) => (
                <tr key={it.id} className="hover:bg-slate-50/80 transition">
                  <td className="py-4 px-4 font-bold text-slate-900">{it.name}</td>
                  <td className="py-4 px-4">
                    <span className="font-semibold text-slate-800 flex items-center gap-1.5">
                      <Building2 className="w-3.5 h-3.5 text-slate-400" />
                      {it.company}
                    </span>
                    <span className="text-[11px] text-slate-400 block mt-0.5">Mentor: {it.mentor}</span>
                  </td>
                  <td className="py-4 px-4 font-mono font-bold text-slate-700">{it.checkin}</td>
                  <td className="py-4 px-4">
                    <span className="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">
                      <MapPin className="w-3 h-3 text-emerald-600" />
                      {it.radius}
                    </span>
                  </td>
                  <td className="py-4 px-4">
                    <span
                      className={`inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold ${
                        it.status === 'Hadir'
                          ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                          : 'bg-amber-50 text-amber-700 border border-amber-200'
                      }`}
                    >
                      <CheckCircle2 className="w-3 h-3" />
                      {it.status}
                    </span>
                  </td>
                  <td className="py-4 px-4">
                    <span className="inline-flex items-center gap-1 text-slate-700 font-medium">
                      <FileText className="w-3.5 h-3.5 text-[#233DFF]" />
                      {it.journal}
                    </span>
                  </td>
                  <td className="py-4 px-4 text-right">
                    <button
                      type="button"
                      className="px-3 py-1.5 rounded-full text-xs font-bold text-[#233DFF] bg-[#E5ECFF] hover:bg-blue-200 transition cursor-pointer"
                    >
                      Validasi
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
};
