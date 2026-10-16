# Satu-Sekolah

<p align="center">
  <strong>Sistem Informasi Manajemen Sekolah Terpadu — Web Portal Admin & Guru</strong>
</p>

<p align="center">
  Platform terintegrasi untuk pengelolaan administrasi akademik, manajemen jadwal pelajaran dengan engine anti-bentrok, pemantauan presensi harian kelas, monitoring komprehensif Praktik Kerja Lapangan (PKL) industri, serta publikasi warta sekolah.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel&logoColor=white" alt="Laravel 11">
  <img src="https://img.shields.io/badge/PHP-8.4-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP 8.4">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/PHPUnit-96_Tests_Passing-10B981?style=flat-square&logo=php" alt="Tests Passing">
  <img src="https://img.shields.io/badge/Security-Anti--IDOR_&_RBAC-172B4D?style=flat-square" alt="Security RBAC">
</p>

<p align="center">
  <a href="#tentang-proyek">Tentang Proyek</a> ·
  <a href="#peran-pengguna--hak-akses">Role & Akses</a> ·
  <a href="#fitur-utama-aplikasi">Fitur Utama</a> ·
  <a href="#arsitektur-sistem--pola-desain">Arsitektur</a> ·
  <a href="#akun-demo--seeder">Akun Bawaan</a> ·
  <a href="#instalasi--menjalankan-aplikasi">Instalasi</a> ·
  <a href="#pengujian-otomatis">Pengujian</a>
</p>

---

## Tentang Proyek

**Satu-Sekolah** adalah aplikasi web enterprise untuk institusi pendidikan kejuruan dan sekolah menengah yang dirancang untuk kebutuhan **Administrator dan Dewan Guru**. 

> **Batasan Lingkup & Arsitektur Peran:**
> Aplikasi web ini diperuntukkan secara khusus bagi **Admin, Guru Pengajar, Wali Kelas, dan Guru Pembimbing PKL**. Siswa mengakses sistem melalui aplikasi mobile terpisah (presensi GPS geofence + bukti foto, pengumpulan jurnal harian, dan pengumpulan tugas PKL diinput via mobile dan diverifikasi/dimonitor melalui portal web ini).

---

## 👥 Peran Pengguna & Hak Akses

Satu-Sekolah menerapkan **Role-Based Access Control (RBAC)** berbasis *Spatie Laravel Permission*, Policy, Form Request Authorizations, serta pencegahan celah **IDOR (Insecure Direct Object Reference)** di sisi backend:

| Hak Akses / Kapabilitas | Administrator | Guru Biasa | Wali Kelas | Guru Pembimbing PKL |
| :--- | :---: | :---: | :---: | :---: |
| **Kelola Data Master (Tahun Ajaran, Kelas, Ruang, Mapel, Siswa, Guru, Mitra DUDI)** | ✓ | - | - | - |
| **Kelola Jadwal & Deteksi Bentrok** | ✓ | - | - | - |
| **Lihat Jadwal Mengajar Pribadi** | ✓ | ✓ | ✓ | ✓ |
| **Kelola Berita, Pengumuman, & Acara Sekolah** | ✓ | - | - | - |
| **Pantau Presensi Harian Siswa Kelas Ampuan** | ✓ | - | ✓ | - |
| **Dashboard Operasional Khusus** | Dashboard Admin | Dashboard Guru | Dashboard Walas | Dashboard Pembimbing |
| **Monitoring Siswa PKL Bimbingan** | Semua Siswa | - | Siswa Kelasnya | Siswa Bimbingannya Saja |
| **Verifikasi Presensi & Cek GPS/Foto PKL** | ✓ | - | - | ✓ (Khusus Bimbingannya) |
| **Review, Revisi, & Persetujuan Jurnal Harian** | ✓ | - | - | ✓ (Khusus Bimbingannya) |
| **Pemberian Tugas PKL & Penilaian Laporan** | ✓ | - | - | ✓ (Khusus Bimbingannya) |
| **Persetujuan Pengajuan Izin/Sakit PKL** | ✓ | - | - | ✓ (Khusus Bimbingannya) |
| **Audit Trail & Koreksi Manual Data Presensi** | ✓ (Wajib Alasan) | - | - | - |
| **Ekspor Laporan Rekapitulasi Akademik & PKL** | ✓ | - | - | - |

