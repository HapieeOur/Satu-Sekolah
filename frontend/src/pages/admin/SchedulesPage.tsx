import React, { useState } from 'react';
import {
  Calendar,
  Plus,
  Search,
  Trash2,
  X,
  Clock,
  BookOpen
} from 'lucide-react';

interface ScheduleItem {
  id: number;
  day: 'Senin' | 'Selasa' | 'Rabu' | 'Kamis' | 'Jumat';
  startTime: string;
  endTime: string;
  classroom: string;
  subject: string;
  teacher: string;
  room: string;
}

export const SchedulesPage: React.FC = () => {
  const [schedules, setSchedules] = useState<ScheduleItem[]>([
    {
      id: 1,
      day: 'Senin',
      startTime: '07:30',
      endTime: '09:30',
      classroom: 'XII RPL 1',
      subject: 'Pemrograman Web & Mobile',
      teacher: 'Bambang Sudiro, M.Pd',
      room: 'Lab Komputer 2',
    },
    {
      id: 2,
      day: 'Senin',
      startTime: '10:00',
      endTime: '11:30',
      classroom: 'XI RPL 2',
      subject: 'Basis Data & SQL',
      teacher: 'Hendra Gunawan, S.Kom',
      room: 'Ruang Teori 4',
    },
    {
      id: 3,
      day: 'Selasa',
      startTime: '07:30',
      endTime: '10:30',
      classroom: 'X PPLG 1',
      subject: 'Dasar Pemrograman Web',
      teacher: 'Rudy Hartono, S.ST',
      room: 'Lab Komputer 1',
    },
    {
      id: 4,
      day: 'Rabu',
      startTime: '08:30',
      endTime: '11:00',
      classroom: 'XII RPL 1',
      subject: 'Pemodelan Perangkat Lunak',
      teacher: 'Siti Aminah, S.Pd',
      room: 'Lab Komputer 2',
    },
    {
      id: 5,
      day: 'Kamis',
      startTime: '07:30',
      endTime: '09:30',
      classroom: 'XI RPL 2',
      subject: 'Bahasa Indonesia & Literasi',
      teacher: 'Dewi Lestari, M.Pd',
      room: 'Ruang Teori 2',
    },
  ]);

  const [searchTerm, setSearchTerm] = useState('');
  const [dayFilter, setDayFilter] = useState('ALL');
  const [modalOpen, setModalOpen] = useState(false);
  const [formData, setFormData] = useState({
    day: 'Senin' as 'Senin' | 'Selasa' | 'Rabu' | 'Kamis' | 'Jumat',
    startTime: '07:30',
    endTime: '09:30',
    classroom: 'XII RPL 1',
    subject: 'Pemrograman Web & Mobile',
    teacher: 'Bambang Sudiro, M.Pd',
    room: 'Lab Komputer 2',
  });

  const handleDelete = (id: number) => {
    if (confirm('Yakin ingin menghapus sesi jadwal ini?')) {
      setSchedules((prev) => prev.filter((s) => s.id !== id));
    }
  };

  const handleCreate = (e: React.FormEvent) => {
    e.preventDefault();
    const newSchedule: ScheduleItem = {
      id: Date.now(),
      day: formData.day,
      startTime: formData.startTime,
      endTime: formData.endTime,
      classroom: formData.classroom,
      subject: formData.subject,
      teacher: formData.teacher,
      room: formData.room,
    };
    setSchedules((prev) => [newSchedule, ...prev]);
    setModalOpen(false);
  };

  const filtered = schedules.filter((s) => {
    const matchesSearch =
      s.subject.toLowerCase().includes(searchTerm.toLowerCase()) ||
      s.teacher.toLowerCase().includes(searchTerm.toLowerCase()) ||
      s.classroom.toLowerCase().includes(searchTerm.toLowerCase()) ||
      s.room.toLowerCase().includes(searchTerm.toLowerCase());
    const matchesDay = dayFilter === 'ALL' || s.day === dayFilter;
    return matchesSearch && matchesDay;
  });

  return (
    <div className="space-y-6">
      {/* Banner */}
      <div className="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#171B61] to-[#233DFF] p-6 sm:p-8 text-white shadow-xl shadow-indigo-950/10">
        <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div>
            <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-amber-300 text-xs font-bold mb-2">
              <Calendar className="w-3.5 h-3.5" />
              <span>Manajemen Waktu &amp; Sesi KBM</span>
            </div>
            <h1 className="text-2xl sm:text-3xl font-black tracking-tight">Jadwal Pelajaran Sekolah</h1>
            <p className="text-xs text-indigo-100 mt-1 max-w-xl">
              Sinkronisasi alokasi jam tatap muka, penugasan ruangan kelas, dan pemetaan guru pengajar per rombongan belajar.
            </p>
          </div>

          <button
            onClick={() => setModalOpen(true)}
            type="button"
            className="inline-flex items-center gap-2 px-5 py-3 rounded-full text-xs font-black bg-white text-[#171B61] hover:bg-amber-300 hover:text-slate-900 shadow-lg transition cursor-pointer"
          >
            <Plus className="w-4 h-4" />
            <span>Tambah Sesi Jadwal</span>
          </button>
        </div>

        {/* Stats */}
        <div className="relative z-10 grid grid-cols-2 sm:grid-cols-3 gap-3 mt-6 pt-6 border-t border-white/10">
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Total Sesi Terjadwal</span>
            <span className="text-xl font-black text-white mt-0.5 block">{schedules.length} Sesi</span>
          </div>
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Praktikum Lab Komputer</span>
            <span className="text-xl font-black text-[#F4CF52] mt-0.5 block">
              {schedules.filter((s) => s.room.includes('Lab')).length} Sesi
            </span>
          </div>
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Sesi Teori Kelas</span>
            <span className="text-xl font-black text-emerald-300 mt-0.5 block">
              {schedules.filter((s) => s.room.includes('Teori')).length} Sesi
            </span>
          </div>
        </div>
      </div>

      {/* Main Table Card */}
      <div className="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs space-y-4">
        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-3 border-b border-slate-100">
          <div className="flex items-center gap-3">
            <h3 className="text-sm font-extrabold text-[#171B61]">Jadwal Pelajaran KBM</h3>
            <select
              value={dayFilter}
              onChange={(e) => setDayFilter(e.target.value)}
              className="text-xs font-bold text-slate-700 bg-[#F8FAFD] border border-slate-200 rounded-xl px-3 py-1.5 focus:outline-none"
            >
              <option value="ALL">Semua Hari (Senin - Jumat)</option>
              <option value="Senin">Senin</option>
              <option value="Selasa">Selasa</option>
              <option value="Rabu">Rabu</option>
              <option value="Kamis">Kamis</option>
              <option value="Jumat">Jumat</option>
            </select>
          </div>

          <div className="relative max-w-xs w-full">
            <Search className="w-4 h-4 text-slate-400 absolute left-3 top-2.5 pointer-events-none" />
            <input
              type="text"
              placeholder="Cari mapel, guru, rombel..."
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
              className="w-full text-xs font-semibold pl-9 pr-3 py-2 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:border-[#233DFF] focus:outline-none transition"
            />
          </div>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-left text-xs">
            <thead className="bg-[#F8FAFD] text-slate-400 font-bold uppercase text-[10px] tracking-wider">
              <tr>
                <th className="py-3.5 px-4">Hari &amp; Jam Sesi</th>
                <th className="py-3.5 px-4">Kelas Rombel</th>
                <th className="py-3.5 px-4">Mata Pelajaran</th>
                <th className="py-3.5 px-4">Guru Pengajar</th>
                <th className="py-3.5 px-4">Ruangan</th>
                <th className="py-3.5 px-4 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium text-slate-700">
              {filtered.map((s) => (
                <tr key={s.id} className="hover:bg-slate-50 transition">
                  <td className="py-4 px-4">
                    <span className="font-extrabold text-slate-900 block">{s.day}</span>
                    <span className="text-[11px] text-slate-500 font-mono flex items-center gap-1">
                      <Clock className="w-3 h-3" />
                      {s.startTime} - {s.endTime}
                    </span>
                  </td>
                  <td className="py-4 px-4">
                    <span className="font-extrabold text-[#233DFF] bg-[#E5ECFF] px-2.5 py-1 rounded-lg">
                      {s.classroom}
                    </span>
                  </td>
                  <td className="py-4 px-4 font-bold text-slate-800">
                    <div className="flex items-center gap-1.5">
                      <BookOpen className="w-3.5 h-3.5 text-slate-400" />
                      <span>{s.subject}</span>
                    </div>
                  </td>
                  <td className="py-4 px-4 font-bold text-slate-900">{s.teacher}</td>
                  <td className="py-4 px-4 text-slate-600 font-medium">{s.room}</td>
                  <td className="py-4 px-4 text-right">
                    <button
                      type="button"
                      onClick={() => handleDelete(s.id)}
                      className="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition cursor-pointer"
                      title="Hapus"
                    >
                      <Trash2 className="w-4 h-4" />
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>

      {/* Modal Tambah Jadwal */}
      {modalOpen && (
        <div className="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
              <h3 className="text-base font-black text-slate-900">Tambah Sesi Jadwal KBM</h3>
              <button
                type="button"
                onClick={() => setModalOpen(false)}
                className="p-1 text-slate-400 hover:text-slate-700 rounded-lg cursor-pointer"
              >
                <X className="w-5 h-5" />
              </button>
            </div>

            <form onSubmit={handleCreate} className="space-y-4 text-xs font-semibold">
              <div className="grid grid-cols-3 gap-3">
                <div>
                  <label className="block text-slate-700 mb-1">Hari</label>
                  <select
                    value={formData.day}
                    onChange={(e) => setFormData({ ...formData, day: e.target.value as any })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  >
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                  </select>
                </div>
                <div>
                  <label className="block text-slate-700 mb-1">Mulai</label>
                  <input
                    type="time"
                    required
                    value={formData.startTime}
                    onChange={(e) => setFormData({ ...formData, startTime: e.target.value })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  />
                </div>
                <div>
                  <label className="block text-slate-700 mb-1">Selesai</label>
                  <input
                    type="time"
                    required
                    value={formData.endTime}
                    onChange={(e) => setFormData({ ...formData, endTime: e.target.value })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  />
                </div>
              </div>

              <div className="grid grid-cols-2 gap-3">
                <div>
                  <label className="block text-slate-700 mb-1">Kelas Rombel</label>
                  <select
                    value={formData.classroom}
                    onChange={(e) => setFormData({ ...formData, classroom: e.target.value })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  >
                    <option value="XII RPL 1">XII RPL 1</option>
                    <option value="XI RPL 2">XI RPL 2</option>
                    <option value="X PPLG 1">X PPLG 1</option>
                  </select>
                </div>
                <div>
                  <label className="block text-slate-700 mb-1">Ruangan</label>
                  <select
                    value={formData.room}
                    onChange={(e) => setFormData({ ...formData, room: e.target.value })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  >
                    <option value="Lab Komputer 1">Lab Komputer 1</option>
                    <option value="Lab Komputer 2">Lab Komputer 2</option>
                    <option value="Ruang Teori 2">Ruang Teori 2</option>
                    <option value="Ruang Teori 4">Ruang Teori 4</option>
                  </select>
                </div>
              </div>

              <div>
                <label className="block text-slate-700 mb-1">Mata Pelajaran</label>
                <input
                  type="text"
                  required
                  placeholder="Contoh: Pemrograman Web & Mobile"
                  value={formData.subject}
                  onChange={(e) => setFormData({ ...formData, subject: e.target.value })}
                  className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                />
              </div>

              <div>
                <label className="block text-slate-700 mb-1">Guru Pengajar</label>
                <input
                  type="text"
                  required
                  placeholder="Contoh: Bambang Sudiro, M.Pd"
                  value={formData.teacher}
                  onChange={(e) => setFormData({ ...formData, teacher: e.target.value })}
                  className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                />
              </div>

              <div className="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                <button
                  type="button"
                  onClick={() => setModalOpen(false)}
                  className="px-4 py-2 rounded-xl text-slate-600 hover:bg-slate-100 cursor-pointer"
                >
                  Batal
                </button>
                <button
                  type="submit"
                  className="px-5 py-2 rounded-xl bg-[#171B61] text-white hover:bg-[#233DFF] font-black cursor-pointer shadow-md"
                >
                  Simpan Jadwal
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};
