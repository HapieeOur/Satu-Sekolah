import React, { useEffect, useState } from 'react';
import { Award, BookOpen, CheckCircle2 } from 'lucide-react';
import { schoolService } from '../api/schoolService';
import { SchoolProfile } from '../types/school';

export const SchoolProfilePage: React.FC = () => {
  const [profile, setProfile] = useState<SchoolProfile | null>(null);

  useEffect(() => {
    schoolService.getSchoolProfile().then(setProfile).catch(() => null);
  }, []);

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
      {/* Header matching Blade reference */}
      <div className="text-center max-w-3xl mx-auto">
        <div className="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-[11px] font-extrabold uppercase tracking-widest text-[#233DFF] bg-[#E5ECFF] border border-blue-200/80 mb-4">
          <span>PROFIL &amp; IDENTITAS LEMBAGA</span>
        </div>
        <h1 className="text-3xl sm:text-5xl font-normal text-[#20211F] tracking-tight leading-tight">
          Visi Keunggulan <span className="font-black text-[#171B61]">Satu-Sekolah</span>
        </h1>
        <p className="text-sm sm:text-base text-[#707581] mt-3 leading-relaxed">
          Mewujudkan lulusan vokasi yang kompeten, berakhlak mulia, adaptif terhadap kemajuan teknologi digital, dan siap bersaing di pasar kerja global.
        </p>
      </div>

      {/* Visi & Misi Cards */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div className="bg-white rounded-3xl p-8 border border-slate-200/90 shadow-xs hover:shadow-card transition duration-300">
          <div className="w-12 h-12 rounded-2xl bg-[#E5ECFF] text-[#233DFF] flex items-center justify-center mb-6">
            <Award className="w-6 h-6" />
          </div>
          <h2 className="text-xl font-bold text-[#171B61] mb-3">Visi Lembaga</h2>
          <p className="text-xs sm:text-sm text-[#707581] leading-relaxed">
            Menjadi pusat keunggulan pendidikan kejuruan yang menghasilkan insan berintegritas tinggi, berdaya cipta mandiri, serta menguasai keahlian industri 4.0 dengan sertifikasi nasional dan internasional.
          </p>
        </div>

        <div className="bg-white rounded-3xl p-8 border border-slate-200/90 shadow-xs hover:shadow-card transition duration-300">
          <div className="w-12 h-12 rounded-2xl bg-[#ECEBFA] text-[#171B61] flex items-center justify-center mb-6">
            <BookOpen className="w-6 h-6" />
          </div>
          <h2 className="text-xl font-bold text-[#171B61] mb-3">Misi Strategis</h2>
          <ul className="space-y-3 text-xs sm:text-sm text-[#707581]">
            <li className="flex items-start gap-2.5">
              <CheckCircle2 className="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" />
              <span>Menyelenggarakan kurikulum berbasis kompetensi yang sinkron dengan kebutuhan mitra DUDI.</span>
            </li>
            <li className="flex items-start gap-2.5">
              <CheckCircle2 className="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" />
              <span>Memperluas jejaring Praktik Kerja Lapangan (PKL) dengan industri teknologi terkemuka.</span>
            </li>
            <li className="flex items-start gap-2.5">
              <CheckCircle2 className="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" />
              <span>Menerapkan sistem manajemen digital terintegrasi untuk transparansi akademik dan presensi.</span>
            </li>
          </ul>
        </div>
      </div>

      {/* Verified Statistics Banner matching Blade */}
      <div className="rounded-[32px] bg-[#171B61] text-white p-8 sm:p-12 shadow-2xl relative overflow-hidden">
        <div className="absolute top-0 right-0 w-80 h-80 bg-[#233DFF]/20 rounded-full blur-3xl pointer-events-none" />
        <div className="relative z-10 text-center max-w-2xl mx-auto mb-10">
          <span className="text-xs font-extrabold uppercase tracking-widest text-[#F4CF52]">
            Data Kinerja Nyata
          </span>
          <h3 className="text-2xl sm:text-3xl font-black mt-2">
            Ekosistem Pendidikan Berkelanjutan
          </h3>
        </div>

        <div className="relative z-10 grid grid-cols-2 sm:grid-cols-4 gap-8 text-center">
          <div>
            <span className="text-3xl sm:text-4xl font-black text-[#F4CF52] block">
              {profile?.statistics.total_students ?? 850}+
            </span>
            <span className="text-xs text-indigo-200 font-semibold mt-1 block">Peserta Didik</span>
          </div>
          <div>
            <span className="text-3xl sm:text-4xl font-black text-white block">
              {profile?.statistics.total_teachers ?? 48}+
            </span>
            <span className="text-xs text-indigo-200 font-semibold mt-1 block">Guru &amp; Staf</span>
          </div>
          <div>
            <span className="text-3xl sm:text-4xl font-black text-white block">
              {profile?.statistics.total_classrooms ?? 18}
            </span>
            <span className="text-xs text-indigo-200 font-semibold mt-1 block">Rombongan Belajar</span>
          </div>
          <div>
            <span className="text-3xl sm:text-4xl font-black text-emerald-400 block">
              {profile?.statistics.total_companies ?? 35}+
            </span>
            <span className="text-xs text-indigo-200 font-semibold mt-1 block">Mitra DUDI / PKL</span>
          </div>
        </div>
      </div>
    </div>
  );
};
