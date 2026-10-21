import React, { useState } from 'react';
import {
  Building,
  Plus,
  Search,
  Trash2,
  X,
  Users,
  CheckCircle2,
  AlertTriangle
} from 'lucide-react';

interface RoomItem {
  id: number;
  code: string;
  name: string;
  type: 'Lab Komputer' | 'Ruang Teori' | 'Bengkel Praktik' | 'Aula';
  capacity: number;
  status: 'Tersedia' | 'Terpakai' | 'Perbaikan';
}

export const RoomsPage: React.FC = () => {
  const [rooms, setRooms] = useState<RoomItem[]>([
    {
      id: 1,
      code: 'LAB-01',
      name: 'Laboratorium Rekayasa Perangkat Lunak 1',
      type: 'Lab Komputer',
      capacity: 36,
      status: 'Terpakai',
    },
    {
      id: 2,
      code: 'LAB-02',
      name: 'Laboratorium Web & Mobile Development',
      type: 'Lab Komputer',
      capacity: 36,
      status: 'Tersedia',
    },
    {
      id: 3,
      code: 'TEORI-01',
      name: 'Ruang Teori Kelas X PPLG',
      type: 'Ruang Teori',
      capacity: 40,
      status: 'Tersedia',
    },
    {
      id: 4,
      code: 'TEORI-02',
      name: 'Ruang Teori Kelas XI RPL',
      type: 'Ruang Teori',
      capacity: 40,
      status: 'Terpakai',
    },
    {
      id: 5,
      code: 'AULA-01',
      name: 'Auditorium Graha Saraswati',
      type: 'Aula',
      capacity: 250,
      status: 'Tersedia',
    },
  ]);

  const [searchTerm, setSearchTerm] = useState('');
  const [modalOpen, setModalOpen] = useState(false);
  const [formData, setFormData] = useState({
    code: '',
    name: '',
    type: 'Lab Komputer' as 'Lab Komputer' | 'Ruang Teori' | 'Bengkel Praktik' | 'Aula',
    capacity: 36,
    status: 'Tersedia' as 'Tersedia' | 'Terpakai' | 'Perbaikan',
  });

  const handleDelete = (id: number) => {
    if (confirm('Yakin ingin menghapus ruangan ini?')) {
      setRooms((prev) => prev.filter((r) => r.id !== id));
    }
  };

  const handleCreate = (e: React.FormEvent) => {
    e.preventDefault();
    const newRoom: RoomItem = {
      id: Date.now(),
      code: formData.code,
      name: formData.name,
      type: formData.type,
      capacity: Number(formData.capacity),
      status: formData.status,
    };
    setRooms((prev) => [newRoom, ...prev]);
    setModalOpen(false);
    setFormData({
      code: '',
      name: '',
      type: 'Lab Komputer',
      capacity: 36,
      status: 'Tersedia',
    });
  };

  const filtered = rooms.filter(
    (r) =>
      r.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
      r.code.toLowerCase().includes(searchTerm.toLowerCase()) ||
      r.type.toLowerCase().includes(searchTerm.toLowerCase())
  );

  return (
    <div className="space-y-6">
      {/* Banner */}
      <div className="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#171B61] to-[#233DFF] p-6 sm:p-8 text-white shadow-xl shadow-indigo-950/10">
        <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div>
            <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-amber-300 text-xs font-bold mb-2">
              <Building className="w-3.5 h-3.5" />
              <span>Sarana &amp; Prasarana Sekolah</span>
            </div>
            <h1 className="text-2xl sm:text-3xl font-black tracking-tight">Ruangan &amp; Laboratorium</h1>
            <p className="text-xs text-indigo-100 mt-1 max-w-xl">
              Inventarisasi ruang kelas teori, laboratorium komputer praktikum, kapasitas tempat duduk, dan status ketersediaan sesi.
            </p>
          </div>

          <button
            onClick={() => setModalOpen(true)}
            type="button"
            className="inline-flex items-center gap-2 px-5 py-3 rounded-full text-xs font-black bg-white text-[#171B61] hover:bg-amber-300 hover:text-slate-900 shadow-lg transition cursor-pointer"
          >
            <Plus className="w-4 h-4" />
            <span>Tambah Ruangan Baru</span>
          </button>
        </div>

        {/* Stats */}
        <div className="relative z-10 grid grid-cols-2 sm:grid-cols-3 gap-3 mt-6 pt-6 border-t border-white/10">
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Total Ruangan Fisik</span>
            <span className="text-xl font-black text-white mt-0.5 block">{rooms.length} Ruangan</span>
          </div>
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Laboratorium Komputer</span>
            <span className="text-xl font-black text-[#F4CF52] mt-0.5 block">
              {rooms.filter((r) => r.type === 'Lab Komputer').length} Lab Aktif
            </span>
          </div>
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Daya Tampung Kumulatif</span>
            <span className="text-xl font-black text-emerald-300 mt-0.5 block">
              {rooms.reduce((sum, r) => sum + r.capacity, 0)} Siswa
            </span>
          </div>
        </div>
      </div>

      {/* Main Table Card */}
      <div className="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs space-y-4">
        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-3 border-b border-slate-100">
          <div className="flex items-center gap-2">
            <h3 className="text-sm font-extrabold text-[#171B61]">Daftar Ruangan Terdaftar</h3>
            <span className="text-xs font-bold text-slate-400">({filtered.length} Ruangan)</span>
          </div>

          <div className="relative max-w-xs w-full">
            <Search className="w-4 h-4 text-slate-400 absolute left-3 top-2.5 pointer-events-none" />
            <input
              type="text"
              placeholder="Cari kode, nama ruangan..."
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
                <th className="py-3.5 px-4">Kode &amp; Nama Ruangan</th>
                <th className="py-3.5 px-4">Tipe Fasilitas</th>
                <th className="py-3.5 px-4">Kapasitas Tempat Duduk</th>
                <th className="py-3.5 px-4">Status Ketersediaan</th>
                <th className="py-3.5 px-4 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium text-slate-700">
              {filtered.map((r) => (
                <tr key={r.id} className="hover:bg-slate-50 transition">
                  <td className="py-4 px-4">
                    <div className="flex items-center gap-3">
                      <span className="px-2.5 py-1 rounded-lg text-xs font-mono font-black bg-[#E5ECFF] text-[#233DFF]">
                        {r.code}
                      </span>
                      <span className="font-extrabold text-slate-900 text-sm">{r.name}</span>
                    </div>
                  </td>
                  <td className="py-4 px-4">
                    <span className="font-bold text-slate-800">{r.type}</span>
                  </td>
                  <td className="py-4 px-4 text-slate-700 font-bold">
                    <div className="flex items-center gap-1.5">
                      <Users className="w-3.5 h-3.5 text-slate-400" />
                      <span>{r.capacity} Kursi</span>
                    </div>
                  </td>
                  <td className="py-4 px-4">
                    <span
                      className={`inline-flex items-center gap-1 px-3 py-0.5 rounded-full text-[10px] font-black ${
                        r.status === 'Tersedia'
                          ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                          : r.status === 'Terpakai'
                          ? 'bg-blue-50 text-[#233DFF] border border-blue-200'
                          : 'bg-rose-50 text-rose-700 border border-rose-200'
                      }`}
                    >
                      {r.status === 'Tersedia' ? (
                        <CheckCircle2 className="w-3 h-3" />
                      ) : (
                        <AlertTriangle className="w-3 h-3" />
                      )}
                      {r.status}
                    </span>
                  </td>
                  <td className="py-4 px-4 text-right">
                    <button
                      type="button"
                      onClick={() => handleDelete(r.id)}
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

      {/* Modal Tambah Ruangan */}
      {modalOpen && (
        <div className="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
              <h3 className="text-base font-black text-slate-900">Tambah Ruangan Baru</h3>
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
                  <label className="block text-slate-700 mb-1">Kode Ruang</label>
                  <input
                    type="text"
                    required
                    placeholder="LAB-03"
                    value={formData.code}
                    onChange={(e) => setFormData({ ...formData, code: e.target.value })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  />
                </div>
                <div className="col-span-2">
                  <label className="block text-slate-700 mb-1">Nama Ruangan</label>
                  <input
                    type="text"
                    required
                    placeholder="Contoh: Lab Jaringan Komputer"
                    value={formData.name}
                    onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  />
                </div>
              </div>

              <div className="grid grid-cols-2 gap-3">
                <div>
                  <label className="block text-slate-700 mb-1">Tipe Fasilitas</label>
                  <select
                    value={formData.type}
                    onChange={(e) => setFormData({ ...formData, type: e.target.value as 'Lab Komputer' | 'Ruang Teori' | 'Bengkel Praktik' | 'Aula' })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  >
                    <option value="Lab Komputer">Lab Komputer</option>
                    <option value="Ruang Teori">Ruang Teori</option>
                    <option value="Bengkel Praktik">Bengkel Praktik</option>
                    <option value="Aula">Aula / Serbaguna</option>
                  </select>
                </div>
                <div>
                  <label className="block text-slate-700 mb-1">Kapasitas Tempat Duduk</label>
                  <input
                    type="number"
                    min="1"
                    max="500"
                    required
                    value={formData.capacity}
                    onChange={(e) => setFormData({ ...formData, capacity: Number(e.target.value) })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  />
                </div>
              </div>

              <div>
                <label className="block text-slate-700 mb-1">Status Ketersediaan</label>
                <select
                  value={formData.status}
                  onChange={(e) => setFormData({ ...formData, status: e.target.value as 'Tersedia' | 'Terpakai' | 'Perbaikan' })}
                  className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                >
                  <option value="Tersedia">Tersedia</option>
                  <option value="Terpakai">Sedang Terpakai</option>
                  <option value="Perbaikan">Dalam Perbaikan</option>
                </select>
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
                  Simpan Ruangan
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};
