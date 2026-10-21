import React, { useState, useRef, useEffect } from 'react';
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
  Share2,
  ChevronDown,
  User as UserIcon,
  ExternalLink,
  GraduationCap,
  Calendar,
  Award
} from 'lucide-react';
import { useAuth } from '../context/AuthContext';

export const AppLayout: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [notifOpen, setNotifOpen] = useState(false);
  const [profileOpen, setProfileOpen] = useState(false);

  const notifRef = useRef<HTMLDivElement>(null);
  const profileRef = useRef<HTMLDivElement>(null);

  const location = useLocation();
  const navigate = useNavigate();
  const { user, logout, hasRole } = useAuth();

  // Close dropdowns on outside click
  useEffect(() => {
    const handleClickOutside = (e: MouseEvent) => {
      if (notifRef.current && !notifRef.current.contains(e.target as Node)) {
        setNotifOpen(false);
      }
      if (profileRef.current && !profileRef.current.contains(e.target as Node)) {
        setProfileOpen(false);
      }
    };
    document.addEventListener('mousedown', handleClickOutside);
    return () => document.removeEventListener('mousedown', handleClickOutside);
  }, []);

  if (!user) return null;

  const handleLogout = async () => {
    await logout();
    navigate('/login');
  };

  // Sample header notifications matching Blade
  const headerNotifications = [
    {
      id: 1,
      title: 'Presensi Masuk Berhasil',
      desc: 'Presensi masuk tercatat pukul 06:55 WIB (Tepat Waktu).',
      time: '10 menit yang lalu',
      unread: true,
      url: '/notifications'
    },
    {
      id: 2,
      title: 'Jurnal PKL Disetujui',
      desc: 'Mentor industri telah memvalidasi jurnal mingguan Anda.',
      time: '1 jam yang lalu',
      unread: true,
      url: '/notifications'
    },
    {
      id: 3,
      title: 'Jadwal Mata Pelajaran Diperbarui',
      desc: 'Perubahan sesi praktikum Lab Komputer hari Kamis.',
      time: '3 jam yang lalu',
      unread: true,
      url: '/notifications'
    },
    {
      id: 4,
      title: 'Sosialisasi Magang Industri DUDI',
      desc: 'Pertemuan pengenalan program magang dibuka minggu ini.',
      time: '1 hari yang lalu',
      unread: false,
      url: '/notifications'
    }
  ];

  // Dynamic Navigation Items matching Blade app.blade.php
  const navItems = [
    { name: 'Dashboard', path: '/dashboard', icon: <LayoutDashboard className="w-4 h-4" /> },

    // Admin Menus
    ...(hasRole('admin')
      ? [
          { name: 'Kelola Pengguna', path: '/admin/users', icon: <Users className="w-4 h-4" /> },
          { name: 'Data Rombel / Kelas', path: '/admin/classrooms', icon: <BookOpen className="w-4 h-4" /> },
          { name: 'Mitra Industri PKL', path: '/admin/companies', icon: <Building2 className="w-4 h-4" /> },
          { name: 'Penempatan Siswa', path: '/admin/placements', icon: <Briefcase className="w-4 h-4" /> },
          { name: 'Presensi & Koreksi', path: '/admin/attendances', icon: <Clock className="w-4 h-4" /> },
          { name: 'Laporan Institusi', path: '/admin/reports', icon: <FileText className="w-4 h-4" /> },
        ]
      : []),

    // Guru Menus
    ...(hasRole('guru') && !hasRole('admin')
      ? [
          { name: 'Jadwal Mengajar', path: '/teacher/schedules', icon: <Calendar className="w-4 h-4" /> },
          { name: 'Presensi Siswa Mapel', path: '/teacher/attendances', icon: <Clock className="w-4 h-4" /> },
          { name: 'Tugas & Penugasan', path: '/teacher/tasks', icon: <FileText className="w-4 h-4" /> },
          { name: 'Ujian Harian', path: '/teacher/exams', icon: <BookOpen className="w-4 h-4" /> },
          { name: 'Input Nilai Siswa', path: '/teacher/grades', icon: <Award className="w-4 h-4" /> },
        ]
      : []),

    // Wali Kelas Menus
    ...(hasRole('wali_kelas') && !hasRole('admin')
      ? [
          { name: 'Kelas Binaan Saya', path: '/homeroom/dashboard', icon: <BookOpen className="w-4 h-4" /> },
          { name: 'Daftar Siswa Binaan', path: '/homeroom/students', icon: <Users className="w-4 h-4" /> },
          { name: 'Rekap Presensi Harian', path: '/homeroom/attendances', icon: <Clock className="w-4 h-4" /> },
        ]
      : []),

    // Pembimbing PKL Menus
    ...(hasRole(['guru_pembimbing_pkl', 'pembimbing_dudi']) && !hasRole('admin')
      ? [
          { name: 'Dashboard Pembimbing', path: '/internship-mentor/dashboard', icon: <Briefcase className="w-4 h-4" /> },
          { name: 'Siswa Bimbingan', path: '/internship-mentor/students', icon: <Users className="w-4 h-4" /> },
          { name: 'Presensi & GPS PKL', path: '/internship-mentor/attendances', icon: <Clock className="w-4 h-4" /> },
          { name: 'Jurnal Harian Siswa', path: '/internship-mentor/journals', icon: <FileText className="w-4 h-4" /> },
          { name: 'Pengajuan Izin / Sakit', path: '/internship-mentor/leaves', icon: <Calendar className="w-4 h-4" /> },
        ]
      : []),

    // Siswa Menus
    ...(hasRole('siswa')
      ? [
          { name: 'Beranda Siswa', path: '/student/dashboard', icon: <GraduationCap className="w-4 h-4" /> },
          { name: 'Jadwal Pelajaran', path: '/student/schedules', icon: <Calendar className="w-4 h-4" /> },
          { name: 'Presensi Saya', path: '/student/attendances', icon: <Clock className="w-4 h-4" /> },
          { name: 'Tugas Saya', path: '/student/tasks', icon: <FileText className="w-4 h-4" /> },
          { name: 'Ujian Harian', path: '/student/exams', icon: <BookOpen className="w-4 h-4" /> },
          { name: 'Informasi PKL', path: '/student/internship', icon: <Briefcase className="w-4 h-4" /> },
        ]
      : []),

    // Shared Profile & Notifications
    { name: 'Profil Saya', path: '/profile', icon: <UserIcon className="w-4 h-4" /> },
    { name: 'Pusat Notifikasi', path: '/notifications', icon: <Bell className="w-4 h-4" /> },
  ];

  return (
    <div className="h-screen flex overflow-hidden bg-[#F4F6FB] font-sans antialiased text-slate-800">
      {/* Mobile Sidebar Overlay */}
      {sidebarOpen && (
        <div
          onClick={() => setSidebarOpen(false)}
          className="fixed inset-0 z-40 bg-slate-950/40 backdrop-blur-xs lg:hidden transition-opacity"
        />
      )}

      {/* Left Sidebar (Docked to full height) */}
      <aside
        className={`fixed inset-y-0 left-0 z-50 w-64 bg-[#F8FAFD] border-r border-slate-200/80 flex flex-col justify-between transition-transform duration-300 ease-in-out lg:static lg:inset-auto lg:z-auto shrink-0 ${
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
                    School Platform
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

          {/* Navigation Links */}
          <nav className="flex-1 px-4 py-2 space-y-1 overflow-y-auto">
            {navItems.map((item) => {
              const active = location.pathname === item.path || (item.path !== '/dashboard' && location.pathname.startsWith(item.path));
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

          {/* User Profile Pill at Bottom Sidebar */}
          <div className="p-4 border-t border-slate-200/70 bg-[#F4F6FB]/60">
            <Link
              to="/profile"
              className="bg-white rounded-2xl p-3 border border-slate-200/80 shadow-xs flex items-center justify-between hover:border-[#233DFF]/40 transition group"
            >
              <div className="flex items-center gap-2.5 min-w-0">
                <div className="w-9 h-9 rounded-full bg-gradient-to-tr from-[#171B61] to-[#233DFF] text-white flex items-center justify-center font-bold text-xs uppercase shrink-0">
                  {user.name.charAt(0)}
                </div>
                <div className="min-w-0">
                  <p className="text-xs font-black text-slate-800 truncate group-hover:text-[#233DFF] transition">{user.name}</p>
                  <p className="text-[10px] text-slate-400 truncate capitalize">{user.roles[0]?.replace('_', ' ')}</p>
                </div>
              </div>
              <button
                onClick={(e) => {
                  e.preventDefault();
                  handleLogout();
                }}
                title="Keluar"
                className="p-1.5 text-slate-400 hover:text-rose-600 rounded-xl hover:bg-rose-50 transition shrink-0"
              >
                <LogOut className="w-4 h-4" />
              </button>
            </Link>
          </div>
        </aside>

        {/* Right Main Content Panel */}
        <div className="flex-1 flex flex-col min-w-0 overflow-hidden bg-white">
          {/* Top Bar matching Reference UI */}
          <header className="px-6 lg:px-8 py-5 border-b border-slate-100 flex items-center justify-between gap-4 bg-white shrink-0 z-20">
            {/* Left: Mobile Toggle & Greeting */}
            <div className="flex items-center gap-3">
              <button
                onClick={() => setSidebarOpen(true)}
                aria-label="Buka Menu"
                className="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 cursor-pointer"
              >
                <Menu className="w-5 h-5" />
              </button>
              <div>
                <h1 className="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                  Welcome, {user.name.split(' ')[0]}!
                </h1>
              </div>
            </div>

            {/* Center: Search Bar */}
            <div className="hidden md:flex items-center relative max-w-xs w-full">
              <Search className="w-4 h-4 text-slate-400 absolute left-3.5 pointer-events-none" />
              <input
                type="text"
                placeholder="Cari data, rombel, siswa..."
                className="w-full bg-[#F4F6FB] text-xs font-medium text-slate-700 pl-9 pr-4 py-2 rounded-full border border-transparent focus:border-[#233DFF]/30 focus:bg-white focus:outline-none transition"
              />
            </div>

            {/* Right Controls: Notification Dropdown & Profile Dropdown */}
            <div className="flex items-center gap-3">
              {/* Notification Interactive Dropdown */}
              <div className="relative" ref={notifRef}>
                <button
                  type="button"
                  onClick={() => setNotifOpen(!notifOpen)}
                  aria-label="Notifikasi"
                  className="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#F4F6FB] hover:bg-slate-100 text-slate-600 text-xs font-bold transition cursor-pointer relative"
                >
                  <Bell className="w-3.5 h-3.5 text-slate-500" />
                  <span className="text-[11px] font-extrabold text-[#233DFF]">+4</span>
                  <span className="w-2 h-2 rounded-full bg-rose-500 absolute -top-0.5 -right-0.5 animate-pulse" />
                </button>

                {/* Notifications Popup Dropdown */}
                {notifOpen && (
                  <div className="absolute right-0 mt-3 w-80 sm:w-96 bg-white rounded-3xl shadow-2xl border border-slate-200/90 z-50 overflow-hidden animate-in fade-in zoom-in-95 duration-150">
                    <div className="p-4 bg-slate-50/90 border-b border-slate-100 flex items-center justify-between">
                      <div className="flex items-center gap-2">
                        <span className="font-black text-xs uppercase tracking-wider text-slate-800">
                          Pusat Notifikasi
                        </span>
                        <span className="px-2 py-0.5 rounded-full text-[10px] font-black bg-[#233DFF] text-white">
                          4 Baru
                        </span>
                      </div>
                      <Link
                        to="/notifications"
                        onClick={() => setNotifOpen(false)}
                        className="text-[11px] font-extrabold text-[#233DFF] hover:underline"
                      >
                        Lihat Semua &rarr;
                      </Link>
                    </div>

                    <div className="max-h-80 overflow-y-auto divide-y divide-slate-100">
                      {headerNotifications.map((notif) => (
                        <Link
                          key={notif.id}
                          to={notif.url}
                          onClick={() => setNotifOpen(false)}
                          className={`block p-4 hover:bg-slate-50 transition ${
                            notif.unread ? 'bg-blue-50/20' : ''
                          }`}
                        >
                          <div className="flex items-start gap-3">
                            <span
                              className={`w-2 h-2 rounded-full mt-1.5 shrink-0 ${
                                notif.unread ? 'bg-[#233DFF]' : 'bg-slate-300'
                              }`}
                            />
                            <div className="min-w-0 flex-1">
                              <p className="text-xs font-extrabold text-slate-900 truncate">
                                {notif.title}
                              </p>
                              <p className="text-[11px] text-slate-500 line-clamp-1 mt-0.5">
                                {notif.desc}
                              </p>
                              <span className="text-[10px] text-slate-400 mt-1 block">
                                {notif.time}
                              </span>
                            </div>
                          </div>
                        </Link>
                      ))}
                    </div>

                    <div className="p-3 bg-slate-50/80 border-t border-slate-100 text-center">
                      <Link
                        to="/notifications"
                        onClick={() => setNotifOpen(false)}
                        className="text-xs font-extrabold text-[#171B61] hover:text-[#233DFF] transition"
                      >
                        Buka Halaman Notifikasi Lengkap &rarr;
                      </Link>
                    </div>
                  </div>
                )}
              </div>

              {/* Web Sekolah Link */}
              <Link
                to="/"
                target="_blank"
                className="hidden xl:inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-extrabold text-slate-700 bg-[#F4F6FB] hover:bg-slate-100 transition"
              >
                <Share2 className="w-3.5 h-3.5 text-slate-500" />
                <span>Web Publik</span>
              </Link>

              {/* User Profile Pill & Dropdown (Pojok Kanan) */}
              <div className="relative" ref={profileRef}>
                <button
                  type="button"
                  onClick={() => setProfileOpen(!profileOpen)}
                  className="flex items-center gap-2.5 p-1 sm:pl-3 sm:pr-2.5 py-1.5 rounded-full bg-[#F4F6FB] hover:bg-slate-100 border border-slate-200/70 transition cursor-pointer"
                >
                  <div className="w-7 h-7 rounded-full bg-gradient-to-tr from-[#171B61] to-[#233DFF] text-white flex items-center justify-center text-xs font-black uppercase shadow-xs shrink-0">
                    {user.name.charAt(0)}
                  </div>
                  <div className="hidden sm:flex flex-col text-left">
                    <span className="text-xs font-black text-slate-900 max-w-[120px] truncate leading-tight">
                      {user.name}
                    </span>
                    <span className="text-[10px] text-slate-400 font-semibold leading-tight capitalize">
                      {user.roles[0]?.replace('_', ' ')}
                    </span>
                  </div>
                  <ChevronDown className="w-3.5 h-3.5 text-slate-400 shrink-0" />
                </button>

                {/* Profile Popup Dropdown Menu */}
                {profileOpen && (
                  <div className="absolute right-0 mt-3 w-64 bg-white rounded-3xl shadow-2xl border border-slate-200/90 z-50 overflow-hidden divide-y divide-slate-100 animate-in fade-in zoom-in-95 duration-150">
                    {/* Header Card */}
                    <div className="p-4 bg-slate-50/90">
                      <div className="flex items-center gap-3">
                        <div className="w-10 h-10 rounded-full bg-gradient-to-tr from-[#171B61] to-[#233DFF] text-white flex items-center justify-center font-black text-sm uppercase shrink-0 shadow-xs">
                          {user.name.charAt(0)}
                        </div>
                        <div className="min-w-0">
                          <p className="text-xs font-black text-slate-900 truncate">{user.name}</p>
                          <p className="text-[10px] text-slate-400 truncate">{user.email}</p>
                        </div>
                      </div>
                      <div className="mt-2.5 flex flex-wrap gap-1">
                        {user.roles.map((r) => (
                          <span
                            key={r}
                            className="px-2 py-0.5 rounded-md text-[9px] font-black uppercase bg-[#E5ECFF] text-[#233DFF]"
                          >
                            {r.replace('_', ' ')}
                          </span>
                        ))}
                      </div>
                    </div>

                    {/* Links */}
                    <div className="py-2 px-1 text-xs font-bold text-slate-700">
                      <Link
                        to="/profile"
                        onClick={() => setProfileOpen(false)}
                        className="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-50 hover:text-[#233DFF] transition"
                      >
                        <UserIcon className="w-4 h-4 text-slate-400" />
                        <span>Profil Saya</span>
                      </Link>
                      <Link
                        to="/notifications"
                        onClick={() => setProfileOpen(false)}
                        className="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-50 hover:text-[#233DFF] transition"
                      >
                        <Bell className="w-4 h-4 text-slate-400" />
                        <span>Pusat Notifikasi</span>
                      </Link>
                      <Link
                        to="/"
                        target="_blank"
                        onClick={() => setProfileOpen(false)}
                        className="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-50 hover:text-[#233DFF] transition"
                      >
                        <ExternalLink className="w-4 h-4 text-slate-400" />
                        <span>Web Publik Sekolah</span>
                      </Link>
                    </div>

                    {/* Logout */}
                    <div className="p-2 bg-slate-50/50">
                      <button
                        type="button"
                        onClick={() => {
                          setProfileOpen(false);
                          handleLogout();
                        }}
                        className="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-xl transition cursor-pointer"
                      >
                        <LogOut className="w-4 h-4" />
                        <span>Keluar dari Akun</span>
                      </button>
                    </div>
                  </div>
                )}
              </div>
            </div>
          </header>

          {/* Main Scrollable View */}
          <main className="flex-1 overflow-y-auto p-5 sm:p-6 lg:p-8 bg-[#F4F6FB]">
            <div className="max-w-[1600px] mx-auto space-y-6">{children}</div>
          </main>
        </div>
      </div>
  );
};
