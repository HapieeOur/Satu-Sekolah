import React, { useState, useEffect } from 'react';
import {
  CheckCircle,
  RefreshCw,
  Terminal,
} from 'lucide-react';
import { useAuth } from '../context/AuthContext';
import { RoleBadge } from '../components/common/Badge';
import { RoleSwitcher, PortalTab } from '../components/common/RoleSwitcher';
import { AdminPortal } from './portals/AdminPortal';
import { TeacherPortal } from './portals/TeacherPortal';
import { HomeroomPortal } from './portals/HomeroomPortal';
import { MentorPortal } from './portals/MentorPortal';
import { StudentPortal } from './portals/StudentPortal';
import { schoolService } from '../api/schoolService';
import { SchoolProfile } from '../types/school';
import api from '../api/axios';

export const DashboardPage: React.FC = () => {
  const { user } = useAuth();
  const [profile, setProfile] = useState<SchoolProfile | null>(null);
  const [rawApiData, setRawApiData] = useState<any>(null);
  const [isPinging, setIsPinging] = useState(false);

  // Determine initial portal tab based on user's roles
  const getInitialTab = (): PortalTab => {
    if (!user) return 'student';
    if (user.roles.includes('admin')) return 'admin';
    if (user.roles.includes('wali_kelas')) return 'homeroom';
    if (user.roles.includes('guru_pembimbing_pkl')) return 'mentor';
    if (user.roles.includes('guru')) return 'teacher';
    return 'student';
  };

  const [currentTab, setCurrentTab] = useState<PortalTab>(getInitialTab);

  useEffect(() => {
    schoolService.getSchoolProfile().then(setProfile).catch(() => null);
  }, []);

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
      {/* User Welcome Banner matching Blade Reference */}
      <div className="relative overflow-hidden rounded-[32px] bg-gradient-to-r from-[#171B61] via-[#1D2275] to-[#233DFF] text-white p-6 sm:p-8 shadow-xl">
        <div className="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div className="flex items-center space-x-4">
            <div className="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-white text-2xl font-black uppercase shadow-inner">
              {user.name.charAt(0)}
            </div>
            <div>
              <div className="flex flex-wrap items-center gap-2 mb-1">
                <span className="text-xs font-semibold px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                  Akun Aktif
                </span>
                <span className="text-xs text-indigo-200">ID #{user.id}</span>
              </div>
              <h1 className="text-xl sm:text-2xl font-black tracking-tight">
                Selamat Datang, {user.name}!
              </h1>
              <p className="text-xs text-indigo-100 mt-1 flex items-center gap-2">
                <span>{user.email}</span>
                {user.phone && <span>&bull; {user.phone}</span>}
              </p>
            </div>
          </div>

          <div className="flex flex-wrap gap-2 items-center bg-white/10 backdrop-blur-md p-3.5 rounded-2xl border border-white/15">
            <span className="text-[10px] font-extrabold uppercase tracking-wider text-indigo-200 block w-full mb-1">
              Peran Akun Terdaftar:
            </span>
            {user.roles.map((r) => (
              <RoleBadge key={r} role={r} />
            ))}
          </div>
        </div>
      </div>

      {/* Role Switcher (Allows switching between Admin, Guru, Walas, PKL, Siswa portals) */}
      <RoleSwitcher
        currentTab={currentTab}
        onTabChange={setCurrentTab}
        availableRoles={user.roles}
      />

      {/* Dynamic Portal View */}
      {currentTab === 'admin' && <AdminPortal profile={profile} />}
      {currentTab === 'teacher' && <TeacherPortal user={user} />}
      {currentTab === 'homeroom' && <HomeroomPortal user={user} />}
      {currentTab === 'mentor' && <MentorPortal user={user} />}
      {currentTab === 'student' && <StudentPortal user={user} />}

      {/* Developer API Inspector for Learning React State */}
      <div className="bg-white rounded-3xl border border-slate-200/90 shadow-xs p-6 space-y-4">
        <div className="flex items-center justify-between pb-3 border-b border-slate-100">
          <div className="flex items-center gap-2">
            <Terminal className="w-5 h-5 text-[#233DFF]" />
            <div>
              <h3 className="text-sm font-extrabold text-[#171B61]">Inspector Komunikasi React &harr; Laravel API</h3>
              <p className="text-xs text-slate-400">Verifikasi koneksi real-time token sesi dengan server Railway</p>
            </div>
          </div>
          <button
            onClick={testApiPing}
            disabled={isPinging}
            className="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1B30D9] transition cursor-pointer disabled:opacity-50"
          >
            <RefreshCw className={`w-3.5 h-3.5 ${isPinging ? 'animate-spin' : ''}`} />
            <span>{isPinging ? 'Menguji...' : 'Tes Ping /auth/me'}</span>
          </button>
        </div>

        <div className="flex flex-wrap items-center gap-3 text-xs">
          <span className="font-semibold text-slate-700">Endpoint:</span>
          <code className="bg-slate-100 px-2.5 py-1 rounded-lg text-slate-800 font-mono text-[11px]">
            GET {import.meta.env.VITE_API_BASE_URL || 'https://satu-sekolah-production.up.railway.app/api/v1'}/auth/me
          </code>
          <span className="inline-flex items-center text-emerald-700 font-bold bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200 text-[11px]">
            <CheckCircle className="w-3 h-3 mr-1" /> Bearer Token Connected
          </span>
        </div>

        <div className="bg-slate-900 rounded-2xl p-4 overflow-x-auto text-emerald-400 font-mono text-xs shadow-inner">
          <div className="flex items-center justify-between text-slate-500 text-[10px] pb-2 border-b border-slate-800 mb-2">
            <span>Payload Respon JSON Sesi:</span>
            <span>application/json</span>
          </div>
          <pre>
            {JSON.stringify(rawApiData || { status: 'Klik tombol di atas untuk menarik data realtime dari backend!', user }, null, 2)}
          </pre>
        </div>
      </div>
    </div>
  );
};
