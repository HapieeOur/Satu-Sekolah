import React, { useState } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { GraduationCap, Menu, X, LogIn, LayoutDashboard, LogOut, User as UserIcon } from 'lucide-react';
import { useAuth } from '../../context/AuthContext';
import { Button } from './Button';

export const Navbar: React.FC = () => {
  const [isOpen, setIsOpen] = useState(false);
  const location = useLocation();
  const { user, isAuthenticated, logout } = useAuth();

  const navLinks = [
    { name: 'Beranda', path: '/' },
    { name: 'Berita & Pengumuman', path: '/news' },
    { name: 'Profil Sekolah', path: '/about' },
  ];

  const isActive = (path: string) => location.pathname === path;

  return (
    <header className="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200/80">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between h-16 items-center">
          {/* Logo & Brand */}
          <Link to="/" className="flex items-center space-x-3 group">
            <div className="w-10 h-10 rounded-xl bg-brand-600 flex items-center justify-center text-white shadow-md shadow-brand-500/20 group-hover:scale-105 transition duration-150">
              <GraduationCap className="w-6 h-6" />
            </div>
            <div>
              <span className="text-base font-extrabold text-slate-900 tracking-tight block">Satu Sekolah</span>
              <span className="text-[10px] font-semibold tracking-wider uppercase text-brand-600 block">Sistem Terpadu</span>
            </div>
          </Link>

          {/* Desktop Navigation */}
          <nav className="hidden md:flex items-center space-x-1">
            {navLinks.map((link) => (
              <Link
                key={link.path}
                to={link.path}
                className={`px-3.5 py-2 rounded-xl text-xs font-semibold transition ${
                  isActive(link.path)
                    ? 'text-brand-600 bg-brand-50/80 font-bold'
                    : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/60'
                }`}
              >
                {link.name}
              </Link>
            ))}
          </nav>

          {/* Desktop Right Side: Auth buttons */}
          <div className="hidden md:flex items-center space-x-3">
            {isAuthenticated && user ? (
              <div className="flex items-center space-x-3">
                <Link to="/dashboard">
                  <Button variant="secondary" size="sm" className="space-x-1.5">
                    <LayoutDashboard className="w-4 h-4 text-brand-600" />
                    <span>Dashboard</span>
                  </Button>
                </Link>
                <div className="flex items-center pl-3 border-l border-slate-200 space-x-2">
                  <div className="w-8 h-8 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center font-bold text-xs uppercase">
                    {user.name.charAt(0)}
                  </div>
                  <span className="text-xs font-semibold text-slate-700 max-w-[120px] truncate">{user.name}</span>
                  <button
                    onClick={() => logout()}
                    title="Keluar"
                    className="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition"
                  >
                    <LogOut className="w-4 h-4" />
                  </button>
                </div>
              </div>
            ) : (
              <Link to="/login">
                <Button size="sm" className="space-x-1.5 shadow-sm">
                  <LogIn className="w-4 h-4" />
                  <span>Masuk Portal</span>
                </Button>
              </Link>
            )}
          </div>

          {/* Mobile menu button */}
          <div className="flex md:hidden items-center">
            <button
              onClick={() => setIsOpen(!isOpen)}
              className="p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none"
              aria-label="Toggle Menu"
            >
              {isOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
            </button>
          </div>
        </div>
      </div>

      {/* Mobile Menu Dropdown */}
      {isOpen && (
        <div className="md:hidden border-b border-slate-200 bg-white px-4 pt-2 pb-4 space-y-2">
          {navLinks.map((link) => (
            <Link
              key={link.path}
              to={link.path}
              onClick={() => setIsOpen(false)}
              className={`block px-3 py-2 rounded-xl text-sm font-medium ${
                isActive(link.path)
                  ? 'text-brand-600 bg-brand-50 font-bold'
                  : 'text-slate-700 hover:bg-slate-100'
              }`}
            >
              {link.name}
            </Link>
          ))}
          <div className="pt-3 border-t border-slate-100">
            {isAuthenticated && user ? (
              <div className="space-y-2">
                <Link
                  to="/dashboard"
                  onClick={() => setIsOpen(false)}
                  className="flex items-center space-x-2 px-3 py-2 rounded-xl text-sm font-medium text-slate-800 bg-slate-50"
                >
                  <LayoutDashboard className="w-4 h-4 text-brand-600" />
                  <span>Dashboard ({user.name})</span>
                </Link>
                <button
                  onClick={() => {
                    logout();
                    setIsOpen(false);
                  }}
                  className="w-full flex items-center space-x-2 px-3 py-2 rounded-xl text-sm font-medium text-rose-600 hover:bg-rose-50"
                >
                  <LogOut className="w-4 h-4" />
                  <span>Keluar Akun</span>
                </button>
              </div>
            ) : (
              <Link to="/login" onClick={() => setIsOpen(false)}>
                <Button className="w-full space-x-1.5">
                  <UserIcon className="w-4 h-4" />
                  <span>Masuk Portal</span>
                </Button>
              </Link>
            )}
          </div>
        </div>
      )}
    </header>
  );
};
