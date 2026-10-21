import React, { useState } from 'react';
import {
  Search,
  Users,
  GraduationCap,
  BookOpen,
  FileText,
  ArrowRight
} from 'lucide-react';
import { Link } from 'react-router-dom';

export const SearchPage: React.FC = () => {
  const [query, setQuery] = useState('');

  // Sample comprehensive search data
  const students = [
    { id: 1, name: 'Ahmad Fauzan', nisn: '0051234561', class: 'XII RPL 1', type: 'Siswa' },
    { id: 2, name: 'Budi Santoso', nisn: '0051234562', class: 'XII RPL 1', type: 'Siswa' },
    { id: 3, name: 'Citra Kirana', nisn: '0051234563', class: 'XII RPL 1', type: 'Siswa' },
    { id: 4, name: 'Dewi Lestari', nisn: '0051234564', class: 'XI RPL 2', type: 'Siswa' },
  ];

  const teachers = [
    { id: 1, name: 'Bambang Sudiro, M.Pd', nip: '198507202010011005', subject: 'Pemrograman Web & Mobile', type: 'Guru' },
    { id: 2, name: 'Hendra Gunawan, S.Kom', nip: '198904122014021003', subject: 'Basis Data & SQL', type: 'Guru' },
    { id: 3, name: 'Siti Aminah, S.Pd', nip: '199201152019032012', subject: 'UI/UX & Desain Web', type: 'Guru' },
  ];

  const classrooms = [
    { id: 1, name: 'XII RPL 1', major: 'Rekayasa Perangkat Lunak', walas: 'Bambang Sudiro, M.Pd' },
    { id: 2, name: 'XI RPL 2', major: 'Rekayasa Perangkat Lunak', walas: 'Hendra Gunawan, S.Kom' },
    { id: 3, name: 'X PPLG 1', major: 'Pengembangan Perangkat Lunak & Gim', walas: 'Siti Aminah, S.Pd' },
  ];

  const posts = [
    { id: 1, title: 'Pelepasan Siswa Praktik Kerja Lapangan (PKL) Industri Batch 1', date: '20 Okt 2026', type: 'Berita' },
    { id: 2, title: 'Jadwal Penilaian Tengah Semester (PTS) Ganjil T.A. 2026/2027', date: '18 Okt 2026', type: 'Pengumuman' },
    { id: 3, title: 'Kunjungan Industri Mitra DUDI PT Telkom & Bank Jatim', date: '15 Okt 2026', type: 'Acara' },
  ];

  const filteredStudents = query
    ? students.filter(
        (s) =>
          s.name.toLowerCase().includes(query.toLowerCase()) ||
          s.nisn.includes(query) ||
          s.class.toLowerCase().includes(query.toLowerCase())
      )
    : [];

  const filteredTeachers = query
    ? teachers.filter(
        (t) =>
          t.name.toLowerCase().includes(query.toLowerCase()) ||
          t.nip.includes(query) ||
          t.subject.toLowerCase().includes(query.toLowerCase())
      )
    : [];

  const filteredClassrooms = query
    ? classrooms.filter(
        (c) =>
          c.name.toLowerCase().includes(query.toLowerCase()) ||
          c.major.toLowerCase().includes(query.toLowerCase())
      )
    : [];

  const filteredPosts = query
    ? posts.filter((p) => p.title.toLowerCase().includes(query.toLowerCase()))
    : [];

  const totalResults =
    filteredStudents.length +
    filteredTeachers.length +
    filteredClassrooms.length +
    filteredPosts.length;

  return (
    <div className="space-y-6 max-w-5xl mx-auto">
      {/* Search Header Input Card */}
      <div className="p-6 sm:p-8 bg-white rounded-3xl border border-slate-200/90 shadow-xs space-y-3">
        <label className="block text-xs font-black uppercase tracking-wider text-slate-400">
          Pencarian Data Portal Sekolah
        </label>
        <div className="relative flex items-center">
          <Search className="w-5 h-5 text-slate-400 absolute left-4 pointer-events-none" />
          <input
            type="text"
            value={query}
            onChange={(e) => setQuery(e.target.value)}
            placeholder="Cari nama siswa, NISN, guru, NIP, kelas rombel, mapel, atau pengumuman..."
            autoFocus
            className="w-full pl-12 pr-4 py-3.5 bg-[#F8FAFD] border border-slate-200 rounded-2xl text-xs sm:text-sm font-semibold text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:border-[#233DFF] focus:ring-4 focus:ring-[#233DFF]/10 transition"
          />
        </div>
        <p className="text-[11px] text-slate-400 font-medium">
          Ketik kata kunci untuk mencari data terpadu siswa, dewan guru, kelas rombel, dan publikasi resmi sekolah.
        </p>
      </div>

      {/* Results Header */}
      {query.length >= 2 && (
        <div className="flex items-center justify-between px-2">
          <p className="text-xs font-bold text-slate-600">
            Ditemukan <strong className="text-[#233DFF]">{totalResults} data</strong> untuk kata kunci "{query}"
          </p>
        </div>
      )}

      {/* Results Sections */}
      {query.length >= 2 && totalResults > 0 && (
        <div className="space-y-6">
          {/* Students Results */}
          {filteredStudents.length > 0 && (
            <div className="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs">
              <div className="px-5 py-3.5 bg-[#F8FAFD] border-b border-slate-200/80 flex items-center gap-2">
                <GraduationCap className="w-4 h-4 text-[#233DFF]" />
                <h4 className="text-xs font-extrabold text-slate-800">
                  Peserta Didik ({filteredStudents.length})
                </h4>
              </div>
              <div className="divide-y divide-slate-100">
                {filteredStudents.map((s) => (
                  <div key={s.id} className="p-4 flex items-center justify-between hover:bg-slate-50 transition">
                    <div>
                      <h5 className="text-sm font-black text-slate-900">{s.name}</h5>
                      <p className="text-xs text-slate-400">
                        NISN: {s.nisn} &bull; Kelas: <strong className="text-slate-700">{s.class}</strong>
                      </p>
                    </div>
                    <Link
                      to="/admin/students"
                      className="inline-flex items-center gap-1 text-xs font-black text-[#233DFF] hover:underline"
                    >
                      <span>Detail Siswa</span>
                      <ArrowRight className="w-3.5 h-3.5" />
                    </Link>
                  </div>
                ))}
              </div>
            </div>
          )}

          {/* Teachers Results */}
          {filteredTeachers.length > 0 && (
            <div className="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs">
              <div className="px-5 py-3.5 bg-[#F8FAFD] border-b border-slate-200/80 flex items-center gap-2">
                <Users className="w-4 h-4 text-emerald-600" />
                <h4 className="text-xs font-extrabold text-slate-800">
                  Tenaga Pendidik / Guru ({filteredTeachers.length})
                </h4>
              </div>
              <div className="divide-y divide-slate-100">
                {filteredTeachers.map((t) => (
                  <div key={t.id} className="p-4 flex items-center justify-between hover:bg-slate-50 transition">
                    <div>
                      <h5 className="text-sm font-black text-slate-900">{t.name}</h5>
                      <p className="text-xs text-slate-400">
                        NIP: {t.nip} &bull; Pengampu: <strong className="text-slate-700">{t.subject}</strong>
                      </p>
                    </div>
                    <Link
                      to="/admin/teachers"
                      className="inline-flex items-center gap-1 text-xs font-black text-[#233DFF] hover:underline"
                    >
                      <span>Detail Guru</span>
                      <ArrowRight className="w-3.5 h-3.5" />
                    </Link>
                  </div>
                ))}
              </div>
            </div>
          )}

          {/* Classrooms Results */}
          {filteredClassrooms.length > 0 && (
            <div className="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs">
              <div className="px-5 py-3.5 bg-[#F8FAFD] border-b border-slate-200/80 flex items-center gap-2">
                <BookOpen className="w-4 h-4 text-amber-600" />
                <h4 className="text-xs font-extrabold text-slate-800">
                  Rombongan Belajar ({filteredClassrooms.length})
                </h4>
              </div>
              <div className="divide-y divide-slate-100">
                {filteredClassrooms.map((c) => (
                  <div key={c.id} className="p-4 flex items-center justify-between hover:bg-slate-50 transition">
                    <div>
                      <h5 className="text-sm font-black text-slate-900">{c.name}</h5>
                      <p className="text-xs text-slate-400">
                        {c.major} &bull; Wali Kelas: <strong className="text-slate-700">{c.walas}</strong>
                      </p>
                    </div>
                    <Link
                      to="/admin/classrooms"
                      className="inline-flex items-center gap-1 text-xs font-black text-[#233DFF] hover:underline"
                    >
                      <span>Lihat Rombel</span>
                      <ArrowRight className="w-3.5 h-3.5" />
                    </Link>
                  </div>
                ))}
              </div>
            </div>
          )}

          {/* Posts Results */}
          {filteredPosts.length > 0 && (
            <div className="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs">
              <div className="px-5 py-3.5 bg-[#F8FAFD] border-b border-slate-200/80 flex items-center gap-2">
                <FileText className="w-4 h-4 text-indigo-600" />
                <h4 className="text-xs font-extrabold text-slate-800">
                  Publikasi &amp; Berita ({filteredPosts.length})
                </h4>
              </div>
              <div className="divide-y divide-slate-100">
                {filteredPosts.map((p) => (
                  <div key={p.id} className="p-4 flex items-center justify-between hover:bg-slate-50 transition">
                    <div>
                      <h5 className="text-sm font-black text-slate-900">{p.title}</h5>
                      <p className="text-xs text-slate-400">
                        Kategori: <strong className="text-[#233DFF]">{p.type}</strong> &bull; {p.date}
                      </p>
                    </div>
                    <Link
                      to="/admin/posts"
                      className="inline-flex items-center gap-1 text-xs font-black text-[#233DFF] hover:underline"
                    >
                      <span>Baca Konten</span>
                      <ArrowRight className="w-3.5 h-3.5" />
                    </Link>
                  </div>
                ))}
              </div>
            </div>
          )}
        </div>
      )}

      {/* Empty State */}
      {query.length >= 2 && totalResults === 0 && (
        <div className="p-12 text-center bg-white rounded-3xl border border-slate-200/80">
          <Search className="w-12 h-12 text-slate-300 mx-auto mb-3" />
          <h4 className="text-sm font-extrabold text-slate-800">Tidak ada data ditemukan</h4>
          <p className="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
            Coba gunakan kata kunci lain seperti nama lengkap siswa, nomor NIP/NISN, atau nama kelas.
          </p>
        </div>
      )}
    </div>
  );
};
