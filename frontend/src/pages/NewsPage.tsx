import React, { useEffect, useState } from 'react';
import { Search, Calendar, User, ArrowLeft, Newspaper, BookOpen } from 'lucide-react';
import { Link } from 'react-router-dom';
import { schoolService } from '../api/schoolService';
import { Post } from '../types/school';

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
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
      {/* Header matching Blade reference */}
      <div className="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-slate-200/80 pb-8">
        <div>
          <Link
            to="/"
            className="inline-flex items-center text-xs font-bold text-[#233DFF] hover:text-[#171B61] mb-3 transition"
          >
            <ArrowLeft className="w-3.5 h-3.5 mr-1.5" />
            <span>Kembali ke Beranda</span>
          </Link>
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-widest text-[#233DFF] bg-[#E5ECFF] border border-blue-200/80 mb-2 block w-fit">
            <span>WARTA INFORMASI RESMI</span>
          </div>
          <h1 className="text-3xl sm:text-4xl font-normal text-[#20211F] tracking-tight">
            Berita &amp; Kabar <span className="font-black text-[#171B61]">Satu-Sekolah</span>
          </h1>
          <p className="text-xs sm:text-sm text-[#707581] mt-1.5">
            Informasi terkini kegiatan akademik, prestasi vokasi, dan pengumuman sekolah
          </p>
        </div>

        {/* Search bar */}
        <form onSubmit={handleSearchSubmit} className="flex gap-2 max-w-md w-full">
          <div className="relative flex-1">
            <span className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
              <Search className="w-4 h-4" />
            </span>
            <input
              type="text"
              placeholder="Cari berita atau kegiatan..."
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="w-full pl-10 pr-4 py-2.5 rounded-full border border-slate-300 bg-white text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF]"
            />
          </div>
          <button
            type="submit"
            className="px-6 py-2.5 rounded-full text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1B30D9] shadow-md shadow-indigo-600/20 transition cursor-pointer"
          >
            Cari
          </button>
        </form>
      </div>

      {/* Grid posts */}
      {isLoading ? (
        <div className="py-24 text-center">
          <div className="w-10 h-10 border-4 border-indigo-200 border-t-[#233DFF] rounded-full animate-spin mx-auto mb-3" />
          <p className="text-xs font-semibold text-slate-500">Memuat warta sekolah...</p>
        </div>
      ) : posts.length === 0 ? (
        <div className="bg-white rounded-3xl border border-dashed border-slate-200 p-16 text-center text-slate-500">
          <Newspaper className="w-12 h-12 text-slate-300 mx-auto mb-3" />
          <h3 className="text-sm font-bold text-slate-700">Tidak ada berita yang ditemukan</h3>
          <p className="text-xs text-slate-400 mt-1">Gunakan kata kunci pencarian yang lain.</p>
        </div>
      ) : (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {posts.map((post) => (
            <article
              key={post.id}
              className="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs hover:shadow-card hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group"
            >
              <div>
                {post.image_url ? (
                  <div className="w-full h-48 overflow-hidden bg-slate-100">
                    <img
                      src={post.image_url}
                      alt={post.title}
                      className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    />
                  </div>
                ) : (
                  <div className="w-full h-48 bg-gradient-to-tr from-[#171B61] to-[#233DFF] flex items-center justify-center text-white/40">
                    <BookOpen className="w-12 h-12" />
                  </div>
                )}
                <div className="p-6">
                  <div className="flex items-center gap-2 mb-3">
                    <span className="text-[10px] font-extrabold uppercase tracking-wider text-[#233DFF] bg-[#E5ECFF] px-2.5 py-0.5 rounded-full">
                      {post.type}
                    </span>
                    <span className="text-[11px] text-[#707581] flex items-center gap-1 font-medium">
                      <Calendar className="w-3 h-3 text-slate-400" />
                      {new Date(post.published_at).toLocaleDateString('id-ID')}
                    </span>
                  </div>
                  <h2 className="text-base font-bold text-[#171B61] group-hover:text-[#233DFF] transition-colors leading-snug line-clamp-2">
                    {post.title}
                  </h2>
                  <p className="text-xs text-[#707581] mt-2.5 line-clamp-3 leading-relaxed">
                    {post.excerpt || post.content}
                  </p>
                </div>
              </div>

              <div className="px-6 py-4 border-t border-slate-100 flex items-center justify-between text-xs text-[#707581]">
                <span className="flex items-center gap-1 font-medium">
                  <User className="w-3.5 h-3.5 text-slate-400" />
                  {post.author.name}
                </span>
              </div>
            </article>
          ))}
        </div>
      )}
    </div>
  );
};
