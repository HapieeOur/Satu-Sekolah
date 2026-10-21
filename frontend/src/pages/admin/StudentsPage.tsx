import React, { useState, useEffect } from 'react';
import {
  Plus,
  Search,
  Trash2,
  X,
  Phone,
  Loader2
} from 'lucide-react';
import { adminService, StudentItem, ClassroomItem } from '../../api/adminService';

export const StudentsPage: React.FC = () => {
  const [students, setStudents] = useState<StudentItem[]>([]);
  const [classrooms, setClassrooms] = useState<ClassroomItem[]>([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState('');
  const [selectedClassroomId, setSelectedClassroomId] = useState<string>('');
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [submitting, setSubmitting] = useState(false);
  const [formError, setFormError] = useState<string | null>(null);

  // Form State
  const [name, setName] = useState('');
  const [nis, setNis] = useState('');
  const [nisn, setNisn] = useState('');
  const [gender, setGender] = useState<'L' | 'P'>('L');
  const [classroomId, setClassroomId] = useState<string>('');
  const [phone, setPhone] = useState('');
  const [address, setAddress] = useState('');
  const [parentName, setParentName] = useState('');
  const [parentPhone, setParentPhone] = useState('');

  const fetchStudents = async () => {
    setLoading(true);
    try {
      const [sData, cData] = await Promise.all([
        adminService.getStudents({
          search: search || undefined,
          classroom_id: selectedClassroomId ? parseInt(selectedClassroomId) : undefined,
        }),
        adminService.getClassrooms().catch(() => []),
      ]);
      setStudents(sData);
      setClassrooms(cData);
    } catch (err: any) {
      console.error('Gagal mengambil data siswa:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchStudents();
  }, [search, selectedClassroomId]);

  const handleOpenModal = () => {
    setName('');
    setNis('');
    setNisn('');
    setGender('L');
    setClassroomId(classrooms[0] ? classrooms[0].id.toString() : '');
    setPhone('');
    setAddress('');
    setParentName('');
    setParentPhone('');
    setFormError(null);
    setIsModalOpen(true);
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!name.trim() || !nis.trim()) {
      setFormError('Nama siswa dan NIS wajib diisi.');
      return;
    }

    setSubmitting(true);
    setFormError(null);
    try {
      await adminService.createStudent({
        name,
        nis,
        nisn: nisn || undefined,
        gender,
        classroom_id: classroomId ? parseInt(classroomId) : null,
        phone: phone || undefined,
        address: address || undefined,
        parent_name: parentName || undefined,
        parent_phone: parentPhone || undefined,
        status: 'aktif',
      });
      setIsModalOpen(false);
      fetchStudents();
    } catch (err: any) {
      const msg = err.response?.data?.message || err.message || 'Gagal menambahkan data siswa.';
      setFormError(msg);
    } finally {
      setSubmitting(false);
    }
  };

  const handleDelete = async (id: number, studentName: string) => {
    if (!window.confirm(`Yakin ingin menghapus siswa "${studentName}" dari database?`)) {
      return;
    }
    try {
      await adminService.deleteStudent(id);
      setStudents((prev) => prev.filter((s) => s.id !== id));
    } catch (err: any) {
      alert(err.response?.data?.message || 'Gagal menghapus data siswa.');
    }
  };

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div className="flex items-center gap-2">
            <h1 className="text-xl sm:text-2xl font-black text-[#171B61] tracking-tight">
              Data Peserta Didik (Siswa)
            </h1>
            <span className="text-xs font-bold bg-[#E5ECFF] text-[#233DFF] px-2.5 py-0.5 rounded-full">
              {students.length} Siswa Terdaftar
            </span>
          </div>
          <p className="text-xs text-slate-500 mt-1">
            Data identitas pokok siswa (NIS, NISN), rombongan belajar aktif, dan kontak orang tua / wali.
          </p>
        </div>

        <div className="flex items-center gap-2.5">
          <button
            type="button"
            onClick={handleOpenModal}
            className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1B30D9] shadow-md shadow-indigo-600/20 transition cursor-pointer"
          >
            <Plus className="w-4 h-4" />
            <span>Tambah Siswa</span>
          </button>
        </div>
      </div>

      {/* Filter and Table Card */}
      <div className="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div className="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div className="flex flex-wrap items-center gap-3 max-w-xl w-full">
            <div className="relative flex-1 min-w-[220px]">
              <span className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <Search className="w-4 h-4" />
              </span>
              <input
                type="text"
                placeholder="Cari nama, NIS, NISN..."
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                className="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF]"
              />
            </div>

            <select
              value={selectedClassroomId}
              onChange={(e) => setSelectedClassroomId(e.target.value)}
              className="px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 bg-white focus:outline-none focus:border-[#233DFF]"
            >
              <option value="">Semua Kelas (Rombel)</option>
              {classrooms.map((c) => (
                <option key={c.id} value={c.id}>
                  {c.name}
                </option>
              ))}
            </select>
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
              <p className="text-xs font-medium">Memuat data siswa dari database...</p>
            </div>
          ) : students.length === 0 ? (
            <div className="p-12 text-center text-slate-400">
              <p className="text-sm font-semibold">Belum ada siswa yang cocok dengan kriteria.</p>
              <p className="text-xs mt-1">Gunakan tombol "Tambah Siswa" untuk mendaftarkan siswa baru.</p>
            </div>
          ) : (
            <table className="w-full text-left text-xs">
              <thead className="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold border-b border-slate-100">
                <tr>
                  <th className="px-6 py-4">Nama Siswa</th>
                  <th className="px-6 py-4">NIS / NISN</th>
                  <th className="px-6 py-4">Kelas</th>
                  <th className="px-6 py-4">L/P</th>
                  <th className="px-6 py-4">Orang Tua / Wali</th>
                  <th className="px-6 py-4">Status</th>
                  <th className="px-6 py-4 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100 font-medium">
                {students.map((s) => (
                  <tr key={s.id} className="hover:bg-slate-50/80 transition">
                    <td className="px-6 py-4">
                      <div className="flex items-center gap-3">
                        <div className="w-9 h-9 rounded-full bg-indigo-50 text-[#233DFF] flex items-center justify-center font-bold text-xs uppercase shrink-0">
                          {s.name.charAt(0)}
                        </div>
                        <div>
                          <span className="font-bold text-slate-900 block">{s.name}</span>
                          {s.phone && s.phone !== '-' && (
                            <span className="text-[11px] text-slate-400">{s.phone}</span>
                          )}
                        </div>
                      </div>
                    </td>
                    <td className="px-6 py-4">
                      <div className="space-y-0.5 font-mono">
                        <div className="text-slate-900 font-semibold">{s.nis}</div>
                        <div className="text-[10px] text-slate-400">NISN: {s.nisn || '-'}</div>
                      </div>
                    </td>
                    <td className="px-6 py-4">
                      <span className="px-2.5 py-1 bg-slate-100 text-slate-800 rounded-lg font-bold text-xs">
                        {s.classroom_name}
                      </span>
                    </td>
                    <td className="px-6 py-4">
                      <span className={`px-2 py-0.5 rounded font-bold text-[10px] ${
                        s.gender === 'L' ? 'bg-blue-50 text-blue-700' : 'bg-pink-50 text-pink-700'
                      }`}>
                        {s.gender === 'L' ? 'Laki-laki' : 'Perempuan'}
                      </span>
                    </td>
                    <td className="px-6 py-4">
                      <div className="space-y-0.5">
                        <span className="text-slate-900 font-medium block">{s.parent_name || '-'}</span>
                        {s.parent_phone && s.parent_phone !== '-' && (
                          <div className="flex items-center gap-1 text-[11px] text-slate-500">
                            <Phone className="w-3 h-3 text-slate-400" />
                            <span>{s.parent_phone}</span>
                          </div>
                        )}
                      </div>
                    </td>
                    <td className="px-6 py-4">
                      <span className="inline-flex items-center gap-1 text-emerald-700 font-bold bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 text-[11px]">
                        {s.status.toUpperCase()}
                      </span>
                    </td>
                    <td className="px-6 py-4 text-right">
                      <button
                        type="button"
                        onClick={() => handleDelete(s.id, s.name)}
                        className="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer"
                        title="Hapus Siswa"
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

      {/* Modal Tambah Siswa */}
      {isModalOpen && (
        <div className="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in-95 duration-150 max-h-[90vh] flex flex-col">
            <div className="p-5 border-b border-slate-100 flex items-center justify-between shrink-0">
              <div>
                <h3 className="font-bold text-slate-900 text-base">Tambah Siswa Baru</h3>
                <p className="text-xs text-slate-500">Daftarkan data siswa dan simpan ke database.</p>
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
                <label className="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Siswa *</label>
                <input
                  type="text"
                  required
                  placeholder="Contoh: Muhammad Rizky Pratama"
                  value={name}
                  onChange={(e) => setName(e.target.value)}
                  className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                />
              </div>

              <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">NIS (Nomor Induk Siswa) *</label>
                  <input
                    type="text"
                    required
                    placeholder="20240101"
                    value={nis}
                    onChange={(e) => setNis(e.target.value)}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                  />
                </div>
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">NISN (Nasional)</label>
                  <input
                    type="text"
                    placeholder="0051234567"
                    value={nisn}
                    onChange={(e) => setNisn(e.target.value)}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                  />
                </div>
              </div>

              <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
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
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">Kelas (Rombel)</label>
                  <select
                    value={classroomId}
                    onChange={(e) => setClassroomId(e.target.value)}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white outline-none focus:border-[#233DFF]"
                  >
                    <option value="">Pilih Rombongan Belajar</option>
                    {classrooms.map((c) => (
                      <option key={c.id} value={c.id}>
                        {c.name}
                      </option>
                    ))}
                  </select>
                </div>
              </div>

              <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">Nama Orang Tua / Wali</label>
                  <input
                    type="text"
                    placeholder="Contoh: Hendra Wijaya"
                    value={parentName}
                    onChange={(e) => setParentName(e.target.value)}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                  />
                </div>
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">No. HP Orang Tua / Wali</label>
                  <input
                    type="text"
                    placeholder="08123456789"
                    value={parentPhone}
                    onChange={(e) => setParentPhone(e.target.value)}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                  />
                </div>
              </div>

              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1">No. HP / WhatsApp Siswa</label>
                <input
                  type="text"
                  placeholder="08123456780"
                  value={phone}
                  onChange={(e) => setPhone(e.target.value)}
                  className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                />
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
                  <span>{submitting ? 'Menyimpan...' : 'Simpan Siswa'}</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};
