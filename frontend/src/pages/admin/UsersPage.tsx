import React, { useState, useEffect } from 'react';
import { Search, Plus, CheckCircle2, XCircle, Mail, Phone, Trash2, X, Loader2 } from 'lucide-react';
import { RoleBadge } from '../../components/common/Badge';
import { adminService, UserItem } from '../../api/adminService';

export const UsersPage: React.FC = () => {
  const [users, setUsers] = useState<UserItem[]>([]);
  const [roles, setRoles] = useState<string[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [search, setSearch] = useState('');
  const [selectedRole, setSelectedRole] = useState<string>('');
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [submitting, setSubmitting] = useState(false);
  const [formError, setFormError] = useState<string | null>(null);

  // Form State
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [phone, setPhone] = useState('');
  const [chosenRoles, setChosenRoles] = useState<string[]>(['guru']);
  const [isActive, setIsActive] = useState(true);

  const fetchUsers = async () => {
    setLoading(true);
    try {
      const [userData, roleData] = await Promise.all([
        adminService.getUsers({ search, role: selectedRole || undefined }),
        adminService.getRoles().catch(() => ['admin', 'guru', 'wali_kelas', 'guru_pembimbing_pkl', 'siswa']),
      ]);
      setUsers(userData);
      if (roleData && roleData.length > 0) {
        setRoles(roleData);
      }
    } catch (err: any) {
      console.error('Gagal mengambil data user:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchUsers();
  }, [search, selectedRole]);

  const handleOpenModal = () => {
    setName('');
    setEmail('');
    setPassword('');
    setPhone('');
    setChosenRoles(['guru']);
    setIsActive(true);
    setFormError(null);
    setIsModalOpen(true);
  };

  const handleRoleToggle = (r: string) => {
    if (chosenRoles.includes(r)) {
      if (chosenRoles.length > 1) {
        setChosenRoles(chosenRoles.filter((item) => item !== r));
      }
    } else {
      setChosenRoles([...chosenRoles, r]);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!name.trim() || !email.trim() || !password.trim()) {
      setFormError('Nama, email, dan kata sandi wajib diisi.');
      return;
    }
    if (password.length < 6) {
      setFormError('Kata sandi minimal 6 karakter.');
      return;
    }

    setSubmitting(true);
    setFormError(null);
    try {
      await adminService.createUser({
        name,
        email,
        password,
        phone: phone || undefined,
        roles: chosenRoles,
        is_active: isActive,
      });
      setIsModalOpen(false);
      fetchUsers();
    } catch (err: any) {
      const msg = err.response?.data?.message || err.message || 'Gagal menambahkan pengguna.';
      setFormError(msg);
    } finally {
      setSubmitting(false);
    }
  };

  const handleDelete = async (id: number, userName: string) => {
    if (!window.confirm(`Yakin ingin menghapus pengguna "${userName}"? Tindakan ini tidak dapat dibatalkan.`)) {
      return;
    }
    try {
      await adminService.deleteUser(id);
      setUsers((prev) => prev.filter((u) => u.id !== id));
    } catch (err: any) {
      alert(err.response?.data?.message || 'Gagal menghapus pengguna.');
    }
  };

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
              {users.length} Akun Terdaftar
            </span>
          </div>
          <p className="text-xs text-slate-500 mt-1">
            Kelola akun autentikasi database, penugasan hak akses (Admin, Guru, Wali Kelas, Pembimbing PKL, Siswa).
          </p>
        </div>

        <div className="flex items-center gap-2.5">
          <button
            type="button"
            onClick={handleOpenModal}
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
          <div className="flex flex-wrap items-center gap-3 max-w-xl w-full">
            <div className="relative flex-1 min-w-[220px]">
              <span className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <Search className="w-4 h-4" />
              </span>
              <input
                type="text"
                placeholder="Cari nama, email, kontak..."
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                className="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF]"
              />
            </div>

            <select
              value={selectedRole}
              onChange={(e) => setSelectedRole(e.target.value)}
              className="px-3 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 bg-white focus:outline-none focus:border-[#233DFF]"
            >
              <option value="">Semua Peran</option>
              {roles.map((r) => (
                <option key={r} value={r}>
                  {r.toUpperCase()}
                </option>
              ))}
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
              <p className="text-xs font-medium">Memuat data pengguna dari database...</p>
            </div>
          ) : users.length === 0 ? (
            <div className="p-12 text-center text-slate-400">
              <p className="text-sm font-semibold">Tidak ada pengguna yang cocok dengan kriteria pencarian.</p>
              <p className="text-xs mt-1">Gunakan tombol "Tambah Pengguna" di atas untuk menambahkan akun baru.</p>
            </div>
          ) : (
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
                {users.map((u) => (
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
                        {u.roles && u.roles.length > 0 ? (
                          u.roles.map((r) => <RoleBadge key={r} role={r} />)
                        ) : (
                          <span className="text-[10px] text-slate-400 italic">Tanpa Peran</span>
                        )}
                      </div>
                    </td>
                    <td className="px-6 py-4">
                      {u.is_active ? (
                        <span className="inline-flex items-center gap-1 text-emerald-700 font-bold bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 text-[11px]">
                          <CheckCircle2 className="w-3 h-3" /> Aktif
                        </span>
                      ) : (
                        <span className="inline-flex items-center gap-1 text-rose-700 font-bold bg-rose-50 px-2.5 py-0.5 rounded-full border border-rose-200 text-[11px]">
                          <XCircle className="w-3 h-3" /> Nonaktif
                        </span>
                      )}
                    </td>
                    <td className="px-6 py-4 text-right">
                      <button
                        type="button"
                        onClick={() => handleDelete(u.id, u.name)}
                        className="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer"
                        title="Hapus Pengguna"
                      >
                        <Trash2 className="w-4 h-4" />
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          )}
        </div>
      </div>

      {/* Modal Tambah Pengguna */}
      {isModalOpen && (
        <div className="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            <div className="p-5 border-b border-slate-100 flex items-center justify-between">
              <div>
                <h3 className="font-bold text-slate-900 text-base">Tambah Pengguna Baru</h3>
                <p className="text-xs text-slate-500">Buat akun login baru dan simpan ke database.</p>
              </div>
              <button
                type="button"
                onClick={() => setIsModalOpen(false)}
                className="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition"
              >
                <X className="w-5 h-5" />
              </button>
            </div>

            <form onSubmit={handleSubmit} className="p-6 space-y-4">
              {formError && (
                <div className="p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">
                  {formError}
                </div>
              )}

              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                <input
                  type="text"
                  required
                  placeholder="Contoh: Ahmad Subardjo, S.Pd"
                  value={name}
                  onChange={(e) => setName(e.target.value)}
                  className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                />
              </div>

              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1">Email Sekolah *</label>
                <input
                  type="email"
                  required
                  placeholder="ahmad@oneschool.sch.id"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                />
              </div>

              <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">Kata Sandi *</label>
                  <input
                    type="password"
                    required
                    placeholder="Minimal 6 karakter"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                  />
                </div>
                <div>
                  <label className="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp / HP</label>
                  <input
                    type="text"
                    placeholder="08123456789"
                    value={phone}
                    onChange={(e) => setPhone(e.target.value)}
                    className="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] outline-none"
                  />
                </div>
              </div>

              <div>
                <label className="block text-xs font-bold text-slate-700 mb-1.5">Penugasan Peran (Roles) *</label>
                <div className="flex flex-wrap gap-2">
                  {(roles.length > 0 ? roles : ['admin', 'guru', 'wali_kelas', 'guru_pembimbing_pkl', 'siswa']).map((r) => {
                    const isChecked = chosenRoles.includes(r);
                    return (
                      <button
                        key={r}
                        type="button"
                        onClick={() => handleRoleToggle(r)}
                        className={`px-3 py-1.5 rounded-xl text-xs font-bold border transition cursor-pointer ${
                          isChecked
                            ? 'bg-[#233DFF] text-white border-[#233DFF] shadow-xs'
                            : 'bg-slate-50 text-slate-600 border-slate-200 hover:border-slate-300'
                        }`}
                      >
                        {r.toUpperCase()}
                      </button>
                    );
                  })}
                </div>
              </div>

              <div className="flex items-center gap-2 pt-2">
                <input
                  type="checkbox"
                  id="user_active"
                  checked={isActive}
                  onChange={(e) => setIsActive(e.target.checked)}
                  className="w-4 h-4 text-[#233DFF] rounded-md border-slate-300 focus:ring-[#233DFF]"
                />
                <label htmlFor="user_active" className="text-xs font-bold text-slate-700 cursor-pointer">
                  Akun langsung aktif dan dapat login
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
                  <span>{submitting ? 'Menyimpan...' : 'Simpan ke Database'}</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};
