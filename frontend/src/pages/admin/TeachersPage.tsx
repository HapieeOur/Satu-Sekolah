import React, { useState } from 'react';
import {
  Plus,
  Search,
  Trash2,
  X,
  Award,
  Phone,
  Mail,
  CheckCircle2
} from 'lucide-react';

interface TeacherItem {
  id: number;
  name: string;
  nip: string;
  subject: string;
  status: 'PNS' | 'PPPK' | 'GTT';
  phone: string;
  email: string;
  isWalas: boolean;
}

export const TeachersPage: React.FC = () => {
  const [teachers, setTeachers] = useState<TeacherItem[]>([
    {
      id: 1,
      name: 'Bambang Sudiro, M.Pd',
      nip: '198507202010011005',
      subject: 'Pemrograman Web & Mobile',
      status: 'PNS',
      phone: '081234567801',
      email: 'bambang.s@smkn1probolinggo.sch.id',
      isWalas: true,
    },
    {
      id: 2,
      name: 'Hendra Gunawan, S.Kom',
      nip: '198904122014021003',
      subject: 'Basis Data & SQL Query',
      status: 'PPPK',
      phone: '081234567802',
      email: 'hendra.g@smkn1probolinggo.sch.id',
      isWalas: false,
    },
    {
      id: 3,
      name: 'Siti Aminah, S.Pd',
      nip: '199201152019032012',
      subject: 'Pemodelan Perangkat Lunak & UI/UX',
      status: 'PNS',
      phone: '081234567803',
      email: 'siti.a@smkn1probolinggo.sch.id',
      isWalas: false,
    },
    {
      id: 4,
      name: 'Rudy Hartono, S.ST',
      nip: '199508212022011008',
      subject: 'Dasar-Dasar Kejuruan PPLG',
      status: 'GTT',
      phone: '081234567804',
      email: 'rudy.h@smkn1probolinggo.sch.id',
      isWalas: false,
    },
  ]);

  const [searchTerm, setSearchTerm] = useState('');
  const [modalOpen, setModalOpen] = useState(false);
  const [formData, setFormData] = useState({
    name: '',
    nip: '',
    subject: 'Pemrograman Web',
    status: 'PNS' as 'PNS' | 'PPPK' | 'GTT',
    phone: '',
    email: '',
    isWalas: false,
  });

  const handleDelete = (id: number) => {
    if (confirm('Yakin ingin menghapus data pendidik ini?')) {
      setTeachers((prev) => prev.filter((t) => t.id !== id));
    }
  };

  const handleCreate = (e: React.FormEvent) => {
    e.preventDefault();
    const newTeacher: TeacherItem = {
      id: Date.now(),
      name: formData.name,
      nip: formData.nip,
      subject: formData.subject,
      status: formData.status,
      phone: formData.phone,
      email: formData.email,
      isWalas: formData.isWalas,
    };
    setTeachers((prev) => [newTeacher, ...prev]);
    setModalOpen(false);
    setFormData({
      name: '',
      nip: '',
      subject: 'Pemrograman Web',
      status: 'PNS',
      phone: '',
      email: '',
      isWalas: false,
    });
  };

  const filtered = teachers.filter(
    (t) =>
      t.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      t.nip.includes(searchTerm) ||
      t.subject.toLowerCase().includes(searchTerm.toLowerCase())
  );

  return (
    <div className="space-y-6">
      {/* Banner */}
      <div className="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#171B61] to-[#233DFF] p-6 sm:p-8 text-white shadow-xl shadow-indigo-950/10">
        <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div>
            <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-amber-300 text-xs font-bold mb-2">
              <Award className="w-3.5 h-3.5" />
              <span>Data Pendidik &amp; Tenaga Kependidikan</span>
            </div>
            <h1 className="text-2xl sm:text-3xl font-black tracking-tight">Data Guru &amp; Pengajar</h1>
            <p className="text-xs text-indigo-100 mt-1 max-w-xl">
              Kelola profil pendidik, penugasan mata pelajaran, nomor induk kepegawaian (NIP), dan hak akses perwalian.
            </p>
          </div>

          <button
            onClick={() => setModalOpen(true)}
            type="button"
            className="inline-flex items-center gap-2 px-5 py-3 rounded-full text-xs font-black bg-white text-[#171B61] hover:bg-amber-300 hover:text-slate-900 shadow-lg transition cursor-pointer"
          >
            <Plus className="w-4 h-4" />
            <span>Tambah Guru Baru</span>
          </button>
        </div>

        {/* Stats */}
        <div className="relative z-10 grid grid-cols-2 sm:grid-cols-3 gap-3 mt-6 pt-6 border-t border-white/10">
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Total Tenaga Pengajar</span>
            <span className="text-xl font-black text-white mt-0.5 block">{teachers.length} Guru</span>
          </div>
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Status PNS &amp; PPPK</span>
            <span className="text-xl font-black text-[#F4CF52] mt-0.5 block">
              {teachers.filter((t) => t.status === 'PNS' || t.status === 'PPPK').length} Guru
            </span>
          </div>
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Amanah Wali Kelas</span>
            <span className="text-xl font-black text-emerald-300 mt-0.5 block">
              {teachers.filter((t) => t.isWalas).length} Guru
            </span>
          </div>
        </div>
      </div>

      {/* Main Table Card */}
      <div className="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs space-y-4">
        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-3 border-b border-slate-100">
          <div className="flex items-center gap-2">
            <h3 className="text-sm font-extrabold text-[#171B61]">Daftar Dewan Guru</h3>
            <span className="text-xs font-bold text-slate-400">({filtered.length} Data)</span>
          </div>

          <div className="relative max-w-xs w-full">
            <Search className="w-4 h-4 text-slate-400 absolute left-3 top-2.5 pointer-events-none" />
            <input
              type="text"
              placeholder="Cari nama, NIP, mapel..."
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
                <th className="py-3.5 px-4">Nama Lengkap &amp; NIP</th>
                <th className="py-3.5 px-4">Spesialisasi Mapel</th>
                <th className="py-3.5 px-4">Status Kepegawaian</th>
                <th className="py-3.5 px-4">Kontak Resmi</th>
                <th className="py-3.5 px-4 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium text-slate-700">
              {filtered.map((t) => (
                <tr key={t.id} className="hover:bg-slate-50 transition">
                  <td className="py-4 px-4">
                    <div className="flex items-center gap-3">
                      <div className="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#171B61] to-[#233DFF] text-white font-black flex items-center justify-center text-xs shadow-xs shrink-0">
                        {t.name.charAt(0)}
                      </div>
                      <div>
                        <div className="font-extrabold text-slate-900 text-sm flex items-center gap-2">
                          <span>{t.name}</span>
                          {t.isWalas && (
                            <span className="px-2 py-0.5 rounded-full text-[9px] font-black bg-amber-100 text-amber-800 border border-amber-200">
                              WALI KELAS
                            </span>
                          )}
                        </div>
                        <span className="text-[11px] font-mono text-slate-400">NIP: {t.nip}</span>
                      </div>
                    </div>
                  </td>
                  <td className="py-4 px-4">
                    <span className="font-bold text-[#171B61] block">{t.subject}</span>
                    <span className="text-[11px] text-slate-400">Program Keahlian PPLG</span>
                  </td>
                  <td className="py-4 px-4">
                    <span
                      className={`inline-flex items-center gap-1 px-3 py-0.5 rounded-full text-[10px] font-black ${
                        t.status === 'PNS'
                          ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                          : t.status === 'PPPK'
                          ? 'bg-blue-50 text-[#233DFF] border border-blue-200'
                          : 'bg-slate-100 text-slate-600'
                      }`}
                    >
                      <CheckCircle2 className="w-3 h-3" />
                      {t.status}
                    </span>
                  </td>
                  <td className="py-4 px-4 text-slate-600">
                    <div className="space-y-0.5 text-[11px]">
                      <div className="flex items-center gap-1.5 font-medium">
                        <Phone className="w-3 h-3 text-slate-400" />
                        <span>{t.phone}</span>
                      </div>
                      <div className="flex items-center gap-1.5 font-medium">
                        <Mail className="w-3 h-3 text-slate-400" />
                        <span>{t.email}</span>
                      </div>
                    </div>
                  </td>
                  <td className="py-4 px-4 text-right">
                    <button
                      type="button"
                      onClick={() => handleDelete(t.id)}
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

      {/* Modal Tambah Guru */}
      {modalOpen && (
        <div className="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
              <h3 className="text-base font-black text-slate-900">Tambah Guru Baru</h3>
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
                <label className="block text-slate-700 mb-1">Nama Lengkap &amp; Gelar</label>
                <input
                  type="text"
                  required
                  placeholder="Contoh: Budi Gunawan, M.Pd"
                  value={formData.name}
                  onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                  className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                />
              </div>

              <div>
                <label className="block text-slate-700 mb-1">NIP Pendidik</label>
                <input
                  type="text"
                  required
                  placeholder="Contoh: 198904122014021003"
                  value={formData.nip}
                  onChange={(e) => setFormData({ ...formData, nip: e.target.value })}
                  className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                />
              </div>

              <div className="grid grid-cols-2 gap-3">
                <div>
                  <label className="block text-slate-700 mb-1">Mata Pelajaran</label>
                  <input
                    type="text"
                    required
                    value={formData.subject}
                    onChange={(e) => setFormData({ ...formData, subject: e.target.value })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  />
                </div>
                <div>
                  <label className="block text-slate-700 mb-1">Status Kepegawaian</label>
                  <select
                    value={formData.status}
                    onChange={(e) => setFormData({ ...formData, status: e.target.value as 'PNS' | 'PPPK' | 'GTT' })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  >
                    <option value="PNS">PNS</option>
                    <option value="PPPK">PPPK</option>
                    <option value="GTT">GTT / Honorer</option>
                  </select>
                </div>
              </div>

              <div className="grid grid-cols-2 gap-3">
                <div>
                  <label className="block text-slate-700 mb-1">No. Kontak / WA</label>
                  <input
                    type="text"
                    required
                    placeholder="081234567890"
                    value={formData.phone}
                    onChange={(e) => setFormData({ ...formData, phone: e.target.value })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  />
                </div>
                <div>
                  <label className="block text-slate-700 mb-1">Email Resmi</label>
                  <input
                    type="email"
                    required
                    placeholder="guru@sekolah.sch.id"
                    value={formData.email}
                    onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  />
                </div>
              </div>

              <div className="flex items-center gap-2 pt-1">
                <input
                  type="checkbox"
                  id="walasCheck"
                  checked={formData.isWalas}
                  onChange={(e) => setFormData({ ...formData, isWalas: e.target.checked })}
                  className="rounded text-[#233DFF] focus:ring-0"
                />
                <label htmlFor="walasCheck" className="text-slate-700 cursor-pointer">
                  Tugaskan sebagai Wali Kelas
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
                  Simpan Guru
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};
