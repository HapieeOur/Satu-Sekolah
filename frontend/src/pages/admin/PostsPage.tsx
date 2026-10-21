import React, { useState, useEffect } from 'react';
import {
  FileText,
  Plus,
  Search,
  Trash2,
  Edit2,
  X,
  CheckCircle2,
  Loader2
} from 'lucide-react';
import { adminService, PostItem } from '../../api/adminService';

export const PostsPage: React.FC = () => {
  const [posts, setPosts] = useState<PostItem[]>([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch] = useState('');
  const [selectedCategory, setSelectedCategory] = useState<string>('');
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [editingPost, setEditingPost] = useState<PostItem | null>(null);
  const [submitting, setSubmitting] = useState(false);
  const [formError, setFormError] = useState<string | null>(null);

  // Form State
  const [title, setTitle] = useState('');
  const [category, setCategory] = useState<'berita' | 'pengumuman' | 'agenda'>('berita');
  const [excerpt, setExcerpt] = useState('');
  const [content, setContent] = useState('');
  const [isPublished, setIsPublished] = useState(true);

  const fetchPosts = async () => {
    setLoading(true);
    try {
      const data = await adminService.getPosts({
        category: selectedCategory || undefined,
        search: search || undefined,
      });
      setPosts(data);
    } catch (err: any) {
      console.error('Gagal mengambil data postingan:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchPosts();
  }, [search, selectedCategory]);

  const handleOpenModal = () => {
    setEditingPost(null);
    setTitle('');
    setCategory('berita');
    setExcerpt('');
    setContent('');
    setIsPublished(true);
    setFormError(null);
    setIsModalOpen(true);
  };

  const handleOpenEdit = (p: PostItem) => {
    setEditingPost(p);
    setTitle(p.title);
    setCategory(p.category as 'berita' | 'pengumuman' | 'agenda');
    setExcerpt(p.excerpt || '');
    setContent(p.content || '');
    setIsPublished(p.is_published);
    setFormError(null);
    setIsModalOpen(true);
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!title.trim() || !content.trim()) {
      setFormError('Judul dan isi konten publikasi wajib diisi.');
      return;
    }

    setSubmitting(true);
    setFormError(null);
    try {
      if (editingPost) {
        await adminService.updatePost(editingPost.id, {
          title,
          category,
          excerpt: excerpt || undefined,
          content,
          is_published: isPublished,
        });
      } else {
        await adminService.createPost({
          title,
          category,
          excerpt: excerpt || undefined,
          content,
          is_published: isPublished,
        });
      }
      setIsModalOpen(false);
      fetchPosts();
    } catch (err: any) {
      const msg = err.response?.data?.message || err.message || 'Gagal menyimpan postingan.';
      setFormError(msg);
    } finally {
      setSubmitting(false);
    }
  };

  const handleDelete = async (id: number, postTitle: string) => {
    if (!window.confirm(`Yakin ingin menghapus publikasi "${postTitle}" dari portal?`)) {
      return;
    }
    try {
      await adminService.deletePost(id);
      setPosts((prev) => prev.filter((p) => p.id !== id));
    } catch (err: any) {
      alert(err.response?.data?.message || 'Gagal menghapus postingan.');
    }
  };

  const getCategoryBadge = (cat: string) => {
    switch (cat.toLowerCase()) {
      case 'berita':
        return <span className="px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">Berita</span>;
      case 'pengumuman':
        return <span className="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">Pengumuman</span>;
      case 'agenda':
        return <span className="px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-50 text-purple-700 border border-purple-200">Agenda</span>;
      default:
        return <span className="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">{cat}</span>;
    }
  };

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div className="flex items-center gap-2">
            <h1 className="text-xl sm:text-2xl font-black text-[#171B61] tracking-tight">
              Publikasi & Pengumuman Portal
            </h1>
            <span className="text-xs font-bold bg-[#E5ECFF] text-[#233DFF] px-2.5 py-0.5 rounded-full">
              {posts.length} Konten Terbit
            </span>
          </div>
          <p className="text-xs text-slate-500 mt-1">
            Kelola rilis berita sekolah, pengumuman kedinasan, agenda kegiatan, dan portal informasi publik.
          </p>
        </div>

        <button
          type="button"
          onClick={handleOpenModal}
          className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1B30D9] shadow-md shadow-indigo-600/20 transition cursor-pointer"
        >
          <Plus className="w-4 h-4" />
          <span>Tulis Publikasi Baru</span>
        </button>
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
                placeholder="Cari judul berita atau pengumuman..."
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                className="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF]"
              />
            </div>

            <select
              value={selectedCategory}
              onChange={(e) => setSelectedCategory(e.target.value)}
              className="px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 bg-white focus:outline-none focus:border-[#233DFF]"
            >
              <option value="">Semua Kategori</option>
              <option value="berita">Berita</option>
              <option value="pengumuman">Pengumuman</option>
              <option value="agenda">Agenda</option>
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
              <p className="text-xs font-medium">Memuat data publikasi...</p>
            </div>
          ) : posts.length === 0 ? (
            <div className="p-12 text-center text-slate-400">
              <p className="text-sm font-semibold">Belum ada publikasi yang cocok dengan pencarian.</p>
              <p className="text-xs mt-1">Gunakan tombol "Tulis Publikasi Baru" untuk memposting artikel baru.</p>
            </div>
          ) : (
            <table className="w-full text-left text-xs">
              <thead className="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold border-b border-slate-100">
                <tr>
                  <th className="px-6 py-4">Judul Publikasi</th>
                  <th className="px-6 py-4">Kategori</th>
                  <th className="px-6 py-4">Penulis</th>
                  <th className="px-6 py-4">Tanggal Rilis</th>
                  <th className="px-6 py-4">Status</th>
                  <th className="px-6 py-4 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100 font-medium">
                {posts.map((p) => (
                  <tr key={p.id} className="hover:bg-slate-50/80 transition">
                    <td className="px-6 py-4">
                      <div className="flex items-center gap-3">
                        <div className="w-9 h-9 rounded-xl bg-indigo-50 text-[#233DFF] flex items-center justify-center shrink-0">
                          <FileText className="w-4 h-4" />
                        </div>
                        <div className="max-w-md">
                          <span className="font-bold text-slate-900 text-sm block line-clamp-1">{p.title}</span>
                          <span className="text-[11px] text-slate-400 line-clamp-1">{p.excerpt}</span>
                        </div>
                      </div>
                    </td>
                    <td className="px-6 py-4">
                      {getCategoryBadge(p.category)}
                    </td>
                    <td className="px-6 py-4 font-semibold text-slate-700">
                      {p.author}
                    </td>
                    <td className="px-6 py-4 text-slate-600 font-mono text-[11px]">
                      {p.published_at}
                    </td>
                    <td className="px-6 py-4">
                      {p.is_published ? (
                        <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                          <CheckCircle2 className="w-3.5 h-3.5" /> Terbit
                        </span>
                      ) : (
                        <span className="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                          Draft
                        </span>
                      )}
                    </td>
                    <td className="px-6 py-4 text-right">
                      <div className="flex items-center justify-end gap-1.5">
                        <button
                          type="button"
                          onClick={() => handleOpenEdit(p)}
                          className="p-1.5 rounded-lg text-slate-400 hover:text-[#233DFF] hover:bg-blue-50 transition cursor-pointer"
                          title="Edit Publikasi"
                        >
                          <Edit2 className="w-4 h-4" />
                        </button>
                        <button
                          type="button"
                          onClick={() => handleDelete(p.id, p.title)}
                          className="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer"
                          title="Hapus Publikasi"
                        >
                          <Trash2 className="w-4 h-4" />
                        </button>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          )}
        </div>
      </div>

      {/* Modal Tulis Publikasi */}
      {isModalOpen && (
        <div className="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-3xl max-w-xl w-full shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in-95 duration-150 max-h-[90vh] flex flex-col">
            <div className="p-5 border-b border-slate-100 flex items-center justify-between shrink-0">
              <div>
                <h3 className="font-bold text-slate-900 text-base">
                  {editingPost ? 'Edit Publikasi Portal' : 'Tulis Publikasi Portal Baru'}
                </h3>
                <p className="text-xs text-slate-500">
                  {editingPost ? 'Perbarui informasi rilis berita atau pengumuman.' : 'Rilis berita atau pengumuman resmi ke seluruh pengguna.'}
                </p>
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
                <label className="block text-xs font-bold text-slate-700 mb-1">Judul Publikasi *</label>
                <input
                  type="text"
                  required
                  placeholder="Contoh: Pembagian Rapor Semester Ganjil T.A 2026/2027"
                  value={title}
                  onChange={(e) => setTitle(e.target.value)}
                  className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                />
              </div>

              <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">Kategori Publikasi *</label>
                  <select
                    value={category}
                    onChange={(e) => setCategory(e.target.value as any)}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white outline-none focus:border-[#233DFF]"
                  >
                    <option value="berita">Berita Sekolah</option>
                    <option value="pengumuman">Pengumuman Resmi</option>
                    <option value="agenda">Agenda Kegiatan</option>
                  </select>
                </div>
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">Ringkasan Singkat (Excerpt)</label>
                  <input
                    type="text"
                    placeholder="Deskripsi 1 kalimat untuk pratinjau..."
                    value={excerpt}
                    onChange={(e) => setExcerpt(e.target.value)}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                  />
                </div>
              </div>

              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1">Isi Konten Publikasi *</label>
                <textarea
                  rows={6}
                  required
                  placeholder="Tuliskan isi berita, pengumuman, atau detail agenda di sini..."
                  value={content}
                  onChange={(e) => setContent(e.target.value)}
                  className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none resize-none"
                />
              </div>

              <div className="flex items-center gap-2 pt-2">
                <input
                  type="checkbox"
                  id="post_published"
                  checked={isPublished}
                  onChange={(e) => setIsPublished(e.target.checked)}
                  className="w-4 h-4 text-[#233DFF] rounded-md border-slate-300 focus:ring-[#233DFF]"
                />
                <label htmlFor="post_published" className="text-xs font-bold text-slate-700 cursor-pointer">
                  Langsung terbitkan ke publik sekarang
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
                  <span>{submitting ? 'Menyimpan...' : (editingPost ? 'Simpan Perubahan' : 'Terbitkan Publikasi')}</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};
