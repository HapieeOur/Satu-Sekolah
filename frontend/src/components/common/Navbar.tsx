import React, { useState } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { LogOut, ArrowRight, LayoutDashboard } from 'lucide-react';
import { useAuth } from '../../context/AuthContext';

export const Navbar: React.FC = () => {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
  const location = useLocation();
  const { user, isAuthenticated, logout } = useAuth();

  const navLinks = [
    { name: 'Home', path: '/' },
    { name: 'Profil', path: '/about' },
    { name: 'Berita', path: '/news' },
  ];

  const isActive = (path: string) => location.pathname === path;

  return (
    <header className="sticky top-0 z-50 glass-nav border-b border-slate-200/80 transition-all duration-200">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-20">
          {/* Brand / Logo */}
          <Link to="/" className="flex items-center gap-3 group cursor-pointer py-1">
            <div className="w-10 h-10 rounded-2xl bg-white p-1.5 flex items-center justify-center shadow-md shadow-indigo-950/20 group-hover:scale-105 transition-transform duration-200 border border-slate-100">
              <img src="/images/logo/icon.png" alt="oneSchool" className="w-full h-full object-contain" />
            </div>
            <div>
              <span className="font-black text-xl tracking-tight text-[#171B61] group-hover:text-[#233DFF] transition-colors">
                SATU<span className="text-[#233DFF]">SEKOLAH</span><span className="text-[#F4CF52]">.</span>
              </span>
              <span className="block text-[10px] font-semibold text-slate-400 tracking-wider uppercase leading-none">Keunggulan Vokasi</span>
            </div>
          </Link>

          {/* Desktop Navigation Links */}
          <nav className="hidden lg:flex items-center gap-8 text-xs font-bold uppercase tracking-wider text-slate-600">
            {navLinks.map((link) => (
              <Link
                key={link.path}
                to={link.path}
                className={`py-1 transition-colors ${
                  isActive(link.path)
                    ? 'text-[#233DFF] border-b-2 border-[#233DFF]'
                    : 'hover:text-[#171B61]'
                }`}
              >
                {link.name}
              </Link>
            ))}
          </nav>

          {/* Auth Action Button */}
          <div className="hidden sm:flex items-center gap-3">
            {isAuthenticated && user ? (
              <div className="flex items-center gap-3">
                <Link
                  to="/dashboard"
                  className="inline-flex items-center gap-2 px-6 py-2.5 text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1B30D9] rounded-full shadow-md shadow-indigo-600/25 hover:shadow-indigo-600/40 hover:-translate-y-0.5 transition-all duration-150"
                >
                  <LayoutDashboard className="w-4 h-4" />
                  <span>Ke Dashboard ({user.name.split(' ')[0]})</span>
                </Link>
                <button
                  onClick={() => logout()}
                  title="Logout"
                  className="p-2 text-slate-400 hover:text-rose-600 rounded-full hover:bg-rose-50 transition"
                >
                  <LogOut className="w-4 h-4" />
                </button>
              </div>
            ) : (
              <Link
                to="/login"
                className="inline-flex items-center gap-2 px-7 py-2.5 text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1B30D9] rounded-full shadow-md shadow-indigo-600/25 hover:shadow-indigo-600/40 hover:-translate-y-0.5 transition-all duration-150"
              >
                <span>Login</span>
                <ArrowRight className="w-3.5 h-3.5" />
              </Link>
            )}
          </div>

          {/* Mobile Menu Button */}
          <div className="flex items-center lg:hidden">
            <button
              onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
              type="button"
              aria-label="Toggle Menu"
              className="p-2.5 rounded-xl text-slate-700 hover:text-[#171B61] hover:bg-slate-100 focus:outline-none transition"
            >
              <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {mobileMenuOpen ? (
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
                ) : (
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6h16M4 12h16M4 18h16" />
                )}
              </svg>
            </button>
          </div>
        </div>
      </div>

      {/* Mobile Menu Dropdown */}
      {mobileMenuOpen && (
        <div className="lg:hidden border-b border-[#E8EDF5] bg-white/95 backdrop-blur-md px-4 pt-3 pb-5 space-y-1.5 shadow-xl">
          {navLinks.map((link) => (
            <Link
              key={link.path}
              to={link.path}
              onClick={() => setMobileMenuOpen(false)}
              className={`block px-3.5 py-2.5 rounded-xl text-sm font-semibold ${
                isActive(link.path)
                  ? 'bg-indigo-50 text-[#233DFF] font-bold'
                  : 'text-slate-700 hover:bg-slate-50'
              }`}
            >
              {link.name}
            </Link>
          ))}
          <div className="pt-3 mt-2 border-t border-slate-100">
            {isAuthenticated && user ? (
              <div className="space-y-2">
                <Link
                  to="/dashboard"
                  onClick={() => setMobileMenuOpen(false)}
                  className="flex items-center justify-center gap-2 w-full py-2.5 px-4 text-xs font-bold text-white bg-[#233DFF] rounded-full shadow-sm"
                >
                  <LayoutDashboard className="w-4 h-4" />
                  <span>Ke Dashboard ({user.name})</span>
                </Link>
                <button
                  onClick={() => {
                    logout();
                    setMobileMenuOpen(false);
                  }}
                  className="w-full py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-xl"
                >
                  Logout
                </button>
              </div>
            ) : (
              <Link
                to="/login"
                onClick={() => setMobileMenuOpen(false)}
                className="flex items-center justify-center gap-2 w-full py-2.5 px-4 text-xs font-bold text-white bg-[#233DFF] rounded-full shadow-sm"
              >
                <span>Login ke Portal</span>
                <ArrowRight className="w-4 h-4" />
              </Link>
            )}
          </div>
        </div>
      )}
    </header>
  );
};
