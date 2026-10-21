import React, { useState } from 'react';
import {
  Bell,
  CheckCheck,
  Megaphone,
  BookOpen,
  Briefcase,
  Clock,
  Trash2,
  CheckCircle2
} from 'lucide-react';

interface NotificationItem {
  id: number;
  category: 'all' | 'announcements' | 'academic' | 'pkl';
  categoryLabel: string;
  title: string;
  description: string;
  time: string;
  isUnread: boolean;
  link?: string;
}

export const NotificationsPage: React.FC = () => {
  const [activeTab, setActiveTab] = useState<'all' | 'announcements' | 'academic' | 'pkl'>('all');
  const [notifications, setNotifications] = useState<NotificationItem[]>([
    {
      id: 1,
      category: 'academic',
      categoryLabel: 'Akademik & Jadwal',
      title: 'Presensi Masuk Berhasil Terverifikasi',
      description: 'Presensi masuk kelas XII RPL 1 tercatat pukul 06:55 WIB dengan status Hadir Tepat Waktu.',
      time: '10 menit yang lalu',
      isUnread: true,
    },
    {
      id: 2,
      category: 'pkl',
      categoryLabel: 'PKL & Magang',
      title: 'Jurnal Harian PKL Disetujui Pembimbing',
      description: 'Jurnal kegiatan "Implementasi RESTful API Laravel Sanctum" di PT Telkom telah divalidasi oleh mentor.',
      time: '1 jam yang lalu',
      isUnread: true,
    },
    {
      id: 3,
      category: 'announcements',
      categoryLabel: 'Pengumuman & Berita',
      title: 'Pelaksanaan Penilaian Tengah Semester (PTS)',
      description: 'PTS Semester Ganjil T.A. 2026/2027 akan diselenggarakan mulai tanggal 28 Oktober 2026 secara daring.',
      time: '3 jam yang lalu',
      isUnread: true,
    },
    {
      id: 4,
      category: 'pkl',
      categoryLabel: 'PKL & Magang',
      title: 'Pengajuan Dispensasi / Izin PKL Diterima',
      description: 'Surat permohonan izin sakit atas nama Ahmad Fauzan telah disetujui oleh Guru Pembimbing.',
      time: '1 hari yang lalu',
      isUnread: false,
    },
    {
      id: 5,
      category: 'academic',
      categoryLabel: 'Akademik & Jadwal',
      title: 'Jadwal Mata Pelajaran Diperbarui',
      description: 'Perubahan jadwal ruang laboratorium komputer untuk mata pelajaran Pemrograman Web hari Kamis.',
      time: '2 hari yang lalu',
      isUnread: false,
    },
    {
      id: 6,
      category: 'announcements',
      categoryLabel: 'Pengumuman & Berita',
      title: 'Sosialisasi Program Magang Industri Batch 2',
      description: 'Pertemuan virtual pengenalan mitra industri DUDI dibuka untuk seluruh siswa kelas XI & XII.',
      time: '3 hari yang lalu',
      isUnread: false,
    },
  ]);

  const unreadCount = notifications.filter((n) => n.isUnread).length;

  const handleMarkAllRead = () => {
    setNotifications((prev) => prev.map((n) => ({ ...n, isUnread: false })));
  };

  const handleToggleRead = (id: number) => {
    setNotifications((prev) =>
      prev.map((n) => (n.id === id ? { ...n, isUnread: !n.isUnread } : n))
    );
  };

  const handleDelete = (id: number) => {
    setNotifications((prev) => prev.filter((n) => n.id !== id));
  };

  const filteredNotifications = notifications.filter((n) => {
    if (activeTab === 'all') return true;
    return n.category === activeTab;
  });

  const getCategoryIcon = (category: string) => {
    switch (category) {
      case 'announcements':
        return <Megaphone className="w-5 h-5 text-emerald-600" />;
      case 'academic':
        return <BookOpen className="w-5 h-5 text-[#233DFF]" />;
      case 'pkl':
        return <Briefcase className="w-5 h-5 text-amber-600" />;
      default:
        return <Bell className="w-5 h-5 text-indigo-600" />;
    }
  };

  const getCategoryBg = (category: string) => {
    switch (category) {
      case 'announcements':
        return 'bg-emerald-50 text-emerald-600';
      case 'academic':
        return 'bg-blue-50 text-[#233DFF]';
      case 'pkl':
        return 'bg-amber-50 text-amber-600';
      default:
        return 'bg-indigo-50 text-indigo-600';
    }
  };

  return (
    <div className="space-y-6 max-w-5xl mx-auto">
      {/* Header Section */}
      <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-2 border-b border-slate-200/80">
        <div>
          <div className="flex items-center gap-2.5">
            <span className="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-[#233DFF]/10 text-[#233DFF] shadow-xs">
              <Bell className="w-5 h-5" />
            </span>
            <h1 className="text-2xl font-black tracking-tight text-slate-900">Pusat Notifikasi</h1>
            {unreadCount > 0 && (
              <span className="px-3 py-0.5 rounded-full text-xs font-black bg-[#233DFF] text-white">
                {unreadCount} Baru
              </span>
            )}
          </div>
          <p className="text-xs text-slate-500 font-medium mt-1">
            Pemberitahuan resmi sekolah, jadwal mengajar, dan aktivitas monitoring PKL secara real-time.
          </p>
        </div>

        {unreadCount > 0 && (
          <button
            onClick={handleMarkAllRead}
            type="button"
            className="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-all shadow-xs cursor-pointer"
          >
            <CheckCheck className="w-4 h-4 text-[#233DFF]" />
            <span>Tandai Semua Dibaca</span>
          </button>
        )}
      </div>

      {/* Filter Tabs */}
      <div className="flex items-center gap-2 overflow-x-auto pb-1 text-xs border-b border-slate-200/80">
        <button
          onClick={() => setActiveTab('all')}
          className={`px-4 py-2 rounded-xl font-extrabold whitespace-nowrap transition-all cursor-pointer ${
            activeTab === 'all'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Semua
        </button>
        <button
          onClick={() => setActiveTab('announcements')}
          className={`px-4 py-2 rounded-xl font-extrabold whitespace-nowrap transition-all cursor-pointer ${
            activeTab === 'announcements'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Pengumuman &amp; Berita
        </button>
        <button
          onClick={() => setActiveTab('academic')}
          className={`px-4 py-2 rounded-xl font-extrabold whitespace-nowrap transition-all cursor-pointer ${
            activeTab === 'academic'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          Akademik &amp; Jadwal
        </button>
        <button
          onClick={() => setActiveTab('pkl')}
          className={`px-4 py-2 rounded-xl font-extrabold whitespace-nowrap transition-all cursor-pointer ${
            activeTab === 'pkl'
              ? 'bg-[#171B61] text-white shadow-xs'
              : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
          }`}
        >
          PKL &amp; Magang
        </button>
      </div>

      {/* Notifications List */}
      <div className="space-y-3">
        {filteredNotifications.length > 0 ? (
          filteredNotifications.map((item) => (
            <div
              key={item.id}
              className={`group relative flex items-start gap-4 p-4 rounded-3xl bg-white border transition-all ${
                item.isUnread
                  ? 'border-[#233DFF]/30 bg-blue-50/10 shadow-xs'
                  : 'border-slate-100 hover:border-slate-200'
              }`}
            >
              {/* Category Icon */}
              <div
                className={`w-11 h-11 rounded-2xl flex items-center justify-center shrink-0 ${getCategoryBg(
                  item.category
                )}`}
              >
                {getCategoryIcon(item.category)}
              </div>

              {/* Content */}
              <div className="flex-1 min-w-0">
                <div className="flex items-center gap-2 mb-1">
                  <span className="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-slate-100 text-slate-700">
                    {item.categoryLabel}
                  </span>
                  {item.isUnread && (
                    <span className="w-2 h-2 rounded-full bg-[#233DFF] animate-pulse" />
                  )}
                  <span className="text-[11px] text-slate-400 font-medium flex items-center gap-1 ml-auto">
                    <Clock className="w-3 h-3" />
                    {item.time}
                  </span>
                </div>

                <h3 className="text-sm font-black text-slate-900">{item.title}</h3>
                <p className="text-xs text-slate-500 font-medium mt-1 leading-relaxed">
                  {item.description}
                </p>
              </div>

              {/* Actions */}
              <div className="flex items-center gap-1 opacity-80 group-hover:opacity-100 transition">
                <button
                  type="button"
                  onClick={() => handleToggleRead(item.id)}
                  title={item.isUnread ? 'Tandai sudah dibaca' : 'Tandai belum dibaca'}
                  className="p-2 rounded-xl text-slate-400 hover:text-[#233DFF] hover:bg-blue-50 transition cursor-pointer"
                >
                  <CheckCircle2 className="w-4 h-4" />
                </button>
                <button
                  type="button"
                  onClick={() => handleDelete(item.id)}
                  title="Hapus pemberitahuan"
                  className="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition cursor-pointer"
                >
                  <Trash2 className="w-4 h-4" />
                </button>
              </div>
            </div>
          ))
        ) : (
          <div className="p-12 text-center bg-white rounded-3xl border border-slate-200/80">
            <Bell className="w-12 h-12 text-slate-300 mx-auto mb-3" />
            <h4 className="text-sm font-extrabold text-slate-700">Tidak ada pemberitahuan</h4>
            <p className="text-xs text-slate-400 mt-1">
              Kategori ini saat ini belum memiliki notifikasi baru.
            </p>
          </div>
        )}
      </div>
    </div>
  );
};
