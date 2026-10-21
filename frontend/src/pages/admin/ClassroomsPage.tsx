import React, { useState } from 'react';
import { Search, Plus, Users, UserCheck } from 'lucide-react';

export const ClassroomsPage: React.FC = () => {
  const [search, setSearch] = useState('');

  const sampleClassrooms = [
    { id: 1, name: 'XII RPL 1', grade: 'XII', walas: 'Bambang Sudiro, M.Pd', walasNip: '197805122005011003', students: 32 },
    { id: 2, name: 'XII RPL 2', grade: 'XII', walas: 'Siti Aminah, S.Pd', walasNip: '198203152008012011', students: 31 },
    { id: 3, name: 'XI RPL 1', grade: 'XI', walas: 'Hendra Gunawan, S.Kom', walasNip: '198507202010011005', students: 34 },
    { id: 4, name: 'XI RPL 2', grade: 'XI', walas: 'Dewi Sartika, M.Kom', walasNip: '198904102014022008', students: 33 },
    { id: 5, name: 'X PPLG 1', grade: 'X', walas: 'Arief Budiman, S.T', walasNip: '199101182019031006', students: 36 },
  ];

  const filtered = sampleClassrooms.filter(
    (c) =>
      c.name.toLowerCase().includes(search.toLowerCase()) ||
      c.walas.toLowerCase().includes(search.toLowerCase())
  );

  return (
    <div className="space-y-6">
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div className="flex items-center gap-2">
            <h1 className="text-xl sm:text-2xl font-black text-[#171B61] tracking-tight">
              Data Rombongan Belajar (Kelas)
            </h1>
            <span className="text-xs font-bold bg-[#E5ECFF] text-[#233DFF] px-2.5 py-0.5 rounded-full">
              {sampleClassrooms.length} Rombel
            </span>
          </div>
          <p className="text-xs text-slate-500 mt-1">
            Daftar ruang kelas aktif dan penetapan wali kelas (khusus guru yang memiliki peran <strong>Wali Kelas</strong>).
          </p>
        </div>

        <button
          type="button"
          className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1B30D9] shadow-md shadow-indigo-600/20 transition cursor-pointer"
        >
          <Plus className="w-4 h-4" />
          <span>Tambah Kelas</span>
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
              placeholder="Cari kelas atau nama wali kelas..."
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF]"
            />
          </div>
          <span className="text-[11px] font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
            Khusus Peran: Wali Kelas
          </span>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-left text-xs">
            <thead className="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold border-b border-slate-100">
              <tr>
                <th className="px-6 py-4">Tingkat</th>
                <th className="px-6 py-4">Nama Rombel</th>
                <th className="px-6 py-4">Wali Kelas (Khusus Role Walas)</th>
                <th className="px-6 py-4">Peserta Didik</th>
                <th className="px-6 py-4 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium">
              {filtered.map((c) => (
                <tr key={c.id} className="hover:bg-slate-50/80 transition">
                  <td className="px-6 py-4 font-bold text-[#171B61]">Kelas {c.grade}</td>
                  <td className="px-6 py-4">
                    <span className="text-sm font-black text-slate-900 block">{c.name}</span>
                    <span className="text-[10px] text-slate-400">T.A. 2026/2027</span>
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-2.5">
                      <div className="w-8 h-8 rounded-full bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0">
                        <UserCheck className="w-4 h-4" />
                      </div>
                      <div>
                        <span className="font-bold text-slate-800 block">{c.walas}</span>
                        <span className="text-[10px] text-slate-400 font-mono">NIP: {c.walasNip}</span>
                      </div>
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <span className="inline-flex items-center gap-1.5 font-bold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg">
                      <Users className="w-3.5 h-3.5 text-slate-500" />
                      <span>{c.students} Siswa</span>
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
