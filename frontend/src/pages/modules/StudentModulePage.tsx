import React, { useState } from 'react';
import { useLocation } from 'react-router-dom';
import {
  GraduationCap,
  Calendar,
  CheckCircle2,
  BookOpen,
  Briefcase,
  Award,
  Building2,
  FileCheck
} from 'lucide-react';
import { useAuth } from '../../context/AuthContext';

export const StudentModulePage: React.FC = () => {
  const { user } = useAuth();
  const location = useLocation();

  const getTabFromPath = () => {
    if (location.pathname.includes('schedules')) return 'schedules';
    if (location.pathname.includes('attendances')) return 'attendances';
    if (location.pathname.includes('tasks')) return 'tasks';
    if (location.pathname.includes('exams')) return 'exams';
    if (location.pathname.includes('internship')) return 'internship';
    return 'dashboard';
  };

  const [activeTab, setActiveTab] = useState<'dashboard' | 'schedules' | 'attendances' | 'tasks' | 'exams' | 'internship'>(
    getTabFromPath
  );

  const schedules = [
    { id: 1, day: 'Senin', time: '07:30 - 09:30', subject: 'Pemrograman Web & Mobile', teacher: 'Bambang Sudiro, M.Pd', room: 'Lab Komputer 2' },
    { id: 2, day: 'Senin', time: '10:00 - 11:30', subject: 'Basis Data & SQL', teacher: 'Ir. Hendra', room: 'Ruang Teori 4' },
    { id: 3, day: 'Selasa', time: '07:30 - 10:30', subject: 'Bahasa Indonesia & Literasi', teacher: 'Siti Aminah, S.Pd', room: 'Ruang Teori 1' },
    { id: 4, day: 'Rabu', time: '08:30 - 11:00', subject: 'Pemrograman Berorientasi Objek', teacher: 'Bambang Sudiro, M.Pd', room: 'Lab Komputer 1' },
  ];

  const tasks = [
    { id: 1, subject: 'Pemrograman Web', title: 'Tugas 02: RESTful API Controller CRUD', deadline: '27 Okt 2026', status: 'Selesai Dikirim', grade: '92/100' },
    { id: 2, subject: 'Basis Data', title: 'Tugas 01: Relasi & Normalisasi Database', deadline: '29 Okt 2026', status: 'Belum Selesai', grade: '-' },
    { id: 3, subject: 'Bahasa Inggris', title: 'Technical Writing: Software Specification', deadline: '01 Nov 2026', status: 'Menunggu Review', grade: '-' },
  ];

  return (
    <div className="space-y-6">
      {/* Banner */}
      <div className="rounded-3xl bg-gradient-to-r from-[#171B61] via-[#1D2275] to-[#233DFF] p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/10 text-amber-300 mb-2">
            <GraduationCap className="w-3.5 h-3.5" />
            <span>Peserta Didik Aktif &bull; XII RPL 1</span>
          </div>
          <h1 className="text-2xl sm:text-3xl font-black tracking-tight">Portal Akademik Siswa</h1>
          <p className="text-xs text-indigo-100 mt-1 max-w-xl">
            Siswa: <strong>{user?.name}</strong> &bull; NISN: {user?.student?.nisn || '0051234567'} &bull; Semester Ganjil 2026/2027
          </p>
        </div>

        <div className="flex items-center gap-4 bg-white/10 backdrop-blur-md px-5 py-3.5 rounded-2xl border border-white/15">
          <div className="text-right">
            <span className="text-2xl sm:text-3xl font-black text-[#F4CF52]">98.5%</span>
            <span className="text-[10px] text-indigo-200 block uppercase font-bold tracking-wider">
              Kehadiran Siswa
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
          Beranda Siswa
        </button>
        <button
          onClick={() => setActiveTab('schedules')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'schedules'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Jadwal Pelajaran
        </button>
        <button
          onClick={() => setActiveTab('attendances')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'attendances'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Presensi Saya
        </button>
        <button
          onClick={() => setActiveTab('tasks')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'tasks'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Tugas Saya
        </button>
        <button
          onClick={() => setActiveTab('exams')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'exams'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Ujian Harian
        </button>
        <button
          onClick={() => setActiveTab('internship')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'internship'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Informasi PKL
        </button>
      </div>

      {/* Tab Panels */}
      {activeTab === 'schedules' && (
        <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-4">
          <div className="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 className="text-sm font-extrabold text-[#171B61] flex items-center gap-2">
              <Calendar className="w-4 h-4 text-[#233DFF]" />
              <span>Jadwal Pelajaran Kelas XII RPL 1</span>
            </h3>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            {schedules.map((sc) => (
              <div key={sc.id} className="p-5 rounded-2xl bg-[#F8FAFD] border border-slate-200/80 space-y-2">
                <div className="flex justify-between items-start">
                  <span className="text-xs font-extrabold text-[#233DFF] bg-[#E5ECFF] px-2.5 py-0.5 rounded-full">
                    {sc.day} &bull; {sc.time}
                  </span>
                  <span className="text-xs font-bold text-slate-500">{sc.room}</span>
                </div>
                <h4 className="text-sm font-black text-slate-900">{sc.subject}</h4>
                <p className="text-xs text-slate-500 font-medium">Pengajar: {sc.teacher}</p>
              </div>
            ))}
          </div>
        </div>
      )}

      {activeTab === 'tasks' && (
        <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-4">
          <div className="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 className="text-sm font-extrabold text-[#171B61] flex items-center gap-2">
              <BookOpen className="w-4 h-4 text-[#233DFF]" />
              <span>Tugas &amp; Lembar Kerja Siswa</span>
            </h3>
          </div>

          <div className="space-y-3">
            {tasks.map((tk) => (
              <div key={tk.id} className="p-4 rounded-2xl bg-white border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                  <span className="text-[10px] font-bold text-[#233DFF] uppercase bg-[#E5ECFF] px-2 py-0.5 rounded-md">
                    {tk.subject}
                  </span>
                  <h4 className="text-xs sm:text-sm font-extrabold text-slate-900 mt-1">{tk.title}</h4>
                  <p className="text-xs text-slate-400 mt-0.5">Batas Pengumpulan: {tk.deadline}</p>
                </div>
                <div className="flex items-center gap-3 shrink-0">
                  <span className="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                    {tk.status}
                  </span>
                  {tk.grade !== '-' && (
                    <span className="text-xs font-black text-slate-900 bg-slate-100 px-2.5 py-1 rounded-full">
                      Nilai: {tk.grade}
                    </span>
                  )}
                </div>
              </div>
            ))}
          </div>
        </div>
      )}

      {activeTab === 'internship' && (
        <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-6">
          <div className="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 className="text-sm font-extrabold text-[#171B61] flex items-center gap-2">
              <Briefcase className="w-4 h-4 text-[#233DFF]" />
              <span>Informasi Tempat PKL / Magang Industri</span>
            </h3>
            <span className="text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
              Status Penempatan: Aktif Berjalan
            </span>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div className="p-5 rounded-2xl bg-indigo-50/50 border border-indigo-100 space-y-3">
              <div className="flex items-center gap-3">
                <div className="w-12 h-12 rounded-2xl bg-[#233DFF] text-white flex items-center justify-center font-bold">
                  <Building2 className="w-6 h-6" />
                </div>
                <div>
                  <h4 className="text-base font-black text-slate-900">PT Telkom Indonesia</h4>
                  <p className="text-xs text-slate-500">Divisi Enterprise Network &amp; Cloud</p>
                </div>
              </div>
              <p className="text-xs text-slate-600 leading-relaxed">
                Jl. Suroyo No. 45, Kota Probolinggo &bull; Radius Geofence Presensi: 100 meter.
              </p>
            </div>

            <div className="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2 text-xs">
              <h5 className="font-extrabold text-slate-900">Pembimbing &amp; Jadwal Magang</h5>
              <p className="text-slate-600">Guru Pembimbing: <strong>Bambang Sudiro, M.Pd</strong></p>
              <p className="text-slate-600">Mentor Lapangan (DUDI): <strong>Ir. Hendra Prasetio</strong></p>
              <p className="text-slate-600">Periode Magang: <strong>01 Juli 2026 - 31 Desember 2026</strong></p>
            </div>
          </div>
        </div>
      )}

      {(activeTab === 'dashboard' || activeTab === 'attendances' || activeTab === 'exams') && (
        <div className="grid grid-cols-1 sm:grid-cols-3 gap-5">
          <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-3">
            <div className="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
              <CheckCircle2 className="w-5 h-5" />
            </div>
            <h4 className="text-2xl font-black text-slate-900">100%</h4>
            <p className="text-xs text-slate-500 font-medium">Presensi Masuk Minggu Ini</p>
          </div>
          <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-3">
            <div className="w-10 h-10 rounded-2xl bg-blue-50 text-[#233DFF] flex items-center justify-center">
              <FileCheck className="w-5 h-5" />
            </div>
            <h4 className="text-2xl font-black text-slate-900">12 / 12</h4>
            <p className="text-xs text-slate-500 font-medium">Tugas Selesai Dikumpulkan</p>
          </div>
          <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-3">
            <div className="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
              <Award className="w-5 h-5" />
            </div>
            <h4 className="text-2xl font-black text-slate-900">89.4</h4>
            <p className="text-xs text-slate-500 font-medium">Rata-rata Nilai Ulangan</p>
          </div>
        </div>
      )}
    </div>
  );
};
