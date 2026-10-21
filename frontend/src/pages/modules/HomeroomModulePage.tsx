import React, { useState } from 'react';
import { useLocation } from 'react-router-dom';
import {
  Users,
  UserCheck,
  CheckCircle2,
  Clock,
  AlertTriangle
} from 'lucide-react';
import { useAuth } from '../../context/AuthContext';

export const HomeroomModulePage: React.FC = () => {
  const { user } = useAuth();
  const location = useLocation();

  const getTabFromPath = () => {
    if (location.pathname.includes('students')) return 'students';
    if (location.pathname.includes('attendances')) return 'attendances';
    if (location.pathname.includes('grades')) return 'grades';
    return 'dashboard';
  };

  const [activeTab, setActiveTab] = useState<'dashboard' | 'students' | 'attendances' | 'grades'>(
    getTabFromPath
  );

  const students = [
    { id: 1, name: 'Ahmad Fauzan', nisn: '0051234561', gender: 'L', attendanceRate: '98%', status: 'Hadir', parent: 'Suprapto (08123456781)' },
    { id: 2, name: 'Budi Santoso', nisn: '0051234562', gender: 'L', attendanceRate: '94%', status: 'Hadir', parent: 'Handoko (08123456782)' },
    { id: 3, name: 'Citra Kirana', nisn: '0051234563', gender: 'P', attendanceRate: '90%', status: 'Sakit', parent: 'Yuliani (08123456783)' },
    { id: 4, name: 'Dewi Lestari', nisn: '0051234564', gender: 'P', attendanceRate: '100%', status: 'Hadir', parent: 'Bambang (08123456784)' },
    { id: 5, name: 'Eko Prasetyo', nisn: '0051234565', gender: 'L', attendanceRate: '92%', status: 'Izin', parent: 'Suhartini (08123456785)' },
  ];

  return (
    <div className="space-y-6">
      {/* Banner */}
      <div className="rounded-3xl bg-gradient-to-r from-[#171B61] to-[#2F3DB6] p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/10 text-[#F4CF52] mb-2">
            <span>🛡️ Amanah Wali Kelas: XII RPL 1</span>
          </div>
          <h1 className="text-2xl sm:text-3xl font-black tracking-tight">Portal Perwalian Kelas</h1>
          <p className="text-xs text-indigo-100 mt-1 max-w-xl">
            Wali Kelas: <strong>{user?.name}</strong> &bull; Total 32 Siswa Aktif Terdaftar
          </p>
        </div>

        <div className="flex items-center gap-4 bg-white/10 backdrop-blur-md px-5 py-3.5 rounded-2xl border border-white/15">
          <div className="text-right">
            <span className="text-2xl sm:text-3xl font-black text-[#F4CF52]">96.8%</span>
            <span className="text-[10px] text-indigo-200 block uppercase font-bold tracking-wider">
              Kehadiran Rata-rata
            </span>
          </div>
        </div>
      </div>

      {/* Tabs */}
      <div className="flex items-center gap-2 overflow-x-auto pb-2 border-b border-slate-200">
        <button
          onClick={() => setActiveTab('dashboard')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'dashboard'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Kelas Binaan Saya
        </button>
        <button
          onClick={() => setActiveTab('students')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'students'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Daftar Siswa Binaan
        </button>
        <button
          onClick={() => setActiveTab('attendances')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'attendances'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Rekap Presensi Harian
        </button>
        <button
          onClick={() => setActiveTab('grades')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'grades'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Buku Nilai Kelas
        </button>
      </div>

      {/* Metrics Row */}
      <div className="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div className="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-xs flex items-center gap-3">
          <div className="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
            <UserCheck className="w-5 h-5" />
          </div>
          <div>
            <span className="text-2xl font-black text-slate-800">30</span>
            <span className="text-xs text-slate-500 font-semibold block">Hadir Hari Ini</span>
          </div>
        </div>
        <div className="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-xs flex items-center gap-3">
          <div className="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
            <Clock className="w-5 h-5" />
          </div>
          <div>
            <span className="text-2xl font-black text-slate-800">1</span>
            <span className="text-xs text-slate-500 font-semibold block">Izin Disetujui</span>
          </div>
        </div>
        <div className="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-xs flex items-center gap-3">
          <div className="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
            <AlertTriangle className="w-5 h-5" />
          </div>
          <div>
            <span className="text-2xl font-black text-slate-800">1</span>
            <span className="text-xs text-slate-500 font-semibold block">Sakit (Keterangan)</span>
          </div>
        </div>
        <div className="bg-white rounded-3xl p-5 border border-slate-200/90 shadow-xs flex items-center gap-3">
          <div className="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
            <Users className="w-5 h-5" />
          </div>
          <div>
            <span className="text-2xl font-black text-slate-800">32</span>
            <span className="text-xs text-slate-500 font-semibold block">Total Anggota Kelas</span>
          </div>
        </div>
      </div>

      {/* Main Table */}
      <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-4">
        <div className="flex items-center justify-between pb-3 border-b border-slate-100">
          <h3 className="text-sm font-extrabold text-[#171B61] flex items-center gap-2">
            <Users className="w-4 h-4 text-[#233DFF]" />
            <span>Data Siswa Kelas Binaan XII RPL 1</span>
          </h3>
          <span className="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
            T.A. 2026/2027 Ganjil
          </span>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-left text-xs">
            <thead className="bg-[#F8FAFD] text-slate-400 font-bold uppercase text-[10px] tracking-wider">
              <tr>
                <th className="py-3 px-4">Nama Siswa</th>
                <th className="py-3 px-4">NISN</th>
                <th className="py-3 px-4">L/P</th>
                <th className="py-3 px-4">Tingkat Kehadiran</th>
                <th className="py-3 px-4">Status Hari Ini</th>
                <th className="py-3 px-4">Kontak Orang Tua / Wali</th>
                <th className="py-3 px-4 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium text-slate-700">
              {students.map((st) => (
                <tr key={st.id} className="hover:bg-slate-50/80 transition">
                  <td className="py-4 px-4 font-bold text-slate-900">{st.name}</td>
                  <td className="py-4 px-4 font-mono text-slate-500">{st.nisn}</td>
                  <td className="py-4 px-4 font-bold">{st.gender}</td>
                  <td className="py-4 px-4 font-bold text-slate-900">
                    <div className="flex items-center gap-2">
                      <div className="w-16 bg-slate-100 rounded-full h-2 overflow-hidden">
                        <div
                          className="bg-[#233DFF] h-full rounded-full"
                          style={{ width: st.attendanceRate }}
                        />
                      </div>
                      <span>{st.attendanceRate}</span>
                    </div>
                  </td>
                  <td className="py-4 px-4">
                    <span
                      className={`inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold ${
                        st.status === 'Hadir'
                          ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                          : st.status === 'Izin'
                          ? 'bg-amber-50 text-amber-700 border border-amber-200'
                          : 'bg-rose-50 text-rose-700 border border-rose-200'
                      }`}
                    >
                      <CheckCircle2 className="w-3 h-3" />
                      {st.status}
                    </span>
                  </td>
                  <td className="py-4 px-4 text-slate-600">{st.parent}</td>
                  <td className="py-4 px-4 text-right">
                    <button
                      type="button"
                      className="px-3 py-1.5 rounded-full text-xs font-bold text-[#233DFF] bg-[#E5ECFF] hover:bg-blue-200 transition cursor-pointer"
                    >
                      Rapor Siswa
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
