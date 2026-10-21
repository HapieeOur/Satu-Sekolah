import React, { useState } from 'react';
import { Search, Plus } from 'lucide-react';

export const PlacementsPage: React.FC = () => {
  const [search, setSearch] = useState('');

  const samplePlacements = [
    {
      id: 1,
      studentName: 'Ahmad Fauzan',
      classroom: 'XII RPL 1',
      company: 'PT Telkom Indonesia (Witel Digital)',
      teacherMentor: 'Hendra Gunawan, S.Kom',
      period: '01 Juli 2026 - 31 Des 2026',
      status: 'Aktif',
    },
    {
      id: 2,
      studentName: 'Budi Santoso',
      classroom: 'XII RPL 1',
      company: 'PT Telkom Indonesia (Witel Digital)',
      teacherMentor: 'Hendra Gunawan, S.Kom',
      period: '01 Juli 2026 - 31 Des 2026',
      status: 'Aktif',
    },
    {
      id: 3,
      studentName: 'Citra Kirana',
      classroom: 'XII RPL 2',
      company: 'CV Inovasi Digital Kreatif',
      teacherMentor: 'Hendra Gunawan, S.Kom',
      period: '01 Juli 2026 - 31 Des 2026',
      status: 'Aktif',
    },
    {
      id: 4,
      studentName: 'Doni Pratama',
      classroom: 'XII TKJ 1',
      company: 'PT Astra International (Auto2000)',
      teacherMentor: 'Drs. Supriyanto, M.T',
      period: '01 Jan 2026 - 30 Juni 2026',
      status: 'Selesai',
    },
  ];

  const filtered = samplePlacements.filter(
    (p) =>
      p.studentName.toLowerCase().includes(search.toLowerCase()) ||
      p.company.toLowerCase().includes(search.toLowerCase()) ||
      p.teacherMentor.toLowerCase().includes(search.toLowerCase())
  );

  return (
    <div className="space-y-6">
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div className="flex items-center gap-2">
            <h1 className="text-xl sm:text-2xl font-black text-[#171B61] tracking-tight">
              Penempatan Siswa PKL
            </h1>
            <span className="text-xs font-bold bg-[#E5ECFF] text-[#233DFF] px-2.5 py-0.5 rounded-full">
              {samplePlacements.length} Penempatan Terdata
            </span>
          </div>
          <p className="text-xs text-slate-500 mt-1">
            Daftar siswa magang di mitra industri DUDI dan penugasan guru pembimbing PKL sekolah.
          </p>
        </div>

        <button
          type="button"
          className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1B30D9] shadow-md shadow-indigo-600/20 transition cursor-pointer"
        >
          <Plus className="w-4 h-4" />
          <span>Tempatkan Siswa Baru</span>
        </button>
      </div>

      <div className="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div className="p-5 border-b border-slate-100 flex items-center justify-between gap-4">
          <div className="relative max-w-sm w-full">
            <span className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
              <Search className="w-4 h-4" />
            </span>
            <input
              type="text"
              placeholder="Cari nama siswa, perusahaan, pembimbing..."
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF]"
            />
          </div>
          <span className="text-[11px] font-bold text-indigo-700 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-200">
            Khusus Peran: Pembimbing PKL
          </span>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-left text-xs">
            <thead className="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold border-b border-slate-100">
              <tr>
                <th className="px-6 py-4">Siswa &amp; Kelas</th>
                <th className="px-6 py-4">Mitra Industri (DUDI)</th>
                <th className="px-6 py-4">Guru Pembimbing PKL</th>
                <th className="px-6 py-4">Periode Magang</th>
                <th className="px-6 py-4">Status</th>
                <th className="px-6 py-4 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium">
              {filtered.map((p) => (
                <tr key={p.id} className="hover:bg-slate-50/80 transition">
                  <td className="px-6 py-4">
                    <span className="font-extrabold text-sm text-slate-900 block">{p.studentName}</span>
                    <span className="text-[11px] text-slate-400">{p.classroom}</span>
                  </td>
                  <td className="px-6 py-4 font-bold text-[#171B61]">{p.company}</td>
                  <td className="px-6 py-4 text-slate-700 font-medium">{p.teacherMentor}</td>
                  <td className="px-6 py-4 text-slate-500">{p.period}</td>
                  <td className="px-6 py-4">
                    <span
                      className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold ${
                        p.status === 'Aktif'
                          ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                          : 'bg-blue-50 text-blue-700 border border-blue-200'
                      }`}
                    >
                      {p.status}
                    </span>
                  </td>
                  <td className="px-6 py-4 text-right">
                    <button
                      type="button"
                      className="px-3 py-1 rounded-lg text-xs font-bold text-[#233DFF] hover:bg-blue-50 transition"
                    >
                      Kelola
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
};
