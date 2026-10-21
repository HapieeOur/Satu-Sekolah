import React, { useState } from 'react';
import { Search, Plus, CheckCircle2, Mail, Phone } from 'lucide-react';
import { RoleBadge } from '../../components/common/Badge';

export const UsersPage: React.FC = () => {
  const [search, setSearch] = useState('');

  const sampleUsers = [
    { id: 1, name: 'Administrator Sekolah', email: 'admin@example.com', phone: '081234567890', roles: ['admin'], isActive: true },
    { id: 2, name: 'Bambang Sudiro, M.Pd', email: 'bambang@sekolah.sch.id', phone: '081234567891', roles: ['guru', 'wali_kelas'], isActive: true },
    { id: 3, name: 'Hendra Gunawan, S.Kom', email: 'hendra@sekolah.sch.id', phone: '081234567892', roles: ['guru', 'guru_pembimbing_pkl'], isActive: true },
    { id: 4, name: 'Siti Aminah, S.Pd', email: 'siti@sekolah.sch.id', phone: '081234567893', roles: ['guru'], isActive: true },
    { id: 5, name: 'Rudy Hartono (PT Telkom)', email: 'rudy@telkom.co.id', phone: '081234567894', roles: ['pembimbing_dudi'], isActive: true },
    { id: 6, name: 'Ahmad Fauzan', email: 'fauzan@student.sch.id', phone: '081234567895', roles: ['siswa'], isActive: true },
  ];

  const filteredUsers = sampleUsers.filter(
    (u) =>
      u.name.toLowerCase().includes(search.toLowerCase()) ||
      u.email.toLowerCase().includes(search.toLowerCase())
  );

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div className="flex items-center gap-2">
            <h1 className="text-xl sm:text-2xl font-black text-[#171B61] tracking-tight">
              Manajemen Pengguna
            </h1>
            <span className="text-xs font-bold bg-[#E5ECFF] text-[#233DFF] px-2.5 py-0.5 rounded-full">
              {sampleUsers.length} Pengguna Terdaftar
            </span>
          </div>
          <p className="text-xs text-slate-500 mt-1">
            Kelola akun autentikasi, penugasan peran (Admin, Guru, Wali Kelas, Pembimbing PKL, Siswa), dan status akun.
          </p>
        </div>

        <div className="flex items-center gap-2.5">
          <button
            type="button"
            className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1B30D9] shadow-md shadow-indigo-600/20 transition cursor-pointer"
          >
            <Plus className="w-4 h-4" />
            <span>Tambah Pengguna</span>
          </button>
        </div>
      </div>

      {/* Filter and Table Card */}
      <div className="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div className="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
          <div className="relative max-w-sm w-full">
            <span className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
              <Search className="w-4 h-4" />
            </span>
            <input
              type="text"
              placeholder="Cari nama atau email..."
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF]"
            />
          </div>

          <div className="flex items-center gap-2 text-xs text-slate-500 font-medium">
            <span className="w-2 h-2 rounded-full bg-emerald-500" />
            <span>Auto-Profile Guru Aktif</span>
          </div>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-left text-xs">
            <thead className="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold border-b border-slate-100">
              <tr>
                <th className="px-6 py-4">Nama Lengkap</th>
                <th className="px-6 py-4">Kontak</th>
                <th className="px-6 py-4">Peran (Roles)</th>
                <th className="px-6 py-4">Status</th>
                <th className="px-6 py-4 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium">
              {filteredUsers.map((u) => (
                <tr key={u.id} className="hover:bg-slate-50/80 transition">
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-3">
                      <div className="w-9 h-9 rounded-full bg-indigo-50 text-[#233DFF] flex items-center justify-center font-bold text-xs uppercase shrink-0">
                        {u.name.charAt(0)}
                      </div>
                      <div>
                        <span className="font-bold text-slate-900 block">{u.name}</span>
                        <span className="text-[10px] text-slate-400">ID #{u.id}</span>
                      </div>
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <div className="space-y-0.5">
                      <div className="flex items-center gap-1.5 text-slate-600">
                        <Mail className="w-3.5 h-3.5 text-slate-400" />
                        <span>{u.email}</span>
                      </div>
                      {u.phone && (
                        <div className="flex items-center gap-1.5 text-slate-500 text-[11px]">
                          <Phone className="w-3.5 h-3.5 text-slate-400" />
                          <span>{u.phone}</span>
                        </div>
                      )}
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex flex-wrap gap-1">
                      {u.roles.map((r) => (
                        <RoleBadge key={r} role={r} />
                      ))}
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <span className="inline-flex items-center gap-1 text-emerald-700 font-bold bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 text-[11px]">
                      <CheckCircle2 className="w-3 h-3" /> Aktif
                    </span>
                  </td>
                  <td className="px-6 py-4 text-right">
                    <button
                      type="button"
                      className="px-3 py-1 rounded-lg text-xs font-bold text-[#233DFF] hover:bg-blue-50 transition"
                    >
                      Edit
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
