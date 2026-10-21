import React, { useState, useEffect } from 'react';
import {
  Plus,
  Search,
  Trash2,
  X,
  Phone,
  Mail,
  Loader2
} from 'lucide-react';
import { adminService, TeacherItem, SubjectItem } from '../../api/adminService';

export const TeachersPage: React.FC = () => {
  const [teachers, setTeachers] = useState<TeacherItem[]>([]);
  const [subjects, setSubjects] = useState<SubjectItem[]>([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState('');
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [submitting, setSubmitting] = useState(false);
  const [formError, setFormError] = useState<string | null>(null);

  // Form State
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [nip, setNip] = useState('');
  const [nuptk, setNuptk] = useState('');
  const [gender, setGender] = useState<'L' | 'P'>('L');
  const [phone, setPhone] = useState('');
  const [address, setAddress] = useState('');
  const [selectedSubjectIds, setSelectedSubjectIds] = useState<number[]>([]);
  const [isWalas, setIsWalas] = useState(false);
  const [isMentor, setIsMentor] = useState(false);

  const fetchTeachers = async () => {
    setLoading(true);
    try {
      const [tData, sData] = await Promise.all([
        adminService.getTeachers({ search: search || undefined }),
        adminService.getSubjects().catch(() => []),
      ]);
      setTeachers(tData);
      setSubjects(sData);
    } catch (err: any) {
      console.error('Gagal mengambil data guru:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchTeachers();
  }, [search]);

  const handleOpenModal = () => {
    setName('');
    setEmail('');
    setNip('');
    setNuptk('');
    setGender('L');
    setPhone('');
    setAddress('');
    setSelectedSubjectIds([]);
    setIsWalas(false);
    setIsMentor(false);
    setFormError(null);
    setIsModalOpen(true);
  };

  const handleSubjectToggle = (id: number) => {
    if (selectedSubjectIds.includes(id)) {
      setSelectedSubjectIds(selectedSubjectIds.filter((item) => item !== id));
    } else {
      setSelectedSubjectIds([...selectedSubjectIds, id]);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!name.trim() || !email.trim()) {
      setFormError('Nama lengkap dan email wajib diisi.');
      return;
    }

    setSubmitting(true);
    setFormError(null);
    try {
      await adminService.createTeacher({
        name,
        email,
        nip: nip || undefined,
        nuptk: nuptk || undefined,
        gender,
        phone: phone || undefined,
        address: address || undefined,
        subject_ids: selectedSubjectIds,
        is_walas: isWalas,
        is_mentor: isMentor,
      });
      setIsModalOpen(false);
      fetchTeachers();
    } catch (err: any) {
      const msg = err.response?.data?.message || err.message || 'Gagal menambahkan data guru.';
      setFormError(msg);
    } finally {
      setSubmitting(false);
    }
  };

  const handleDelete = async (id: number, teacherName: string) => {
    if (!window.confirm(`Yakin ingin menghapus guru "${teacherName}" dari database?`)) {
      return;
    }
    try {
      await adminService.deleteTeacher(id);
      setTeachers((prev) => prev.filter((t) => t.id !== id));
    } catch (err: any) {
      alert(err.response?.data?.message || 'Gagal menghapus data guru.');
    }
  };

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div className="flex items-center gap-2">
            <h1 className="text-xl sm:text-2xl font-black text-[#171B61] tracking-tight">
              Data Tenaga Pendidik (Guru)
            </h1>
            <span className="text-xs font-bold bg-[#E5ECFF] text-[#233DFF] px-2.5 py-0.5 rounded-full">
              {teachers.length} Guru Terdaftar
            </span>
          </div>
          <p className="text-xs text-slate-500 mt-1">
            Manajemen profil guru, nomor induk (NIP/NUPTK), penugasan wali kelas, dan pembimbing PKL.
          </p>
        </div>

        <div className="flex items-center gap-2.5">
          <button
            type="button"
            onClick={handleOpenModal}
            className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1B30D9] shadow-md shadow-indigo-600/20 transition cursor-pointer"
          >
            <Plus className="w-4 h-4" />
            <span>Tambah Guru</span>
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
              placeholder="Cari nama, NIP, telepon..."
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
              <p className="text-xs font-medium">Memuat data guru dari database...</p>
            </div>
          ) : teachers.length === 0 ? (
            <div className="p-12 text-center text-slate-400">
              <p className="text-sm font-semibold">Belum ada data guru di database.</p>
              <p className="text-xs mt-1">Gunakan tombol "Tambah Guru" untuk mendaftarkan pendidik baru.</p>
            </div>
          ) : (
            <table className="w-full text-left text-xs">
              <thead className="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold border-b border-slate-100">
                <tr>
                  <th className="px-6 py-4">Nama Lengkap & NIP</th>
                  <th className="px-6 py-4">Kontak</th>
                  <th className="px-6 py-4">Mata Pelajaran</th>
                  <th className="px-6 py-4">Peran Tambahan</th>
                  <th className="px-6 py-4 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100 font-medium">
                {teachers.map((t) => (
                  <tr key={t.id} className="hover:bg-slate-50/80 transition">
                    <td className="px-6 py-4">
                      <div className="flex items-center gap-3">
                        <div className="w-9 h-9 rounded-full bg-indigo-50 text-[#233DFF] flex items-center justify-center font-bold text-xs shrink-0">
                          {t.name.charAt(0)}
                        </div>
                        <div>
                          <span className="font-bold text-slate-900 block">{t.name}</span>
                          <span className="text-[11px] text-slate-400 font-mono">NIP: {t.nip || '-'}</span>
                        </div>
                      </div>
                    </td>
                    <td className="px-6 py-4">
                      <div className="space-y-0.5">
                        <div className="flex items-center gap-1.5 text-slate-600">
                          <Mail className="w-3.5 h-3.5 text-slate-400" />
                          <span>{t.email}</span>
                        </div>
                        {t.phone && t.phone !== '-' && (
                          <div className="flex items-center gap-1.5 text-slate-500 text-[11px]">
                            <Phone className="w-3.5 h-3.5 text-slate-400" />
                            <span>{t.phone}</span>
                          </div>
                        )}
                      </div>
                    </td>
                    <td className="px-6 py-4">
                      <div className="flex flex-wrap gap-1">
                        {t.subjects && t.subjects.length > 0 ? (
                          t.subjects.map((s) => (
                            <span
                              key={s.id}
                              className="px-2 py-0.5 bg-slate-100 text-slate-700 rounded-md font-semibold text-[11px]"
                            >
                              {s.name}
                            </span>
                          ))
                        ) : (
                          <span className="text-slate-400 italic text-[11px]">-</span>
                        )}
                      </div>
                    </td>
                    <td className="px-6 py-4">
                      <div className="flex flex-wrap gap-1">
                        {t.is_walas && (
                          <span className="px-2 py-0.5 bg-blue-50 text-[#233DFF] border border-blue-200 rounded-md font-bold text-[10px]">
                            Wali Kelas
                          </span>
                        )}
                        {t.is_mentor && (
                          <span className="px-2 py-0.5 bg-purple-50 text-purple-700 border border-purple-200 rounded-md font-bold text-[10px]">
                            Pembimbing PKL
                          </span>
                        )}
                        {!t.is_walas && !t.is_mentor && (
                          <span className="text-slate-400 text-[11px]">Pengajar Mapel</span>
                        )}
                      </div>
                    </td>
                    <td className="px-6 py-4 text-right">
                      <button
                        type="button"
                        onClick={() => handleDelete(t.id, t.name)}
                        className="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer"
                        title="Hapus Guru"
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

      {/* Modal Tambah Guru */}
      {isModalOpen && (
        <div className="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in-95 duration-150 max-h-[90vh] flex flex-col">
            <div className="p-5 border-b border-slate-100 flex items-center justify-between shrink-0">
              <div>
                <h3 className="font-bold text-slate-900 text-base">Tambah Tenaga Pendidik Baru</h3>
                <p className="text-xs text-slate-500">Daftarkan data guru dan otomatis buatkan akun sistem.</p>
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

              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Guru (dengan Gelar) *</label>
                <input
                  type="text"
                  required
                  placeholder="Contoh: Bambang Sudiro, M.Pd"
                  value={name}
                  onChange={(e) => setName(e.target.value)}
                  className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                />
              </div>

              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1">Email Sekolah *</label>
                <input
                  type="email"
                  required
                  placeholder="bambang@oneschool.sch.id"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                />
              </div>

              <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">NIP (Nomor Induk Pegawai)</label>
                  <input
                    type="text"
                    placeholder="198507202010011005"
                    value={nip}
                    onChange={(e) => setNip(e.target.value)}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                  />
                </div>
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">Jenis Kelamin</label>
                  <select
                    value={gender}
                    onChange={(e) => setGender(e.target.value as 'L' | 'P')}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white outline-none focus:border-[#233DFF]"
                  >
                    <option value="L">Laki-laki (L)</option>
                    <option value="P">Perempuan (P)</option>
                  </select>
                </div>
              </div>

              <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">No. WhatsApp / HP</label>
                  <input
                    type="text"
                    placeholder="08123456789"
                    value={phone}
                    onChange={(e) => setPhone(e.target.value)}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                  />
                </div>
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">NUPTK (Jika Ada)</label>
                  <input
                    type="text"
                    placeholder="Opsional"
                    value={nuptk}
                    onChange={(e) => setNuptk(e.target.value)}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                  />
                </div>
              </div>

              {subjects.length > 0 && (
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1.5">Mata Pelajaran yang Diampu</label>
                  <div className="flex flex-wrap gap-1.5 max-h-32 overflow-y-auto p-2 bg-slate-50 rounded-xl border border-slate-200">
                    {subjects.map((sub) => {
                      const isChecked = selectedSubjectIds.includes(sub.id);
                      return (
                        <button
                          key={sub.id}
                          type="button"
                          onClick={() => handleSubjectToggle(sub.id)}
                          className={`px-2.5 py-1 rounded-lg text-[11px] font-bold border transition cursor-pointer ${
                            isChecked
                              ? 'bg-[#233DFF] text-white border-[#233DFF]'
                              : 'bg-white text-slate-700 border-slate-200 hover:border-slate-300'
                          }`}
                        >
                          {sub.name}
                        </button>
                      );
                    })}
                  </div>
                </div>
              )}

              <div className="pt-2 border-t border-slate-100 space-y-2">
                <label className="block text-xs font-bold text-slate-700">Penugasan Tambahan</label>
                <div className="flex flex-col gap-2">
                  <label className="flex items-center gap-2 cursor-pointer">
                    <input
                      type="checkbox"
                      checked={isWalas}
                      onChange={(e) => setIsWalas(e.target.checked)}
                      className="w-4 h-4 text-[#233DFF] rounded-md border-slate-300 focus:ring-[#233DFF]"
                    />
                    <span className="text-xs text-slate-700 font-semibold">Tugaskan sebagai Wali Kelas</span>
                  </label>
                  <label className="flex items-center gap-2 cursor-pointer">
                    <input
                      type="checkbox"
                      checked={isMentor}
                      onChange={(e) => setIsMentor(e.target.checked)}
                      className="w-4 h-4 text-[#233DFF] rounded-md border-slate-300 focus:ring-[#233DFF]"
                    />
                    <span className="text-xs text-slate-700 font-semibold">Tugaskan sebagai Guru Pembimbing PKL</span>
                  </label>
                </div>
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
                  <span>{submitting ? 'Menyimpan...' : 'Simpan Guru'}</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};
