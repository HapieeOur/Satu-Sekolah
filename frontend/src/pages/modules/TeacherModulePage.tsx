import React, { useState } from 'react';
import { useLocation } from 'react-router-dom';
import {
  Calendar,
  CheckCircle2,
  Clock,
  PlusCircle,
  Award,
  BookOpen,
  FileText
} from 'lucide-react';
import { useAuth } from '../../context/AuthContext';

export const TeacherModulePage: React.FC = () => {
  const { user } = useAuth();
  const location = useLocation();

  // Determine active tab from URL path
  const getTabFromPath = () => {
    if (location.pathname.includes('attendances')) return 'attendances';
    if (location.pathname.includes('tasks')) return 'tasks';
    if (location.pathname.includes('exams')) return 'exams';
    if (location.pathname.includes('grades')) return 'grades';
    return 'schedules';
  };

  const [activeTab, setActiveTab] = useState<'schedules' | 'attendances' | 'tasks' | 'exams' | 'grades'>(
    getTabFromPath
  );

  const schedules = [
    { id: 1, day: 'Senin', time: '07:30 - 09:30', class: 'XII RPL 1', subject: 'Pemrograman Web & Mobile', room: 'Lab Komputer 2', status: 'Selesai' },
    { id: 2, day: 'Senin', time: '10:00 - 11:30', class: 'XI RPL 2', subject: 'Basis Data & SQL', room: 'Ruang Teori 4', status: 'Selesai' },
    { id: 3, day: 'Selasa', time: '07:30 - 10:30', class: 'X PPLG 1', subject: 'Dasar Pemrograman Web', room: 'Lab Komputer 1', status: 'Aktif' },
    { id: 4, day: 'Rabu', time: '08:30 - 11:00', class: 'XII RPL 2', subject: 'Framework Laravel & React', room: 'Lab Komputer 2', status: 'Mendatang' },
    { id: 5, day: 'Kamis', time: '09:00 - 11:30', class: 'XI RPL 1', subject: 'Pemodelan Perangkat Lunak', room: 'Ruang Teori 3', status: 'Mendatang' },
  ];

  const tasks = [
    { id: 1, title: 'Tugas 01: Desain ERD Database Sekolah', class: 'XI RPL 2', deadline: '25 Okt 2026', submitted: '28/30 Siswa', status: 'Aktif' },
    { id: 2, title: 'Tugas 02: RESTful API Controller CRUD', class: 'XII RPL 1', deadline: '27 Okt 2026', submitted: '31/32 Siswa', status: 'Aktif' },
    { id: 3, title: 'Tugas 03: Logika Algoritma Pseudocode', class: 'X PPLG 1', deadline: '22 Okt 2026', submitted: '36/36 Siswa', status: 'Selesai' },
  ];

  const exams = [
    { id: 1, name: 'Ulangan Harian 1: Query SQL Kompleks', class: 'XI RPL 2', date: '29 Okt 2026', duration: '60 Menit', status: 'Terjadwal' },
    { id: 2, name: 'PTS Ganjil: Pemrograman Web & Mobile', class: 'XII RPL 1', date: '02 Nov 2026', duration: '90 Menit', status: 'Draft' },
  ];

  const grades = [
    { id: 1, student: 'Ahmad Fauzan', nisn: '0051234561', class: 'XII RPL 1', uh1: 88, uh2: 92, tugas: 90, pts: 89, final: 90 },
    { id: 2, student: 'Budi Santoso', nisn: '0051234562', class: 'XII RPL 1', uh1: 82, uh2: 85, tugas: 88, pts: 84, final: 85 },
    { id: 3, student: 'Citra Kirana', nisn: '0051234563', class: 'XII RPL 1', uh1: 95, uh2: 94, tugas: 96, pts: 95, final: 95 },
    { id: 4, student: 'Dewi Lestari', nisn: '0051234564', class: 'XII RPL 1', uh1: 78, uh2: 80, tugas: 82, pts: 80, final: 80 },
  ];

  return (
    <div className="space-y-6">
      {/* Top Banner */}
      <div className="rounded-3xl bg-gradient-to-r from-[#171B61] to-[#2F3DB6] p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/10 text-amber-300 mb-2">
            <Award className="w-3.5 h-3.5" />
            <span>Portal Kegiatan Akademik Pendidik</span>
          </div>
          <h1 className="text-2xl sm:text-3xl font-black tracking-tight">Portal Guru &amp; Mengajar</h1>
          <p className="text-xs text-indigo-100 mt-1 max-w-xl">
            Guru Pengajar: <strong>{user?.name}</strong> &bull; NIP: {user?.teacher?.nip || '198507202010011005'}
          </p>
        </div>

        <div className="flex items-center gap-2">
          <button
            type="button"
            className="inline-flex items-center gap-2 px-4 py-2.5 rounded-full text-xs font-extrabold bg-[#233DFF] hover:bg-[#1B30D9] text-white shadow-lg transition cursor-pointer"
          >
            <PlusCircle className="w-4 h-4" />
            <span>Buat Agenda / Tugas Baru</span>
          </button>
        </div>
      </div>

      {/* Navigation Tabs */}
      <div className="flex items-center gap-2 overflow-x-auto pb-2 border-b border-slate-200">
        <button
          onClick={() => setActiveTab('schedules')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'schedules'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Jadwal Mengajar
        </button>
        <button
          onClick={() => setActiveTab('attendances')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'attendances'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Presensi Siswa Mapel
        </button>
        <button
          onClick={() => setActiveTab('tasks')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'tasks'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Tugas &amp; Penugasan
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
          onClick={() => setActiveTab('grades')}
          className={`px-4 py-2 rounded-xl text-xs font-black transition cursor-pointer ${
            activeTab === 'grades'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Input &amp; Rekap Nilai
        </button>
      </div>

      {/* Content depending on Active Tab */}
      {activeTab === 'schedules' && (
        <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-4">
          <div className="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 className="text-sm font-extrabold text-[#171B61] flex items-center gap-2">
              <Calendar className="w-4 h-4 text-[#233DFF]" />
              <span>Jadwal Pelajaran Mengajar Semester Ganjil 2026/2027</span>
            </h3>
            <span className="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
              Total {schedules.length} Sesi Terjadwal
            </span>
          </div>

          <div className="overflow-x-auto">
            <table className="w-full text-left text-xs">
              <thead className="bg-[#F8FAFD] text-slate-400 font-bold uppercase text-[10px] tracking-wider">
                <tr>
                  <th className="py-3 px-4">Hari &amp; Waktu</th>
                  <th className="py-3 px-4">Kelas Rombel</th>
                  <th className="py-3 px-4">Mata Pelajaran</th>
                  <th className="py-3 px-4">Ruangan</th>
                  <th className="py-3 px-4">Status Sesi</th>
                  <th className="py-3 px-4 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100 font-medium text-slate-700">
                {schedules.map((item) => (
                  <tr key={item.id} className="hover:bg-slate-50/80 transition">
                    <td className="py-4 px-4">
                      <span className="font-bold text-slate-900 block">{item.day}</span>
                      <span className="text-[11px] text-slate-500 font-mono flex items-center gap-1">
                        <Clock className="w-3 h-3" />
                        {item.time}
                      </span>
                    </td>
                    <td className="py-4 px-4 font-bold text-[#171B61]">{item.class}</td>
                    <td className="py-4 px-4 font-semibold text-slate-800">{item.subject}</td>
                    <td className="py-4 px-4 text-slate-600">{item.room}</td>
                    <td className="py-4 px-4">
                      <span
                        className={`inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold ${
                          item.status === 'Aktif'
                            ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                            : 'bg-slate-100 text-slate-600'
                        }`}
                      >
                        {item.status}
                      </span>
                    </td>
                    <td className="py-4 px-4 text-right">
                      <button
                        type="button"
                        className="px-3 py-1.5 rounded-full text-xs font-bold text-[#233DFF] bg-[#E5ECFF] hover:bg-blue-200 transition cursor-pointer"
                      >
                        Isi Presensi
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}

      {activeTab === 'attendances' && (
        <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-4">
          <div className="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 className="text-sm font-extrabold text-[#171B61] flex items-center gap-2">
              <CheckCircle2 className="w-4 h-4 text-[#233DFF]" />
              <span>Presensi Siswa Mata Pelajaran Hari Ini</span>
            </h3>
            <span className="text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
              XII RPL 1 &bull; 32 Siswa
            </span>
          </div>

          <div className="overflow-x-auto">
            <table className="w-full text-left text-xs">
              <thead className="bg-[#F8FAFD] text-slate-400 font-bold uppercase text-[10px] tracking-wider">
                <tr>
                  <th className="py-3 px-4">Nama Siswa</th>
                  <th className="py-3 px-4">NISN</th>
                  <th className="py-3 px-4">Waktu Presensi</th>
                  <th className="py-3 px-4">Status Kehadiran</th>
                  <th className="py-3 px-4">Catatan Guru</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100 font-medium text-slate-700">
                {grades.map((st) => (
                  <tr key={st.id} className="hover:bg-slate-50/80 transition">
                    <td className="py-4 px-4 font-bold text-slate-900">{st.student}</td>
                    <td className="py-4 px-4 font-mono text-slate-500">{st.nisn}</td>
                    <td className="py-4 px-4 font-mono font-bold text-slate-700">07:05 WIB</td>
                    <td className="py-4 px-4">
                      <span className="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <CheckCircle2 className="w-3 h-3" />
                        Hadir
                      </span>
                    </td>
                    <td className="py-4 px-4 text-slate-500 text-xs">Tepat waktu &amp; aktif berpartisipasi</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}

      {activeTab === 'tasks' && (
        <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-4">
          <div className="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 className="text-sm font-extrabold text-[#171B61] flex items-center gap-2">
              <FileText className="w-4 h-4 text-[#233DFF]" />
              <span>Daftar Tugas &amp; Proyek Siswa</span>
            </h3>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
            {tasks.map((tsk) => (
              <div key={tsk.id} className="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs space-y-3">
                <span className="text-[10px] font-bold uppercase tracking-wider text-[#233DFF] bg-[#E5ECFF] px-2.5 py-0.5 rounded-full">
                  {tsk.class}
                </span>
                <h4 className="text-sm font-extrabold text-slate-900">{tsk.title}</h4>
                <div className="text-xs text-slate-500 space-y-1">
                  <p>Tenggat Waktu: <strong className="text-slate-800">{tsk.deadline}</strong></p>
                  <p>Terkumpul: <strong className="text-emerald-600">{tsk.submitted}</strong></p>
                </div>
                <div className="pt-2 border-t border-slate-100 flex justify-between items-center text-xs">
                  <span className="font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                    {tsk.status}
                  </span>
                  <button type="button" className="text-[#233DFF] font-extrabold hover:underline">
                    Periksa Jawaban &rarr;
                  </button>
                </div>
              </div>
            ))}
          </div>
        </div>
      )}

      {activeTab === 'exams' && (
        <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-4">
          <div className="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 className="text-sm font-extrabold text-[#171B61] flex items-center gap-2">
              <BookOpen className="w-4 h-4 text-[#233DFF]" />
              <span>Bank Soal &amp; Jadwal Ujian Harian</span>
            </h3>
          </div>

          <div className="space-y-3">
            {exams.map((ex) => (
              <div key={ex.id} className="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                <div>
                  <span className="text-[10px] font-bold text-[#233DFF] uppercase bg-[#E5ECFF] px-2 py-0.5 rounded-md mr-2">
                    {ex.class}
                  </span>
                  <strong className="text-xs font-extrabold text-slate-800">{ex.name}</strong>
                  <p className="text-[11px] text-slate-500 mt-0.5">Tanggal: {ex.date} &bull; Durasi: {ex.duration}</p>
                </div>
                <button
                  type="button"
                  className="px-3.5 py-1.5 rounded-full text-xs font-bold text-white bg-[#171B61] hover:bg-[#233DFF] transition"
                >
                  Kelola Soal
                </button>
              </div>
            ))}
          </div>
        </div>
      )}

      {activeTab === 'grades' && (
        <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-4">
          <div className="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 className="text-sm font-extrabold text-[#171B61] flex items-center gap-2">
              <Award className="w-4 h-4 text-[#233DFF]" />
              <span>Rekapitulasi Buku Nilai Siswa (XII RPL 1)</span>
            </h3>
            <button
              type="button"
              className="px-3 py-1.5 rounded-full text-xs font-bold text-[#233DFF] bg-[#E5ECFF] hover:bg-blue-200 transition"
            >
              Export Excel / PDF
            </button>
          </div>

          <div className="overflow-x-auto">
            <table className="w-full text-left text-xs">
              <thead className="bg-[#F8FAFD] text-slate-400 font-bold uppercase text-[10px] tracking-wider">
                <tr>
                  <th className="py-3 px-4">Nama Siswa</th>
                  <th className="py-3 px-4">NISN</th>
                  <th className="py-3 px-4 text-center">UH 1</th>
                  <th className="py-3 px-4 text-center">UH 2</th>
                  <th className="py-3 px-4 text-center">Tugas</th>
                  <th className="py-3 px-4 text-center">PTS</th>
                  <th className="py-3 px-4 text-center font-black text-slate-900">Nilai Akhir</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100 font-medium text-slate-700">
                {grades.map((g) => (
                  <tr key={g.id} className="hover:bg-slate-50/80 transition">
                    <td className="py-4 px-4 font-bold text-slate-900">{g.student}</td>
                    <td className="py-4 px-4 font-mono text-slate-500">{g.nisn}</td>
                    <td className="py-4 px-4 text-center font-bold text-slate-700">{g.uh1}</td>
                    <td className="py-4 px-4 text-center font-bold text-slate-700">{g.uh2}</td>
                    <td className="py-4 px-4 text-center font-bold text-slate-700">{g.tugas}</td>
                    <td className="py-4 px-4 text-center font-bold text-slate-700">{g.pts}</td>
                    <td className="py-4 px-4 text-center font-black text-[#233DFF] bg-blue-50/40">{g.final}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}
    </div>
  );
};
