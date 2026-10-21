import React from 'react';
import { Shield, GraduationCap, Users, Briefcase, BookOpen } from 'lucide-react';

export type PortalTab = 'admin' | 'teacher' | 'homeroom' | 'mentor' | 'student';

interface RoleSwitcherProps {
  currentTab: PortalTab;
  onTabChange: (tab: PortalTab) => void;
  availableRoles: string[];
}

export const RoleSwitcher: React.FC<RoleSwitcherProps> = ({
  currentTab,
  onTabChange,
  availableRoles,
}) => {
  // If user is admin, allow viewing all portals
  const isAdmin = availableRoles.includes('admin');

  const tabs: { id: PortalTab; label: string; icon: React.ReactNode; requiredRole?: string }[] = [
    {
      id: 'admin',
      label: 'Portal Admin',
      icon: <Shield className="w-4 h-4" />,
      requiredRole: 'admin',
    },
    {
      id: 'teacher',
      label: 'Portal Guru',
      icon: <GraduationCap className="w-4 h-4" />,
      requiredRole: 'guru',
    },
    {
      id: 'homeroom',
      label: 'Portal Wali Kelas',
      icon: <Users className="w-4 h-4" />,
      requiredRole: 'wali_kelas',
    },
    {
      id: 'mentor',
      label: 'Portal Pembimbing PKL',
      icon: <Briefcase className="w-4 h-4" />,
      requiredRole: 'guru_pembimbing_pkl',
    },
    {
      id: 'student',
      label: 'Portal Siswa',
      icon: <BookOpen className="w-4 h-4" />,
      requiredRole: 'siswa',
    },
  ];

  // Filter tabs based on user's roles (Admin can see all tabs)
  const visibleTabs = tabs.filter(
    (tab) => isAdmin || !tab.requiredRole || availableRoles.includes(tab.requiredRole)
  );

  if (visibleTabs.length <= 1) {
    return null;
  }

  return (
    <div className="bg-white rounded-2xl p-1.5 border border-slate-200/90 shadow-xs flex flex-wrap gap-1 items-center">
      <span className="text-[11px] font-extrabold uppercase tracking-wider text-slate-400 px-3 py-1">
        Pindah Portal:
      </span>
      {visibleTabs.map((tab) => {
        const isActive = currentTab === tab.id;
        return (
          <button
            key={tab.id}
            onClick={() => onTabChange(tab.id)}
            className={`inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition duration-150 cursor-pointer ${
              isActive
                ? 'bg-[#171B61] text-white shadow-sm'
                : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
            }`}
          >
            {tab.icon}
            <span>{tab.label}</span>
          </button>
        );
      })}
    </div>
  );
};
