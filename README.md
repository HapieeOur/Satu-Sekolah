# Satu-Sekolah

\<p align="center">
&#x20; \<strong>One Platform. A Better School Experience.\</strong>
\</p>

\<p align="center">
&#x20; Sistem manajemen sekolah terpadu untuk menghubungkan kegiatan akademik, Praktik Kerja Lapangan (PKL), perpustakaan, dan administrasi dalam satu platform.
\</p>

\<p align="center">
&#x20; \<img src="[https://img.shields.io/badge/Laravel-Framework-172B4D?style=flat-square&logo=laravel&logoColor=white](https://img.shields.io/badge/Laravel-Framework-172B4D?style=flat-square\&logo=laravel\&logoColor=white)" alt="Laravel">
&#x20; \<img src="[https://img.shields.io/badge/Blade-Templating-315E8A?style=flat-square](https://img.shields.io/badge/Blade-Templating-315E8A?style=flat-square)" alt="Blade">
&#x20; \<img src="[https://img.shields.io/badge/Tailwind_CSS-Styling-0F766E?style=flat-square&logo=tailwindcss&logoColor=white](https://img.shields.io/badge/Tailwind_CSS-Styling-0F766E?style=flat-square\&logo=tailwindcss\&logoColor=white)" alt="Tailwind CSS">
&#x20; \<img src="[https://img.shields.io/badge/Status-In_Development-946200?style=flat-square](https://img.shields.io/badge/Status-In_Development-946200?style=flat-square)" alt="In Development">
\</p>

\<p align="center">
&#x20; \<a href="#-fitur-utama">Fitur\</a> ·
&#x20; \<a href="#-arsitektur-sistem">Arsitektur\</a> ·
&#x20; \<a href="#-teknologi">Teknologi\</a> ·
&#x20; \<a href="#-instalasi">Instalasi\</a> ·
&#x20; \<a href="#-kontribusi">Kontribusi\</a>
\</p>

---

## Tentang Proyek

**Satu-Sekolah** adalah sistem manajemen sekolah berbasis web yang dirancang untuk menyederhanakan pengelolaan informasi dan aktivitas sekolah melalui satu platform terintegrasi.

Sistem ini memisahkan akses berdasarkan peran pengguna agar setiap pengguna hanya dapat mengakses fitur yang sesuai dengan tanggung jawabnya.

### Tujuan

- Menyatukan informasi akademik dan administrasi sekolah.
- Mempermudah pengelolaan tugas, absensi, dan jadwal pelajaran.
- Mendigitalisasi pencatatan kegiatan serta evaluasi PKL.
- Mengelola peminjaman dan pengembalian buku perpustakaan.
- Menyediakan kontrol akses yang konsisten dan aman.

## ✦ Fitur Utama

| Modul              | Deskripsi                                                                        |
| ------------------ | -------------------------------------------------------------------------------- |
| Akademik           | Informasi kelas, mata pelajaran, tugas, pengumpulan, penilaian, dan absensi.     |
| Jadwal Pelajaran   | Pengajuan jadwal oleh guru, validasi bentrok, serta persetujuan oleh admin.      |
| Portal PKL         | Informasi tempat PKL, logbook harian, bukti kegiatan, revisi, dan laporan akhir. |
| Perpustakaan       | Katalog buku, sirkulasi, peminjaman, pengembalian, dan pengelolaan denda.        |
| Manajemen Pengguna | Pengelolaan akun, peran, kelas, dan penempatan siswa.                            |
| Administrasi       | Tahun ajaran, semester, mitra DUDI, ruangan, dan pengaturan sistem.              |

> Status implementasi setiap modul mengikuti perkembangan kode aplikasi. Daftar di atas merupakan cakupan fitur yang direncanakan, bukan pernyataan bahwa seluruh fitur telah selesai.

## 👥 Role dan Hak Akses

Satu-Sekolah menggunakan pendekatan **Role-Based Access Control (RBAC)**.

| Fitur                           | Siswa | Siswa PKL |        Guru        | Petugas Perpustakaan | Admin |
| ------------------------------- | :---: | :-------: | :----------------: | :------------------: | :---: |
| Dashboard sesuai role           |   ✓   |     ✓     |          ✓         |           ✓          |   ✓   |
| Informasi kelas dan tugas       |   ✓   |     ✓     |          ✓         |           -          |   ✓   |
| Pengumpulan dan penilaian tugas |   ✓   |     ✓     |          ✓         |           -          |   ✓   |
| Absensi kelas                   |   ✓   |     ✓     |          ✓         |           -          |   ✓   |
| Logbook dan laporan PKL         |   -   |     ✓     |          ✓         |           -          |   ✓   |
| Supervisi dan evaluasi PKL      |   -   |     -     |          ✓         |           -          |   ✓   |
| Katalog dan sirkulasi buku      |   ✓   |     ✓     |          -         |           ✓          |   ✓   |
| Pengelolaan pengguna            |   -   |     -     |          -         |           -          |   ✓   |
| Persetujuan jadwal              |   -   |     -     |      Pengajuan     |           -          |   ✓   |
| Pengaturan akademik             |   -   |     -     | Pengajuan tertentu |           -          |   ✓   |