---

## ✦ Fitur Utama Aplikasi

### 1. Engine Jadwal Pelajaran (Conflict Detection)
- Validasi bentrok multi-parameter secara real-time di sisi server:
  - **Bentrok Guru:** Guru tidak dapat dijadwalkan mengajar di dua kelas berbeda pada hari dan jam yang bertabrakan.
  - **Bentrok Ruangan:** Satu ruangan tidak dapat digunakan lebih dari satu kelas pada interval waktu bersamaan.
  - **Bentrok Kelas:** Satu kelas tidak dapat memiliki dua mata pelajaran pada slot jam yang sama.
- Relasi dinamis: Dropdown guru pengajar otomatis terfilter berdasarkan spesialisasi mata pelajaran yang dipilih (`subject_teacher` pivot).

### 2. Modul Monitoring Praktik Kerja Lapangan (PKL)
- **Data Penempatan & Geofence Mitra DUDI:** Pengaturan koordinat lintang/bujur serta radius aman geofencing lokasi magang.
- **Verifikasi Presensi Masuk & Pulang:** Inspeksi bukti swafoto, akurasi GPS, status geofence, dan timestamp presensi siswa mobile.
- **Alur Review Jurnal Harian:** Status terstruktur (*draft* $\to$ *submitted* $\to$ *revision requested* $\to$ *approved*) dengan catatan evaluasi pembimbing.
- **Tugas PKL & Grading:** Pembimbing dapat merilis penugasan teknis industri, meninjau berkas lampiran, dan memberikan nilai akhir.
- **Pengajuan Izin/Sakit:** Peninjauan surat izin siswa magang secara transparan.
- **Audit Log Koreksi Manual:** Setiap pengubahan data sensitif oleh Administrator wajib menyertakan alasan koreksi, identitas pelaku, dan jejak waktu modifikasi.

### 3. Presensi & Monitoring Akademik
- Monitoring kehadiran harian per tanggal dan kelas oleh Wali Kelas.
- Ringkasan statistik kehadiran siswa (Hadir, Sakit, Izin, Alpa).

### 4. Modul Publikasi & Landing Page Publik
- **Landing Page Terpadu (`/`):** Hero section, profil sekolah, indikator akreditasi, berita terbaru, pengumuman, dan agenda kegiatan sekolah.
- **Profil Sekolah (`/profil`):** Visi, misi, dan detail program keahlian kejuruan (RPL & TKJ).
- **Katalog Berita (`/berita`):** Artikel liputan kegiatan dengan paginasi dan halaman detail.
- **Papan Pengumuman Resmi (`/pengumuman`):** Informasi administratif penting bagi wali murid dan masyarakat.
- **Agenda Acara (`/acara`):** Kalender kegiatan akademik, ujian, dan kemitraan industri.
- **Proteksi Status Draft:** Konten yang berstatus draf otomatis terlindungi dengan HTTP 404 pada rute publik.

### 5. Laporan & Rekapitulasi Cetak
- Rekapitulasi akademik per kelas dan semester.
- Laporan komprehensif PKL per mitra industri siap cetak dengan tata letak ramah cetak (print-ready stylesheet).

---

## 🧱 Arsitektur Sistem & Pola Desain

Aplikasi dibangun dengan prinsip **SOLID**, **Clean Architecture**, dan **Design Tokens** yang tertata rapi:

- **Repository & Service Pattern:**
  - `PostServiceInterface` $\to$ `PostService`
  - `AttendanceServiceInterface` $\to$ `AttendanceService` & `AttendanceRepository`
  - `InternshipServiceInterface` $\to$ `InternshipService` & `InternshipMonitoringRepository`
