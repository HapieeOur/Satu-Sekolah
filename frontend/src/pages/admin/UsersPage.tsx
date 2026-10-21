import React, { useState, useEffect } from 'react';
import {
  Search,
  Plus,
  Trash2,
  X,
  Loader2,
  Edit2,
  Power,
  Shield,
  Users,
  AlertCircle
} from 'lucide-react';
import { adminService, UserItem } from '../../api/adminService';
import { useAuth } from '../../context/AuthContext';

export const UsersPage: React.FC = () => {
  const { user: currentUser } = useAuth();
  const [users, setUsers] = useState<UserItem[]>([]);
  const [stats, setStats] = useState({ total_users: 0, active_users: 0, teacher_users: 0 });
  const [roles, setRoles] = useState<string[]>([]);
  const [loading, setLoading] = useState<boolean>(true);
  const [errorMsg, setErrorMsg] = useState<string | null>(null);

  // Filters
  const [search, setSearch] = useState('');
  const [selectedRole, setSelectedRole] = useState('');
  const [selectedStatus, setSelectedStatus] = useState('');

  // Modals state
  const [isAddOpen, setIsAddOpen] = useState(false);
  const [isEditOpen, setIsEditOpen] = useState(false);
  const [editingUser, setEditingUser] = useState<UserItem | null>(null);
  const [submitting, setSubmitting] = useState(false);
  const [formError, setFormError] = useState<string | null>(null);

  // Form Fields
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [passwordConfirmation, setPasswordConfirmation] = useState('');
  const [phone, setPhone] = useState('');
  const [nis, setNis] = useState('');
  const [nisn, setNisn] = useState('');
  const [chosenRoles, setChosenRoles] = useState<string[]>(['guru']);
  const [isActive, setIsActive] = useState(true);

  const fetchUsers = async () => {
    setLoading(true);
    setErrorMsg(null);
    try {
      const [res, roleData] = await Promise.all([
        adminService.getUsers({
          search: search || undefined,
          role: selectedRole || undefined,
          status: selectedStatus || undefined,
        }),
        adminService.getRoles().catch(() => ['admin', 'guru', 'wali_kelas', 'guru_pembimbing_pkl', 'siswa']),
      ]);

      setUsers(res.users || []);
      if (res.stats) {
        setStats(res.stats);
      } else {
        setStats({
          total_users: res.users.length,
          active_users: res.users.filter((u) => u.is_active).length,
          teacher_users: res.users.filter((u) => u.roles.some((r) => r.includes('guru') || r.includes('wali'))).length,
        });
      }

      if (roleData && roleData.length > 0) {
        setRoles(roleData);
      }
    } catch (err: any) {
      console.error('Gagal mengambil data user:', err);
      const msg = err.response?.data?.message || err.message || 'Gagal terhubung ke database server.';
      setErrorMsg(msg);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchUsers();
  }, [selectedRole, selectedStatus]);

  const handleSearchSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    fetchUsers();
  };

  const handleResetFilter = () => {
    setSearch('');
    setSelectedRole('');
    setSelectedStatus('');
  };

  // Open Create Modal
  const handleOpenAdd = () => {
    setName('');
    setEmail('');
    setPassword('');
    setPasswordConfirmation('');
    setPhone('');
    setNis('');
    setNisn('');
    setChosenRoles(['guru']);
    setIsActive(true);
    setFormError(null);
    setIsAddOpen(true);
  };

  // Open Edit Modal
  const handleOpenEdit = (u: UserItem) => {
    setEditingUser(u);
    setName(u.name);
    setEmail(u.email);
    setPassword('');
    setPasswordConfirmation('');
    setPhone(u.phone || '');
    setNis(u.nis || '');
    setNisn(u.nisn || '');
    setChosenRoles(u.roles && u.roles.length > 0 ? u.roles : ['guru']);
    setIsActive(u.is_active);
    setFormError(null);
    setIsEditOpen(true);
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

  // Submit Create
  const handleCreateSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!name.trim() || !email.trim() || !password.trim()) {
      setFormError('Nama lengkap, email, dan kata sandi wajib diisi.');
      return;
    }
    if (password.length < 6) {
      setFormError('Kata sandi minimal 6 karakter.');
      return;
    }
    if (passwordConfirmation && password !== passwordConfirmation) {
      setFormError('Konfirmasi kata sandi tidak cocok.');
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
        nis: nis || undefined,
        nisn: nisn || undefined,
        roles: chosenRoles,
        is_active: isActive,
      });
      setIsAddOpen(false);
      fetchUsers();
    } catch (err: any) {
      const msg = err.response?.data?.message || err.message || 'Gagal menambahkan pengguna.';
      setFormError(msg);
    } finally {
      setSubmitting(false);
    }
  };

  // Submit Edit
  const handleEditSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!editingUser) return;
    if (!name.trim() || !email.trim()) {
      setFormError('Nama lengkap dan email wajib diisi.');
      return;
    }
    if (password && password.length < 6) {
      setFormError('Kata sandi baru minimal 6 karakter.');
      return;
    }
    if (password && passwordConfirmation && password !== passwordConfirmation) {
      setFormError('Konfirmasi kata sandi tidak cocok.');
      return;
    }

    setSubmitting(true);
    setFormError(null);
    try {
      await adminService.updateUser(editingUser.id, {
        name,
        email,
        password: password || undefined,
        phone: phone || undefined,
        nis: nis || undefined,
        nisn: nisn || undefined,
        roles: chosenRoles,
        is_active: isActive,
      });
      setIsEditOpen(false);
      fetchUsers();
    } catch (err: any) {
      const msg = err.response?.data?.message || err.message || 'Gagal memperbarui data pengguna.';
      setFormError(msg);
    } finally {
      setSubmitting(false);
    }
  };

  // Toggle Active Status
  const handleToggleStatus = async (u: UserItem) => {
    const actionText = u.is_active ? 'menonaktifkan' : 'mengaktifkan';
    if (!window.confirm(`Yakin ingin ${actionText} akun "${u.name}"?`)) {
      return;
    }
    try {
      await adminService.toggleUserStatus(u.id);
      fetchUsers();
    } catch (err: any) {
      alert(err.response?.data?.message || 'Gagal mengubah status akun.');
    }
  };

  // Delete User
  const handleDelete = async (u: UserItem) => {
    if (!window.confirm(`Apakah Anda yakin ingin menghapus akun "${u.name}"? Tindakan ini tidak dapat dibatalkan.`)) {
      return;
    }
    try {
      await adminService.deleteUser(u.id);
      setUsers((prev) => prev.filter((item) => item.id !== u.id));
    } catch (err: any) {
      alert(err.response?.data?.message || 'Gagal menghapus pengguna.');
    }
  };

  const getRoleDesc = (r: string) => {
    switch (r) {
      case 'admin':
        return 'Akses penuh kelola sistem & master data';
      case 'guru':
        return 'Akses jadwal mengajar & presensi sesi';
      case 'wali_kelas':
        return 'Rekap presensi & monitoring kelas';
      case 'guru_pembimbing_pkl':
        return 'Verifikasi jurnal & tugas PKL';
      case 'siswa':
        return 'Akses jadwal kelas, presensi & jurnal PKL (login via NISN)';
      default:
        return 'Hak akses portal';
    }
  };

  return (
    <div className="space-y-6">
      {/* Top Hero / Page Header matching Blade */}
      <div className="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 p-6 md:p-8 text-white shadow-xl">
        <div className="absolute -right-12 -top-12 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none" />
        <div className="absolute -left-12 -bottom-12 w-64 h-64 bg-[#233DFF]/10 rounded-full blur-3xl pointer-events-none" />

        <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div>
            <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-300 text-xs font-semibold mb-3">
              <Shield className="w-3.5 h-3.5" />
              <span>Access Management &amp; RBAC</span>
            </div>
            <h1 className="text-2xl md:text-3xl font-extrabold tracking-tight text-white">
              Daftar Akun Pengguna
            </h1>
            <p className="text-sm text-slate-300 mt-1 max-w-xl">
              Atur hak akses staf administrasi, dewan guru, wali kelas, dan pembimbing PKL melalui sistem multi-role RBAC.
            </p>
          </div>
          <div className="flex items-center gap-3">
            <button
              type="button"
              onClick={handleOpenAdd}
              className="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold text-xs shadow-lg shadow-indigo-500/25 transition duration-150 transform hover:-translate-y-0.5 cursor-pointer"
            >
              <Plus className="w-4 h-4" />
              <span>Tambah Pengguna Baru</span>
            </button>
          </div>
        </div>

        {/* Bento Stats Sub-row matching Blade */}
        <div className="relative z-10 grid grid-cols-2 sm:grid-cols-4 gap-3 mt-6 pt-6 border-t border-white/10">
          <div className="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-xs">
            <span className="text-[11px] font-medium text-slate-400 block">Total Pengguna</span>
            <span className="text-xl font-bold text-white mt-0.5 block">{stats.total_users} Akun</span>
          </div>
          <div className="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-xs">
            <span className="text-[11px] font-medium text-slate-400 block">Akun Aktif</span>
            <span className="text-xl font-bold text-emerald-400 mt-0.5 block">{stats.active_users} Aktif</span>
          </div>
          <div className="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-xs">
            <span className="text-[11px] font-medium text-slate-400 block">Role Guru &amp; Wali</span>
            <span className="text-xl font-bold text-sky-400 mt-0.5 block">{stats.teacher_users} Tenaga Pendidik</span>
          </div>
          <div className="p-3 rounded-xl bg-white/5 border border-white/10 backdrop-blur-xs">
            <span className="text-[11px] font-medium text-slate-400 block">Status Keamanan</span>
            <span className="text-xl font-bold text-indigo-400 mt-0.5 block">Bcrypt Secured</span>
          </div>
        </div>
      </div>

      {/* Filter Card matching Blade */}
      <div className="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-5">
        <form onSubmit={handleSearchSubmit} className="grid grid-cols-1 sm:grid-cols-4 gap-3">
          {/* Search */}
          <div className="sm:col-span-2 relative">
            <span className="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
              <Search className="w-4 h-4" />
            </span>
            <input
              type="text"
              name="search"
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              placeholder="Cari nama, email, NISN, NIS, atau no. telepon..."
              className="w-full pl-10 pr-4 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] bg-slate-50/50 text-slate-800 outline-none"
            />
          </div>

          {/* Role Filter */}
          <div>
            <select
              value={selectedRole}
              onChange={(e) => setSelectedRole(e.target.value)}
              className="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] bg-slate-50/50 text-slate-800 outline-none"
            >
              <option value="">Semua Peran (Role)</option>
              {(roles.length > 0 ? roles : ['admin', 'guru', 'wali_kelas', 'guru_pembimbing_pkl', 'siswa']).map((r) => (
                <option key={r} value={r}>
                  {r.toUpperCase().replace(/_/g, ' ')}
                </option>
              ))}
            </select>
          </div>

          {/* Status Filter & Buttons */}
          <div className="flex items-center gap-2">
            <select
              value={selectedStatus}
              onChange={(e) => setSelectedStatus(e.target.value)}
              className="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] bg-slate-50/50 text-slate-800 outline-none"
            >
              <option value="">Semua Status</option>
              <option value="active">Aktif</option>
              <option value="inactive">Nonaktif</option>
            </select>
            <button
              type="submit"
              className="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-xl shadow-xs transition min-h-[42px] shrink-0 cursor-pointer"
            >
              Filter
            </button>
            {(search || selectedRole || selectedStatus) && (
              <button
                type="button"
                onClick={handleResetFilter}
                className="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition min-h-[42px] flex items-center shrink-0 cursor-pointer"
              >
                Reset
              </button>
            )}
          </div>
        </form>
      </div>

      {/* Users Table Card matching Blade */}
      <div className="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        {errorMsg && (
          <div className="p-4 bg-rose-50 border-b border-rose-100 flex items-center justify-between gap-3 text-rose-700 text-xs font-semibold">
            <div className="flex items-center gap-2">
              <AlertCircle className="w-4 h-4 shrink-0" />
              <span>{errorMsg}</span>
            </div>
            <button
              type="button"
              onClick={fetchUsers}
              className="px-3 py-1 bg-rose-600 text-white rounded-lg hover:bg-rose-700 text-xs cursor-pointer"
            >
              Muat Ulang
            </button>
          </div>
        )}

        <div className="overflow-x-auto">
          {loading ? (
            <div className="py-16 text-center text-slate-400 flex flex-col items-center justify-center gap-2">
              <Loader2 className="w-7 h-7 animate-spin text-[#233DFF]" />
              <p className="text-xs font-semibold text-slate-600">Menghubungkan ke database...</p>
            </div>
          ) : users.length === 0 ? (
            <div className="py-16 px-4 text-center">
              <div className="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center mx-auto mb-3">
                <Users className="w-8 h-8" />
              </div>
              <h4 className="text-sm font-bold text-slate-800">Tidak Ditemukan Pengguna</h4>
              <p className="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-4">
                Tidak ada akun pengguna yang cocok dengan kueri atau filter pencarian Anda di database.
              </p>
              <button
                type="button"
                onClick={handleOpenAdd}
                className="inline-flex items-center gap-1.5 px-4 py-2 bg-[#233DFF] hover:bg-[#1B30D9] text-white text-xs font-semibold rounded-xl shadow-xs transition cursor-pointer"
              >
                <Plus className="w-4 h-4" />
                <span>Tambah Pengguna Baru</span>
              </button>
            </div>
          ) : (
            <table className="w-full text-left border-collapse text-xs">
              <thead>
                <tr className="bg-slate-50/75 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-600">
                  <th className="py-3.5 px-5">Pengguna</th>
                  <th className="py-3.5 px-4">Kontak Telepon</th>
                  <th className="py-3.5 px-4">Hak Akses &amp; Peran (Roles)</th>
                  <th className="py-3.5 px-4">Status Akun</th>
                  <th className="py-3.5 px-4">Terdaftar</th>
                  <th className="py-3.5 px-5 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-slate-100 font-medium">
                {users.map((u) => {
                  const isSelf = currentUser && currentUser.id === u.id;
                  const initials = u.name
                    ? u.name
                        .split(' ')
                        .filter(Boolean)
                        .slice(0, 2)
                        .map((n) => n[0])
                        .join('')
                        .toUpperCase()
                    : 'US';

                  return (
                    <tr key={u.id} className="hover:bg-indigo-50/30 transition-colors duration-150">
                      {/* Pengguna Column */}
                      <td className="py-4 px-5">
                        <div className="flex items-center gap-3">
                          <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white font-extrabold flex items-center justify-center text-xs shadow-xs shrink-0">
                            {initials}
                          </div>
                          <div>
                            <div className="font-bold text-slate-900 text-sm flex items-center gap-1.5">
                              <span>{u.name}</span>
                              {isSelf && (
                                <span className="text-[10px] px-2 py-0.5 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full font-bold">
                                  Anda
                                </span>
                              )}
                            </div>
                            <div className="text-[11px] text-slate-400 flex flex-wrap items-center gap-1.5 mt-0.5">
                              <span>{u.email}</span>
                              {u.nisn && (
                                <span className="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-mono font-semibold bg-blue-50 text-[#233DFF] border border-blue-200/80">
                                  NISN: {u.nisn}
                                </span>
                              )}
                              {!u.nisn && u.nis && (
                                <span className="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-mono font-semibold bg-blue-50 text-[#233DFF] border border-blue-200/80">
                                  NIS: {u.nis}
                                </span>
                              )}
                            </div>
                          </div>
                        </div>
                      </td>

                      {/* Kontak Telepon */}
                      <td className="py-4 px-4 font-mono text-slate-600">
                        {u.phone || '—'}
                      </td>

                      {/* Hak Akses & Peran */}
                      <td className="py-4 px-4">
                        <div className="flex flex-wrap gap-1.5 max-w-sm">
                          {u.roles && u.roles.length > 0 ? (
                            u.roles.map((r) => (
                              <span
                                key={r}
                                className="px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200 uppercase tracking-tight"
                              >
                                {r.replace(/_/g, ' ')}
                              </span>
                            ))
                          ) : (
                            <span className="text-slate-400 italic text-[11px]">Tanpa Role</span>
                          )}
                        </div>
                      </td>

                      {/* Status Akun */}
                      <td className="py-4 px-4">
                        {u.is_active ? (
                          <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                            <span className="w-1.5 h-1.5 rounded-full bg-emerald-500" />
                            Aktif
                          </span>
                        ) : (
                          <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-800 border border-rose-200">
                            <span className="w-1.5 h-1.5 rounded-full bg-rose-500" />
                            Nonaktif
                          </span>
                        )}
                      </td>

                      {/* Terdaftar */}
                      <td className="py-4 px-4 text-slate-500 font-mono text-[11px]">
                        {u.created_at}
                      </td>

                      {/* Aksi matching Blade */}
                      <td className="py-4 px-5 text-right whitespace-nowrap">
                        <div className="inline-flex items-center gap-1.5 justify-end">
                          <button
                            type="button"
                            onClick={() => handleOpenEdit(u)}
                            className="p-2 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition cursor-pointer"
                            title="Edit Pengguna"
                          >
                            <Edit2 className="w-4 h-4" />
                          </button>

                          {!isSelf && (
                            <>
                              <button
                                type="button"
                                onClick={() => handleToggleStatus(u)}
                                className={`p-2 rounded-lg transition cursor-pointer ${
                                  u.is_active
                                    ? 'text-amber-600 hover:bg-amber-50'
                                    : 'text-emerald-600 hover:bg-emerald-50'
                                }`}
                                title={u.is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun'}
                              >
                                <Power className="w-4 h-4" />
                              </button>

                              <button
                                type="button"
                                onClick={() => handleDelete(u)}
                                className="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer"
                                title="Hapus Akun"
                              >
                                <Trash2 className="w-4 h-4" />
                              </button>
                            </>
                          )}
                        </div>
                      </td>
                    </tr>
                  );
                })}
              </tbody>
            </table>
          )}
        </div>
      </div>

      {/* MODAL TAMBAH PENGGUNA (Matching Blade Create Form) */}
      {isAddOpen && (
        <div className="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-2xl max-w-2xl w-full shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in-95 duration-150 max-h-[90vh] flex flex-col">
            <div className="p-6 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white flex items-center justify-between shrink-0">
              <div>
                <h2 className="text-lg font-bold">Formulir Tambah Akun Pengguna</h2>
                <p className="text-xs text-slate-300 mt-0.5">
                  Lengkapi data kredensial akun dan tetapkan hak akses multi-role (RBAC) yang sesuai.
                </p>
              </div>
              <button
                type="button"
                onClick={() => setIsAddOpen(false)}
                className="p-1.5 text-slate-300 hover:text-white rounded-lg hover:bg-white/10 transition"
              >
                <X className="w-5 h-5" />
              </button>
            </div>

            <form onSubmit={handleCreateSubmit} className="p-6 md:p-8 space-y-4 overflow-y-auto text-xs">
              {formError && (
                <div className="p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">
                  {formError}
                </div>
              )}

              {/* Nama Lengkap */}
              <div>
                <label className="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                  Nama Lengkap &amp; Gelar <span className="text-rose-500">*</span>
                </label>
                <input
                  type="text"
                  required
                  placeholder="Contoh: Budi Santoso, S.Pd., M.Kom."
                  value={name}
                  onChange={(e) => setName(e.target.value)}
                  className="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] text-slate-800 transition outline-none"
                />
              </div>

              {/* Email & No. HP */}
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label className="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Alamat Email (Login) <span className="text-rose-500">*</span>
                  </label>
                  <input
                    type="email"
                    required
                    placeholder="nama@satusekolah.sch.id"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    className="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] text-slate-800 transition outline-none"
                  />
                </div>
                <div>
                  <label className="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Nomor WhatsApp / HP
                  </label>
                  <input
                    type="text"
                    placeholder="081234567890"
                    value={phone}
                    onChange={(e) => setPhone(e.target.value)}
                    className="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] text-slate-800 transition font-mono outline-none"
                  />
                </div>
              </div>

              {/* Identitas Siswa */}
              <div className="p-4 rounded-2xl bg-blue-50/50 border border-blue-200/70 space-y-3">
                <div className="flex items-center justify-between">
                  <div>
                    <span className="block text-xs font-bold text-slate-900">Identitas Siswa (NISN &amp; NIS)</span>
                    <p className="text-[11px] text-slate-500">Khusus untuk akun siswa agar siswa dapat login menggunakan NISN/NIS.</p>
                  </div>
                  <span className="text-[10px] font-bold px-2 py-0.5 rounded-md bg-[#233DFF]/10 text-[#233DFF] border border-[#233DFF]/20">
                    Login Siswa
                  </span>
                </div>

                <div className="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                  <div>
                    <label className="block font-bold uppercase tracking-wider text-slate-700 mb-1 text-[11px]">
                      NISN (10 Digit)
                    </label>
                    <input
                      type="text"
                      placeholder="0071234567"
                      value={nisn}
                      onChange={(e) => setNisn(e.target.value)}
                      className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] text-slate-800 font-mono outline-none"
                    />
                  </div>
                  <div>
                    <label className="block font-bold uppercase tracking-wider text-slate-700 mb-1 text-[11px]">
                      NIS
                    </label>
                    <input
                      type="text"
                      placeholder="20261101"
                      value={nis}
                      onChange={(e) => setNis(e.target.value)}
                      className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] text-slate-800 font-mono outline-none"
                    />
                  </div>
                </div>
              </div>

              {/* Password & Konfirmasi */}
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label className="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Password Login <span className="text-rose-500">*</span>
                  </label>
                  <input
                    type="password"
                    required
                    placeholder="Minimal 6 karakter"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    className="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] text-slate-800 transition outline-none"
                  />
                </div>
                <div>
                  <label className="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Konfirmasi Password <span className="text-rose-500">*</span>
                  </label>
                  <input
                    type="password"
                    required
                    placeholder="Ulangi password sama"
                    value={passwordConfirmation}
                    onChange={(e) => setPasswordConfirmation(e.target.value)}
                    className="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] text-slate-800 transition outline-none"
                  />
                </div>
              </div>

              {/* Multi-Role Checkboxes */}
              <div className="pt-2">
                <label className="block font-bold uppercase tracking-wider text-slate-700 mb-2">
                  Peran &amp; Hak Akses (Pilih satu atau lebih) <span className="text-rose-500">*</span>
                </label>
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-2.5 p-3.5 bg-slate-50/60 rounded-2xl border border-slate-200">
                  {(roles.length > 0 ? roles : ['admin', 'guru', 'wali_kelas', 'guru_pembimbing_pkl', 'siswa']).map((r) => {
                    const isChecked = chosenRoles.includes(r);
                    return (
                      <label
                        key={r}
                        className={`flex items-start gap-2.5 p-2.5 rounded-xl border cursor-pointer transition ${
                          isChecked
                            ? 'border-indigo-400 bg-indigo-50/40 text-indigo-900'
                            : 'border-slate-200/80 bg-white hover:border-indigo-200 hover:bg-slate-50 text-slate-700'
                        }`}
                      >
                        <input
                          type="checkbox"
                          checked={isChecked}
                          onChange={() => handleRoleToggle(r)}
                          className="mt-0.5 rounded text-indigo-600 focus:ring-indigo-500 border-slate-300"
                        />
                        <div>
                          <span className="block text-xs font-bold uppercase">{r.replace(/_/g, ' ')}</span>
                          <span className="block text-[10px] text-slate-500 mt-0.5 leading-snug">
                            {getRoleDesc(r)}
                          </span>
                        </div>
                      </label>
                    );
                  })}
                </div>
              </div>

              {/* Status Akun */}
              <div className="pt-2">
                <label className="flex items-center gap-3 cursor-pointer">
                  <input
                    type="checkbox"
                    checked={isActive}
                    onChange={(e) => setIsActive(e.target.checked)}
                    className="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500"
                  />
                  <div>
                    <span className="block text-xs font-bold text-slate-800">Aktifkan Akun Pengguna</span>
                    <span className="block text-[11px] text-slate-400">Pengguna hanya dapat login jika akun berstatus aktif.</span>
                  </div>
                </label>
              </div>

              <div className="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100">
                <button
                  type="button"
                  onClick={() => setIsAddOpen(false)}
                  className="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition cursor-pointer"
                >
                  Batal
                </button>
                <button
                  type="submit"
                  disabled={submitting}
                  className="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-md shadow-indigo-600/20 disabled:opacity-60 transition cursor-pointer"
                >
                  {submitting && <Loader2 className="w-3.5 h-3.5 animate-spin" />}
                  <span>{submitting ? 'Menyimpan...' : 'Simpan Pengguna'}</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      )}

      {/* MODAL EDIT PENGGUNA (Matching Blade Edit Form) */}
      {isEditOpen && editingUser && (
        <div className="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
          <div className="bg-white rounded-2xl max-w-2xl w-full shadow-2xl border border-slate-100 overflow-hidden animate-in fade-in zoom-in-95 duration-150 max-h-[90vh] flex flex-col">
            <div className="p-6 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white flex items-center justify-between shrink-0">
              <div>
                <h2 className="text-lg font-bold">Perbarui Akun: {editingUser.name}</h2>
                <p className="text-xs text-slate-300 mt-0.5">
                  Ubah profil akun, kata sandi, peran hak akses, atau status keaktifan.
                </p>
              </div>
              <button
                type="button"
                onClick={() => setIsEditOpen(false)}
                className="p-1.5 text-slate-300 hover:text-white rounded-lg hover:bg-white/10 transition"
              >
                <X className="w-5 h-5" />
              </button>
            </div>

            <form onSubmit={handleEditSubmit} className="p-6 md:p-8 space-y-4 overflow-y-auto text-xs">
              {formError && (
                <div className="p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">
                  {formError}
                </div>
              )}

              {/* Nama Lengkap */}
              <div>
                <label className="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                  Nama Lengkap &amp; Gelar <span className="text-rose-500">*</span>
                </label>
                <input
                  type="text"
                  required
                  value={name}
                  onChange={(e) => setName(e.target.value)}
                  className="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] text-slate-800 transition outline-none"
                />
              </div>

              {/* Email & No. HP */}
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label className="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Alamat Email (Login) <span className="text-rose-500">*</span>
                  </label>
                  <input
                    type="email"
                    required
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    className="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] text-slate-800 transition outline-none"
                  />
                </div>
                <div>
                  <label className="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Nomor WhatsApp / HP
                  </label>
                  <input
                    type="text"
                    value={phone}
                    onChange={(e) => setPhone(e.target.value)}
                    className="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] text-slate-800 transition font-mono outline-none"
                  />
                </div>
              </div>

              {/* Identitas Siswa */}
              <div className="p-4 rounded-2xl bg-blue-50/50 border border-blue-200/70 space-y-3">
                <span className="block text-xs font-bold text-slate-900">Identitas Siswa (NISN &amp; NIS)</span>
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                  <div>
                    <label className="block font-bold uppercase tracking-wider text-slate-700 mb-1 text-[11px]">
                      NISN (10 Digit)
                    </label>
                    <input
                      type="text"
                      value={nisn}
                      onChange={(e) => setNisn(e.target.value)}
                      className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] text-slate-800 font-mono outline-none"
                    />
                  </div>
                  <div>
                    <label className="block font-bold uppercase tracking-wider text-slate-700 mb-1 text-[11px]">
                      NIS
                    </label>
                    <input
                      type="text"
                      value={nis}
                      onChange={(e) => setNis(e.target.value)}
                      className="w-full px-3.5 py-2 text-xs rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] text-slate-800 font-mono outline-none"
                    />
                  </div>
                </div>
              </div>

              {/* Password Baru (Opsional) */}
              <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label className="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Kata Sandi Baru (Kosongkan jika tidak diubah)
                  </label>
                  <input
                    type="password"
                    placeholder="Minimal 6 karakter"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    className="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] text-slate-800 transition outline-none"
                  />
                </div>
                <div>
                  <label className="block font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Konfirmasi Kata Sandi Baru
                  </label>
                  <input
                    type="password"
                    placeholder="Ulangi kata sandi baru"
                    value={passwordConfirmation}
                    onChange={(e) => setPasswordConfirmation(e.target.value)}
                    className="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] text-slate-800 transition outline-none"
                  />
                </div>
              </div>

              {/* Multi-Role Checkboxes */}
              <div className="pt-2">
                <label className="block font-bold uppercase tracking-wider text-slate-700 mb-2">
                  Peran &amp; Hak Akses <span className="text-rose-500">*</span>
                </label>
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-2.5 p-3.5 bg-slate-50/60 rounded-2xl border border-slate-200">
                  {(roles.length > 0 ? roles : ['admin', 'guru', 'wali_kelas', 'guru_pembimbing_pkl', 'siswa']).map((r) => {
                    const isChecked = chosenRoles.includes(r);
                    return (
                      <label
                        key={r}
                        className={`flex items-start gap-2.5 p-2.5 rounded-xl border cursor-pointer transition ${
                          isChecked
                            ? 'border-indigo-400 bg-indigo-50/40 text-indigo-900'
                            : 'border-slate-200/80 bg-white hover:border-indigo-200 hover:bg-slate-50 text-slate-700'
                        }`}
                      >
                        <input
                          type="checkbox"
                          checked={isChecked}
                          onChange={() => handleRoleToggle(r)}
                          className="mt-0.5 rounded text-indigo-600 focus:ring-indigo-500 border-slate-300"
                        />
                        <div>
                          <span className="block text-xs font-bold uppercase">{r.replace(/_/g, ' ')}</span>
                          <span className="block text-[10px] text-slate-500 mt-0.5 leading-snug">
                            {getRoleDesc(r)}
                          </span>
                        </div>
                      </label>
                    );
                  })}
                </div>
              </div>

              {/* Status Akun */}
              <div className="pt-2">
                <label className="flex items-center gap-3 cursor-pointer">
                  <input
                    type="checkbox"
                    checked={isActive}
                    onChange={(e) => setIsActive(e.target.checked)}
                    className="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500"
                  />
                  <div>
                    <span className="block text-xs font-bold text-slate-800">Status Akun Aktif</span>
                    <span className="block text-[11px] text-slate-400">Centang untuk mengizinkan pengguna login ke portal.</span>
                  </div>
                </label>
              </div>

              <div className="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100">
                <button
                  type="button"
                  onClick={() => setIsEditOpen(false)}
                  className="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition cursor-pointer"
                >
                  Batal
                </button>
                <button
                  type="submit"
                  disabled={submitting}
                  className="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-md shadow-indigo-600/20 disabled:opacity-60 transition cursor-pointer"
                >
                  {submitting && <Loader2 className="w-3.5 h-3.5 animate-spin" />}
                  <span>{submitting ? 'Memperbarui...' : 'Simpan Perubahan'}</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </div>
  );
};
