<x-public-layout title="Profil Sekolah">
    <!-- Header Banner -->
    <div class="bg-navy text-white py-12 border-b border-navy-light/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-semibold bg-brand text-white mb-3">
                Tentang Institusi
            </span>
            <h1 class="text-3xl font-bold tracking-tight">Profil Satu-Sekolah</h1>
            <p class="text-xs sm:text-sm text-slate-300 mt-2 max-w-2xl">
                Lembaga pendidikan kejuruan unggulan yang berfokus pada penguasaan teknologi informasi, integritas profesional, dan kesiapan kerja industri.
            </p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
        <!-- Visi & Misi Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Visi -->
            <div class="bg-white rounded-2xl border border-border p-8 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-brand flex items-center justify-center font-bold mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <h2 class="text-lg font-bold text-navy uppercase tracking-wider mb-3">Visi Institusi</h2>
                    <p class="text-sm text-slate-700 leading-relaxed">
                        "Menjadi institusi pendidikan kejuruan terdepan yang menghasilkan lulusan berkompeten, berkarakter luhur, adaptif terhadap inovasi teknologi, serta siap bersaing di dunia industri global."
                    </p>
                </div>
            </div>

            <!-- Misi -->
            <div class="bg-white rounded-2xl border border-border p-8 shadow-xs">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-navy uppercase tracking-wider mb-3">Misi Institusi</h2>
                <ul class="space-y-2.5 text-xs text-slate-700 leading-relaxed list-disc list-inside">
                    <li>Menyelenggarakan kurikulum berbasis kompetensi yang selaras dengan kebutuhan dunia usaha dan dunia industri (DUDI).</li>
                    <li>Mengembangkan ekosistem pembelajaran digital yang transparan dan akuntabel.</li>
                    <li>Memperluas jejaring kemitraan Praktik Kerja Lapangan (PKL) yang kredibel dan bermakna.</li>
                    <li>Membina kepribadian siswa yang berdisiplin tinggi, beretika, dan memiliki jiwa kepemimpinan.</li>
                </ul>
            </div>
        </div>

        <!-- Program Keahlian -->
        <div class="bg-white rounded-2xl border border-border p-8 shadow-xs space-y-6">
            <div>
                <h2 class="text-lg font-bold text-navy uppercase tracking-wider">Program Keahlian</h2>
                <p class="text-xs text-slate-500 mt-0.5">Bidang studi kejuruan spesialisasi yang dikembangkan di Satu-Sekolah</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 rounded-xl bg-slate-50 border border-border/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-bold text-navy">Rekayasa Perangkat Lunak (RPL)</h3>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-brand border border-blue-200">Teknologi</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Fokus pada pengembangan aplikasi web, mobile development, rekayasa basis data, arsitektur perangkat lunak, serta praktik DevOps modern.
                    </p>
                </div>

                <div class="p-6 rounded-xl bg-slate-50 border border-border/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-bold text-navy">Teknik Komputer dan Jaringan (TKJ)</h3>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-100 text-indigo-700 border border-indigo-200">Infrastruktur</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Fokus pada perancangan infrastruktur jaringan, administrasi server cloud, keamanan siber (cybersecurity), serta implementasi IoT industri.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
