import React, { useState } from 'react';
import {
  BookOpen,
  Plus,
  Search,
  Trash2,
  X,
  Clock,
  Award
} from 'lucide-react';

interface SubjectItem {
  id: number;
  code: string;
  name: string;
  category: 'Kejuruan' | 'Umum' | 'Muatan Lokal';
  hours: number;
  leadTeacher: string;
}

export const SubjectsPage: React.FC = () => {
  const [subjects, setSubjects] = useState<SubjectItem[]>([
    {
      id: 1,
      code: 'PPLG-01',
      name: 'Pemrograman Web & Perangkat Bergerak',
      category: 'Kejuruan',
      hours: 6,
      leadTeacher: 'Bambang Sudiro, M.Pd',
    },
    {
      id: 2,
      code: 'PPLG-02',
      name: 'Basis Data & SQL Architecture',
      category: 'Kejuruan',
      hours: 4,
      leadTeacher: 'Hendra Gunawan, S.Kom',
    },
    {
      id: 3,
      code: 'PPLG-03',
      name: 'Pemodelan Perangkat Lunak & Sistem',
      category: 'Kejuruan',
      hours: 4,
      leadTeacher: 'Siti Aminah, S.Pd',
    },
    {
      id: 4,
      code: 'UMUM-01',
      name: 'Bahasa Indonesia & Komunikasi Teknis',
      category: 'Umum',
      hours: 3,
      leadTeacher: 'Dewi Lestari, M.Pd',
    },
    {
      id: 5,
      code: 'UMUM-02',
      name: 'Bahasa Inggris & Korespondensi Bisnis',
      category: 'Umum',
      hours: 3,
      leadTeacher: 'Rina Kusuma, S.Pd',
    },
  ]);

  const [searchTerm, setSearchTerm] = useState('');
  const [modalOpen, setModalOpen] = useState(false);
  const [formData, setFormData] = useState({
    code: '',
    name: '',
    category: 'Kejuruan' as 'Kejuruan' | 'Umum' | 'Muatan Lokal',
    hours: 4,
    leadTeacher: '',
  });

  const handleDelete = (id: number) => {
    if (confirm('Yakin ingin menghapus mata pelajaran ini?')) {
      setSubjects((prev) => prev.filter((s) => s.id !== id));
    }
  };

  const handleCreate = (e: React.FormEvent) => {
    e.preventDefault();
    const newSubject: SubjectItem = {
      id: Date.now(),
      code: formData.code,
      name: formData.name,
      category: formData.category,
      hours: Number(formData.hours),
      leadTeacher: formData.leadTeacher,
    };
    setSubjects((prev) => [newSubject, ...prev]);
    setModalOpen(false);
    setFormData({
      code: '',
      name: '',
      category: 'Kejuruan',
      hours: 4,
      leadTeacher: '',
    });
  };

  const filtered = subjects.filter(
    (s) =>
      s.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      s.code.toLowerCase().includes(searchTerm.toLowerCase()) ||
      s.leadTeacher.toLowerCase().includes(searchTerm.toLowerCase())
  );

  return (
    <div className="space-y-6">
      {/* Banner */}
      <div className="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#171B61] to-[#233DFF] p-6 sm:p-8 text-white shadow-xl shadow-indigo-950/10">
        <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div>
            <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-amber-300 text-xs font-bold mb-2">
              <BookOpen className="w-3.5 h-3.5" />
              <span>Kurikulum &amp; Struktur Program</span>
            </div>
            <h1 className="text-2xl sm:text-3xl font-black tracking-tight">Mata Pelajaran (Mapel)</h1>
            <p className="text-xs text-indigo-100 mt-1 max-w-xl">
              Daftar mata pelajaran kejuruan Rekayasa Perangkat Lunak, mata pelajaran umum, alokasi jam tatap muka, dan koordinator guru.
            </p>
          </div>

          <button
            onClick={() => setModalOpen(true)}
            type="button"
            className="inline-flex items-center gap-2 px-5 py-3 rounded-full text-xs font-black bg-white text-[#171B61] hover:bg-amber-300 hover:text-slate-900 shadow-lg transition cursor-pointer"
          >
            <Plus className="w-4 h-4" />
            <span>Tambah Mapel Baru</span>
          </button>
        </div>

        {/* Stats */}
        <div className="relative z-10 grid grid-cols-2 sm:grid-cols-3 gap-3 mt-6 pt-6 border-t border-white/10">
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Total Mapel Terdaftar</span>
            <span className="text-xl font-black text-white mt-0.5 block">{subjects.length} Mapel</span>
          </div>
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Mapel Kejuruan</span>
            <span className="text-xl font-black text-[#F4CF52] mt-0.5 block">
              {subjects.filter((s) => s.category === 'Kejuruan').length} Mapel
            </span>
          </div>
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Total JP Mingguan</span>
            <span className="text-xl font-black text-emerald-300 mt-0.5 block">
              {subjects.reduce((sum, s) => sum + s.hours, 0)} Jam Pelajaran
            </span>
          </div>
        </div>
      </div>

      {/* Main Table Card */}
      <div className="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs space-y-4">
        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-3 border-b border-slate-100">
          <div className="flex items-center gap-2">
            <h3 className="text-sm font-extrabold text-[#171B61]">Struktur Mata Pelajaran</h3>
            <span className="text-xs font-bold text-slate-400">({filtered.length} Mata Pelajaran)</span>
          </div>

          <div className="relative max-w-xs w-full">
            <Search className="w-4 h-4 text-slate-400 absolute left-3 top-2.5 pointer-events-none" />
            <input
              type="text"
              placeholder="Cari kode, nama, pengampu..."
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
                <th className="py-3.5 px-4">Kode &amp; Nama Mapel</th>
                <th className="py-3.5 px-4">Kategori Program</th>
                <th className="py-3.5 px-4">Beban Belajar</th>
                <th className="py-3.5 px-4">Koordinator Pendidik</th>
                <th className="py-3.5 px-4 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium text-slate-700">
              {filtered.map((s) => (
                <tr key={s.id} className="hover:bg-slate-50 transition">
                  <td className="py-4 px-4">
                    <div className="flex items-center gap-3">
                      <span className="px-2.5 py-1 rounded-lg text-xs font-mono font-black bg-[#E5ECFF] text-[#233DFF]">
                        {s.code}
                      </span>
                      <span className="font-extrabold text-slate-900 text-sm">{s.name}</span>
                    </div>
                  </td>
                  <td className="py-4 px-4">
                    <span
                      className={`inline-flex items-center px-3 py-0.5 rounded-full text-[10px] font-black ${
                        s.category === 'Kejuruan'
                          ? 'bg-indigo-50 text-[#171B61] border border-indigo-200'
                          : 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                      }`}
                    >
                      {s.category}
                    </span>
                  </td>
                  <td className="py-4 px-4 text-slate-700 font-bold">
                    <div className="flex items-center gap-1.5">
                      <Clock className="w-3.5 h-3.5 text-slate-400" />
                      <span>{s.hours} JP / Minggu</span>
                    </div>
                  </td>
                  <td className="py-4 px-4">
                    <div className="flex items-center gap-1.5 font-bold text-slate-800">
                      <Award className="w-3.5 h-3.5 text-[#233DFF]" />
                      <span>{s.leadTeacher}</span>
                    </div>
                  </td>
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

      {/* Modal Tambah Mapel */}
      {modalOpen && (
        <div className="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
              <h3 className="text-base font-black text-slate-900">Tambah Mata Pelajaran</h3>
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
                <div className="col-span-1">
                  <label className="block text-slate-700 mb-1">Kode Mapel</label>
                  <input
                    type="text"
                    required
                    placeholder="PPLG-04"
                    value={formData.code}
                    onChange={(e) => setFormData({ ...formData, code: e.target.value })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  />
                </div>
                <div className="col-span-2">
                  <label className="block text-slate-700 mb-1">Nama Mata Pelajaran</label>
                  <input
                    type="text"
                    required
                    placeholder="Contoh: Keamanan Jaringan & API"
                    value={formData.name}
                    onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  />
                </div>
              </div>

              <div className="grid grid-cols-2 gap-3">
                <div>
                  <label className="block text-slate-700 mb-1">Kategori</label>
                  <select
                    value={formData.category}
                    onChange={(e) => setFormData({ ...formData, category: e.target.value as 'Kejuruan' | 'Umum' | 'Muatan Lokal' })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  >
                    <option value="Kejuruan">Kejuruan PPLG</option>
                    <option value="Umum">Umum / Wajib</option>
                    <option value="Muatan Lokal">Muatan Lokal</option>
                  </select>
                </div>
                <div>
                  <label className="block text-slate-700 mb-1">Beban Jam (JP/Minggu)</label>
                  <input
                    type="number"
                    min="1"
                    max="10"
                    required
                    value={formData.hours}
                    onChange={(e) => setFormData({ ...formData, hours: Number(e.target.value) })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  />
                </div>
              </div>

              <div>
                <label className="block text-slate-700 mb-1">Guru Koordinator Pengampu</label>
                <input
                  type="text"
                  required
                  placeholder="Nama Guru Pengampu"
                  value={formData.leadTeacher}
                  onChange={(e) => setFormData({ ...formData, leadTeacher: e.target.value })}
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
                  Simpan Mapel
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};
