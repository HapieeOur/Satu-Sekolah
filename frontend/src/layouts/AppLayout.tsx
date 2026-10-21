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
  Search,
  Bell,
  Share2
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

  const navItems = [
    { name: 'Dashboard', path: '/dashboard', icon: <LayoutDashboard className="w-4 h-4" /> },
    ...(hasRole('admin')
      ? [{ name: 'Kelola Pengguna', path: '/admin/users', icon: <Users className="w-4 h-4" /> }]
      : []),
    ...(hasRole(['admin', 'guru'])
      ? [
          { name: 'Data Rombel / Kelas', path: '/admin/classrooms', icon: <BookOpen className="w-4 h-4" /> },
          { name: 'Mitra Industri PKL', path: '/admin/companies', icon: <Building2 className="w-4 h-4" /> },
        ]
      : []),
    ...(hasRole(['admin', 'guru_pembimbing_pkl', 'pembimbing_dudi'])
      ? [
          { name: 'Penempatan Siswa', path: '/admin/placements', icon: <Briefcase className="w-4 h-4" /> },
          { name: 'Presensi & Koreksi', path: '/admin/attendances', icon: <Clock className="w-4 h-4" /> },
        ]
      : []),
    ...(hasRole(['admin', 'wali_kelas', 'guru_pembimbing_pkl'])
      ? [{ name: 'Laporan Institusi', path: '/admin/reports', icon: <FileText className="w-4 h-4" /> }]
      : []),
  ];

  return (
    <div className="min-h-screen bg-[#F0F2F8] p-2 sm:p-4 lg:p-6 flex items-center justify-center font-sans antialiased text-slate-800">
      {/* Outer Rounded Container matching the Reference UI Window */}
      <div className="w-full max-w-[1600px] h-[96vh] bg-white rounded-[32px] sm:rounded-[38px] shadow-[0_20px_60px_-15px_rgba(23,27,97,0.07)] border border-slate-200/70 flex overflow-hidden relative">
        
        {/* Mobile Sidebar Overlay */}
        {sidebarOpen && (
          <div
            onClick={() => setSidebarOpen(false)}
            className="fixed inset-0 z-40 bg-slate-950/40 backdrop-blur-xs lg:hidden transition-opacity"
          />
        )}

        {/* Left Sidebar (Matching Reference UI Light/Clean Sidebar) */}
        <aside
          className={`fixed inset-y-0 left-0 z-50 w-64 bg-[#F8FAFD] border-r border-slate-200/80 flex flex-col justify-between transition-transform duration-300 ease-in-out lg:static lg:inset-auto lg:z-auto ${
            sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
          }`}
        >
          {/* Top Brand Header */}
          <div className="p-6 pb-4">
            <div className="flex items-center justify-between">
              <Link to="/dashboard" className="flex items-center gap-3 group">
                <div className="w-10 h-10 rounded-2xl bg-white p-1.5 flex items-center justify-center shadow-xs border border-slate-200/80 group-hover:scale-105 transition-transform duration-200">
                  <img src="/images/logo/icon.png" alt="Satu Sekolah" className="w-full h-full object-contain" />
                </div>
                <div>
                  <span className="font-black text-slate-900 text-base tracking-tight leading-none block">
                    SATU<span className="text-[#233DFF]">SEKOLAH</span>
                  </span>
                  <span className="text-[10px] font-semibold text-slate-400 tracking-wider uppercase mt-1 block">
                    School Portal
                  </span>
                </div>
              </Link>
              <button
                onClick={() => setSidebarOpen(false)}
                className="lg:hidden p-1.5 rounded-xl text-slate-400 hover:text-slate-700"
              >
                <X className="w-5 h-5" />
              </button>
            </div>
          </div>

          {/* Navigation Links with Reference Pill Active Style */}
          <nav className="flex-1 px-4 py-2 space-y-1.5 overflow-y-auto">
            {navItems.map((item) => {
              const active = isActive(item.path);
              return (
                <Link
                  key={item.path}
                  to={item.path}
                  onClick={() => setSidebarOpen(false)}
                  className={`flex items-center gap-3.5 px-4 py-3 rounded-2xl text-xs font-bold transition-all duration-200 ${
                    active
                      ? 'bg-white text-slate-900 shadow-xs border border-slate-200/70 font-black'
                      : 'text-slate-500 hover:text-slate-900 hover:bg-white/60'
                  }`}
                >
                  <span className={active ? 'text-[#233DFF]' : 'text-slate-400'}>
                    {item.icon}
                  </span>
                  <span>{item.name}</span>
                </Link>
              );
            })}
          </nav>

          {/* User Profile Pill at Bottom (Matching Reference UI Avatar Card) */}
          <div className="p-4 border-t border-slate-200/70 bg-[#F4F6FB]/60">
            <div className="bg-white rounded-2xl p-3 border border-slate-200/80 shadow-xs flex items-center justify-between">
              <div className="flex items-center gap-2.5 min-w-0">
                <div className="w-9 h-9 rounded-full bg-gradient-to-tr from-[#171B61] to-[#233DFF] text-white flex items-center justify-center font-bold text-xs uppercase shrink-0">
                  {user.name.charAt(0)}
                </div>
                <div className="min-w-0">
                  <p className="text-xs font-black text-slate-800 truncate">{user.name}</p>
                  <p className="text-[10px] text-slate-400 truncate">{user.email}</p>
                </div>
              </div>
              <button
                onClick={handleLogout}
                title="Keluar"
                className="p-1.5 text-slate-400 hover:text-rose-600 rounded-xl hover:bg-rose-50 transition"
              >
                <LogOut className="w-4 h-4" />
              </button>
            </div>
          </div>
        </aside>

        {/* Right Main Content Panel */}
        <div className="flex-1 flex flex-col min-w-0 overflow-hidden bg-white">
          {/* Top Bar (Matching Reference Header: Welcome Greeting, Search, Notification, Location, Action Button) */}
          <header className="px-6 lg:px-8 py-5 border-b border-slate-100 flex items-center justify-between gap-4 bg-white shrink-0">
            {/* Left: Mobile Toggle & Greeting */}
            <div className="flex items-center gap-3">
              <button
                onClick={() => setSidebarOpen(true)}
                aria-label="Buka Menu"
                className="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100"
              >
                <Menu className="w-5 h-5" />
              </button>
              <div>
                <h1 className="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                  Welcome, {user.name.split(' ')[0]}!
                </h1>
              </div>
            </div>

            {/* Center: Integrated Pill Search Bar */}
            <div className="hidden md:flex items-center relative max-w-xs w-full">
              <Search className="w-4 h-4 text-slate-400 absolute left-3.5 pointer-events-none" />
              <input
                type="text"
                placeholder="Search..."
                className="w-full bg-[#F4F6FB] text-xs font-medium text-slate-700 pl-9 pr-4 py-2 rounded-full border border-transparent focus:border-[#233DFF]/30 focus:bg-white focus:outline-none transition"
              />
            </div>

            {/* Right: Notifications, Role Pill, and Dark Action Button */}
            <div className="flex items-center gap-3">
              {/* Notifications Pill */}
              <Link
                to="/news"
                className="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#F4F6FB] hover:bg-slate-100 text-slate-600 text-xs font-bold transition"
              >
                <Bell className="w-3.5 h-3.5 text-slate-500" />
                <span className="text-[11px] font-extrabold text-[#233DFF]">+4</span>
              </Link>

              {/* Role Indicator Pill */}
              <div className="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#E5ECFF] text-[#233DFF] text-xs font-extrabold">
                <span className="w-2 h-2 rounded-full bg-[#233DFF]" />
                <span className="capitalize">{user.roles[0]?.replace('_', ' ')}</span>
              </div>

              {/* Dark Action Pill Button (Matching "Share access" button in Reference) */}
              <Link
                to="/"
                target="_blank"
                className="inline-flex items-center gap-2 px-5 py-2 rounded-full text-xs font-extrabold text-white bg-[#171B61] hover:bg-[#233DFF] shadow-md shadow-indigo-950/15 hover:-translate-y-0.5 transition-all"
              >
                <Share2 className="w-3.5 h-3.5" />
                <span>Web Sekolah</span>
              </Link>
            </div>
          </header>

          {/* Main Scrollable View */}
          <main className="flex-1 overflow-y-auto p-5 sm:p-6 lg:p-8 bg-white">
            <div className="max-w-[1400px] mx-auto space-y-6">{children}</div>
          </main>
        </div>
      </div>
    </div>
  );
};
