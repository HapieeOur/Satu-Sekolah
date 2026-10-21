import React, { useState } from 'react';
import { Download, CheckCircle2 } from 'lucide-react';

export const ReportsPage: React.FC = () => {
  const [activeTab, setActiveTab] = useState<'academic' | 'internship'>('internship');

  return (
    <div className="space-y-6">
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div className="flex items-center gap-2">
            <h1 className="text-xl sm:text-2xl font-black text-[#171B61] tracking-tight">
              Laporan &amp; Rekapitulasi Institusi
            </h1>
            <span className="text-xs font-bold bg-[#E5ECFF] text-[#233DFF] px-2.5 py-0.5 rounded-full">
              T.A. 2026/2027
            </span>
          </div>
          <p className="text-xs text-slate-500 mt-1">
            Ekspor dan analisis rekap kehadiran akademik dan performa monitoring Praktik Kerja Lapangan (PKL).
          </p>
        </div>

        <div className="flex items-center gap-2">
          <button
            type="button"
            className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-white border border-slate-200/90 shadow-xs hover:bg-slate-50 transition cursor-pointer"
          >
            <Download className="w-4 h-4" />
            <span>Ekspor PDF / Excel</span>
          </button>
        </div>
      </div>

      {/* Tabs */}
      <div className="flex gap-2 border-b border-slate-200">
        <button
          onClick={() => setActiveTab('internship')}
          className={`px-5 py-2.5 text-xs font-bold border-b-2 transition cursor-pointer ${
            activeTab === 'internship'
              ? 'border-[#233DFF] text-[#233DFF]'
              : 'border-transparent text-slate-500 hover:text-slate-800'
          }`}
        >
          Rekapitulasi PKL &amp; DUDI
        </button>
        <button
          onClick={() => setActiveTab('academic')}
          className={`px-5 py-2.5 text-xs font-bold border-b-2 transition cursor-pointer ${
            activeTab === 'academic'
              ? 'border-[#233DFF] text-[#233DFF]'
              : 'border-transparent text-slate-500 hover:text-slate-800'
          }`}
        >
          Rekap Kehadiran Akademik
        </button>
      </div>

      {/* Bento Stats Showcase */}
      <div className="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div className="rounded-3xl p-6 bg-white border border-slate-200/90 shadow-xs space-y-2">
          <span className="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">
            Total Penempatan Magang
          </span>
          <span className="text-3xl font-black text-[#171B61] block">120 Siswa</span>
          <span className="text-xs text-slate-500 font-medium">Tersebar di 35 Mitra DUDI</span>
        </div>

        <div className="rounded-3xl p-6 bg-white border border-slate-200/90 shadow-xs space-y-2">
          <span className="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">
            Rata-Rata Kehadiran GPS
          </span>
          <span className="text-3xl font-black text-emerald-600 block">98.2%</span>
          <span className="text-xs text-emerald-700 font-semibold flex items-center gap-1">
            <CheckCircle2 className="w-3.5 h-3.5" /> Validasi Radius Terpenuhi
          </span>
        </div>

        <div className="rounded-3xl p-6 bg-white border border-slate-200/90 shadow-xs space-y-2">
          <span className="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">
            Tingkat Penyelesaian Jurnal
          </span>
          <span className="text-3xl font-black text-[#233DFF] block">95.4%</span>
          <span className="text-xs text-slate-500 font-medium">Ditinjau Guru Pembimbing</span>
        </div>
      </div>
    </div>
  );
};
