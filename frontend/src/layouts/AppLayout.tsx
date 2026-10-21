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
  ChevronLeft,
  ChevronRight,
  User as UserIcon,
  ExternalLink,
  GraduationCap,
  Calendar,
  Award
} from 'lucide-react';
import { useAuth } from '../context/AuthContext';

interface NavGroup {
  title: string;
  items: {
    name: string;
    path: string;
    icon: React.ReactNode;
  }[];
}

export const AppLayout: React.FC<{ children: React.ReactNode }> = ({ children }) => {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [collapsed, setCollapsed] = useState(false);
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

  // Grouped Navigation Items matching Blade app.blade.php
  const navGroups: NavGroup[] = [
    {
      title: 'Menu Utama',
      items: [
        { name: 'Dashboard', path: '/dashboard', icon: <LayoutDashboard className="w-5 h-5 shrink-0" /> }
      ]
    },

    // Admin Sections
    ...(hasRole('admin')
      ? [
          {
            title: 'Administrasi',
            items: [
              { name: 'Kelola Pengguna', path: '/admin/users', icon: <Users className="w-5 h-5 shrink-0" /> }
            ]
          },
          {
            title: 'Data Master',
            items: [
              { name: 'Tahun Ajaran', path: '/admin/academic-years', icon: <Calendar className="w-5 h-5 shrink-0" /> },
              { name: 'Data Guru', path: '/admin/teachers', icon: <Award className="w-5 h-5 shrink-0" /> },
              { name: 'Data Rombel / Kelas', path: '/admin/classrooms', icon: <BookOpen className="w-5 h-5 shrink-0" /> },
              { name: 'Data Siswa', path: '/admin/students', icon: <GraduationCap className="w-5 h-5 shrink-0" /> },
              { name: 'Mata Pelajaran', path: '/admin/subjects', icon: <BookOpen className="w-5 h-5 shrink-0" /> },
              { name: 'Ruangan', path: '/admin/rooms', icon: <Building2 className="w-5 h-5 shrink-0" /> },
              { name: 'Mitra Industri PKL', path: '/admin/companies', icon: <Briefcase className="w-5 h-5 shrink-0" /> }
            ]
          },
          {
            title: 'Akademik',
            items: [
              { name: 'Jadwal Pelajaran', path: '/admin/schedules', icon: <Clock className="w-5 h-5 shrink-0" /> }
            ]
          },
          {
            title: 'Monitoring PKL',
            items: [
              { name: 'Penempatan Siswa', path: '/admin/placements', icon: <Briefcase className="w-5 h-5 shrink-0" /> },
              { name: 'Presensi & Koreksi', path: '/admin/attendances', icon: <Clock className="w-5 h-5 shrink-0" /> }
            ]
          },
          {
            title: 'Publikasi Informasi',
            items: [
              { name: 'Berita & Pengumuman', path: '/admin/posts', icon: <FileText className="w-5 h-5 shrink-0" /> }
            ]
          },
          {
            title: 'Laporan',
            items: [
              { name: 'Laporan Institusi', path: '/admin/reports', icon: <FileText className="w-5 h-5 shrink-0" /> }
            ]
          }
        ]
      : []),

    // Guru Sections
    ...(hasRole('guru') && !hasRole('admin')
      ? [
          {
            title: 'Portal Guru',
            items: [
              { name: 'Jadwal Mengajar', path: '/teacher/schedules', icon: <Calendar className="w-5 h-5 shrink-0" /> },
              { name: 'Presensi Siswa Mapel', path: '/teacher/attendances', icon: <Clock className="w-5 h-5 shrink-0" /> },
              { name: 'Tugas & Penugasan', path: '/teacher/tasks', icon: <FileText className="w-5 h-5 shrink-0" /> },
              { name: 'Ujian Harian', path: '/teacher/exams', icon: <BookOpen className="w-5 h-5 shrink-0" /> },
              { name: 'Input Nilai Siswa', path: '/teacher/grades', icon: <Award className="w-5 h-5 shrink-0" /> }
            ]
          }
        ]
      : []),

    // Wali Kelas Sections
    ...(hasRole('wali_kelas') && !hasRole('admin')
      ? [
          {
            title: 'Wali Kelas',
            items: [
              { name: 'Kelas Binaan Saya', path: '/homeroom/dashboard', icon: <BookOpen className="w-5 h-5 shrink-0" /> },
              { name: 'Daftar Siswa Binaan', path: '/homeroom/students', icon: <Users className="w-5 h-5 shrink-0" /> },
              { name: 'Rekap Presensi Harian', path: '/homeroom/attendances', icon: <Clock className="w-5 h-5 shrink-0" /> }
            ]
          }
        ]
      : []),

    // Pembimbing PKL Sections
    ...(hasRole(['guru_pembimbing_pkl', 'pembimbing_dudi']) && !hasRole('admin')
      ? [
          {
            title: 'Bimbingan PKL',
            items: [
              { name: 'Dashboard Pembimbing', path: '/internship-mentor/dashboard', icon: <Briefcase className="w-5 h-5 shrink-0" /> },
              { name: 'Siswa Bimbingan', path: '/internship-mentor/students', icon: <Users className="w-5 h-5 shrink-0" /> },
              { name: 'Presensi & GPS PKL', path: '/internship-mentor/attendances', icon: <Clock className="w-5 h-5 shrink-0" /> },
              { name: 'Jurnal Harian Siswa', path: '/internship-mentor/journals', icon: <FileText className="w-5 h-5 shrink-0" /> },
              { name: 'Pengajuan Izin / Sakit', path: '/internship-mentor/leaves', icon: <Calendar className="w-5 h-5 shrink-0" /> }
            ]
          }
        ]
      : []),

    // Siswa Sections
    ...(hasRole('siswa')
      ? [
          {
            title: 'Portal Siswa',
            items: [
              { name: 'Beranda Siswa', path: '/student/dashboard', icon: <GraduationCap className="w-5 h-5 shrink-0" /> },
              { name: 'Jadwal Pelajaran', path: '/student/schedules', icon: <Calendar className="w-5 h-5 shrink-0" /> },
              { name: 'Presensi Saya', path: '/student/attendances', icon: <Clock className="w-5 h-5 shrink-0" /> },
              { name: 'Tugas Saya', path: '/student/tasks', icon: <FileText className="w-5 h-5 shrink-0" /> },
              { name: 'Ujian Harian', path: '/student/exams', icon: <BookOpen className="w-5 h-5 shrink-0" /> },
              { name: 'Informasi PKL', path: '/student/internship', icon: <Briefcase className="w-5 h-5 shrink-0" /> }
            ]
          }
        ]
      : []),

    // Shared Profile & Notifications
    {
      title: 'Akun & Bantuan',
      items: [
        { name: 'Pencarian Global', path: '/search', icon: <Search className="w-5 h-5 shrink-0" /> },
        { name: 'Profil Saya', path: '/profile', icon: <UserIcon className="w-5 h-5 shrink-0" /> },
        { name: 'Pusat Notifikasi', path: '/notifications', icon: <Bell className="w-5 h-5 shrink-0" /> }
      ]
    }
  ];

  return (
    <div className="h-screen flex overflow-hidden bg-[#F4F6FB] font-sans antialiased text-slate-800">
      {/* Mobile Sidebar Overlay */}
      {sidebarOpen && (
        <div
          onClick={() => setSidebarOpen(false)}
          className="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-xs lg:hidden transition-opacity"
        />
      )}

      {/* Colored & Collapsible Sidebar (Deep Navy #131652 matching Blade) */}
      <aside
        className={`fixed inset-y-0 left-0 z-50 bg-[#131652] text-slate-200 border-r border-[#1C206B] flex flex-col justify-between transition-all duration-300 ease-in-out lg:static lg:inset-auto lg:z-auto shrink-0 shadow-2xl lg:shadow-none ${
          collapsed ? 'w-20' : 'w-64'
        } ${sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'}`}
      >
        {/* Brand Header */}
        <div className="h-20 min-h-[80px] bg-[#0E103D] border-b border-[#1C206B] px-4 flex items-center justify-between shrink-0">
          <Link
            to="/dashboard"
            className={`flex items-center gap-3 group overflow-hidden ${
              collapsed ? 'justify-center w-full' : ''
            }`}
          >
            <div className="w-10 h-10 rounded-2xl bg-white p-1.5 flex items-center justify-center shadow-lg shadow-black/20 group-hover:scale-105 transition-transform shrink-0">
              <img src="/images/logo/icon.png" alt="Satu Sekolah" className="w-full h-full object-contain" />
            </div>
            {!collapsed && (
              <div className="min-w-0">
                <div className="flex items-center gap-1.5">
                  <span className="font-black text-white text-base tracking-tight leading-none block">
                    SATU-SEKOLAH
                  </span>
                  <span className="w-1.5 h-1.5 rounded-full bg-[#F4CF52] shrink-0" />
                </div>
                <span className="text-[10px] text-indigo-300 font-medium tracking-wide block truncate mt-1">
                  Digital School Platform
                </span>
              </div>
            )}
          </Link>

          {/* Desktop Collapse Button */}
          {!collapsed && (
            <button
              type="button"
              onClick={() => setCollapsed(true)}
              title="Kecilkan Sidebar"
              className="hidden lg:flex p-1.5 rounded-xl text-indigo-300 hover:text-white hover:bg-[#1D2275] transition cursor-pointer ml-1"
            >
              <ChevronLeft className="w-4 h-4" />
            </button>
          )}

          {/* Mobile Close Button */}
          <button
            onClick={() => setSidebarOpen(false)}
            aria-label="Tutup Menu"
            className="lg:hidden p-1.5 rounded-xl text-indigo-300 hover:text-white hover:bg-[#1D2275] transition cursor-pointer"
          >
            <X className="w-5 h-5" />
          </button>
        </div>

        {/* Grouped Navigation Links */}
        <nav className="flex-1 px-3 py-4 space-y-4 overflow-y-auto sidebar-scroll">
          {navGroups.map((group, gIdx) => (
            <div key={gIdx} className="space-y-1">
              {/* Group Title or Divider */}
              {!collapsed ? (
                <p className="px-3 text-[10px] font-extrabold text-indigo-300/60 uppercase tracking-wider mb-1.5">
                  {group.title}
                </p>
              ) : (
                gIdx > 0 && <div className="my-2 border-t border-[#1C206B]/80 mx-2" />
              )}

              {/* Group Items */}
              {group.items.map((item) => {
                const active =
                  location.pathname === item.path ||
                  (item.path !== '/dashboard' && location.pathname.startsWith(item.path));

                return (
                  <Link
                    key={item.path}
                    to={item.path}
                    onClick={() => setSidebarOpen(false)}
                    title={collapsed ? item.name : undefined}
                    className={`group relative flex items-center rounded-xl text-xs font-semibold transition-all duration-150 ${
                      collapsed ? 'justify-center p-3' : 'gap-3 px-3 py-2.5'
                    } ${
                      active
                        ? 'bg-[#233DFF] text-white shadow-md shadow-indigo-950/40 font-black'
                        : 'text-indigo-200/80 hover:bg-[#1D2275] hover:text-white'
                    }`}
                  >
                    <span className={active ? 'text-white' : 'text-indigo-300 group-hover:text-white'}>
                      {item.icon}
                    </span>
                    {!collapsed && <span>{item.name}</span>}

                    {/* Collapsed Tooltip Pill on Hover */}
                    {collapsed && (
                      <span className="absolute left-full ml-3 px-3 py-1.5 rounded-xl bg-[#0E103D] text-white text-xs font-bold whitespace-nowrap shadow-xl border border-[#1C206B] hidden group-hover:block z-50 pointer-events-none">
                        {item.name}
                      </span>
                    )}
                  </Link>
                );
              })}
            </div>
          ))}
        </nav>

        {/* Sidebar Footer User Info & Expand Button */}
        <div className="p-3 border-t border-[#1C206B] bg-[#0E103D]">
          {collapsed ? (
            <div className="flex flex-col items-center gap-2">
              <Link
                to="/profile"
                title={`Profil: ${user.name}`}
                className="w-10 h-10 rounded-xl bg-[#233DFF] text-white flex items-center justify-center font-black text-sm uppercase shadow-xs hover:ring-2 hover:ring-white/40 transition"
              >
                {user.name.charAt(0)}
              </Link>
              <button
                type="button"
                onClick={() => setCollapsed(false)}
                title="Perluas Sidebar"
                className="p-2 rounded-xl text-indigo-300 hover:text-white hover:bg-[#1D2275] transition cursor-pointer"
              >
                <ChevronRight className="w-4 h-4" />
              </button>
            </div>
          ) : (
            <div className="flex items-center justify-between">
              <Link
                to="/profile"
                className="flex items-center gap-2.5 min-w-0 group hover:opacity-90 transition"
              >
                <div className="w-9 h-9 rounded-xl bg-[#233DFF] text-white flex items-center justify-center font-black text-xs uppercase shadow-xs group-hover:ring-2 group-hover:ring-white/40 transition shrink-0">
                  {user.name.charAt(0)}
                </div>
                <div className="min-w-0">
                  <p className="text-xs font-black text-white truncate group-hover:text-indigo-200 transition">
                    {user.name}
                  </p>
                  <p className="text-[10px] text-indigo-300/70 truncate capitalize">
                    {user.roles[0]?.replace('_', ' ')}
                  </p>
                </div>
              </Link>
              <button
                onClick={handleLogout}
                title="Keluar"
                className="p-2 rounded-xl text-indigo-300 hover:text-rose-400 hover:bg-rose-500/10 transition cursor-pointer shrink-0"
              >
                <LogOut className="w-4 h-4" />
              </button>
            </div>
          )}
        </div>
      </aside>

      {/* Right Main Content Panel */}
      <div className="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#F4F6FB]">
        {/* Top Bar Header */}
        <header className="h-20 min-h-[80px] px-6 lg:px-8 border-b border-slate-200/80 flex items-center justify-between gap-4 bg-white shrink-0 z-20">
          {/* Left: Mobile Toggle, Desktop Expand/Collapse & Greeting */}
          <div className="flex items-center gap-3">
            <button
              onClick={() => setSidebarOpen(true)}
              aria-label="Buka Menu"
              className="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 cursor-pointer"
            >
              <Menu className="w-5 h-5" />
            </button>
            <button
              onClick={() => setCollapsed(!collapsed)}
              title={collapsed ? 'Perluas Sidebar' : 'Kecilkan Sidebar'}
              className="hidden lg:flex p-2 rounded-xl text-slate-600 hover:text-[#233DFF] hover:bg-slate-100 transition cursor-pointer"
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
          <form
            onSubmit={(e) => {
              e.preventDefault();
              navigate('/search');
            }}
            className="hidden md:flex items-center relative max-w-xs w-full"
          >
            <Search className="w-4 h-4 text-slate-400 absolute left-3.5 pointer-events-none" />
            <input
              type="text"
              placeholder="Cari data, rombel, siswa (Enter)..."
              onClick={() => navigate('/search')}
              className="w-full bg-[#F4F6FB] text-xs font-medium text-slate-700 pl-9 pr-4 py-2 rounded-full border border-transparent focus:border-[#233DFF]/30 focus:bg-white focus:outline-none transition cursor-pointer"
            />
          </form>

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
