import React, { useState } from 'react';
import { Search, MapPin } from 'lucide-react';

export const AttendancesPage: React.FC = () => {
  const [search, setSearch] = useState('');

  const sampleAttendances = [
    { id: 1, name: 'Ahmad Fauzan', role: 'Siswa PKL', place: 'PT Telkom Indonesia', checkIn: '07:45', checkOut: '17:00', status: 'Hadir', gps: 'Valid (45m)' },
    { id: 2, name: 'Budi Santoso', role: 'Siswa PKL', place: 'PT Telkom Indonesia', checkIn: '07:50', checkOut: '17:05', status: 'Hadir', gps: 'Valid (60m)' },
    { id: 3, name: 'Citra Kirana', role: 'Siswa PKL', place: 'CV Inovasi Digital', checkIn: '08:15', checkOut: '17:00', status: 'Terlambat', gps: 'Valid (30m)' },
    { id: 4, name: 'Bambang Sudiro, M.Pd', role: 'Guru / Walas', place: 'Sekolah', checkIn: '06:50', checkOut: '15:30', status: 'Hadir', gps: 'Presensi Finger/Face' },
    { id: 5, name: 'Eko Prasetyo', role: 'Siswa PKL', place: 'CV Inovasi Digital', checkIn: '-', checkOut: '-', status: 'Izin', gps: 'Surat Izin' },
  ];

  const filtered = sampleAttendances.filter(
    (a) =>
      a.name.toLowerCase().includes(search.toLowerCase()) ||
      a.place.toLowerCase().includes(search.toLowerCase())
  );

  return (
    <div className="space-y-6">
      <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <div className="flex items-center gap-2">
            <h1 className="text-xl sm:text-2xl font-black text-[#171B61] tracking-tight">
              Presensi &amp; Koreksi Kehadiran
            </h1>
            <span className="text-xs font-bold bg-[#E5ECFF] text-[#233DFF] px-2.5 py-0.5 rounded-full">
              Real-time Geofence
            </span>
          </div>
          <p className="text-xs text-slate-500 mt-1">
            Rekap log kehadiran harian peserta didik, guru, serta verifikasi radius lokasi GPS magang siswa di mitra DUDI.
          </p>
        </div>
      </div>

      <div className="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div className="p-5 border-b border-slate-100 flex items-center justify-between gap-4">
          <div className="relative max-w-sm w-full">
            <span className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
              <Search className="w-4 h-4" />
            </span>
            <input
              type="text"
              placeholder="Cari nama atau tempat presensi..."
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF]"
            />
          </div>
          <span className="text-xs font-bold text-slate-500">
            Tanggal: {new Date().toLocaleDateString('id-ID')}
          </span>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-left text-xs">
            <thead className="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold border-b border-slate-100">
              <tr>
                <th className="px-6 py-4">Nama &amp; Peran</th>
                <th className="px-6 py-4">Lokasi Presensi</th>
                <th className="px-6 py-4">Jam Masuk</th>
                <th className="px-6 py-4">Jam Pulang</th>
                <th className="px-6 py-4">Status</th>
                <th className="px-6 py-4">Verifikasi GPS</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 font-medium">
              {filtered.map((a) => (
                <tr key={a.id} className="hover:bg-slate-50/80 transition">
                  <td className="px-6 py-4">
                    <span className="font-extrabold text-sm text-slate-900 block">{a.name}</span>
                    <span className="text-[10px] text-slate-400">{a.role}</span>
                  </td>
                  <td className="px-6 py-4 font-bold text-[#171B61]">{a.place}</td>
                  <td className="px-6 py-4 font-mono font-bold text-slate-800">{a.checkIn}</td>
                  <td className="px-6 py-4 font-mono text-slate-600">{a.checkOut}</td>
                  <td className="px-6 py-4">
                    <span
                      className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold ${
                        a.status === 'Hadir'
                          ? 'bg-emerald-50 text-emerald-700 border border-emerald-200'
                          : a.status === 'Terlambat'
                          ? 'bg-amber-50 text-amber-700 border border-amber-200'
                          : 'bg-blue-50 text-blue-700 border border-blue-200'
                      }`}
                    >
                      {a.status}
                    </span>
                  </td>
                  <td className="px-6 py-4">
                    <span className="inline-flex items-center gap-1 text-[11px] text-slate-600 font-medium bg-slate-100 px-2.5 py-1 rounded-lg">
                      <MapPin className="w-3 h-3 text-[#233DFF]" />
                      <span>{a.gps}</span>
                    </span>
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
