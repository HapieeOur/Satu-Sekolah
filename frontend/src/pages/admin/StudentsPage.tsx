import React, { useState } from 'react';
import {
  GraduationCap,
  Plus,
  Search,
  Trash2,
  X,
  Phone,
  CheckCircle2
} from 'lucide-react';

interface StudentItem {
  id: number;
  name: string;
  nisn: string;
  nis: string;
  classroom: string;
  gender: 'L' | 'P';
  parentPhone: string;
  status: 'Aktif' | 'Mutasi' | 'Lulus';
}

export const StudentsPage: React.FC = () => {
  const [students, setStudents] = useState<StudentItem[]>([
    {
      id: 1,
      name: 'Ahmad Fauzan',
      nisn: '0051234561',
      nis: '20240101',
      classroom: 'XII RPL 1',
      gender: 'L',
      parentPhone: '081234567801',
      status: 'Aktif',
    },
    {
      id: 2,
      name: 'Budi Santoso',
      nisn: '0051234562',
      nis: '20240102',
      classroom: 'XII RPL 1',
      gender: 'L',
      parentPhone: '081234567802',
      status: 'Aktif',
    },
    {
      id: 3,
      name: 'Citra Kirana',
      nisn: '0051234563',
      nis: '20240103',
      classroom: 'XII RPL 1',
      gender: 'P',
      parentPhone: '081234567803',
      status: 'Aktif',
    },
    {
      id: 4,
      name: 'Dewi Lestari',
      nisn: '0051234564',
      nis: '20240104',
      classroom: 'XI RPL 2',
      gender: 'P',
      parentPhone: '081234567804',
      status: 'Aktif',
    },
    {
      id: 5,
      name: 'Eko Prasetyo',
      nisn: '0051234565',
      nis: '20240105',
      classroom: 'X PPLG 1',
      gender: 'L',
      parentPhone: '081234567805',
      status: 'Aktif',
    },
  ]);

  const [searchTerm, setSearchTerm] = useState('');
  const [classFilter, setClassFilter] = useState('ALL');
  const [modalOpen, setModalOpen] = useState(false);
  const [formData, setFormData] = useState({
    name: '',
    nisn: '',
    nis: '',
    classroom: 'XII RPL 1',
    gender: 'L' as 'L' | 'P',
    parentPhone: '',
    status: 'Aktif' as 'Aktif' | 'Mutasi' | 'Lulus',
  });

  const handleDelete = (id: number) => {
    if (confirm('Yakin ingin menghapus data peserta didik ini?')) {
      setStudents((prev) => prev.filter((s) => s.id !== id));
    }
  };

  const handleCreate = (e: React.FormEvent) => {
    e.preventDefault();
    const newStudent: StudentItem = {
      id: Date.now(),
      name: formData.name,
      nisn: formData.nisn,
      nis: formData.nis,
      classroom: formData.classroom,
      gender: formData.gender,
      parentPhone: formData.parentPhone,
      status: formData.status,
    };
    setStudents((prev) => [newStudent, ...prev]);
    setModalOpen(false);
    setFormData({
      name: '',
      nisn: '',
      nis: '',
      classroom: 'XII RPL 1',
      gender: 'L',
      parentPhone: '',
      status: 'Aktif',
    });
  };

  const filtered = students.filter((s) => {
    const matchesSearch =
      s.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      s.nisn.includes(searchTerm) ||
      s.nis.includes(searchTerm);
    const matchesClass = classFilter === 'ALL' || s.classroom === classFilter;
    return matchesSearch && matchesClass;
  });

  return (
    <div className="space-y-6">
      {/* Banner */}
      <div className="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#171B61] to-[#233DFF] p-6 sm:p-8 text-white shadow-xl shadow-indigo-950/10">
        <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div>
            <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-amber-300 text-xs font-bold mb-2">
              <GraduationCap className="w-3.5 h-3.5" />
              <span>Buku Induk &amp; Data Siswa</span>
            </div>
            <h1 className="text-2xl sm:text-3xl font-black tracking-tight">Data Siswa &amp; Peserta Didik</h1>
            <p className="text-xs text-indigo-100 mt-1 max-w-xl">
              Pusat data induk murid, nomor induk siswa nasional (NISN), plotting kelas, dan kontak wali murid.
            </p>
          </div>

          <button
            onClick={() => setModalOpen(true)}
            type="button"
            className="inline-flex items-center gap-2 px-5 py-3 rounded-full text-xs font-black bg-white text-[#171B61] hover:bg-amber-300 hover:text-slate-900 shadow-lg transition cursor-pointer"
          >
            <Plus className="w-4 h-4" />
            <span>Tambah Siswa Baru</span>
          </button>
        </div>

        {/* Stats */}
        <div className="relative z-10 grid grid-cols-2 sm:grid-cols-3 gap-3 mt-6 pt-6 border-t border-white/10">
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Total Siswa Terdaftar</span>
            <span className="text-xl font-black text-white mt-0.5 block">{students.length} Siswa</span>
          </div>
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Laki-Laki</span>
            <span className="text-xl font-black text-[#F4CF52] mt-0.5 block">
              {students.filter((s) => s.gender === 'L').length} Siswa
            </span>
          </div>
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Perempuan</span>
            <span className="text-xl font-black text-emerald-300 mt-0.5 block">
              {students.filter((s) => s.gender === 'P').length} Siswa
            </span>
          </div>
        </div>
      </div>

      {/* Main Table Card */}
      <div className="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs space-y-4">
        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-3 border-b border-slate-100">
          <div className="flex items-center gap-3">
            <h3 className="text-sm font-extrabold text-[#171B61]">Daftar Peserta Didik</h3>
            <select
              value={classFilter}
              onChange={(e) => setClassFilter(e.target.value)}
              className="text-xs font-bold text-slate-700 bg-[#F8FAFD] border border-slate-200 rounded-xl px-3 py-1.5 focus:outline-none"
            >
              <option value="ALL">Semua Kelas</option>
              <option value="XII RPL 1">XII RPL 1</option>
              <option value="XI RPL 2">XI RPL 2</option>
              <option value="X PPLG 1">X PPLG 1</option>
            </select>
          </div>

          <div className="relative max-w-xs w-full">
            <Search className="w-4 h-4 text-slate-400 absolute left-3 top-2.5 pointer-events-none" />
            <input
              type="text"
              placeholder="Cari nama, NISN, NIS..."
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
                <th className="py-3.5 px-4">Nama Siswa &amp; NISN</th>
                <th className="py-3.5 px-4">Kelas Rombel</th>
                <th className="py-3.5 px-4">L/P</th>
                <th className="py-3.5 px-4">Status Akademik</th>
                <th className="py-3.5 px-4">Kontak Orang Tua</th>
                <th className="py-3.5 px-4 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium text-slate-700">
              {filtered.map((s) => (
                <tr key={s.id} className="hover:bg-slate-50 transition">
                  <td className="py-4 px-4">
                    <div className="flex items-center gap-3">
                      <div className="w-10 h-10 rounded-xl bg-slate-100 text-[#171B61] font-black flex items-center justify-center text-xs shadow-xs shrink-0">
                        {s.name.charAt(0)}
                      </div>
                      <div>
                        <div className="font-extrabold text-slate-900 text-sm">
                          {s.name}
                        </div>
                        <span className="text-[11px] font-mono text-slate-400">
                          NISN: {s.nisn} &bull; NIS: {s.nis}
                        </span>
                      </div>
                    </div>
                  </td>
                  <td className="py-4 px-4">
                    <span className="font-extrabold text-[#233DFF] bg-[#E5ECFF] px-2.5 py-1 rounded-lg">
                      {s.classroom}
                    </span>
                  </td>
                  <td className="py-4 px-4 font-bold text-slate-700">{s.gender}</td>
                  <td className="py-4 px-4">
                    <span className="inline-flex items-center gap-1 px-3 py-0.5 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200">
                      <CheckCircle2 className="w-3 h-3" />
                      {s.status}
                    </span>
                  </td>
                  <td className="py-4 px-4 text-slate-600">
                    <div className="flex items-center gap-1.5 font-medium">
                      <Phone className="w-3.5 h-3.5 text-slate-400" />
                      <span>{s.parentPhone}</span>
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

      {/* Modal Tambah Siswa */}
      {modalOpen && (
        <div className="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
              <h3 className="text-base font-black text-slate-900">Tambah Peserta Didik Baru</h3>
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
                <label className="block text-slate-700 mb-1">Nama Lengkap Siswa</label>
                <input
                  type="text"
                  required
                  placeholder="Contoh: Dimas Anggara"
                  value={formData.name}
                  onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                  className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                />
              </div>

              <div className="grid grid-cols-2 gap-3">
                <div>
                  <label className="block text-slate-700 mb-1">NISN</label>
                  <input
                    type="text"
                    required
                    placeholder="0051234567"
                    value={formData.nisn}
                    onChange={(e) => setFormData({ ...formData, nisn: e.target.value })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  />
                </div>
                <div>
                  <label className="block text-slate-700 mb-1">NIS Sekolah</label>
                  <input
                    type="text"
                    required
                    placeholder="20240109"
                    value={formData.nis}
                    onChange={(e) => setFormData({ ...formData, nis: e.target.value })}
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
                  <label className="block text-slate-700 mb-1">Jenis Kelamin</label>
                  <select
                    value={formData.gender}
                    onChange={(e) => setFormData({ ...formData, gender: e.target.value as 'L' | 'P' })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  >
                    <option value="L">Laki-Laki (L)</option>
                    <option value="P">Perempuan (P)</option>
                  </select>
                </div>
              </div>

              <div>
                <label className="block text-slate-700 mb-1">No. Kontak Orang Tua / Wali</label>
                <input
                  type="text"
                  required
                  placeholder="081234567890"
                  value={formData.parentPhone}
                  onChange={(e) => setFormData({ ...formData, parentPhone: e.target.value })}
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
                  Simpan Siswa
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};
