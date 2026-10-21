import React, { useState } from 'react';
import {
  Calendar,
  Plus,
  CheckCircle2,
  Clock,
  Trash2,
  X,
  Search,
  Check
} from 'lucide-react';

interface AcademicYear {
  id: number;
  name: string;
  semester: 'ganjil' | 'genap';
  startDate: string;
  endDate: string;
  isActive: boolean;
}

export const AcademicYearsPage: React.FC = () => {
  const [academicYears, setAcademicYears] = useState<AcademicYear[]>([
    {
      id: 1,
      name: '2026/2027',
      semester: 'ganjil',
      startDate: '15 Juli 2026',
      endDate: '20 Desember 2026',
      isActive: true,
    },
    {
      id: 2,
      name: '2025/2026',
      semester: 'genap',
      startDate: '05 Januari 2026',
      endDate: '25 Juni 2026',
      isActive: false,
    },
    {
      id: 3,
      name: '2025/2026',
      semester: 'ganjil',
      startDate: '14 Juli 2025',
      endDate: '19 Desember 2025',
      isActive: false,
    },
  ]);

  const [searchTerm, setSearchTerm] = useState('');
  const [modalOpen, setModalOpen] = useState(false);
  const [formData, setFormData] = useState({
    name: '2027/2028',
    semester: 'ganjil' as 'ganjil' | 'genap',
    startDate: '2027-07-15',
    endDate: '2027-12-20',
    isActive: false,
  });

  const handleSetActive = (id: number) => {
    setAcademicYears((prev) =>
      prev.map((y) => ({
        ...y,
        isActive: y.id === id,
      }))
    );
  };

  const handleDelete = (id: number) => {
    if (confirm('Yakin ingin menghapus periode tahun ajaran ini?')) {
      setAcademicYears((prev) => prev.filter((y) => y.id !== id));
    }
  };

  const handleCreate = (e: React.FormEvent) => {
    e.preventDefault();
    const newYear: AcademicYear = {
      id: Date.now(),
      name: formData.name,
      semester: formData.semester,
      startDate: formData.startDate,
      endDate: formData.endDate,
      isActive: formData.isActive,
    };
    if (formData.isActive) {
      setAcademicYears((prev) => [newYear, ...prev.map((y) => ({ ...y, isActive: false }))]);
    } else {
      setAcademicYears((prev) => [newYear, ...prev]);
    }
    setModalOpen(false);
  };

  const filtered = academicYears.filter((y) =>
    y.name.toLowerCase().includes(searchTerm.toLowerCase())
  );

  const activeYear = academicYears.find((y) => y.isActive);

  return (
    <div className="space-y-6">
      {/* Top Banner */}
      <div className="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#171B61] to-[#233DFF] p-6 sm:p-8 text-white shadow-xl shadow-indigo-950/10">
        <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div>
            <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-amber-300 text-xs font-bold mb-2">
              <Calendar className="w-3.5 h-3.5" />
              <span>Kalender &amp; Periode Akademik</span>
            </div>
            <h1 className="text-2xl sm:text-3xl font-black tracking-tight">Tahun Ajaran &amp; Semester</h1>
            <p className="text-xs text-indigo-100 mt-1 max-w-xl">
              Atur kalender belajar mengajar, aktifkan semester berjalan, dan sinkronisasi seluruh presensi serta pelaporan nilai.
            </p>
          </div>

          <button
            onClick={() => setModalOpen(true)}
            type="button"
            className="inline-flex items-center gap-2 px-5 py-3 rounded-full text-xs font-black bg-white text-[#171B61] hover:bg-amber-300 hover:text-slate-900 shadow-lg transition cursor-pointer"
          >
            <Plus className="w-4 h-4" />
            <span>Tambah Tahun Ajaran</span>
          </button>
        </div>

        {/* Bento Stats Sub-row */}
        <div className="relative z-10 grid grid-cols-2 sm:grid-cols-3 gap-3 mt-6 pt-6 border-t border-white/10">
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Total Periode Tercatat</span>
            <span className="text-xl font-black text-white mt-0.5 block">{academicYears.length} Periode</span>
          </div>
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Periode Aktif Saat Ini</span>
            <span className="text-xl font-black text-[#F4CF52] mt-0.5 block">
              {activeYear ? activeYear.name : 'Belum Ada'}
            </span>
          </div>
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Semester Aktif</span>
            <span className="text-xl font-black text-white mt-0.5 block capitalize">
              {activeYear ? activeYear.semester : '-'}
            </span>
          </div>
        </div>
      </div>

      {/* Main Table Card */}
      <div className="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs space-y-4">
        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-3 border-b border-slate-100">
          <div className="flex items-center gap-2">
            <h3 className="text-sm font-extrabold text-[#171B61]">Daftar Periode Akademik</h3>
            <span className="text-xs font-bold text-slate-400">({filtered.length} Periode)</span>
          </div>

          <div className="relative max-w-xs w-full">
            <Search className="w-4 h-4 text-slate-400 absolute left-3 top-2.5 pointer-events-none" />
            <input
              type="text"
              placeholder="Cari tahun ajaran..."
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
                <th className="py-3.5 px-4">Tahun Ajaran</th>
                <th className="py-3.5 px-4">Semester</th>
                <th className="py-3.5 px-4">Rentang Periode Tanggal</th>
                <th className="py-3.5 px-4">Status KBM</th>
                <th className="py-3.5 px-4 text-right">Aksi &amp; Kontrol</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium text-slate-700">
              {filtered.map((year) => (
                <tr key={year.id} className={`hover:bg-slate-50 transition ${year.isActive ? 'bg-blue-50/20' : ''}`}>
                  <td className="py-4 px-4">
                    <div className="flex items-center gap-3">
                      <div
                        className={`w-10 h-10 rounded-xl font-black flex items-center justify-center text-xs shadow-xs shrink-0 ${
                          year.isActive ? 'bg-[#233DFF] text-white' : 'bg-slate-100 text-slate-700'
                        }`}
                      >
                        {year.name.substring(2, 4)}
                      </div>
                      <div>
                        <div className="font-extrabold text-slate-900 text-sm flex items-center gap-2">
                          <span>{year.name}</span>
                          {year.isActive && (
                            <span className="px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200">
                              SEDANG BERJALAN
                            </span>
                          )}
                        </div>
                      </div>
                    </div>
                  </td>
                  <td className="py-4 px-4 font-bold capitalize text-slate-800">
                    Semester {year.semester}
                  </td>
                  <td className="py-4 px-4 text-slate-600 font-medium">
                    <div className="flex items-center gap-1.5">
                      <Clock className="w-3.5 h-3.5 text-slate-400" />
                      <span>{year.startDate} &mdash; {year.endDate}</span>
                    </div>
                  </td>
                  <td className="py-4 px-4">
                    {year.isActive ? (
                      <span className="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-black bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <CheckCircle2 className="w-3.5 h-3.5" />
                        Aktif
                      </span>
                    ) : (
                      <span className="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500">
                        Arsip
                      </span>
                    )}
                  </td>
                  <td className="py-4 px-4 text-right">
                    <div className="flex items-center justify-end gap-2">
                      {!year.isActive && (
                        <button
                          type="button"
                          onClick={() => handleSetActive(year.id)}
                          className="px-3 py-1.5 rounded-full text-xs font-black text-[#233DFF] bg-[#E5ECFF] hover:bg-blue-200 transition cursor-pointer flex items-center gap-1"
                        >
                          <Check className="w-3.5 h-3.5" />
                          <span>Aktifkan</span>
                        </button>
                      )}
                      <button
                        type="button"
                        onClick={() => handleDelete(year.id)}
                        className="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition cursor-pointer"
                        title="Hapus"
                      >
                        <Trash2 className="w-4 h-4" />
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>

      {/* Create Modal */}
      {modalOpen && (
        <div className="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
              <h3 className="text-base font-black text-slate-900">Tambah Tahun Ajaran Baru</h3>
              <button
                type="button"
                onClick={() => setModalOpen(false)}
                className="p-1 text-slate-400 hover:text-slate-700 rounded-lg cursor-pointer"
              >
                <X className="w-5 h-5" />
              </button>
            </div>

            <form onSubmit={handleCreate} className="space-y-4 text-xs font-semibold">
              <div>
                <label className="block text-slate-700 mb-1">Tahun Ajaran (Contoh: 2027/2028)</label>
                <input
                  type="text"
                  required
                  value={formData.name}
                  onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                  className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                />
              </div>

              <div>
                <label className="block text-slate-700 mb-1">Semester</label>
                <select
                  value={formData.semester}
                  onChange={(e) => setFormData({ ...formData, semester: e.target.value as 'ganjil' | 'genap' })}
                  className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                >
                  <option value="ganjil">Semester Ganjil</option>
                  <option value="genap">Semester Genap</option>
                </select>
              </div>

              <div className="grid grid-cols-2 gap-3">
                <div>
                  <label className="block text-slate-700 mb-1">Tanggal Mulai</label>
                  <input
                    type="date"
                    required
                    value={formData.startDate}
                    onChange={(e) => setFormData({ ...formData, startDate: e.target.value })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  />
                </div>
                <div>
                  <label className="block text-slate-700 mb-1">Tanggal Selesai</label>
                  <input
                    type="date"
                    required
                    value={formData.endDate}
                    onChange={(e) => setFormData({ ...formData, endDate: e.target.value })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  />
                </div>
              </div>

              <div className="flex items-center gap-2 pt-1">
                <input
                  type="checkbox"
                  id="isActiveCheck"
                  checked={formData.isActive}
                  onChange={(e) => setFormData({ ...formData, isActive: e.target.checked })}
                  className="rounded text-[#233DFF] focus:ring-0"
                />
                <label htmlFor="isActiveCheck" className="text-slate-700 cursor-pointer">
                  Jadikan periode aktif sekarang
                </label>
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
                  Simpan Periode
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};
