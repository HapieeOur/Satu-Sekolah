import React, { useState } from 'react';
import {
  Shield,
  Briefcase,
  GraduationCap,
  CheckCircle,
  ExternalLink,
  RefreshCw,
  Terminal,
} from 'lucide-react';
import { useAuth } from '../context/AuthContext';
import { RoleBadge } from '../components/common/Badge';
import { Card } from '../components/common/Card';
import { Button } from '../components/common/Button';
import api from '../api/axios';

export const DashboardPage: React.FC = () => {
  const { user, hasRole } = useAuth();
  const [rawApiData, setRawApiData] = useState<any>(null);
  const [isPinging, setIsPinging] = useState(false);

  if (!user) return null;

  const testApiPing = async () => {
    setIsPinging(true);
    try {
      const res = await api.get('/auth/me');
      setRawApiData(res.data);
    } catch (err: any) {
      setRawApiData({ error: err.message, status: err.response?.status });
    } finally {
      setIsPinging(false);
    }
  };

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
      {/* Welcome Banner */}
      <div className="relative overflow-hidden rounded-3xl bg-gradient-to-r from-brand-900 via-indigo-900 to-slate-900 text-white p-6 sm:p-8 shadow-xl">
        <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div className="flex items-center space-x-4">
            <div className="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white text-2xl font-bold uppercase shadow-inner">
              {user.name.charAt(0)}
            </div>
            <div>
              <div className="flex flex-wrap items-center gap-2 mb-1">
                <span className="text-xs font-semibold px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                  Akun Aktif
                </span>
                <span className="text-xs text-slate-300">ID #{user.id}</span>
              </div>
              <h1 className="text-xl sm:text-2xl font-extrabold tracking-tight">
                Selamat Datang, {user.name}!
              </h1>
              <p className="text-xs text-slate-300 mt-1 flex items-center gap-2">
                <span>{user.email}</span>
                {user.phone && <span>• {user.phone}</span>}
              </p>
            </div>
          </div>

          <div className="flex flex-wrap gap-2 items-center bg-white/5 backdrop-blur-md p-3 rounded-2xl border border-white/10">
            <span className="text-[11px] font-semibold text-slate-300 uppercase tracking-wider block w-full mb-1">
              Peran Anda di Sistem:
            </span>
            {user.roles.map((r) => (
              <RoleBadge key={r} role={r} />
            ))}
          </div>
        </div>
      </div>

      {/* Role specific quick insights */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        {/* Guru / Wali Kelas Module */}
        {(hasRole('guru') || hasRole('wali_kelas')) && (
          <Card
            title="Portal Guru & Kelas"
            subtitle="Administrasi ruang kelas & jadwal"
            icon={<GraduationCap className="w-5 h-5" />}
          >
            <div className="space-y-3">
              <p className="text-xs text-slate-600 leading-relaxed">
                Anda memiliki hak akses untuk mengelola kehadiran kelas dan input tugas harian siswa.
              </p>
              {hasRole('wali_kelas') && (
                <div className="p-3 bg-emerald-50 rounded-xl border border-emerald-100 text-xs text-emerald-800 font-medium">
                  ✓ Anda terdaftar aktif sebagai <strong>Wali Kelas</strong> pada sistem.
                </div>
              )}
            </div>
          </Card>
        )}

        {/* Guru Pembimbing PKL Module */}
        {(hasRole('guru_pembimbing_pkl') || hasRole('pembimbing_dudi')) && (
          <Card
            title="Portal Monitoring PKL"
            subtitle="Mitra industri & siswa magang"
            icon={<Briefcase className="w-5 h-5" />}
          >
            <div className="space-y-3">
              <p className="text-xs text-slate-600 leading-relaxed">
                Pantau daftar penempatan siswa magang di mitra DUDI, tinjau jurnal harian, dan evaluasi capaian kompetensi.
              </p>
              <div className="p-3 bg-indigo-50 rounded-xl border border-indigo-100 text-xs text-indigo-800 font-medium">
                ✓ Filter guru pembimbing PKL otomatis terhubung dengan database perusahaan.
              </div>
            </div>
          </Card>
        )}

        {/* Administrator Module */}
        {hasRole('admin') && (
          <Card
            title="Pusat Kendali Admin"
            subtitle="Master data dan perizinan"
            icon={<Shield className="w-5 h-5" />}
          >
            <div className="space-y-3">
              <p className="text-xs text-slate-600 leading-relaxed">
                Kelola data master pengguna, penetapan wali kelas, penempatan siswa magang, dan pengaturan radius peta lokasi PKL.
              </p>
              <a
                href="https://satu-sekolah-production.up.railway.app/admin/dashboard"
                target="_blank"
                rel="noreferrer"
                className="inline-flex items-center text-xs font-semibold text-brand-600 hover:text-brand-700 space-x-1"
              >
                <span>Buka Panel Admin Laravel</span>
                <ExternalLink className="w-3.5 h-3.5" />
              </a>
            </div>
          </Card>
        )}
      </div>

      {/* Developer / Learning Inspector (Helps user understand React + Laravel API in real time) */}
      <Card
        title="Inspector Komunikasi React ↔ Laravel API"
        subtitle="Alat bantu belajar: lihat langsung respon JSON mentah dari server Railway"
        icon={<Terminal className="w-5 h-5 text-indigo-600" />}
        headerAction={
          <Button
            size="sm"
            variant="outline"
            isLoading={isPinging}
            onClick={testApiPing}
            className="space-x-1.5"
          >
            <RefreshCw className="w-3.5 h-3.5" />
            <span>Tes Ping /auth/me</span>
          </Button>
        }
      >
        <div className="space-y-4">
          <div className="flex flex-wrap items-center gap-3 text-xs">
            <span className="font-semibold text-slate-700">API Endpoint:</span>
            <code className="bg-slate-100 px-2 py-1 rounded text-slate-800 font-mono text-[11px]">
              GET {import.meta.env.VITE_API_BASE_URL || 'https://satu-sekolah-production.up.railway.app/api/v1'}/auth/me
            </code>
            <span className="inline-flex items-center text-emerald-600 font-semibold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">
              <CheckCircle className="w-3 h-3 mr-1" /> Bearer Token Connected
            </span>
          </div>

          <div className="bg-slate-900 rounded-2xl p-4 overflow-x-auto text-emerald-400 font-mono text-xs shadow-inner">
            <div className="flex items-center justify-between text-slate-500 text-[10px] pb-2 border-b border-slate-800 mb-2">
              <span>Payload JSON Sesi Pengguna:</span>
              <span>application/json</span>
            </div>
            <pre>
              {JSON.stringify(rawApiData || { status: 'Klik tombol di atas untuk menarik data realtime dari backend!', user }, null, 2)}
            </pre>
          </div>
        </div>
      </Card>
    </div>
  );
};
