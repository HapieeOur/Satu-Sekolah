import React, { useState, useEffect } from 'react';
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

export const DashboardPage: React.FC = () => {
  const { user } = useAuth();
  const [profile, setProfile] = useState<SchoolProfile | null>(null);

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

  return (
    <div className="space-y-8">
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
    </div>
  );
};

