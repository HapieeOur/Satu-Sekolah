@extends('layouts.app')

@section('title', 'Pusat Notifikasi')

@section('content')
<div class="space-y-6 max-w-5xl">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-2 border-b border-slate-200/80">
        <div>
            <div class="flex items-center gap-2.5">
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-[#233DFF]/10 text-[#233DFF]">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                </span>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Pusat Notifikasi</h1>
                @if($unreadCount > 0)
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#233DFF] text-white">
                        {{ $unreadCount }} Baru
                    </span>
                @endif
            </div>
            <p class="text-xs text-slate-500 mt-1">Pemberitahuan resmi sekolah, jadwal mengajar, dan aktivitas monitoring PKL secara real-time.</p>
        </div>

        @if($notifications->count() > 0)
            <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm">
                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    Tandai Semua Dibaca
                </button>
            </form>
        @endif
    </div>

    {{-- Filter Tabs --}}
    <div class="flex items-center gap-2 overflow-x-auto pb-1 text-sm border-b border-slate-200/80">
        <a href="{{ route('notifications.index', ['tab' => 'all']) }}"
           class="px-3.5 py-2 rounded-lg font-semibold whitespace-nowrap transition-all {{ $tab === 'all' ? 'bg-[#171B61] text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
            Semua
        </a>
        <a href="{{ route('notifications.index', ['tab' => 'announcements']) }}"
           class="px-3.5 py-2 rounded-lg font-semibold whitespace-nowrap transition-all {{ $tab === 'announcements' ? 'bg-[#171B61] text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
            Pengumuman & Berita
        </a>
        <a href="{{ route('notifications.index', ['tab' => 'academic']) }}"
           class="px-3.5 py-2 rounded-lg font-semibold whitespace-nowrap transition-all {{ $tab === 'academic' ? 'bg-[#171B61] text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
            Akademik & Jadwal
        </a>
        <a href="{{ route('notifications.index', ['tab' => 'pkl']) }}"
           class="px-3.5 py-2 rounded-lg font-semibold whitespace-nowrap transition-all {{ $tab === 'pkl' ? 'bg-[#171B61] text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
            PKL & Magang
        </a>
    </div>

    {{-- Notifications List --}}
    <div class="space-y-3">
        @forelse($notifications as $item)
            <div class="group relative flex items-start gap-4 p-4 rounded-2xl bg-white border {{ $item['is_unread'] ? 'border-[#233DFF]/30 bg-blue-50/10 shadow-sm' : 'border-slate-100 hover:border-slate-200' }} transition-all">
                {{-- Category Icon Avatar --}}
                <div class="flex-shrink-0 mt-0.5">
                    @if($item['icon'] === 'announcement')
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                            </svg>
                        </div>
                    @elseif($item['icon'] === 'academic')
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                            </svg>
                        </div>
                    @elseif($item['icon'] === 'pkl')
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006A2.18 2.18 0 0118 15.75H6a2.18 2.18 0 01-2.25-1.6M2.25 14.15c.29-.39.467-.872.467-1.393V8.706c0-1.081.768-2.015 1.837-2.175a48.114 48.114 0 013.413-.387m14.25 0V6a2.25 2.25 0 00-2.25-2.25H8.25A2.25 2.25 0 006 6v.144m14.25 0c-1.22-.093-2.455-.144-3.7-.144s-2.48.051-3.7.144m0 0a2.25 2.25 0 00-2.25 2.25v2.25h12V8.394a2.25 2.25 0 00-2.25-2.25z" />
                            </svg>
                        </div>
                    @else
                        <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                        </div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700">
                            {{ $item['category_label'] }}
                        </span>
                        @if($item['is_unread'])
                            <span class="w-2 h-2 rounded-full bg-[#233DFF]"></span>
                        @endif
                        <span class="text-xs text-slate-400 ml-auto">
                            @if(isset($item['time']) && $item['time'])
                                {{ \Carbon\Carbon::parse($item['time'])->diffForHumans() }}
                            @endif
                        </span>
                    </div>

                    <h4 class="text-sm font-bold text-slate-900 group-hover:text-[#233DFF] transition-colors line-clamp-1">
                        <a href="{{ $item['url'] }}" class="focus:outline-none">
                            {{ $item['title'] }}
                        </a>
                    </h4>
                    <p class="text-xs text-slate-600 mt-0.5 line-clamp-2">
                        {{ $item['description'] }}
                    </p>

                    <div class="mt-2.5">
                        <a href="{{ $item['url'] }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#233DFF] hover:text-[#171B61] transition-colors">
                            <span>Buka Halaman</span>
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16 px-4 bg-white rounded-2xl border border-slate-100">
                <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-900">Tidak ada notifikasi</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Saat ini belum ada pemberitahuan baru dalam kategori yang dipilih.
                </p>
            </div>
        @endforelse
    </div>
</div>
@endsection
