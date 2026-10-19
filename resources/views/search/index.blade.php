@extends('layouts.app')

@section('title', 'Pencarian: ' . ($query ?: 'Semua'))

@section('content')
<div class="space-y-6 max-w-5xl">
    {{-- Search Input Bar --}}
    <div class="p-6 bg-white rounded-2xl border border-slate-200/80 shadow-sm">
        <form action="{{ route('search.index') }}" method="GET" class="relative">
            <label for="search-input" class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Pencarian Data Portal</label>
            <div class="relative flex items-center">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </span>
                <input type="text"
                       name="q"
                       id="search-input"
                       value="{{ $query }}"
                       placeholder="Cari nama siswa, NIS, guru, NIP, rombel kelas, mapel, atau pengumuman..."
                       autofocus
                       class="w-full pl-11 pr-28 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-900 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#233DFF]/20 focus:border-[#233DFF] transition-all">
                <button type="submit"
                        class="absolute right-1.5 px-4 py-2 bg-[#233DFF] hover:bg-[#171B61] text-white text-xs font-bold rounded-lg transition-colors shadow-sm">
                    Cari Data
                </button>
            </div>
            <p class="text-[11px] text-slate-400 mt-2">
                Tekan <kbd class="px-1.5 py-0.5 rounded bg-slate-100 border border-slate-200 text-slate-600 font-mono text-[10px]">Enter</kbd> untuk mencari atau <kbd class="px-1.5 py-0.5 rounded bg-slate-100 border border-slate-200 text-slate-600 font-mono text-[10px]">Ctrl+K</kbd> dari mana saja.
            </p>
        </form>
    </div>

    @if($query && strlen($query) >= 2)
        {{-- Results Summary --}}
        <div class="flex items-center justify-between">
            <p class="text-xs font-semibold text-slate-600">
                Menemukan <span class="text-[#233DFF] font-bold">{{ $totalCount }}</span> data untuk kata kunci <span class="text-slate-900 font-bold">"{{ $query }}"</span>
            </p>
        </div>

        @if($totalCount === 0)
            <div class="text-center py-16 px-4 bg-white rounded-2xl border border-slate-100">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-900">Tidak ada data ditemukan</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                    Coba gunakan kata kunci lain seperti nama lengkap, nomor induk, atau istilah umum.
                </p>
            </div>
        @else
            {{-- Category: Students --}}
            @if($results['students']->count() > 0)
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden">
                    <div class="px-5 py-3.5 bg-slate-50/70 border-b border-slate-200/80 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#233DFF]"></span>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Data Siswa ({{ $results['students']->count() }})</h3>
                        </div>
                        @if($user->hasRole('admin'))
                            <a href="{{ route('admin.students.index', ['search' => $query]) }}" class="text-xs font-semibold text-[#233DFF] hover:underline">Kelola Siswa &rarr;</a>
                        @endif
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach($results['students'] as $s)
                            <div class="p-4 hover:bg-slate-50/80 flex items-center justify-between gap-4 transition-colors">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                        {{ strtoupper(substr($s->name, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-sm font-bold text-slate-900 truncate">{{ $s->name }}</h4>
                                        <p class="text-xs text-slate-500">
                                            NIS: <span class="font-mono text-slate-700">{{ $s->nis }}</span> &bull; Kelas: <span class="font-medium text-slate-800">{{ $s->classroom->name ?? 'Belum ditentukan' }}</span> &bull; Status: <span class="capitalize">{{ $s->status ?? 'Aktif' }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    @if($user->hasRole('admin'))
                                        <a href="{{ route('admin.students.edit', $s->id) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
                                            Edit Data
                                        </a>
                                    @elseif($user->hasRole('guru_pembimbing_pkl'))
                                        <a href="{{ route('internship-mentor.students.show', $s->id) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
                                            Rincian PKL
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Category: Teachers --}}
            @if($results['teachers']->count() > 0)
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden">
                    <div class="px-5 py-3.5 bg-slate-50/70 border-b border-slate-200/80 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Tenaga Pendidik / Guru ({{ $results['teachers']->count() }})</h3>
                        </div>
                        @if($user->hasRole('admin'))
                            <a href="{{ route('admin.teachers.index', ['search' => $query]) }}" class="text-xs font-semibold text-[#233DFF] hover:underline">Kelola Guru &rarr;</a>
                        @endif
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach($results['teachers'] as $t)
                            <div class="p-4 hover:bg-slate-50/80 flex items-center justify-between gap-4 transition-colors">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold text-xs flex-shrink-0">
                                        {{ strtoupper(substr($t->name, 0, 2)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-sm font-bold text-slate-900 truncate">{{ $t->name }}</h4>
                                        <p class="text-xs text-slate-500">
                                            NIP: <span class="font-mono text-slate-700">{{ $t->nip ?: 'Non-NIP' }}</span> &bull; Telepon: <span class="text-slate-700">{{ $t->phone ?: '-' }}</span>
                                            @if($t->subjects && $t->subjects->count() > 0)
                                                &bull; Mengajar: <span class="text-slate-800">{{ $t->subjects->pluck('name')->implode(', ') }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @if($user->hasRole('admin'))
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('admin.teachers.edit', $t->id) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
                                            Edit Data
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Category: Classrooms --}}
            @if($results['classrooms']->count() > 0)
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden">
                    <div class="px-5 py-3.5 bg-slate-50/70 border-b border-slate-200/80 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Rombongan Belajar / Kelas ({{ $results['classrooms']->count() }})</h3>
                        </div>
                        @if($user->hasRole('admin'))
                            <a href="{{ route('admin.classrooms.index') }}" class="text-xs font-semibold text-[#233DFF] hover:underline">Kelola Kelas &rarr;</a>
                        @endif
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach($results['classrooms'] as $c)
                            <div class="p-4 hover:bg-slate-50/80 flex items-center justify-between gap-4 transition-colors">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">Kelas {{ $c->name }}</h4>
                                    <p class="text-xs text-slate-500">
                                        Tingkat {{ $c->level }} &bull; Jurusan: {{ $c->major }} &bull; Wali Kelas: <span class="font-medium text-slate-800">{{ $c->homeroomTeacher->name ?? 'Belum Ditugaskan' }}</span>
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    @if($user->hasRole('admin'))
                                        <a href="{{ route('admin.classrooms.edit', $c->id) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
                                            Edit Kelas
                                        </a>
                                    @elseif($user->hasRole('guru'))
                                        <a href="{{ route('teacher.attendances.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
                                            Presensi Kelas
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Category: Subjects --}}
            @if($results['subjects']->count() > 0)
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden">
                    <div class="px-5 py-3.5 bg-slate-50/70 border-b border-slate-200/80 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Mata Pelajaran ({{ $results['subjects']->count() }})</h3>
                        </div>
                        @if($user->hasRole('admin'))
                            <a href="{{ route('admin.subjects.index') }}" class="text-xs font-semibold text-[#233DFF] hover:underline">Kelola Mapel &rarr;</a>
                        @endif
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach($results['subjects'] as $sub)
                            <div class="p-4 hover:bg-slate-50/80 flex items-center justify-between gap-4 transition-colors">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">{{ $sub->name }}</h4>
                                    <p class="text-xs text-slate-500">
                                        Kode: <span class="font-mono text-slate-700">{{ $sub->code }}</span> &bull; Beban Jam: {{ $sub->total_hours ?? 2 }} Jam / Minggu
                                    </p>
                                </div>
                                @if($user->hasRole('admin'))
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('admin.subjects.edit', $sub->id) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
                                            Edit Mapel
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Category: Posts / News / Events --}}
            @if($results['posts']->count() > 0)
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden">
                    <div class="px-5 py-3.5 bg-slate-50/70 border-b border-slate-200/80 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Publikasi Sekolah & Berita ({{ $results['posts']->count() }})</h3>
                        </div>
                        @if($user->hasRole('admin'))
                            <a href="{{ route('admin.posts.index') }}" class="text-xs font-semibold text-[#233DFF] hover:underline">Kelola Berita &rarr;</a>
                        @endif
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach($results['posts'] as $p)
                            @php
                                $postUrl = match ($p->category) {
                                    'berita' => route('public.news.show', $p->slug),
                                    'pengumuman' => route('public.announcements.show', $p->slug),
                                    'acara' => route('public.events.show', $p->slug),
                                    default => route('public.news.show', $p->slug),
                                };
                            @endphp
                            <div class="p-4 hover:bg-slate-50/80 flex items-center justify-between gap-4 transition-colors">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-100 text-slate-700">
                                            {{ $p->category }}
                                        </span>
                                        <span class="text-[11px] text-slate-400">
                                            {{ $p->published_at ? $p->published_at->format('d M Y') : 'Draft' }}
                                        </span>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-900">{{ $p->title }}</h4>
                                    <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">{{ $p->excerpt }}</p>
                                </div>
                                <div class="flex-shrink-0 flex items-center gap-2">
                                    <a href="{{ $postUrl }}" target="_blank" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
                                        Lihat
                                    </a>
                                    @if($user->hasRole('admin'))
                                        <a href="{{ route('admin.posts.edit', $p->id) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-50 text-[#233DFF] hover:bg-blue-100 transition-colors">
                                            Edit
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Category: Companies / PKL Partners --}}
            @if($results['companies']->count() > 0)
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden">
                    <div class="px-5 py-3.5 bg-slate-50/70 border-b border-slate-200/80 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700">Mitra Industri PKL ({{ $results['companies']->count() }})</h3>
                        </div>
                        @if($user->hasRole('admin'))
                            <a href="{{ route('admin.internship-companies.index') }}" class="text-xs font-semibold text-[#233DFF] hover:underline">Kelola Mitra &rarr;</a>
                        @endif
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach($results['companies'] as $comp)
                            <div class="p-4 hover:bg-slate-50/80 flex items-center justify-between gap-4 transition-colors">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">{{ $comp->name }}</h4>
                                    <p class="text-xs text-slate-500">
                                        {{ $comp->address ?: 'Alamat belum diatur' }} &bull; Kontak: {{ $comp->phone ?? '-' }}
                                    </p>
                                </div>
                                @if($user->hasRole('admin'))
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('admin.internship-companies.edit', $comp->id) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
                                            Edit Mitra
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    @else
        <div class="text-center py-16 px-4 bg-white rounded-2xl border border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#233DFF] flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>
            <h3 class="text-sm font-bold text-slate-900">Masukkan kata kunci pencarian</h3>
            <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                Ketikkan minimal 2 karakter untuk mencari data siswa, pengajar, rombel kelas, jadwal, berita sekolah, atau mitra PKL.
            </p>
        </div>
    @endif
</div>
@endsection
