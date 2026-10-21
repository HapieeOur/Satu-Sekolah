import React from 'react';
import { Link } from 'react-router-dom';
import { MapPin, Mail, ArrowRight } from 'lucide-react';
import { useAuth } from '../../context/AuthContext';

export const Footer: React.FC = () => {
  const { isAuthenticated } = useAuth();

  return (
    <footer className="bg-[#171B61] text-slate-300 border-t border-slate-800 mt-20 relative overflow-hidden">
      {/* Subtle Background Glow */}
      <div className="absolute -top-24 left-1/2 -translate-x-1/2 w-96 h-96 bg-[#233DFF]/10 rounded-full blur-3xl pointer-events-none" />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
        <div className="grid grid-cols-1 md:grid-cols-12 gap-10">
          {/* Col 1: About & Identity */}
          <div className="space-y-4 md:col-span-5">
            <div className="flex items-center gap-3">
              <div className="w-10 h-10 rounded-2xl bg-white p-1.5 flex items-center justify-center shadow-md shadow-indigo-950/20">
                <img src="/images/logo/icon.png" alt="oneSchool" className="w-full h-full object-contain" />
              </div>
              <div>
                <span className="font-extrabold text-white text-lg tracking-tight block">oneSchool</span>
                <span className="text-[11px] text-indigo-300 font-medium">Digital Learning Platform &amp; PKL</span>
              </div>
            </div>
            <p className="text-xs text-slate-400 leading-relaxed max-w-sm">
              Mendukung ekosistem pendidikan cerdas dengan administrasi akademik digital, transparansi presensi, dan sistem monitoring Praktik Kerja Lapangan (PKL) presisi tinggi berbasis geofence.
            </p>
            <div className="pt-2 text-xs text-slate-400 space-y-1.5">
              <p className="flex items-center gap-2">
                <MapPin className="w-4 h-4 text-indigo-400 shrink-0" />
                <span>Jl. Pendidikan No. 01, Kompleks Edukasi Modern</span>
              </p>
              <p className="flex items-center gap-2">
                <Mail className="w-4 h-4 text-indigo-400 shrink-0" />
                <span>info@satusekolah.sch.id &bull; (021) 7890-1234</span>
              </p>
            </div>
          </div>

          {/* Col 2: Navigation Links */}
          <div className="md:col-span-3 space-y-3">
            <h3 className="text-xs font-bold uppercase tracking-wider text-white">Navigasi Cepat</h3>
            <ul className="space-y-2 text-xs">
              <li>
                <Link to="/" className="hover:text-indigo-400 transition flex items-center gap-1.5">
                  &rsaquo; Beranda Utama
                </Link>
              </li>
              <li>
                <Link to="/about" className="hover:text-indigo-400 transition flex items-center gap-1.5">
                  &rsaquo; Profil &amp; Visi Misi
                </Link>
              </li>
              <li>
                <Link to="/news" className="hover:text-indigo-400 transition flex items-center gap-1.5">
                  &rsaquo; Warta &amp; Kabar Sekolah
                </Link>
              </li>
            </ul>
          </div>

          {/* Col 3: Portal Access & Info */}
          <div className="md:col-span-4 space-y-3">
            <h3 className="text-xs font-bold uppercase tracking-wider text-white">Akses Portal Terpadu</h3>
            <p className="text-xs text-slate-400 leading-relaxed">
              Gerbang operasional terintegrasi untuk Administrator, Tenaga Pendidik, Wali Kelas, dan Pembimbing PKL Industri.
            </p>
            <div className="pt-2">
              {isAuthenticated ? (
                <Link
                  to="/dashboard"
                  className="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1B30D9] rounded-full shadow-md shadow-indigo-600/30 transition"
                >
                  <span>Buka Dashboard</span>
                  <ArrowRight className="w-4 h-4" />
                </Link>
              ) : (
                <Link
                  to="/login"
                  className="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-extrabold text-[#171B61] bg-[#F4CF52] hover:bg-[#e5be42] rounded-full shadow-md shadow-amber-400/20 transition cursor-pointer"
                >
                  <span>Masuk ke Akun Pendidik</span>
                  <ArrowRight className="w-4 h-4 text-[#171B61]" />
                </Link>
              )}
            </div>
            <div className="p-3 rounded-xl bg-slate-800/60 border border-slate-700/60 text-[11px] text-slate-400">
              <span className="text-emerald-400 font-semibold block mb-0.5">Siswa PKL:</span>
              Gunakan aplikasi mobile dengan GPS aktif untuk mencatat presensi dan jurnal harian.
            </div>
          </div>
        </div>

        {/* Bottom Copyright & Badges */}
        <div className="mt-12 pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
          <p>&copy; {new Date().getFullYear()} Satu-Sekolah. Seluruh hak cipta dilindungi undang-undang.</p>
          <div className="flex items-center gap-4 text-[11px] text-slate-400">
            <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-800 border border-slate-700">
              <span className="w-2 h-2 rounded-full bg-emerald-400" />
              <span>Status Sistem: Normal (99.9% Uptime)</span>
            </span>
            <span>React SPA &bull; Laravel API</span>
          </div>
        </div>
      </div>
    </footer>
  );
};
