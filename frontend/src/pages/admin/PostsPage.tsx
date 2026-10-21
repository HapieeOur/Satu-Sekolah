import React, { useState } from 'react';
import {
  FileText,
  Plus,
  Search,
  Trash2,
  X,
  Clock,
  Eye,
  CheckCircle2
} from 'lucide-react';

interface PostItem {
  id: number;
  title: string;
  type: 'Berita' | 'Pengumuman' | 'Acara';
  publishedAt: string;
  author: string;
  views: number;
  status: 'Published' | 'Draft';
}

export const PostsPage: React.FC = () => {
  const [posts, setPosts] = useState<PostItem[]>([
    {
      id: 1,
      title: 'Pelepasan Siswa Praktik Kerja Lapangan (PKL) Industri Batch 1',
      type: 'Berita',
      publishedAt: '20 Okt 2026',
      author: 'Humas SMKN 1 Probolinggo',
      views: 342,
      status: 'Published',
    },
    {
      id: 2,
      title: 'Jadwal Penilaian Tengah Semester (PTS) Ganjil T.A. 2026/2027',
      type: 'Pengumuman',
      publishedAt: '18 Okt 2026',
      author: 'Kurikulum',
      views: 520,
      status: 'Published',
    },
    {
      id: 3,
      title: 'Kunjungan Industri Mitra DUDI PT Telkom & Bank Jatim',
      type: 'Acara',
      publishedAt: '15 Okt 2026',
      author: 'Ketua Jurusan PPLG',
      views: 215,
      status: 'Published',
    },
    {
      id: 4,
      title: 'Draft Panduan Penyusunan Laporan Portofolio PKL Siswa',
      type: 'Pengumuman',
      publishedAt: '21 Okt 2026',
      author: 'Koordinator PKL',
      views: 0,
      status: 'Draft',
    },
  ]);

  const [searchTerm, setSearchTerm] = useState('');
  const [typeFilter, setTypeFilter] = useState('ALL');
  const [modalOpen, setModalOpen] = useState(false);
  const [formData, setFormData] = useState({
    title: '',
    type: 'Berita' as 'Berita' | 'Pengumuman' | 'Acara',
    author: 'Admin Sekolah',
    status: 'Published' as 'Published' | 'Draft',
  });

  const handleDelete = (id: number) => {
    if (confirm('Yakin ingin menghapus publikasi ini?')) {
      setPosts((prev) => prev.filter((p) => p.id !== id));
    }
  };

  const handleCreate = (e: React.FormEvent) => {
    e.preventDefault();
    const newPost: PostItem = {
      id: Date.now(),
      title: formData.title,
      type: formData.type,
      publishedAt: 'Hari ini',
      author: formData.author,
      views: 0,
      status: formData.status,
    };
    setPosts((prev) => [newPost, ...prev]);
    setModalOpen(false);
    setFormData({
      title: '',
      type: 'Berita',
      author: 'Admin Sekolah',
      status: 'Published',
    });
  };

  const filtered = posts.filter((p) => {
    const matchesSearch =
      p.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
      p.author.toLowerCase().includes(searchTerm.toLowerCase());
    const matchesType = typeFilter === 'ALL' || p.type === typeFilter;
    return matchesSearch && matchesType;
  });

  return (
    <div className="space-y-6">
      {/* Banner */}
      <div className="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#171B61] to-[#233DFF] p-6 sm:p-8 text-white shadow-xl shadow-indigo-950/10">
        <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div>
            <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-amber-300 text-xs font-bold mb-2">
              <FileText className="w-3.5 h-3.5" />
              <span>Portal Publikasi Resmi</span>
            </div>
            <h1 className="text-2xl sm:text-3xl font-black tracking-tight">Berita, Pengumuman &amp; Acara</h1>
            <p className="text-xs text-indigo-100 mt-1 max-w-xl">
              Publikasikan informasi resmi institusi, kegiatan belajar mengajar, agenda industri, dan pengumuman untuk seluruh sivitas sekolah.
            </p>
          </div>

          <button
            onClick={() => setModalOpen(true)}
            type="button"
            className="inline-flex items-center gap-2 px-5 py-3 rounded-full text-xs font-black bg-white text-[#171B61] hover:bg-amber-300 hover:text-slate-900 shadow-lg transition cursor-pointer"
          >
            <Plus className="w-4 h-4" />
            <span>Tulis Publikasi Baru</span>
          </button>
        </div>

        {/* Stats */}
        <div className="relative z-10 grid grid-cols-2 sm:grid-cols-3 gap-3 mt-6 pt-6 border-t border-white/10">
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Total Publikasi Aktif</span>
            <span className="text-xl font-black text-white mt-0.5 block">{posts.length} Konten</span>
          </div>
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Telah Dibaca</span>
            <span className="text-xl font-black text-[#F4CF52] mt-0.5 block">
              {posts.reduce((sum, p) => sum + p.views, 0)} Views
            </span>
          </div>
          <div className="p-3.5 rounded-2xl bg-white/10 backdrop-blur-xs border border-white/10">
            <span className="text-[11px] font-bold text-indigo-200 block">Status Terbit</span>
            <span className="text-xl font-black text-emerald-300 mt-0.5 block">
              {posts.filter((p) => p.status === 'Published').length} Terbit
            </span>
          </div>
        </div>
      </div>

      {/* Main Table Card */}
      <div className="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs space-y-4">
        <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-3 border-b border-slate-100">
          <div className="flex items-center gap-3">
            <h3 className="text-sm font-extrabold text-[#171B61]">Daftar Konten Publikasi</h3>
            <select
              value={typeFilter}
              onChange={(e) => setTypeFilter(e.target.value)}
              className="text-xs font-bold text-slate-700 bg-[#F8FAFD] border border-slate-200 rounded-xl px-3 py-1.5 focus:outline-none"
            >
              <option value="ALL">Semua Tipe Konten</option>
              <option value="Berita">Berita</option>
              <option value="Pengumuman">Pengumuman</option>
              <option value="Acara">Acara Sekolah</option>
            </select>
          </div>

          <div className="relative max-w-xs w-full">
            <Search className="w-4 h-4 text-slate-400 absolute left-3 top-2.5 pointer-events-none" />
            <input
              type="text"
              placeholder="Cari judul artikel, penulis..."
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
                <th className="py-3.5 px-4">Judul Artikel &amp; Konten</th>
                <th className="py-3.5 px-4">Kategori Tipe</th>
                <th className="py-3.5 px-4">Tanggal Terbit</th>
                <th className="py-3.5 px-4">Penulis / Unit</th>
                <th className="py-3.5 px-4">Pembaca</th>
                <th className="py-3.5 px-4">Status</th>
                <th className="py-3.5 px-4 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium text-slate-700">
              {filtered.map((p) => (
                <tr key={p.id} className="hover:bg-slate-50 transition">
                  <td className="py-4 px-4 font-extrabold text-slate-900 max-w-md">
                    <span className="line-clamp-1">{p.title}</span>
                  </td>
                  <td className="py-4 px-4">
                    <span
                      className={`inline-flex items-center px-3 py-0.5 rounded-full text-[10px] font-black ${
                        p.type === 'Berita'
                          ? 'bg-blue-50 text-[#233DFF] border border-blue-200'
                          : p.type === 'Pengumuman'
                          ? 'bg-amber-50 text-amber-700 border border-amber-200'
                          : 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                      }`}
                    >
                      {p.type}
                    </span>
                  </td>
                  <td className="py-4 px-4 text-slate-500 font-medium">
                    <div className="flex items-center gap-1">
                      <Clock className="w-3.5 h-3.5 text-slate-400" />
                      <span>{p.publishedAt}</span>
                    </div>
                  </td>
                  <td className="py-4 px-4 font-bold text-slate-800">{p.author}</td>
                  <td className="py-4 px-4 text-slate-600 font-bold">
                    <div className="flex items-center gap-1">
                      <Eye className="w-3.5 h-3.5 text-slate-400" />
                      <span>{p.views}</span>
                    </div>
                  </td>
                  <td className="py-4 px-4">
                    <span
                      className={`inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-black ${
                        p.status === 'Published'
                          ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                          : 'bg-slate-100 text-slate-500'
                      }`}
                    >
                      <CheckCircle2 className="w-3 h-3" />
                      {p.status}
                    </span>
                  </td>
                  <td className="py-4 px-4 text-right">
                    <button
                      type="button"
                      onClick={() => handleDelete(p.id)}
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

      {/* Modal Tulis Publikasi */}
      {modalOpen && (
        <div className="fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
            <div className="flex items-center justify-between pb-3 border-b border-slate-100">
              <h3 className="text-base font-black text-slate-900">Tulis Publikasi Baru</h3>
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
                <label className="block text-slate-700 mb-1">Judul Artikel / Pengumuman</label>
                <input
                  type="text"
                  required
                  placeholder="Masukkan judul publikasi..."
                  value={formData.title}
                  onChange={(e) => setFormData({ ...formData, title: e.target.value })}
                  className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                />
              </div>

              <div className="grid grid-cols-2 gap-3">
                <div>
                  <label className="block text-slate-700 mb-1">Kategori Tipe</label>
                  <select
                    value={formData.type}
                    onChange={(e) => setFormData({ ...formData, type: e.target.value as any })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  >
                    <option value="Berita">Berita Sekolah</option>
                    <option value="Pengumuman">Pengumuman Resmi</option>
                    <option value="Acara">Agenda Acara</option>
                  </select>
                </div>
                <div>
                  <label className="block text-slate-700 mb-1">Status Publikasi</label>
                  <select
                    value={formData.status}
                    onChange={(e) => setFormData({ ...formData, status: e.target.value as any })}
                    className="w-full p-2.5 rounded-xl border border-slate-200 bg-[#F8FAFD] focus:bg-white focus:outline-none focus:border-[#233DFF]"
                  >
                    <option value="Published">Langsung Terbitkan</option>
                    <option value="Draft">Simpan Draft</option>
                  </select>
                </div>
              </div>

              <div>
                <label className="block text-slate-700 mb-1">Penulis / Sumber</label>
                <input
                  type="text"
                  required
                  value={formData.author}
                  onChange={(e) => setFormData({ ...formData, author: e.target.value })}
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
                  Simpan Publikasi
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};