**Prinsip keamanan:** menyembunyikan menu di antarmuka tidak cukup. Setiap akses ke halaman, aksi, dan data harus tetap divalidasi melalui middleware, policy, atau mekanisme otorisasi di sisi server.

## 📅 Alur Pengelolaan Jadwal

Pengelolaan jadwal dirancang menggunakan alur pengajuan dan persetujuan untuk menjaga konsistensi jadwal resmi.

```mermaid
flowchart TD
    A["Guru menyusun jadwal"] --> B["Validasi jadwal"]
    B --> C{"Ada bentrok?"}
    C -->|Ya| D["Perbaiki jadwal"]
    D --> B
    C -->|Tidak| E["Ajukan ke admin"]
    E --> F["Admin melakukan pemeriksaan"]
    F --> G{"Keputusan"}
    G -->|Ditolak| H["Catat alasan penolakan"]
    H --> D
    G -->|Disetujui| I["Jadwal resmi diterbitkan"]
```

### Aturan Jadwal

- Setiap kelas memiliki susunan jadwalnya sendiri.
- Jadwal terkait dengan tahun ajaran dan semester.
- Guru mengajukan perubahan; admin menyetujui atau menolaknya.
- Jadwal resmi hanya menampilkan pengajuan yang telah disetujui.
- Sistem memvalidasi bentrok guru, kelas, dan ruangan.
- Riwayat persetujuan dan alasan penolakan disimpan untuk kebutuhan audit.

## 🧱 Arsitektur Sistem

```mermaid
flowchart TB
    U["Pengguna"]
    UI["Laravel Blade + Tailwind CSS"]
    MW["Middleware dan Otorisasi"]
    APP["Laravel Application"]
    DB[("Database Relasional")]

    U --> UI
    UI --> MW
    MW --> APP
    APP --> DB

    subgraph Modules["Modul Aplikasi"]
        A["Akademik"]
        B["PKL"]
        C["Perpustakaan"]
        D["Administrasi"]
    end

    APP --> A
    APP --> B
    APP --> C
    APP --> D
```

Arsitektur ini menggunakan Laravel sebagai fondasi aplikasi server-side, Blade untuk rendering antarmuka, Tailwind CSS untuk styling, dan database relasional untuk menyimpan data aplikasi.

## 🎨 Design System

Antarmuka Satu-Sekolah mengutamakan keterbacaan, konsistensi, dan efisiensi penggunaan sehari-hari.

### Palet Warna

| Token        | Warna     | Penggunaan                     |
| ------------ | --------- | ------------------------------ |
| Primary Navy | `#172B4D` | Sidebar, heading, elemen utama |
| Primary Blue | `#315E8A` | Tombol utama dan tautan        |
| Canvas       | `#F7F8FA` | Latar belakang halaman         |
| Surface      | `#FFFFFF` | Panel dan area konten          |
| Border       | `#DCE2E9` | Garis pemisah dan tabel        |
| Success      | `#247A58` | Status berhasil                |
| Warning      | `#946200` | Status menunggu                |
| Danger       | `#B42318` | Status gagal atau ditolak      |

### Prinsip UI/UX

- **Clean institutional SaaS:** profesional dan tidak berlebihan.
- **Desktop-first, responsive:** nyaman untuk penggunaan di laptop dan tetap dapat digunakan di layar kecil.
- **Consistent navigation:** menu menyesuaikan peran pengguna.
- **Data-first layout:** tabel, formulir, jadwal, dan informasi penting menjadi prioritas.
- **Restrained styling:** tanpa gradien dekoratif berlebihan, bayangan berat, atau kartu statistik yang tidak memiliki fungsi.
- **Accessible states:** status tidak hanya dibedakan melalui warna, tetapi juga melalui label yang jelas.

## 🛠️ Teknologi

| Teknologi           | Peran                                                     |
| ------------------- | --------------------------------------------------------- |
| PHP                 | Bahasa pemrograman backend                                |
| Laravel             | Framework aplikasi, routing, validasi, dan otorisasi      |
| Blade               | Template antarmuka server-side                            |
| Tailwind CSS        | Utility-first styling                                     |
| Vite                | Build tool untuk aset frontend                            |
| Database relasional | Penyimpanan data aplikasi, misalnya MySQL atau PostgreSQL |
| Git                 | Version control                                           |

Versi PHP, Laravel, Node.js, dan dependensi lainnya harus mengikuti persyaratan versi pada `composer.json` dan `package.json` proyek yang digunakan.

## 🚀 Instalasi

### Prasyarat

Pastikan lingkungan pengembangan telah memiliki:

