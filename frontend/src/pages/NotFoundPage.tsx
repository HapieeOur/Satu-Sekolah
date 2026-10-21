import React from 'react';
import { Link } from 'react-router-dom';
import { AlertTriangle, Home } from 'lucide-react';
import { Button } from '../components/common/Button';

export const NotFoundPage: React.FC = () => {
  return (
    <div className="min-h-[70vh] flex items-center justify-center p-4">
      <div className="text-center max-w-md">
        <div className="w-16 h-16 bg-amber-50 text-amber-600 rounded-3xl flex items-center justify-center mx-auto mb-4 border border-amber-100">
          <AlertTriangle className="w-8 h-8" />
        </div>
        <h1 className="text-3xl font-extrabold text-slate-900">404</h1>
        <h2 className="text-base font-bold text-slate-800 mt-1">Halaman Tidak Ditemukan</h2>
        <p className="text-xs text-slate-500 mt-2 mb-6">
          Maaf, halaman yang Anda tuju tidak tersedia atau telah dipindahkan.
        </p>
        <Link to="/">
          <Button className="space-x-2">
            <Home className="w-4 h-4" />
            <span>Kembali ke Beranda</span>
          </Button>
        </Link>
      </div>
    </div>
  );
};
