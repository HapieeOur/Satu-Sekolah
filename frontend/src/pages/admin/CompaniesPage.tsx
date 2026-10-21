import React, { useState } from 'react';
import { Search, Plus, MapPin } from 'lucide-react';

export const CompaniesPage: React.FC = () => {
  const [search, setSearch] = useState('');

  const sampleCompanies = [
    {
      id: 1,
      name: 'PT Telkom Indonesia (Witel Digital)',
      industry: 'Telekomunikasi & Jaringan',
      address: 'Jl. Merdeka No. 45, Kompleks Graha Telkom',
      radiusMeters: 100,
      teacherMentor: 'Hendra Gunawan, S.Kom',
      teacherNip: '198507202010011005',
      dudiMentor: 'Rudy Hartono',
      phone: '021-5551234',
      activeStudents: 6,
    },
    {
      id: 2,
      name: 'CV Inovasi Digital Kreatif',
      industry: 'Software House & Web Development',
      address: 'Jl. Pemuda No. 12, Smart Hub Lt. 3',
      radiusMeters: 50,
      teacherMentor: 'Hendra Gunawan, S.Kom',
      teacherNip: '198507202010011005',
      dudiMentor: 'Bambang Irawan',
      phone: '021-5555678',
      activeStudents: 4,
    },
    {
      id: 3,
      name: 'PT Astra International (Auto2000)',
      industry: 'Otomotif & Manufaktur',
      address: 'Kawasan Industri Timur Blok C2',
      radiusMeters: 150,
      teacherMentor: 'Drs. Supriyanto, M.T',
      teacherNip: '197509182003011002',
      dudiMentor: null,
      phone: '021-8889999',
      activeStudents: 5,
    },
  ];

  const filtered = sampleCompanies.filter(
    (c) =>
      c.name.toLowerCase().includes(search.toLowerCase()) ||
      c.teacherMentor.toLowerCase().includes(search.toLowerCase())
  );

  return (
    <div className="space-y-6">
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div className="flex items-center gap-2">
            <h1 className="text-xl sm:text-2xl font-black text-[#171B61] tracking-tight">
              Mitra Industri &amp; Tempat PKL
            </h1>
            <span className="text-xs font-bold bg-[#E5ECFF] text-[#233DFF] px-2.5 py-0.5 rounded-full">
              {sampleCompanies.length} Perusahaan Mitra
            </span>
          </div>
          <p className="text-xs text-slate-500 mt-1">
            Data mitra DUDI, titik koordinat radius geofence GPS, serta penetapan guru pembimbing PKL sekolah (wajib) &amp; mentor industri.
          </p>
        </div>

        <button
          type="button"
          className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1B30D9] shadow-md shadow-indigo-600/20 transition cursor-pointer"
        >
          <Plus className="w-4 h-4" />
          <span>Tambah Mitra Industri</span>
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
              placeholder="Cari perusahaan atau pembimbing..."
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
                <th className="px-6 py-4">Nama Perusahaan &amp; Alamat</th>
                <th className="px-6 py-4">Radius Geofence</th>
                <th className="px-6 py-4">Guru Pembimbing PKL (Sekolah)</th>
                <th className="px-6 py-4">Mentor Industri</th>
                <th className="px-6 py-4 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium">
              {filtered.map((c) => (
                <tr key={c.id} className="hover:bg-slate-50/80 transition">
                  <td className="px-6 py-4">
                    <div className="space-y-1">
                      <span className="font-extrabold text-sm text-[#171B61] block">{c.name}</span>
                      <span className="text-[11px] text-slate-500 block">{c.industry}</span>
                      <div className="flex items-center gap-1 text-[11px] text-slate-400">
                        <MapPin className="w-3.5 h-3.5 text-slate-400 shrink-0" />
                        <span className="truncate max-w-xs">{c.address}</span>
                      </div>
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <span className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                      <MapPin className="w-3.5 h-3.5" />
                      <span>{c.radiusMeters} Meter</span>
                    </span>
                  </td>
                  <td className="px-6 py-4">
                    <div>
                      <span className="font-bold text-slate-900 block">{c.teacherMentor}</span>
                      <span className="text-[10px] text-slate-400 font-mono">NIP: {c.teacherNip}</span>
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    {c.dudiMentor ? (
                      <div>
                        <span className="font-bold text-slate-800 block">{c.dudiMentor}</span>
                        <span className="text-[10px] text-slate-400">Mentor DUDI</span>
                      </div>
                    ) : (
                      <span className="text-slate-400 italic text-[11px]">(Opsional / Belum Diisi)</span>
                    )}
                  </td>
                  <td className="px-6 py-4 text-right">
                    <button
                      type="button"
                      className="px-3 py-1 rounded-lg text-xs font-bold text-[#233DFF] hover:bg-blue-50 transition"
                    >
                      Detail
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
