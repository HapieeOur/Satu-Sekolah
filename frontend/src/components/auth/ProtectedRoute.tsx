import React from 'react';
import { Navigate, useLocation } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';
import { ShieldAlert } from 'lucide-react';
import { Card } from '../common/Card';
import { Button } from '../common/Button';

interface ProtectedRouteProps {
  children: React.ReactNode;
  allowedRoles?: string[];
}

export const ProtectedRoute: React.FC<ProtectedRouteProps> = ({
  children,
  allowedRoles,
}) => {
  const { isAuthenticated, isLoading, user, hasRole } = useAuth();
  const location = useLocation();

  if (isLoading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-slate-50">
        <div className="text-center">
          <div className="w-12 h-12 border-4 border-brand-200 border-t-brand-600 rounded-full animate-spin mx-auto mb-3" />
          <p className="text-xs font-semibold text-slate-500 uppercase tracking-wider">Memuat Sesi Pengguna...</p>
        </div>
      </div>
    );
  }

  // Jika belum login, redirect ke halaman login dan simpan target URL
  if (!isAuthenticated || !user) {
    return <Navigate to="/login" state={{ from: location }} replace />;
  }

  // Jika rute membutuhkan role tertentu dan user tidak memilikinya
  if (allowedRoles && allowedRoles.length > 0 && !hasRole(allowedRoles)) {
    return (
      <div className="min-h-[70vh] flex items-center justify-center p-4">
        <Card className="max-w-md w-full text-center">
          <div className="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-rose-100">
            <ShieldAlert className="w-6 h-6" />
          </div>
          <h2 className="text-lg font-bold text-slate-800">Akses Terbatas</h2>
          <p className="text-xs text-slate-500 mt-2 mb-6">
            Akun Anda tidak memiliki hak akses untuk membuka halaman ini. Halaman ini hanya untuk pengguna dengan peran:
          </p>
          <div className="flex flex-wrap gap-1.5 justify-center mb-6">
            {allowedRoles.map((role) => (
              <span key={role} className="text-xs font-mono font-semibold bg-slate-100 px-2.5 py-1 rounded-lg text-slate-700">
                {role}
              </span>
            ))}
          </div>
          <Button variant="secondary" onClick={() => window.history.back()} className="w-full">
            Kembali ke Halaman Sebelumnya
          </Button>
        </Card>
      </div>
    );
  }

  return <>{children}</>;
};