- PHP dengan ekstensi yang diwajibkan versi Laravel proyek.
- Composer.
- Node.js dan npm.
- MySQL, PostgreSQL, atau database lain yang dikonfigurasi aplikasi.
- Git.

### 1. Clone repository

```bash
git clone <URL_REPOSITORY>
cd <NAMA_FOLDER_PROYEK>
```

Ganti kedua nilai tersebut dengan URL repository dan nama folder proyek yang sebenarnya.

### 2. Instal dependensi

```bash
composer install
npm install
```

### 3. Konfigurasi environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env`, kemudian sesuaikan koneksi database:


Buat database `satu_sekolah` terlebih dahulu melalui database server yang digunakan. Sesuaikan nama database, username, dan password dengan lingkungan lokal.

### 4. Jalankan migrasi

```bash
php artisan migrate
```

Perintah ini menjalankan migrasi yang tersedia di repository. Data awal atau akun demo hanya dapat dibuat apabila seeder yang sesuai telah disediakan.

### 5. Jalankan aplikasi

Buka dua terminal dari direktori proyek.

Terminal pertama:

```bash
npm run dev
```

Terminal kedua:

```bash
php artisan serve
```

Buka alamat berikut di browser:

```text
http://127.0.0.1:8000
```

Untuk build aset produksi:

```bash
npm run build
```

**Catatan:** instruksi ini berlaku untuk proyek Laravel yang telah memiliki konfigurasi Vite, dependensi Tailwind CSS, file environment contoh, dan migrasi yang sesuai. Perintah instalasi tidak otomatis membuat modul akademik, akun role, atau halaman dashboard yang belum dikembangkan.

## 📂 Struktur Direktori

Struktur berikut adalah contoh susunan proyek Laravel yang direkomendasikan, bukan klaim bahwa semua file sudah tersedia di repository.

```text
satu-sekolah/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   ├── Policies/
│   └── Services/
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── layouts/
│       ├── components/
│       ├── akademik/
│       ├── pkl/
│       ├── perpustakaan/
│       └── admin/
├── routes/
│   └── web.php
├── tests/
│   ├── Feature/
│   └── Unit/
├── public/
├── .env.example
├── composer.json
├── package.json
└── README.md
```

## 🔐 Keamanan

Aspek keamanan yang perlu diterapkan dalam pengembangan:

- Autentikasi dan otorisasi berbasis peran.
- Validasi input menggunakan Form Request atau mekanisme validasi Laravel.
- Pemeriksaan kepemilikan data agar pengguna tidak dapat mengakses data milik pihak lain.
- Proteksi CSRF untuk formulir yang relevan.
- Penyimpanan password menggunakan hashing Laravel.
- Validasi ulang bentrok jadwal saat pengajuan dan persetujuan.
- Transaksi database untuk operasi yang membutuhkan konsistensi data.
- Audit log untuk tindakan administratif penting.
- Penggunaan environment variables untuk kredensial dan konfigurasi rahasia.

Jangan commit file `.env`, password, token, atau kredensial database ke repository.

## 🧪 Pengujian

Jalankan pengujian otomatis Laravel menggunakan:

```bash
php artisan test
```

Pengujian yang direkomendasikan mencakup autentikasi, pembatasan akses antar-role, validasi formulir, alur PKL, sirkulasi perpustakaan, serta bentrok dan persetujuan jadwal.

## 🗺️ Roadmap

- [ ] Fondasi aplikasi dan autentikasi.
- [ ] Manajemen pengguna dan role.
- [ ] Modul kelas, mata pelajaran, dan tahun ajaran.
- [ ] Jadwal pelajaran dan persetujuan admin.
- [ ] Tugas, pengumpulan, dan penilaian.
- [ ] Absensi.
- [ ] Portal PKL dan evaluasi.
- [ ] Manajemen perpustakaan.
- [ ] Audit log dan pengujian akses.
- [ ] Penyempurnaan responsivitas dan aksesibilitas.

Checklist ini merupakan rencana pengembangan. Tandai suatu fitur selesai setelah implementasi dan pengujiannya benar-benar tersedia.

## 🤝 Kontribusi

Kontribusi untuk pengembangan Satu-Sekolah terbuka melalui alur berikut:

1. Fork repository.
2. Buat branch untuk perubahan yang dikerjakan.
3. Implementasikan perubahan sesuai konvensi proyek.
4. Jalankan pengujian yang relevan.
5. Kirim pull request dengan ringkasan perubahan dan hasil pengujian.

Gunakan nama branch yang deskriptif, misalnya `feat/schedule-approval` atau `fix/role-authorization`.

## 📄 Lisensi

Lisensi proyek belum ditentukan. Tambahkan file `LICENSE` dan sesuaikan bagian ini setelah ketentuan penggunaan serta distribusi kode diputuskan.

---

\<p align="center">
&#x20; \<strong>Satu-Sekolah\</strong>\<br>
&#x20; \<sub>Satu platform untuk mendukung pengelolaan sekolah yang lebih terintegrasi.\</sub>
\</p>
