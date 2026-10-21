import React, { useState, useEffect } from 'react';
import { Search, Plus, Trash2, X, Loader2 } from 'lucide-react';
import { adminService, ClassroomItem, TeacherItem, AcademicYearItem } from '../../api/adminService';

export const ClassroomsPage: React.FC = () => {
  const [classrooms, setClassrooms] = useState<ClassroomItem[]>([]);
  const [academicYears, setAcademicYears] = useState<AcademicYearItem[]>([]);
  const [teachers, setTeachers] = useState<TeacherItem[]>([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState('');
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [submitting, setSubmitting] = useState(false);
  const [formError, setFormError] = useState<string | null>(null);

  // Form State
  const [name, setName] = useState('');
  const [gradeLevel, setGradeLevel] = useState<number>(10);
  const [major, setMajor] = useState('');
  const [academicYearId, setAcademicYearId] = useState<string>('');
  const [teacherId, setTeacherId] = useState<string>('');

  const fetchData = async () => {
    setLoading(true);
    try {
      const [cData, yData, tData] = await Promise.all([
        adminService.getClassrooms(),
        adminService.getAcademicYears().catch(() => []),
        adminService.getTeachers().catch(() => []),
      ]);
      setClassrooms(cData);
      setAcademicYears(yData);
      setTeachers(tData);
    } catch (err: any) {
      console.error('Gagal mengambil data rombel:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchData();
  }, []);

  const handleOpenModal = () => {
    setName('');
    setGradeLevel(10);
    setMajor('RPL');
    const activeY = academicYears.find((y) => y.is_active);
    setAcademicYearId(activeY ? activeY.id.toString() : '');
    setTeacherId('');
    setFormError(null);
    setIsModalOpen(true);
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!name.trim() || !major.trim()) {
      setFormError('Nama kelas dan jurusan wajib diisi.');
      return;
    }

    setSubmitting(true);
    setFormError(null);
    try {
      await adminService.createClassroom({
        name,
        grade_level: gradeLevel,
        major,
        academic_year_id: academicYearId ? parseInt(academicYearId) : null,
        teacher_id: teacherId ? parseInt(teacherId) : null,
      });
      setIsModalOpen(false);
      fetchData();
    } catch (err: any) {
      const msg = err.response?.data?.message || err.message || 'Gagal menambahkan rombel.';
      setFormError(msg);
    } finally {
      setSubmitting(false);
    }
  };

  const handleDelete = async (id: number, className: string) => {
    if (!window.confirm(`Yakin ingin menghapus rombel "${className}" dari database?`)) {
      return;
    }
    try {
      await adminService.deleteClassroom(id);
      setClassrooms((prev) => prev.filter((c) => c.id !== id));
    } catch (err: any) {
      alert(err.response?.data?.message || 'Gagal menghapus rombel.');
    }
  };

  const filtered = classrooms.filter(
    (c) =>
      c.name.toLowerCase().includes(search.toLowerCase()) ||
      c.walas_name.toLowerCase().includes(search.toLowerCase()) ||
      c.major.toLowerCase().includes(search.toLowerCase())
  );

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div className="flex items-center gap-2">
            <h1 className="text-xl sm:text-2xl font-black text-[#171B61] tracking-tight">
              Data Rombongan Belajar (Kelas)
            </h1>
            <span className="text-xs font-bold bg-[#E5ECFF] text-[#233DFF] px-2.5 py-0.5 rounded-full">
              {classrooms.length} Rombel Terdaftar
            </span>
          </div>
          <p className="text-xs text-slate-500 mt-1">
            Daftar ruang kelas aktif dan penetapan wali kelas (khusus guru yang memiliki peran <strong>Wali Kelas</strong>).
          </p>
        </div>

        <div className="flex items-center gap-2.5">
          <button
            type="button"
            onClick={handleOpenModal}
            className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1B30D9] shadow-md shadow-indigo-600/20 transition cursor-pointer"
          >
            <Plus className="w-4 h-4" />
            <span>Tambah Rombel</span>
          </button>
        </div>
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
              placeholder="Cari nama rombel atau wali kelas..."
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
              <p className="text-xs font-medium">Memuat data rombel dari database...</p>
            </div>
          ) : filtered.length === 0 ? (
            <div className="p-12 text-center text-slate-400">
              <p className="text-sm font-semibold">Belum ada rombongan belajar di database.</p>
              <p className="text-xs mt-1">Gunakan tombol "Tambah Rombel" untuk mendaftarkan kelas baru.</p>
            </div>
          ) : (
            <table className="w-full text-left text-xs">
              <thead className="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold border-b border-slate-100">
                <tr>
                  <th className="px-6 py-4">Nama Rombel</th>
                  <th className="px-6 py-4">Tingkat & Jurusan</th>
                  <th className="px-6 py-4">Wali Kelas</th>
                  <th className="px-6 py-4">Tahun Ajaran</th>
                  <th className="px-6 py-4">Jumlah Siswa</th>
                  <th className="px-6 py-4 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100 font-medium">
                {filtered.map((c) => (
                  <tr key={c.id} className="hover:bg-slate-50/80 transition">
                    <td className="px-6 py-4 font-bold text-slate-900 text-sm">
                      {c.name}
                    </td>
                    <td className="px-6 py-4">
                      <span className="px-2.5 py-1 bg-indigo-50 text-[#233DFF] rounded-lg font-bold text-[11px]">
                        Kelas {c.grade_level} - {c.major}
                      </span>
                    </td>
                    <td className="px-6 py-4">
                      <div>
                        <span className="font-bold text-slate-800 block">{c.walas_name}</span>
                        {c.walas_nip && c.walas_nip !== '-' && (
                          <span className="text-[10px] text-slate-400 font-mono">NIP: {c.walas_nip}</span>
                        )}
                      </div>
                    </td>
                    <td className="px-6 py-4 text-slate-600 font-medium">
                      {c.academic_year_name}
                    </td>
                    <td className="px-6 py-4">
                      <span className="font-bold text-slate-900">{c.students_count} Siswa</span>
                    </td>
                    <td className="px-6 py-4 text-right">
                      <button
                        type="button"
                        onClick={() => handleDelete(c.id, c.name)}
                        className="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer"
                        title="Hapus Rombel"
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

      {/* Modal Tambah Rombel */}
      {isModalOpen && (
        <div className="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            <div className="p-5 border-b border-slate-100 flex items-center justify-between">
              <div>
                <h3 className="font-bold text-slate-900 text-base">Tambah Rombel (Kelas) Baru</h3>
                <p className="text-xs text-slate-500">Buat kelas baru dan tetapkan wali kelas.</p>
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

              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1">Nama Rombel / Kelas *</label>
                <input
                  type="text"
                  required
                  placeholder="Contoh: XII RPL 1"
                  value={name}
                  onChange={(e) => setName(e.target.value)}
                  className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                />
              </div>

              <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">Tingkat Kelas</label>
                  <select
                    value={gradeLevel}
                    onChange={(e) => setGradeLevel(parseInt(e.target.value))}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white outline-none focus:border-[#233DFF]"
                  >
                    <option value={10}>Kelas 10 (Fase E)</option>
                    <option value={11}>Kelas 11 (Fase F)</option>
                    <option value={12}>Kelas 12 (Fase F)</option>
                  </select>
                </div>
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">Kompetensi Keahlian (Jurusan) *</label>
                  <input
                    type="text"
                    required
                    placeholder="Contoh: RPL, TKJ, AKL"
                    value={major}
                    onChange={(e) => setMajor(e.target.value)}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                  />
                </div>
              </div>

              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1">Tahun Ajaran</label>
                <select
                  value={academicYearId}
                  onChange={(e) => setAcademicYearId(e.target.value)}
                  className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white outline-none focus:border-[#233DFF]"
                >
                  <option value="">Tahun Ajaran Aktif (Otomatis)</option>
                  {academicYears.map((y) => (
                    <option key={y.id} value={y.id}>
                      {y.name} ({y.semester}) {y.is_active ? '• [Aktif]' : ''}
                    </option>
                  ))}
                </select>
              </div>

              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1">Wali Kelas</label>
                <select
                  value={teacherId}
                  onChange={(e) => setTeacherId(e.target.value)}
                  className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white outline-none focus:border-[#233DFF]"
                >
                  <option value="">Pilih Wali Kelas (Opsional)</option>
                  {teachers.map((t) => (
                    <option key={t.id} value={t.id}>
                      {t.name} {t.nip ? `(NIP: ${t.nip})` : ''}
                    </option>
                  ))}
                </select>
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
                  <span>{submitting ? 'Menyimpan...' : 'Simpan Rombel'}</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};
