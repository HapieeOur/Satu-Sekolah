import React from 'react';
import {
  Users,
  Building2,
  BookOpen,
  Calendar,
  FileText,
  Clock,
  ShieldCheck,
  CheckCircle2,
  ArrowRight
} from 'lucide-react';
import { Link } from 'react-router-dom';
import { SchoolProfile } from '../../types/school';

interface AdminPortalProps {
  profile: SchoolProfile | null;
}

export const AdminPortal: React.FC<AdminPortalProps> = () => {
  const adminModules = [
    {
      title: 'Manajemen Pengguna & Guru',
      desc: 'Pengelolaan akun multi-peran dengan auto-sync profil guru otomatis.',
      icon: <Users className="w-6 h-6 text-[#233DFF]" />,
      bg: 'bg-[#E5ECFF]',
      link: '/admin/users',
      badge: 'Auto-Sync Aktif',
    },
    {
      title: 'Rombongan Belajar & Walas',
      desc: 'Penetapan wali kelas khusus guru ber-role wali_kelas dan ruang kelas.',
      icon: <BookOpen className="w-6 h-6 text-[#171B61]" />,
      bg: 'bg-[#ECEBFA]',
      link: '/admin/classrooms',
      badge: '18 Rombel Aktif',
    },
    {
      title: 'Mitra DUDI & Penempatan PKL',
      desc: 'Map lokasi perusahaan, radius geofence presensi, dan pembimbing industri.',
      icon: <Building2 className="w-6 h-6 text-emerald-700" />,
      bg: 'bg-emerald-50',
      link: '/admin/companies',
      badge: '35 Mitra DUDI',
    },
    {
      title: 'Kalender & Tahun Ajaran',
      desc: 'Aktifkan semester berjalan, jadwal libur, dan periode KBM resmi.',
      icon: <Calendar className="w-6 h-6 text-[#233DFF]" />,
      bg: 'bg-[#E5ECFF]',
      link: '/admin/academic-years',
      badge: 'Periode Aktif',
    },
    {
      title: 'Jadwal Pelajaran Sekolah',
      desc: 'Sinkronisasi jam tatap muka KBM, laboratorium, dan pemetaan guru.',
      icon: <Clock className="w-6 h-6 text-amber-700" />,
      bg: 'bg-amber-50',
      link: '/admin/schedules',
      badge: 'Realtime Sync',
    },
    {
      title: 'Publikasi Berita & Acara',
      desc: 'Portal publikasi resmi informasi sekolah dan pengumuman sivitas.',
      icon: <FileText className="w-6 h-6 text-indigo-700" />,
      bg: 'bg-indigo-50',
      link: '/admin/posts',
      badge: 'Pemberitahuan',
    },
  ];

  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <h3 className="text-base font-black text-[#171B61] tracking-tight flex items-center gap-2">
          <ShieldCheck className="w-5 h-5 text-[#233DFF]" />
          <span>Akses Cepat Tata Kelola Master Data Sekolah</span>
        </h3>
        <span className="text-xs font-bold text-slate-400">
          Hak Akses: Administrator Utama
        </span>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        {adminModules.map((mod, idx) => (
          <div
            key={idx}
            className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs hover:shadow-card transition duration-200 flex flex-col justify-between space-y-4"
          >
            <div className="space-y-3">
              <div className="flex items-center justify-between">
                <div className={`w-12 h-12 rounded-2xl ${mod.bg} flex items-center justify-center`}>
                  {mod.icon}
                </div>
                <span className="text-[10px] font-black text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                  {mod.badge}
                </span>
              </div>
              <h4 className="text-base font-black text-slate-900">{mod.title}</h4>
              <p className="text-xs text-slate-500 leading-relaxed font-medium">
                {mod.desc}
              </p>
            </div>

            <div className="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
              <span className="text-emerald-600 font-bold flex items-center gap-1 text-[11px]">
                <CheckCircle2 className="w-3.5 h-3.5" /> Terintegrasi
              </span>
              <Link
                to={mod.link}
                className="font-black text-[#233DFF] hover:underline flex items-center gap-1"
              >
                <span>Buka Modul</span>
                <ArrowRight className="w-3.5 h-3.5" />
              </Link>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};
