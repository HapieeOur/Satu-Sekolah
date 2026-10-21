import React, { useState } from 'react';
import { Link, useLocation, useNavigate } from 'react-router-dom';
import {
  LayoutDashboard,
  Users,
  BookOpen,
  Building2,
  Briefcase,
  Clock,
  FileText,
  LogOut,
  Menu,
  X,
  ExternalLink,
  Bell,
} from 'lucide-react';
import { useAuth } from '../context/AuthContext';

export const AppLayout: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const location = useLocation();
  const navigate = useNavigate();
  const { user, logout, hasRole } = useAuth();

  if (!user) return null;

  const isActive = (path: string) => location.pathname === path;

  const handleLogout = async () => {
    await logout();
    navigate('/login');
  };

  return (
    <div className="h-screen flex overflow-hidden bg-[#F4F6FB] text-slate-800 font-sans">
      {/* Mobile Sidebar Overlay */}
      {sidebarOpen && (
        <div
          onClick={() => setSidebarOpen(false)}
          className="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-xs lg:hidden transition-opacity"
        />
      )}

      {/* Sidebar Desktop & Mobile matching Blade */}
      <aside
        className={`fixed inset-y-0 left-0 z-50 w-64 bg-[#131652] border-r border-[#1C206B] text-slate-200 flex flex-col transition-transform duration-300 ease-in-out lg:static lg:inset-auto lg:z-auto shadow-2xl lg:shadow-none ${
          sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
        }`}
      >
        {/* Brand / Header with Logo Icon */}
        <div className="h-20 min-h-[80px] flex items-center justify-between px-6 py-4 border-b border-[#1C206B] bg-[#0E103D]">
          <Link to="/dashboard" className="flex items-center gap-3.5 group">
            <div className="w-11 h-11 rounded-2xl bg-white p-2 flex items-center justify-center shadow-lg shadow-black/20 group-hover:scale-105 transition-transform duration-200 shrink-0">
              <img src="/images/logo/icon.png" alt="oneSchool" className="w-full h-full object-contain" />
            </div>
            <div className="min-w-0">
              <div className="flex items-center gap-1.5">
                <span className="font-black text-white text-base tracking-tight leading-tight">
                  SATU-SEKOLAH
                </span>
                <span className="w-1.5 h-1.5 rounded-full bg-[#F4CF52] shrink-0" />
              </div>
              <span className="text-[10px] text-indigo-300 font-medium tracking-wide block truncate">
                Digital School Platform
              </span>
            </div>
          </Link>
          <button
            onClick={() => setSidebarOpen(false)}
            aria-label="Tutup Menu"
            className="lg:hidden p-2 rounded-xl text-indigo-300 hover:text-white hover:bg-[#1D2275] transition shrink-0 ml-1"
          >
            <X className="w-5 h-5" />
          </button>
        </div>

        {/* Navigation Menu matching Blade */}
        <nav className="flex-1 px-3 py-4 overflow-y-auto space-y-5 text-xs">
          {/* Menu Utama */}
          <div>
            <p className="px-3 text-[10px] font-bold text-indigo-300/70 uppercase tracking-wider mb-1.5">
              Menu Utama
            </p>
            <div className="space-y-1">
              <Link
                to="/dashboard"
                onClick={() => setSidebarOpen(false)}
                className={`flex items-center gap-2.5 px-3 py-2 rounded-xl font-semibold transition-all duration-150 ${
                  isActive('/dashboard')
                    ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40'
                    : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white'
                }`}
              >
                <LayoutDashboard className="w-4 h-4 shrink-0" />
                <span>Dashboard</span>
              </Link>
            </div>
          </div>

          {/* Bagian Administrasi (Khusus Admin) */}
          {hasRole('admin') && (
            <div>
              <p className="px-3 text-[10px] font-bold text-indigo-300/70 uppercase tracking-wider mb-1.5">
                Administrasi
              </p>
              <div className="space-y-1">
                <Link
                  to="/admin/users"
                  onClick={() => setSidebarOpen(false)}
                  className={`flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 ${
                    isActive('/admin/users')
                      ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold'
                      : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white'
                  }`}
                >
                  <Users className="w-4 h-4 shrink-0" />
                  <span>Kelola Pengguna</span>
                </Link>
              </div>
            </div>
          )}

          {/* Data Master (Admin / Guru) */}
          {hasRole(['admin', 'guru']) && (
            <div>
              <p className="px-3 text-[10px] font-bold text-indigo-300/70 uppercase tracking-wider mb-1.5">
                Data Master
              </p>
              <div className="space-y-1">
                <Link
                  to="/admin/classrooms"
                  onClick={() => setSidebarOpen(false)}
                  className={`flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 ${
                    isActive('/admin/classrooms')
                      ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold'
                      : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white'
                  }`}
                >
                  <BookOpen className="w-4 h-4 shrink-0" />
                  <span>Data Rombel / Kelas</span>
                </Link>
                <Link
                  to="/admin/companies"
                  onClick={() => setSidebarOpen(false)}
                  className={`flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 ${
                    isActive('/admin/companies')
                      ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold'
                      : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white'
                  }`}
                >
                  <Building2 className="w-4 h-4 shrink-0" />
                  <span>Mitra Industri PKL</span>
                </Link>
              </div>
            </div>
          )}

          {/* Monitoring PKL */}
          {hasRole(['admin', 'guru_pembimbing_pkl', 'pembimbing_dudi']) && (
            <div>
              <p className="px-3 text-[10px] font-bold text-indigo-300/70 uppercase tracking-wider mb-1.5">
                Monitoring PKL
              </p>
              <div className="space-y-1">
                <Link
                  to="/admin/placements"
                  onClick={() => setSidebarOpen(false)}
                  className={`flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 ${
                    isActive('/admin/placements')
                      ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold'
                      : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white'
                  }`}
                >
                  <Briefcase className="w-4 h-4 shrink-0" />
                  <span>Penempatan Siswa</span>
                </Link>
                <Link
                  to="/admin/attendances"
                  onClick={() => setSidebarOpen(false)}
                  className={`flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 ${
                    isActive('/admin/attendances')
                      ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold'
                      : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white'
                  }`}
                >
                  <Clock className="w-4 h-4 shrink-0" />
                  <span>Presensi &amp; Koreksi PKL</span>
                </Link>
              </div>
            </div>
          )}

          {/* Laporan Institusi */}
          {hasRole(['admin', 'wali_kelas', 'guru_pembimbing_pkl']) && (
            <div>
              <p className="px-3 text-[10px] font-bold text-indigo-300/70 uppercase tracking-wider mb-1.5">
                Laporan &amp; Rekap
              </p>
              <div className="space-y-1">
                <Link
                  to="/admin/reports"
                  onClick={() => setSidebarOpen(false)}
                  className={`flex items-center gap-2.5 px-3 py-2 rounded-xl font-medium transition-all duration-150 ${
                    isActive('/admin/reports')
                      ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-900/40 font-bold'
                      : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white'
                  }`}
                >
                  <FileText className="w-4 h-4 shrink-0" />
                  <span>Laporan Institusi</span>
                </Link>
              </div>
            </div>
          )}

          {/* Role Badges Footer */}
          <div className="pt-3 border-t border-slate-800/80">
            <p className="px-3 text-[10px] font-bold text-indigo-300/70 uppercase tracking-wider mb-2">
              Peran Aktif Anda
            </p>
            <div className="px-3 flex flex-wrap gap-1.5">
              {user.roles.map((role) => (
                <span
                  key={role}
                  className="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold border bg-indigo-950/80 text-indigo-300 border-indigo-700/50"
                >
                  {role.replace('_', ' ')}
                </span>
              ))}
            </div>
          </div>
        </nav>

        {/* Sidebar Footer with User Avatar & Logout */}
        <div className="p-4 border-t border-[#1C206B] bg-[#0E103D] flex items-center justify-between">
          <div className="flex items-center gap-2.5 min-w-0">
            <div className="w-8 h-8 rounded-full bg-[#233DFF] text-white flex items-center justify-center font-bold text-xs uppercase shrink-0 shadow-xs">
              {user.name.substring(0, 2)}
            </div>
            <div className="min-w-0">
              <p className="text-xs font-bold text-white truncate">{user.name}</p>
              <p className="text-[10px] text-indigo-300/70 truncate">{user.email}</p>
            </div>
          </div>
          <button
            onClick={handleLogout}
            title="Keluar dari Portal"
            className="p-2 rounded-xl text-indigo-300 hover:text-rose-400 hover:bg-rose-500/10 transition cursor-pointer"
          >
            <LogOut className="w-4 h-4" />
          </button>
        </div>
      </aside>

      {/* Main Content Area */}
      <div className="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#F4F6FB]">
        {/* Topbar matching Blade */}
        <header className="h-20 min-h-[80px] bg-white/95 backdrop-blur-md border-b border-slate-200/80 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-10 shrink-0">
          <div className="flex items-center gap-4">
            <button
              onClick={() => setSidebarOpen(true)}
              aria-label="Toggle Sidebar"
              className="lg:hidden p-2 rounded-xl text-slate-600 hover:text-[#171B61] hover:bg-slate-100 transition cursor-pointer"
            >
              <Menu className="w-5 h-5" />
            </button>

            {/* Date Display */}
            <div className="hidden sm:flex items-center gap-2">
              <div className="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-100/90 border border-slate-200/80 text-xs font-bold text-[#171B61]">
                <Clock className="w-3.5 h-3.5 text-[#233DFF]" />
                <span>
                  {new Date().toLocaleDateString('id-ID', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                  })}
                </span>
              </div>
            </div>
          </div>

          {/* Right Controls */}
          <div className="flex items-center gap-3">
            <Link
              to="/"
              className="hidden md:inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold text-slate-600 hover:text-[#233DFF] bg-slate-100/90 hover:bg-blue-50 border border-slate-200/80 transition"
            >
              <span>Lihat Web Sekolah</span>
              <ExternalLink className="w-3 h-3" />
            </Link>

            <Link
              to="/news"
              title="Kabar & Acara"
              className="w-9 h-9 rounded-full bg-slate-100/80 hover:bg-slate-200/80 text-slate-600 hover:text-[#171B61] flex items-center justify-center transition"
            >
              <Bell className="w-4 h-4" />
            </Link>

            <div className="flex items-center pl-3 border-l border-slate-200 gap-2">
              <div className="w-9 h-9 rounded-full bg-gradient-to-tr from-[#171B61] to-[#233DFF] text-white flex items-center justify-center font-black text-xs uppercase shadow-xs">
                {user.name.charAt(0)}
              </div>
              <div className="hidden sm:block text-left">
                <span className="text-xs font-extrabold text-slate-800 block leading-tight">{user.name}</span>
                <span className="text-[10px] text-slate-400 capitalize block">{user.roles[0]?.replace('_', ' ')}</span>
              </div>
            </div>
          </div>
        </header>

        {/* Scrollable Main Content */}
        <main className="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
          <div className="max-w-7xl mx-auto">{children}</div>
        </main>
      </div>
    </div>
  );
};
