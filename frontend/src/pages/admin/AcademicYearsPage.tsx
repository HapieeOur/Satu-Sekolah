import React, { useState, useEffect } from 'react';
import {
  Calendar,
  Plus,
  CheckCircle2,
  Trash2,
  X,
  Search,
  Check,
  Loader2
} from 'lucide-react';
import { adminService, AcademicYearItem } from '../../api/adminService';

export const AcademicYearsPage: React.FC = () => {
  const [academicYears, setAcademicYears] = useState<AcademicYearItem[]>([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState('');
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [submitting, setSubmitting] = useState(false);
  const [formError, setFormError] = useState<string | null>(null);

  // Form State
  const [name, setName] = useState('');
  const [semester, setSemester] = useState<'ganjil' | 'genap'>('ganjil');
  const [startDate, setStartDate] = useState('');
  const [endDate, setEndDate] = useState('');
  const [isActive, setIsActive] = useState(false);

  const fetchYears = async () => {
    setLoading(true);
    try {
      const data = await adminService.getAcademicYears();
      setAcademicYears(data);
    } catch (err: any) {
      console.error('Gagal mengambil data tahun ajaran:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchYears();
  }, []);

  const handleOpenModal = () => {
    setName('');
    setSemester('ganjil');
    setStartDate('');
    setEndDate('');
    setIsActive(false);
    setFormError(null);
    setIsModalOpen(true);
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!name.trim() || !startDate || !endDate) {
      setFormError('Nama tahun ajaran, tanggal mulai, dan tanggal selesai wajib diisi.');
      return;
    }

    setSubmitting(true);
    setFormError(null);
    try {
      await adminService.createAcademicYear({
        name,
        semester,
        start_date: startDate,
        end_date: endDate,
        is_active: isActive,
      });
      setIsModalOpen(false);
      fetchYears();
    } catch (err: any) {
      const msg = err.response?.data?.message || err.message || 'Gagal menambahkan tahun ajaran.';
      setFormError(msg);
    } finally {
      setSubmitting(false);
    }
  };

  const handleSetActive = async (id: number, yearName: string) => {
    if (!window.confirm(`Aktifkan tahun ajaran "${yearName}" sebagai periode berjalan?`)) {
      return;
    }
    try {
      await adminService.setActiveAcademicYear(id);
      fetchYears();
    } catch (err: any) {
      alert(err.response?.data?.message || 'Gagal mengaktifkan tahun ajaran.');
    }
  };

  const handleDelete = async (id: number, yearName: string) => {
    if (!window.confirm(`Yakin ingin menghapus tahun ajaran "${yearName}"?`)) {
      return;
    }
    try {
      await adminService.deleteAcademicYear(id);
      setAcademicYears((prev) => prev.filter((y) => y.id !== id));
    } catch (err: any) {
      alert(err.response?.data?.message || 'Gagal menghapus tahun ajaran.');
    }
  };

  const filteredYears = academicYears.filter(
    (y) =>
      y.name.toLowerCase().includes(search.toLowerCase()) ||
      y.semester.toLowerCase().includes(search.toLowerCase())
  );

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div className="flex items-center gap-2">
            <h1 className="text-xl sm:text-2xl font-black text-[#171B61] tracking-tight">
              Tahun Ajaran & Semester
            </h1>
            <span className="text-xs font-bold bg-[#E5ECFF] text-[#233DFF] px-2.5 py-0.5 rounded-full">
              {academicYears.length} Periode Terdaftar
            </span>
          </div>
          <p className="text-xs text-slate-500 mt-1">
            Atur kalender akademik sekolah, penetapan semester aktif, dan arsip data tahun ajaran.
          </p>
        </div>

        <button
          type="button"
          onClick={handleOpenModal}
          className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1B30D9] shadow-md shadow-indigo-600/20 transition cursor-pointer"
        >
          <Plus className="w-4 h-4" />
          <span>Tambah Tahun Ajaran</span>
        </button>
      </div>

      {/* Filter and Table Card */}
      <div className="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div className="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div className="relative max-w-sm w-full">
            <span className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
              <Search className="w-4 h-4" />
            </span>
            <input
              type="text"
              placeholder="Cari tahun ajaran atau semester..."
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF]"
            />
          </div>

          <div className="flex items-center gap-2 text-xs text-slate-500 font-medium">
            <span className="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" />
            <span>Tersinkron Database Railway</span>
          </div>
        </div>

        <div className="overflow-x-auto">
          {loading ? (
            <div className="p-12 text-center text-slate-400 flex flex-col items-center justify-center gap-2">
              <Loader2 className="w-6 h-6 animate-spin text-[#233DFF]" />
              <p className="text-xs font-medium">Memuat data tahun ajaran...</p>
            </div>
          ) : filteredYears.length === 0 ? (
            <div className="p-12 text-center text-slate-400">
              <p className="text-sm font-semibold">Belum ada tahun ajaran terdaftar.</p>
              <p className="text-xs mt-1">Gunakan tombol "Tambah Tahun Ajaran" untuk membuat baru.</p>
            </div>
          ) : (
            <table className="w-full text-left text-xs">
              <thead className="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold border-b border-slate-100">
                <tr>
                  <th className="px-6 py-4">Tahun Ajaran</th>
                  <th className="px-6 py-4">Semester</th>
                  <th className="px-6 py-4">Periode Tanggal</th>
                  <th className="px-6 py-4">Jumlah Rombel</th>
                  <th className="px-6 py-4">Status</th>
                  <th className="px-6 py-4 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100 font-medium">
                {filteredYears.map((y) => (
                  <tr key={y.id} className="hover:bg-slate-50/80 transition">
                    <td className="px-6 py-4">
                      <div className="flex items-center gap-3">
                        <div className="w-9 h-9 rounded-xl bg-blue-50 text-[#233DFF] flex items-center justify-center shrink-0">
                          <Calendar className="w-4 h-4" />
                        </div>
                        <span className="font-bold text-slate-900 text-sm">{y.name}</span>
                      </div>
                    </td>
                    <td className="px-6 py-4">
                      <span className="capitalize font-bold text-slate-700">{y.semester}</span>
                    </td>
                    <td className="px-6 py-4 text-slate-600">
                      {y.start_date || '-'} s/d {y.end_date || '-'}
                    </td>
                    <td className="px-6 py-4 font-bold text-slate-900">
                      {y.classrooms_count || 0} Kelas
                    </td>
                    <td className="px-6 py-4">
                      {y.is_active ? (
                        <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                          <CheckCircle2 className="w-3.5 h-3.5" /> Aktif (Berjalan)
                        </span>
                      ) : (
                        <span className="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-500">
                          Nonaktif
                        </span>
                      )}
                    </td>
                    <td className="px-6 py-4 text-right space-x-2">
                      {!y.is_active && (
                        <button
                          type="button"
                          onClick={() => handleSetActive(y.id, y.name)}
                          className="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 transition cursor-pointer"
                        >
                          <Check className="w-3.5 h-3.5" />
                          <span>Aktifkan</span>
                        </button>
                      )}
                      <button
                        type="button"
                        onClick={() => handleDelete(y.id, y.name)}
                        className="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer"
                        title="Hapus"
                      >
                        <Trash2 className="w-4 h-4" />
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          )}
        </div>
      </div>

      {/* Modal Tambah Tahun Ajaran */}
      {isModalOpen && (
        <div className="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            <div className="p-5 border-b border-slate-100 flex items-center justify-between">
              <div>
                <h3 className="font-bold text-slate-900 text-base">Tambah Tahun Ajaran Baru</h3>
                <p className="text-xs text-slate-500">Tentukan periode kalender akademik sekolah.</p>
              </div>
              <button
                type="button"
                onClick={() => setIsModalOpen(false)}
                className="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition"
              >
                <X className="w-5 h-5" />
              </button>
            </div>

            <form onSubmit={handleSubmit} className="p-6 space-y-4">
              {formError && (
                <div className="p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">
                  {formError}
                </div>
              )}

              <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">Nama Tahun Ajaran *</label>
                  <input
                    type="text"
                    required
                    placeholder="Contoh: 2026/2027"
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                  />
                </div>
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">Semester *</label>
                  <select
                    value={semester}
                    onChange={(e) => setSemester(e.target.value as 'ganjil' | 'genap')}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white outline-none focus:border-[#233DFF]"
                  >
                    <option value="ganjil">Ganjil</option>
                    <option value="genap">Genap</option>
                  </select>
                </div>
              </div>

              <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">Tanggal Mulai *</label>
                  <input
                    type="date"
                    required
                    value={startDate}
                    onChange={(e) => setStartDate(e.target.value)}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                  />
                </div>
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">Tanggal Selesai *</label>
                  <input
                    type="date"
                    required
                    value={endDate}
                    onChange={(e) => setEndDate(e.target.value)}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                  />
                </div>
              </div>

              <div className="flex items-center gap-2 pt-2">
                <input
                  type="checkbox"
                  id="active_year"
                  checked={isActive}
                  onChange={(e) => setIsActive(e.target.checked)}
                  className="w-4 h-4 text-[#233DFF] rounded-md border-slate-300 focus:ring-[#233DFF]"
                />
                <label htmlFor="active_year" className="text-xs font-bold text-slate-700 cursor-pointer">
                  Jadikan periode aktif sekarang
                </label>
              </div>

              <div className="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100">
                <button
                  type="button"
                  onClick={() => setIsModalOpen(false)}
                  className="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition cursor-pointer"
                >
                  Batal
                </button>
                <button
                  type="submit"
                  disabled={submitting}
                  className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1B30D9] shadow-md shadow-indigo-600/20 disabled:opacity-60 transition cursor-pointer"
                >
                  {submitting && <Loader2 className="w-3.5 h-3.5 animate-spin" />}
                  <span>{submitting ? 'Menyimpan...' : 'Simpan Tahun Ajaran'}</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};