- **Otorisasi & Keamanan:**
  - Middleware `active` untuk mencegah akun nonaktif login ke sistem.
  - Proteksi anti-IDOR pada controller pembimbing PKL (pembimbing ditolak mengakses data di luar penugasan siswa bimbingannya).
  - Validasi ketat menggunakan Laravel Form Requests.
- **UI/UX & Design Tokens:**
  - Tipografi: *Plus Jakarta Sans*.
  - Palet Institusi: Primary Navy (`#172B4D`), Brand Blue (`#315E8A`), Canvas (`#F7F8FA`), Slate Border (`#DCE2E9`).
  - Responsif di laptop/desktop maupun perangkat mobile via Alpine.js slide drawer.

---

## 🔑 Akun Demo & Seeder

Database seeder telah menyediakan akun demo untuk seluruh peran. Semua akun menggunakan password: `password`.

| Peran | Email | Password | Keterangan |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@oneschool.sch.id` | `password` | Akses penuh master data, jadwal, publikasi, & laporan |
| **Guru Pengajar** | `guru@oneschool.sch.id` | `password` | Guru mata pelajaran biasa, jadwal mengajar pribadi |
| **Wali Kelas** | `walikelas@oneschool.sch.id` | `password` | Guru + Wali Kelas (memiliki akses presensi kelas binaan) |
| **Pembimbing PKL** | `pembimbing@oneschool.sch.id` | `password` | Guru + Pembimbing siswa magang industri |

---

## 🚀 Instalasi & Menjalankan Aplikasi

### Prasyarat
- PHP $\ge$ 8.2 (Direkomendasikan PHP 8.4)
- Composer
- Node.js & NPM
- MySQL / MariaDB

### 1. Clone & Masuk Direktori
```bash
git clone https://github.com/HapieeOur/Satu-Sekolah.git
cd Satu-Sekolah
```

### 2. Instalasi Dependensi PHP & Node.js
```bash
composer install
npm install
```

### 3. Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```
Sesuaikan konfigurasi database Anda pada file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=satu_sekolah
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi & Seeder Database
Jalankan migrasi seluruh tabel beserta data awal:
```bash
php artisan migrate --seed
```

### 5. Menjalankan Server Aplikasi
Jalankan build aset dan server pengembangan:
```bash
# Terminal 1: Vite dev server
npm run dev

# Terminal 2: Laravel server
php artisan serve
```
Akses aplikasi melalui browser di: `http://localhost:8000`

---

## 🧪 Pengujian Otomatis

Aplikasi dilengkapi dengan rangkaian **Automated Feature & Unit Tests** yang komprehensif menguji seluruh alur autentikasi, otorisasi RBAC, validasi bentrok jadwal, alur kerja PKL, hingga pengujian rute publik:

```bash
php artisan test
```

**Hasil Pengujian:**
```text
   PASS  Tests\Unit\ExampleTest
   PASS  Tests\Unit\RepositoryAndHelperTest
   PASS  Tests\Feature\AttendanceTest
   PASS  Tests\Feature\AuthTest
   PASS  Tests\Feature\DashboardTest
   PASS  Tests\Feature\DataMasterTest
   PASS  Tests\Feature\ExampleTest
   PASS  Tests\Feature\InternshipMonitoringTest
   PASS  Tests\Feature\PostManagementTest
   PASS  Tests\Feature\PublicPageTest
   PASS  Tests\Feature\ReportTest
   PASS  Tests\Feature\RoleAccessTest
   PASS  Tests\Feature\ScheduleTest
   PASS  Tests\Feature\UserManagementTest

  Tests:    96 passed (340 assertions)
  Duration: 7.84s
```

---

## 📄 Lisensi

Hak Cipta © 2026 Satu-Sekolah. Seluruh hak cipta dilindungi undang-undang.
