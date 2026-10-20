@php
    $userRoles = Auth::user()?->roles->pluck('name')->toArray() ?? [];
    $teacherRoles = array_intersect(['guru', 'wali_kelas', 'guru_pembimbing_pkl'], $userRoles);
@endphp

@if (count($teacherRoles) > 1)
    <div class="bg-white rounded-2xl border border-slate-200/90 p-2 shadow-xs mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div class="px-2 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-[#233DFF] animate-pulse"></span>
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Peralihan Peran Pendidik:</span>
            </div>

            <div class="flex items-center gap-1.5 flex-wrap">
                @if (in_array('guru', $userRoles))
                    <a href="{{ route('teacher.dashboard') }}" 
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ request()->routeIs('teacher.*') ? 'bg-[#233DFF] text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-navy' }}">
                        <span>📚</span>
                        <span>Portal Guru (KBM)</span>
                    </a>
                @endif

                @if (in_array('wali_kelas', $userRoles))
                    <a href="{{ route('homeroom.dashboard') }}" 
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ request()->routeIs('homeroom.*') ? 'bg-[#233DFF] text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-navy' }}">
                        <span>🏫</span>
                        <span>Wali Kelas</span>
                    </a>
                @endif

                @if (in_array('guru_pembimbing_pkl', $userRoles))
                    <a href="{{ route('internship-mentor.dashboard') }}" 
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ request()->routeIs('internship-mentor.*') ? 'bg-[#233DFF] text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100 hover:text-navy' }}">
                        <span>🏢</span>
                        <span>Pembimbing PKL</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif
