import React from 'react';
import { GraduationCap, Globe, ShieldCheck } from 'lucide-react';

export const Footer: React.FC = () => {
  return (
    <footer className="bg-white border-t border-slate-200/80 mt-auto">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div className="flex flex-col md:flex-row items-center justify-between gap-4">
          <div className="flex items-center space-x-3">
            <div className="w-8 h-8 rounded-lg bg-brand-600 flex items-center justify-center text-white">
              <GraduationCap className="w-5 h-5" />
            </div>
            <div>
              <p className="text-xs font-bold text-slate-800">Satu Sekolah Platform</p>
              <p className="text-[11px] text-slate-500">Sistem Informasi Akademik & PKL Terpadu</p>
            </div>
          </div>

          <div className="flex items-center space-x-6 text-xs text-slate-500">
            <span className="flex items-center space-x-1">
              <Globe className="w-3.5 h-3.5 text-slate-400" />
              <span>React 18 + Vite SPA</span>
            </span>
            <span className="flex items-center space-x-1">
              <ShieldCheck className="w-3.5 h-3.5 text-emerald-500" />
              <span>Laravel API Connected</span>
            </span>
          </div>

          <p className="text-xs text-slate-400 flex items-center">
            Dibuat untuk pembelajaran & modernisasi
          </p>
        </div>
      </div>
    </footer>
  );
};
