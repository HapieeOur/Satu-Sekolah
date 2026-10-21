import React from 'react';
import {
  Briefcase,
  MapPin,
  CheckCircle2,
  BookOpen,
  Building2,
  Users,
} from 'lucide-react';
import { User } from '../../types/auth';

interface MentorPortalProps {
  user: User;
}

export const MentorPortal: React.FC<MentorPortalProps> = ({ user }) => {
  const sampleMentees = [
    { id: 1, name: 'Dimas Anggara', company: 'PT Telkom Indonesia', attendance: 'Hadir (Radius 50m)', journal: 'Menunggu Review' },
    { id: 2, name: 'Rian Hidayat', company: 'PT Telkom Indonesia', attendance: 'Hadir (Radius 45m)', journal: 'Disetujui' },
    { id: 3, name: 'Siti Rahmawati', company: 'CV Inovasi Digital', attendance: 'Hadir (Radius 20m)', journal: 'Disetujui' },
    { id: 4, name: 'Fajar Nugraha', company: 'CV Inovasi Digital', attendance: 'Izin', journal: '-' },
  ];

  return (
    <div className="space-y-8">
      {/* Top Banner matching Blade Reference */}
      <div className="rounded-3xl bg-gradient-to-r from-[#171B61] to-[#233DFF] p-6 sm:p-8 text-white shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
          <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/10 text-[#F4CF52] mb-3">
            <span>💼 Portal Pembimbing PKL &amp; DUDI</span>
          </div>
          <h2 className="text-2xl sm:text-3xl font-black tracking-tight">
            Monitoring Siswa Magang Industri
          </h2>
          <p className="text-xs text-indigo-100 mt-1 max-w-xl leading-relaxed">
            Guru Pembimbing: <strong>{user.name}</strong> &bull; Pemantauan absensi geofence GPS real-time, foto selfie kehadiran, dan validasi jurnal harian industri.
          </p>
        </div>

        <div className="flex items-center gap-4 bg-white/10 backdrop-blur-md px-6 py-4 rounded-2xl border border-white/15">
          <div className="text-right">
            <span className="text-3xl font-black text-[#F4CF52]">100%</span>
            <span className="text-[10px] text-indigo-200 block uppercase font-bold tracking-wider">
              Kehadiran DUDI Hari Ini
            </span>
          </div>
        </div>
      </div>

      {/* 3 Overview Metrics */}
      <div className="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs flex items-center gap-4">
          <div className="w-12 h-12 rounded-2xl bg-indigo-50 text-[#233DFF] flex items-center justify-center">
            <Users className="w-6 h-6" />
          </div>
          <div>
            <span className="text-3xl font-black text-[#171B61]">14</span>
            <span className="text-xs text-slate-500 font-semibold block">Siswa Bimbingan Aktif</span>
          </div>
        </div>

        <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs flex items-center gap-4">
          <div className="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center">
            <Building2 className="w-6 h-6" />
          </div>
          <div>
            <span className="text-3xl font-black text-[#171B61]">4</span>
            <span className="text-xs text-slate-500 font-semibold block">Mitra Perusahaan DUDI</span>
          </div>
        </div>

        <div className="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs flex items-center gap-4">
          <div className="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center">
            <BookOpen className="w-6 h-6" />
          </div>
          <div>
            <span className="text-3xl font-black text-[#171B61]">3</span>
            <span className="text-xs text-slate-500 font-semibold block">Jurnal Menunggu Review</span>
          </div>
        </div>
      </div>

      {/* Mentees Table with Geofence & Journal Status */}
      <div className="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div className="p-6 border-b border-slate-100 flex items-center justify-between">
          <div className="flex items-center gap-2">
            <Briefcase className="w-5 h-5 text-[#233DFF]" />
            <h3 className="text-sm font-extrabold text-[#171B61]">
              Aktivitas Terkini Siswa Magang PKL
            </h3>
          </div>
          <span className="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200 flex items-center gap-1">
            <MapPin className="w-3.5 h-3.5" /> Geofence Aktif
          </span>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-left text-xs">
            <thead className="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold border-b border-slate-100">
              <tr>
                <th className="px-6 py-3.5">Nama Siswa</th>
                <th className="px-6 py-3.5">Mitra Industri (DUDI)</th>
                <th className="px-6 py-3.5">Presensi GPS</th>
                <th className="px-6 py-3.5">Status Jurnal</th>
                <th className="px-6 py-3.5">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium">
              {sampleMentees.map((m) => (
                <tr key={m.id} className="hover:bg-slate-50/80 transition">
                  <td className="px-6 py-4 font-bold text-slate-900">{m.name}</td>
                  <td className="px-6 py-4 text-slate-600 font-medium">{m.company}</td>
                  <td className="px-6 py-4">
                    <span className="inline-flex items-center gap-1 text-emerald-700 font-bold bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 text-[11px]">
                      <CheckCircle2 className="w-3 h-3" /> {m.attendance}
                    </span>
                  </td>
                  <td className="px-6 py-4">
                    <span
                      className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold ${
                        m.journal === 'Disetujui'
                          ? 'bg-blue-50 text-blue-700 border border-blue-200'
                          : m.journal === 'Menunggu Review'
                          ? 'bg-amber-50 text-amber-700 border border-amber-200'
                          : 'bg-slate-100 text-slate-600'
                      }`}
                    >
                      {m.journal}
                    </span>
                  </td>
                  <td className="px-6 py-4">
                    <button
                      type="button"
                      className="px-3 py-1 rounded-full text-xs font-bold text-white bg-[#233DFF] hover:bg-[#1B30D9] transition cursor-pointer"
                    >
                      Beri Nilai / Review
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
};
