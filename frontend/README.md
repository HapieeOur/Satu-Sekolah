# Satu Sekolah - Frontend Web (React + TypeScript + Vite)

Frontend modern berbasis Single Page Application (SPA) yang dibuat khusus untuk platform **Satu Sekolah**. Frontend ini sepenuhnya terpisah (*decoupled*) dari backend Laravel dan berkomunikasi langsung melalui REST API serta Bearer Token.

---

## 🎯 Panduan Belajar React: Memahami Struktur Project

Jika Anda baru belajar React, folder dan file dalam proyek ini disusun dengan standar industri terbaik agar mudah dipahami:

```text
frontend/
├── src/
│   ├── api/             # Komunikasi ke Backend Laravel
│   │   ├── axios.ts     # Konfigurasi Axios & Bearer Token otomatis
│   │   ├── authService.ts # API login, logout, me
│   │   └── schoolService.ts # API berita, profil, pengumuman
│   │
│   ├── context/         # Global State Management (React Context)
│   │   └── AuthContext.tsx # Menyimpan data user login, token, & fungsi auth
│   │
│   ├── types/           # Definisi Tipe Data TypeScript
│   │   ├── auth.ts      # Tipe User, LoginResponse, ApiResponse
│   │   └── school.ts    # Tipe Post, SchoolProfile
│   │
│   ├── components/      # Komponen UI yang dapat digunakan berulang (Reusable)
│   │   ├── common/      # Button, Input, Card, Badge, Navbar, Footer
│   │   └── auth/        # ProtectedRoute (Pelindung halaman login)
│   │
│   ├── pages/           # Halaman Tampilan Aplikasi
│   │   ├── LandingPage.tsx   # Halaman depan umum (Statistik & Berita)
│   │   ├── NewsPage.tsx      # Halaman daftar berita + fitur cari
│   │   ├── SchoolProfilePage.tsx # Profil, visi & misi
│   │   ├── LoginPage.tsx     # Form login (Email/NIP/NIS/HP)
│   │   ├── DashboardPage.tsx # Halaman setelah login (Multi-Role)
│   │   └── NotFoundPage.tsx  # Halaman 404 jika rute salah
│   │
│   ├── App.tsx          # Mengatur Routing (React Router)
│   ├── main.tsx         # Entry point aplikasi React
│   └── index.css        # Konfigurasi Tailwind CSS
│
├── .env                 # URL Backend API (Railway / Localhost)
├── package.json         # Daftar dependensi & script (npm run dev/build)
├── tailwind.config.js   # Konfigurasi tema dan warna brand Satu Sekolah
└── vite.config.ts       # Konfigurasi Vite bundler
```

---

## 💡 4 Konsep Inti React yang Digunakan di Sini

1. **Komponen & Props (`src/components/common/Button.tsx`)**
   * Di React, tampilan dipecah menjadi komponen kecil mandiri.
   * *Props* adalah data yang dikirim dari komponen induk ke anak (misal: `<Button variant="primary" size="lg">`).
2. **State & Effect (`useState` & `useEffect`)**
   * `useState`: Menyimpan data yang bisa berubah (misal: teks input di form login atau hasil API).
   * `useEffect`: Menjalankan kode otomatis saat halaman pertama kali dibuka (misal: mengambil daftar berita dari server).
3. **Global State (`src/context/AuthContext.tsx`)**
   * Memungkinkan semua komponen mengetahui status login user tanpa harus mengoper data satu per satu.
4. **Client-Side Routing (`react-router-dom`)**
   * Berpindah halaman secepat kilat tanpa ada layar putih (*no full-page reload*).

---

## 🚀 Cara Menjalankan di Komputer Lokal

1. Buka terminal dan masuk ke folder `frontend`:
   ```bash
   cd frontend
   ```

2. Pasang semua dependensi (*node_modules*):
   ```bash
   npm install
   ```

3. Jalankan server lokal:
   ```bash
   npm run dev
   ```
   Buka browser di `http://localhost:5173`. Frontend sudah langsung terhubung dengan backend Railway!

---

## 🌐 Cara Deploy ke Vercel (Gratis & Otomatis)

Karena frontend React ini terpisah, cara deploy-nya sangat mudah di **Vercel**:

1. Masuk ke [vercel.com](https://vercel.com) menggunakan akun GitHub Anda.
2. Klik tombol **Add New...** -> **Project**.
3. Pilih repository `Satu-Sekolah` Anda.
4. Pada bagian **Root Directory**, klik **Edit** dan pilih folder: `frontend`.
5. Pada bagian **Environment Variables**, tambahkan:
   * **Key**: `VITE_API_BASE_URL`
   * **Value**: `https://satu-sekolah-production.up.railway.app/api/v1`
6. Klik **Deploy**!
7. Dalam 1-2 menit, web React Anda sudah live dengan URL gratis dari Vercel (contoh: `https://web-sekolah-hapiee.vercel.app`).

Setiap kali Anda mengubah kode React dan melakukan `git push`, Vercel akan otomatis melakukan build dan deploy versi terbaru.
