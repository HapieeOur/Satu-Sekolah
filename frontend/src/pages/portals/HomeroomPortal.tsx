import React from 'react';
import {
  Users,
  FileText,
  UserCheck,
  UserX,
  Clock,
} from 'lucide-react';
import { User } from '../../types/auth';

interface HomeroomPortalProps {
  user: User;
}

export const HomeroomPortal: React.FC<HomeroomPortalProps> = ({ user }) => {
  const sampleStudents = [
    { id: 1, name: 'Ahmad Fauzan', nisn: '0051234561', status: 'Hadir', time: '06:55' },
    { id: 2, name: 'Budi Santoso', nisn: '0051234562', status: 'Hadir', time: '07:10' },
    { id: 3, name: 'Citra Kirana', nisn: '0051234563', status: 'Sakit', time: '-' },
    { id: 4, name: 'Dewi Lestari', nisn: '0051234564', status: 'Hadir', time: '07:05' },
    { id: 5, name: 'Eko Prasetyo', nisn: '0051234565', status: 'Izin', time: '-' },
  ];

  return (
    <div className="space-y-8">
      {/* Homeroom Header Banner */}
      <div className="rounded-3xl bg-gradient-to-r from-[#171B61] to-[#2F3DB6] p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/10 text-[#F4CF52] mb-3">
            <span>🛡️ Amanah Peran: Wali Kelas</span>
          </div>
          <h2 className="text-2xl sm:text-3xl font-black tracking-tight">
            Kelas Perwalian: XII RPL 1
          </h2>
          <p className="text-xs text-indigo-100 mt-1 max-w-xl">
            Wali Kelas: <strong>{user.name}</strong> &bull; Total 32 Peserta Didik Terdaftar Aktif
          </p>
        </div>

        <div className="flex items-center gap-4 bg-white/10 backdrop-blur-md px-6 py-4 rounded-2xl border border-white/15">
          <div className="text-right">
            <span className="text-3xl font-black text-[#F4CF52]">96.8%</span>
            <span className="text-[10px] text-indigo-200 block uppercase font-bold tracking-wider">
              Tingkat Kehadiran
            </span>
          </div>
        </div>
      </div>

      {/* Attendance Metric Breakdown */}
      <div className="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div className="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-xs flex items-center gap-3">
          <div className="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
            <UserCheck className="w-5 h-5" />
          </div>
          <div>
            <span className="text-2xl font-black text-slate-800">30</span>
            <span className="text-xs text-slate-500 font-semibold block">Hadir Tepat Waktu</span>
          </div>
        </div>

        <div className="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-xs flex items-center gap-3">
          <div className="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
            <Clock className="w-5 h-5" />
          </div>
          <div>
            <span className="text-2xl font-black text-slate-800">1</span>
            <span className="text-xs text-slate-500 font-semibold block">Izin Terverifikasi</span>
          </div>
        </div>

        <div className="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-xs flex items-center gap-3">
          <div className="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
            <FileText className="w-5 h-5" />
          </div>
          <div>
            <span className="text-2xl font-black text-slate-800">1</span>
            <span className="text-xs text-slate-500 font-semibold block">Surat Dokter / Sakit</span>
          </div>
        </div>

        <div className="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-xs flex items-center gap-3">
          <div className="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center">
            <UserX className="w-5 h-5" />
          </div>
          <div>
            <span className="text-2xl font-black text-slate-800">0</span>
            <span className="text-xs text-slate-500 font-semibold block">Alpa / Tanpa Keterangan</span>
          </div>
        </div>
      </div>

      {/* Student List Table */}
      <div className="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div className="p-6 border-b border-slate-100 flex items-center justify-between">
          <div className="flex items-center gap-2">
            <Users className="w-5 h-5 text-[#233DFF]" />
            <h3 className="text-sm font-extrabold text-[#171B61]">
              Daftar Siswa Perwalian Hari Ini
            </h3>
          </div>
          <span className="text-xs font-bold text-[#233DFF]">32 Siswa</span>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-left text-xs">
            <thead className="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold border-b border-slate-100">
              <tr>
                <th className="px-6 py-3.5">Nama Peserta Didik</th>
                <th className="px-6 py-3.5">NISN</th>
                <th className="px-6 py-3.5">Jam Masuk</th>
                <th className="px-6 py-3.5">Status Kehadiran</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium">
              {sampleStudents.map((st) => (
                <tr key={st.id} className="hover:bg-slate-50/80 transition">
                  <td className="px-6 py-4 font-bold text-slate-900">{st.name}</td>
                  <td className="px-6 py-4 font-mono text-slate-500">{st.nisn}</td>
                  <td className="px-6 py-4 text-slate-600">{st.time}</td>
                  <td className="px-6 py-4">
                    <span
                      className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold ${
                        st.status === 'Hadir'
                          ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                          : st.status === 'Sakit'
                          ? 'bg-blue-50 text-blue-700 border border-blue-200'
                          : 'bg-amber-50 text-amber-700 border border-amber-200'
                      }`}
                    >
                      {st.status}
                    </span>
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
