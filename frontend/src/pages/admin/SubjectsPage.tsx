import React, { useState, useEffect } from 'react';
import {
  Search,
  Plus,
  BookOpen,
  Trash2,
  X,
  Loader2
} from 'lucide-react';
import { adminService, SubjectItem, TeacherItem } from '../../api/adminService';

export const SubjectsPage: React.FC = () => {
  const [subjects, setSubjects] = useState<SubjectItem[]>([]);
  const [teachers, setTeachers] = useState<TeacherItem[]>([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState('');
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [submitting, setSubmitting] = useState(false);
  const [formError, setFormError] = useState<string | null>(null);

  // Form State
  const [code, setCode] = useState('');
  const [name, setName] = useState('');
  const [description, setDescription] = useState('');
  const [selectedTeacherIds, setSelectedTeacherIds] = useState<number[]>([]);

  const fetchData = async () => {
    setLoading(true);
    try {
      const [sData, tData] = await Promise.all([
        adminService.getSubjects(),
        adminService.getTeachers().catch(() => []),
      ]);
      setSubjects(sData);
      setTeachers(tData);
    } catch (err: any) {
      console.error('Gagal mengambil data mata pelajaran:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchData();
  }, []);

  const handleOpenModal = () => {
    setCode('');
    setName('');
    setDescription('');
    setSelectedTeacherIds([]);
    setFormError(null);
    setIsModalOpen(true);
  };

  const handleTeacherToggle = (id: number) => {
    if (selectedTeacherIds.includes(id)) {
      setSelectedTeacherIds(selectedTeacherIds.filter((item) => item !== id));
    } else {
      setSelectedTeacherIds([...selectedTeacherIds, id]);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!code.trim() || !name.trim()) {
      setFormError('Kode mapel dan nama mapel wajib diisi.');
      return;
    }

    setSubmitting(true);
    setFormError(null);
    try {
      await adminService.createSubject({
        code,
        name,
        description: description || undefined,
        teacher_ids: selectedTeacherIds,
      });
      setIsModalOpen(false);
      fetchData();
    } catch (err: any) {
      const msg = err.response?.data?.message || err.message || 'Gagal menambahkan mata pelajaran.';
      setFormError(msg);
    } finally {
      setSubmitting(false);
    }
  };

  const handleDelete = async (id: number, subName: string) => {
    if (!window.confirm(`Yakin ingin menghapus mata pelajaran "${subName}" dari database?`)) {
      return;
    }
    try {
      await adminService.deleteSubject(id);
      setSubjects((prev) => prev.filter((s) => s.id !== id));
    } catch (err: any) {
      alert(err.response?.data?.message || 'Gagal menghapus mata pelajaran.');
    }
  };

  const filtered = subjects.filter(
    (s) =>
      s.name.toLowerCase().includes(search.toLowerCase()) ||
      s.code.toLowerCase().includes(search.toLowerCase())
  );

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div className="flex items-center gap-2">
            <h1 className="text-xl sm:text-2xl font-black text-[#171B61] tracking-tight">
              Mata Pelajaran
            </h1>
            <span className="text-xs font-bold bg-[#E5ECFF] text-[#233DFF] px-2.5 py-0.5 rounded-full">
              {subjects.length} Mapel Terdaftar
            </span>
          </div>
          <p className="text-xs text-slate-500 mt-1">
            Daftar kurikulum mata pelajaran sekolah kejuruan dan penugasan guru pengajar.
          </p>
        </div>

        <button
          type="button"
          onClick={handleOpenModal}
          className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1B30D9] shadow-md shadow-indigo-600/20 transition cursor-pointer"
        >
          <Plus className="w-4 h-4" />
          <span>Tambah Mata Pelajaran</span>
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
              placeholder="Cari kode atau nama mata pelajaran..."
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
              <p className="text-xs font-medium">Memuat data mata pelajaran...</p>
            </div>
          ) : filtered.length === 0 ? (
            <div className="p-12 text-center text-slate-400">
              <p className="text-sm font-semibold">Belum ada mata pelajaran terdaftar.</p>
              <p className="text-xs mt-1">Gunakan tombol "Tambah Mata Pelajaran" untuk mendaftarkan mapel baru.</p>
            </div>
          ) : (
            <table className="w-full text-left text-xs">
              <thead className="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold border-b border-slate-100">
                <tr>
                  <th className="px-6 py-4">Kode & Mata Pelajaran</th>
                  <th className="px-6 py-4">Deskripsi</th>
                  <th className="px-6 py-4">Guru Pengampu</th>
                  <th className="px-6 py-4 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100 font-medium">
                {filtered.map((s) => (
                  <tr key={s.id} className="hover:bg-slate-50/80 transition">
                    <td className="px-6 py-4">
                      <div className="flex items-center gap-3">
                        <div className="w-9 h-9 rounded-xl bg-indigo-50 text-[#233DFF] flex items-center justify-center shrink-0">
                          <BookOpen className="w-4 h-4" />
                        </div>
                        <div>
                          <span className="font-bold text-slate-900 text-sm block">{s.name}</span>
                          <span className="text-[11px] font-mono font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded">
                            {s.code}
                          </span>
                        </div>
                      </div>
                    </td>
                    <td className="px-6 py-4 text-slate-600 max-w-xs truncate">
                      {s.description || '-'}
                    </td>
                    <td className="px-6 py-4">
                      <div className="flex flex-wrap gap-1">
                        {s.teachers && s.teachers.length > 0 ? (
                          s.teachers.map((t) => (
                            <span
                              key={t.id}
                              className="px-2.5 py-0.5 bg-slate-100 text-slate-700 rounded-md font-bold text-[11px]"
                            >
                              {t.name}
                            </span>
                          ))
                        ) : (
                          <span className="text-slate-400 italic text-[11px]">Belum Ada Guru</span>
                        )}
                      </div>
                    </td>
                    <td className="px-6 py-4 text-right">
                      <button
                        type="button"
                        onClick={() => handleDelete(s.id, s.name)}
                        className="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer"
                        title="Hapus Mapel"
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

      {/* Modal Tambah Mapel */}
      {isModalOpen && (
        <div className="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in-95 duration-150 max-h-[90vh] flex flex-col">
            <div className="p-5 border-b border-slate-100 flex items-center justify-between shrink-0">
              <div>
                <h3 className="font-bold text-slate-900 text-base">Tambah Mata Pelajaran</h3>
                <p className="text-xs text-slate-500">Daftarkan kurikulum mata pelajaran baru.</p>
              </div>
              <button
                type="button"
                onClick={() => setIsModalOpen(false)}
                className="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition"
              >
                <X className="w-5 h-5" />
              </button>
            </div>

            <form onSubmit={handleSubmit} className="p-6 space-y-4 overflow-y-auto">
              {formError && (
                <div className="p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">
                  {formError}
                </div>
              )}

              <div className="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">Kode Mapel *</label>
                  <input
                    type="text"
                    required
                    placeholder="RPL-01"
                    value={code}
                    onChange={(e) => setCode(e.target.value)}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none font-mono uppercase"
                  />
                </div>
                <div className="sm:col-span-2">
                  <label className="block text-xs font-bold text-slate-700 mb-1">Nama Mata Pelajaran *</label>
                  <input
                    type="text"
                    required
                    placeholder="Contoh: Pemrograman Web & Bergerak"
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                  />
                </div>
              </div>

              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1">Deskripsi / Capaian Pembelajaran</label>
                <textarea
                  rows={3}
                  placeholder="Keterangan singkat materi atau ruang lingkup kompetensi..."
                  value={description}
                  onChange={(e) => setDescription(e.target.value)}
                  className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none resize-none"
                />
              </div>

              {teachers.length > 0 && (
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1.5">Tetapkan Guru Pengampu</label>
                  <div className="flex flex-wrap gap-1.5 max-h-36 overflow-y-auto p-2 bg-slate-50 rounded-xl border border-slate-200">
                    {teachers.map((t) => {
                      const isChecked = selectedTeacherIds.includes(t.id);
                      return (
                        <button
                          key={t.id}
                          type="button"
                          onClick={() => handleTeacherToggle(t.id)}
                          className={`px-2.5 py-1 rounded-lg text-[11px] font-bold border transition cursor-pointer ${
                            isChecked
                              ? 'bg-[#233DFF] text-white border-[#233DFF]'
                              : 'bg-white text-slate-700 border-slate-200 hover:border-slate-300'
                          }`}
                        >
                          {t.name}
                        </button>
                      );
                    })}
                  </div>
                </div>
              )}

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
                  <span>{submitting ? 'Menyimpan...' : 'Simpan Mapel'}</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};
