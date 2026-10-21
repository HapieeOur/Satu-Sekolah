import React, { useEffect, useState } from 'react';
import { Building2, BookOpen, Award, CheckCircle2 } from 'lucide-react';
import { schoolService } from '../api/schoolService';
import { SchoolProfile } from '../types/school';
import { Card } from '../components/common/Card';

export const SchoolProfilePage: React.FC = () => {
  const [profile, setProfile] = useState<SchoolProfile | null>(null);

  useEffect(() => {
    schoolService.getSchoolProfile().then(setProfile).catch(() => null);
  }, []);

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
      <div className="border-b border-slate-200/80 pb-6 text-center max-w-3xl mx-auto">
        <h1 className="text-3xl font-extrabold text-slate-900 tracking-tight">
          Profil & Visi Sekolah
        </h1>
        <p className="text-xs text-slate-500 mt-2 leading-relaxed">
          Mewujudkan generasi unggul, berkarakter, berdaya saing global, dan siap kerja melalui ekosistem pendidikan vokasi dan teknologi modern.
        </p>
      </div>

      {/* Overview Cards */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        <Card title="Visi Pendidikan" icon={<Award className="w-5 h-5" />}>
          <p className="text-xs text-slate-600 leading-relaxed">
            Menjadi institusi pendidikan kejuruan rujukan terdepan yang menghasilkan lulusan berakhlak mulia, profesional, adaptif terhadap perkembangan revolusi industri, dan memiliki jiwa kewirausahaan yang tangguh.
          </p>
        </Card>

        <Card title="Misi Strategis" icon={<BookOpen className="w-5 h-5" />}>
          <ul className="space-y-2 text-xs text-slate-600">
            <li className="flex items-start gap-2">
              <CheckCircle2 className="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" />
              <span>Menyelenggarakan proses pembelajaran berbasis industri (*teaching factory*).</span>
            </li>
            <li className="flex items-start gap-2">
              <CheckCircle2 className="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" />
              <span>Membangun kemitraan erat dengan Dunia Usaha dan Dunia Industri (DUDI) untuk program PKL.</span>
            </li>
            <li className="flex items-start gap-2">
              <CheckCircle2 className="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" />
              <span>Mengintegrasikan teknologi informasi dalam manajemen presensi, penilaian, dan administrasi akademik.</span>
            </li>
          </ul>
        </Card>
      </div>

      {/* Info Stats */}
      <div className="bg-white rounded-3xl border border-slate-200/80 p-8 shadow-sm">
        <h3 className="text-sm font-bold text-slate-800 mb-6 flex items-center gap-2">
          <Building2 className="w-4 h-4 text-brand-600" />
          <span>Statistik Terverifikasi Sekolah</span>
        </h3>
        <div className="grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
          <div>
            <span className="text-3xl font-extrabold text-brand-600">
              {profile?.statistics.total_students ?? '500+'}
            </span>
            <span className="text-xs text-slate-500 block mt-1">Siswa Aktif</span>
          </div>
          <div>
            <span className="text-3xl font-extrabold text-emerald-600">
              {profile?.statistics.total_teachers ?? '40+'}
            </span>
            <span className="text-xs text-slate-500 block mt-1">Guru & Staf</span>
          </div>
          <div>
            <span className="text-3xl font-extrabold text-sky-600">
              {profile?.statistics.total_classrooms ?? '18'}
            </span>
            <span className="text-xs text-slate-500 block mt-1">Ruang Kelas</span>
          </div>
          <div>
            <span className="text-3xl font-extrabold text-amber-600">
              {profile?.statistics.total_companies ?? '25+'}
            </span>
            <span className="text-xs text-slate-500 block mt-1">Mitra Industri</span>
          </div>
        </div>
      </div>
    </div>
  );
};
