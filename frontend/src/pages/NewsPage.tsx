import React, { useEffect, useState } from 'react';
import { Newspaper, Search, Calendar, User, ArrowLeft } from 'lucide-react';
import { Link } from 'react-router-dom';
import { schoolService } from '../api/schoolService';
import { Post } from '../types/school';
import { Input } from '../components/common/Input';
import { Button } from '../components/common/Button';

export const NewsPage: React.FC = () => {
  const [posts, setPosts] = useState<Post[]>([]);
  const [search, setSearch] = useState('');
  const [isLoading, setIsLoading] = useState(true);

  const fetchNews = async (searchTerm = '') => {
    setIsLoading(true);
    try {
      const data = await schoolService.getNews(searchTerm);
      setPosts(data);
    } catch {
      setPosts([]);
    } finally {
      setIsLoading(false);
    }
  };

  useEffect(() => {
    fetchNews();
  }, []);

  const handleSearchSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    fetchNews(search);
  };

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
      {/* Header */}
      <div className="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-slate-200/80 pb-6">
        <div>
          <Link to="/" className="inline-flex items-center text-xs font-semibold text-brand-600 hover:text-brand-700 mb-2">
            <ArrowLeft className="w-3.5 h-3.5 mr-1" />
            <span>Kembali ke Beranda</span>
          </Link>
          <h1 className="text-2xl sm:text-3xl font-extrabold text-slate-900">Warta & Pengumuman Sekolah</h1>
          <p className="text-xs text-slate-500 mt-1">Dapatkan informasi resmi seputar kegiatan, prestasi, dan agenda sekolah</p>
        </div>

        {/* Search bar */}
        <form onSubmit={handleSearchSubmit} className="flex gap-2 max-w-md w-full">
          <Input
            placeholder="Cari judul atau topik berita..."
            value={search}
            onChange={(e) => setSearch(e.target.value)}
            icon={<Search className="w-4 h-4" />}
          />
          <Button type="submit" size="sm" className="whitespace-nowrap">
            Cari
          </Button>
        </form>
      </div>

      {/* Grid posts */}
      {isLoading ? (
        <div className="py-20 text-center">
          <div className="w-10 h-10 border-4 border-brand-200 border-t-brand-600 rounded-full animate-spin mx-auto mb-3" />
          <p className="text-xs font-semibold text-slate-500">Memuat kabar berita...</p>
        </div>
      ) : posts.length === 0 ? (
        <div className="bg-white rounded-2xl border border-dashed border-slate-200 p-12 text-center text-slate-500">
          <Newspaper className="w-12 h-12 text-slate-300 mx-auto mb-3" />
          <h3 className="text-sm font-bold text-slate-700">Tidak ada berita yang ditemukan</h3>
          <p className="text-xs text-slate-400 mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
        </div>
      ) : (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {posts.map((post) => (
            <article key={post.id} className="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm flex flex-col hover:shadow-md transition">
              {post.image_url ? (
                <img src={post.image_url} alt={post.title} className="w-full h-48 object-cover" />
              ) : (
                <div className="w-full h-48 bg-slate-100 flex items-center justify-center text-slate-400">
                  <Newspaper className="w-12 h-12 opacity-30" />
                </div>
              )}
              <div className="p-5 flex-1 flex flex-col justify-between">
                <div>
                  <div className="flex items-center gap-2 mb-2">
                    <span className="text-[10px] font-bold uppercase tracking-wider text-brand-600 bg-brand-50 px-2 py-0.5 rounded-full">
                      {post.type}
                    </span>
                    <span className="text-[11px] text-slate-400 flex items-center gap-1">
                      <Calendar className="w-3 h-3" />
                      {new Date(post.published_at).toLocaleDateString('id-ID')}
                    </span>
                  </div>
                  <h2 className="text-base font-bold text-slate-900 leading-snug">
                    {post.title}
                  </h2>
                  <p className="text-xs text-slate-600 mt-2 line-clamp-3 leading-relaxed">
                    {post.excerpt || post.content}
                  </p>
                </div>

                <div className="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                  <span className="flex items-center gap-1">
                    <User className="w-3.5 h-3.5 text-slate-400" />
                    {post.author.name}
                  </span>
                </div>
              </div>
            </article>
          ))}
        </div>
      )}
    </div>
  );
};
