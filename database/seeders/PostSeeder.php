<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@oneschool.sch.id')->first();

        $posts = [
            // 1. Berita
            [
                'title' => 'Prestasi Gemilang: Siswa Satu-Sekolah Meraih Juara 1 LKS Tingkat Provinsi',
                'slug' => 'siswa-satu-sekolah-juara-1-lks-provinsi',
                'category' => 'berita',
                'excerpt' => 'Delegasi sekolah berhasil mengharumkan nama almamater dalam ajang Lomba Kompetensi Siswa (LKS) bidang Teknologi Informasi.',
                'content' => 'Prestasi membanggakan kembali diukir oleh siswa-siswi SMK Satu-Sekolah. Dalam ajang bergengsi Lomba Kompetensi Siswa (LKS) tingkat provinsi yang diselenggarakan pekan lalu, perwakilan sekolah berhasil membawa pulang Juara 1 pada bidang Web Technologies dan Cyber Security. Pencapaian ini merupakan buah kerja keras para siswa dan bimbingan intensif dari dewan guru.',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(2),
                'user_id' => $admin?->id,
            ],
            [
                'title' => 'Kerjasama Industri: Penandatanganan MoU Bersama Mitra DUDI Terkemuka',
                'slug' => 'penandatanganan-mou-mitra-dudi',
                'category' => 'berita',
                'excerpt' => 'Sekolah memperluas jaringan kemitraan dengan 10 perusahaan teknologi guna mendukung program Praktik Kerja Lapangan (PKL) berkualitas.',
                'content' => 'Dalam rangka meningkatkan relevansi kompetensi lulusan dengan kebutuhan dunia usaha dan dunia industri (DUDI), manajemen SMK Satu-Sekolah secara resmi menandatangani Nota Kesepahaman (MoU) dengan berbagai perusahaan mitra. Kerjasama ini mencakup penyelarasan kurikulum, guru tamu, serta penempatan PKL bagi siswa tingkat akhir.',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(5),
                'user_id' => $admin?->id,
            ],
            [
                'title' => 'Pelepasan Kontingen Siswa Praktik Kerja Lapangan (PKL) Periode Berjalan',
                'slug' => 'pelepasan-siswa-pkl-periode-berjalan',
                'category' => 'berita',
                'excerpt' => 'Kepala Sekolah secara resmi melepas ratusan siswa untuk melaksanakan program magang industri selama 6 bulan.',
                'content' => 'Sebanyak 180 siswa dari berbagai kompetensi keahlian resmi dilepas oleh Kepala Sekolah untuk memulai masa Praktik Kerja Lapangan (PKL) di berbagai mitra industri. Siswa dibekali dengan etika kerja, kedisiplinan, serta sistem monitoring digital melalui aplikasi mobile sekolah.',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(8),
                'user_id' => $admin?->id,
            ],

            // 2. Pengumuman
            [
                'title' => 'Jadwal Pelaksanaan Penilaian Akhir Semester (PAS) Semester Ganjil',
                'slug' => 'jadwal-penilaian-akhir-semester-ganjil',
                'category' => 'pengumuman',
                'excerpt' => 'Diberitahukan kepada seluruh warga sekolah bahwa PAS semester ganjil akan dimulai sesuai kalender akademik.',
                'content' => 'Diberitahukan kepada seluruh siswa, orang tua/wali murid, dan tenaga pendidik bahwa Penilaian Akhir Semester (PAS) akan dilaksanakan secara serentak. Siswa diimbau untuk mempersiapkan diri sebaik mungkin dan menyelesaikan seluruh tugas akademik sebelum masa ujian dimulai.',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(1),
                'user_id' => $admin?->id,
            ],
            [
                'title' => 'Informasi Jam Operasional Layanan Administrasi Tata Usaha',
                'slug' => 'jam-operasional-layanan-administrasi-tu',
                'category' => 'pengumuman',
                'excerpt' => 'Pelayanan administrasi surat-menyurat dan legalisir ijazah dilayani pada hari kerja Senin hingga Jumat.',
                'content' => 'Layanan Tata Usaha sekolah beroperasi setiap hari Senin - Kamis pukul 07.30 - 15.30 WIB dan hari Jumat pukul 07.30 - 11.30 WIB. Bagi alumni yang memerlukan legalisir dokumen harap membawa dokumen asli dan fotokopi sesuai ketentuan.',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(4),
                'user_id' => $admin?->id,
            ],

            // 3. Acara
            [
                'title' => 'Career Expo & Job Fair Kemitraan SMK Satu-Sekolah',
                'slug' => 'career-expo-job-fair-satu-sekolah',
                'category' => 'acara',
                'excerpt' => 'Ajang pameran karya siswa dan rekrutmen langsung oleh puluhan perusahaan mitra DUDI terbuka untuk umum.',
                'content' => 'SMK Satu-Sekolah mempersembahkan Career Expo tahunan. Acara ini menghadirkan pameran proyek inovasi siswa, seminar karir bersama praktisi industri, serta peluang rekrutmen kerja langsung bagi alumni dan siswa tingkat akhir.',
                'event_date' => Carbon::now()->addDays(14)->toDateString(),
                'event_time' => '08:30:00',
                'event_location' => 'Auditorium Utama & Lapangan Sekolah',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(1),
                'user_id' => $admin?->id,
            ],
            [
                'title' => 'Workshop Literasi Digital & Keamanan Siber untuk Pelajar',
                'slug' => 'workshop-literasi-digital-pelajar',
                'category' => 'acara',
                'excerpt' => 'Pelatihan interaktif mengenai etika berinternet sehat dan perlindungan data pribadi di era digital.',
                'content' => 'Workshop edukatif yang diselenggarakan bersama komunitas pegiat siber untuk memperkuat pemahaman siswa mengenai keamanan berselancar di dunia maya, mencegah kejahatan siber, dan meningkatkan produktivitas digital.',
                'event_date' => Carbon::now()->addDays(25)->toDateString(),
                'event_time' => '09:00:00',
                'event_location' => 'Laboratorium Komputer Terpadu',
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(3),
                'user_id' => $admin?->id,
            ],

            // 4. Draft & Masa Depan (UNTUK UJI FILTER KEAMANAN)
            [
                'title' => 'Laporan Anggaran Internal Sekolah (DRAFT RAHASIA)',
                'slug' => 'laporan-anggaran-internal-draft',
                'category' => 'pengumuman',
                'excerpt' => 'Draft dokumen internal yang tidak boleh tampil di halaman publik.',
                'content' => 'Dokumen ini berstatus draft dan hanya untuk kepentingan internal pimpinan sekolah.',
                'is_published' => false, // DRAFT!
                'published_at' => null,
                'user_id' => $admin?->id,
            ],
            [
                'title' => 'Berita Terjadwal Masa Depan (BELUM WAKTUNYA TAMPIL)',
                'slug' => 'berita-terjadwal-masa-depan',
                'category' => 'berita',
                'excerpt' => 'Berita ini dijadwalkan terbit minggu depan sehingga tidak boleh muncul saat ini.',
                'content' => 'Konten berita ini masih dijadwalkan untuk rilis masa mendatang.',
                'is_published' => true,
                'published_at' => Carbon::now()->addDays(7), // FUTURE!
                'user_id' => $admin?->id,
            ],
        ];

        foreach ($posts as $item) {
            Post::firstOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}
