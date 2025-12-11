# 🏢 Web Company Profile - Surya Kencana

> Website company profile modern dengan backend (Laravel) dan frontend (Vue.js) terpisah dalam struktur monorepo.

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com)
[![Vue.js](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=flat&logo=vue.js&logoColor=white)](https://vuejs.org)
[![Infisical](https://img.shields.io/badge/Infisical-Secrets-6C47FF?style=flat&logo=data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyIDJMMiAxMkwxMiAyMkwyMiAxMkwxMiAyWiIgZmlsbD0id2hpdGUiLz4KPC9zdmc+&logoColor=white)](https://infisical.com)

## 🌐 Demo Production

- **Website**: [https://suryakencana.fizualstd.my.id](https://suryakencana.fizualstd.my.id)
- **Backend API**: [https://becompro.fizualstd.my.id/api](https://becompro.fizualstd.my.id/api)
- **API Documentation**: [https://becompro.fizualstd.my.id/api/documentation](https://becompro.fizualstd.my.id/api/documentation)

## 🎯 Cara Memulai

### 1. Clone Repository

```bash
git clone https://github.com/hafidzrizqullahprasetya/Web-Company-Profile-Surya-Kencana.git
cd Web-Company-Profile-Surya-Kencana
```

---

### 2. Setup Backend

#### Langkah 1: Masuk ke Direktori Backend
```bash
cd be
```

#### Langkah 2: Install Dependencies
```bash
composer install
```

#### Langkah 3: Konfigurasi Infisical

Proyek ini menggunakan **Infisical** untuk manajemen environment variables (bukan file `.env` biasa).

**a. Login ke Infisical**
```bash
infisical login
```

Pilih:
- **Self-Hosting or Dedicated Instance**
- Masukkan URL: `https://env.fizualstd.my.id`
- Login via browser

**b. Verifikasi Koneksi**

Cek apakah secrets sudah ter-load:
```bash
infisical secrets
```

Anda akan melihat daftar environment variables seperti `DB_HOST`, `DB_DATABASE`, dll.

#### Langkah 4: Jalankan Migrasi Database

> **Penting**: Database sudah ada di remote, jadi **TIDAK PERLU seed**. Cukup jalankan migrasi untuk memastikan struktur tabel up-to-date.

**Cara 1: Menggunakan Composer Script (Recommended)**
```bash
composer migrate
```
Jika ada pertanyaan "Do you want to run this command in production?", ketik `yes`.

### 3. Setup Frontend

#### Langkah 1: Masuk ke Direktori Frontend
```bash
cd ../fe 
```

#### Langkah 2: Install Dependencies
```bash
npm install
```

---

## 🏃 Menjalankan Aplikasi

### Backend (Laravel)

Jalankan server development dengan Infisical:

```bash
cd be
composer run dev
```

Perintah ini akan menjalankan:
- ✅ Laravel development server di `http://localhost:8000`
- ✅ Laravel Pail (real-time logs)
- ✅ Auto-load secrets dari Infisical

**Output yang diharapkan:**
```
INFO  Server running on [http://0.0.0.0:8000].
INFO  Tailing application logs.
```

### Frontend (Vue.js)

Buka terminal baru, lalu jalankan:

```bash
cd fe
npm run dev
```

Vite dev server akan berjalan di `http://localhost:5173`

### Akses Aplikasi

- **Frontend**: http://localhost:5173
- **Backend API**: http://localhost:8000/api
- **API Documentation**: http://localhost:8000/api/documentation

---

## � Infisical - Manajemen Secrets

### Apa itu Infisical?

Infisical adalah platform manajemen secrets yang aman. Proyek ini menggunakan Infisical untuk menyimpan environment variables seperti database credentials, API keys, dll.

### Cara Kerja

1. **Secrets disimpan** di server Infisical (`https://env.fizualstd.my.id`)
2. **CLI Infisical** mengambil secrets saat runtime
3. **Tidak ada file `.env`** yang di-commit ke Git (lebih aman)

### Perintah Infisical yang Berguna

#### Langkah 4: Jalankan Migrasi Database

> **Penting**: Database sudah ada di remote, jadi **TIDAK PERLU seed**. Cukup jalankan migrasi untuk memastikan struktur tabel up-to-date.

**Cara 1: Menggunakan Composer Script (Recommended)**
```bash
composer migrate
```

**Cara 2: Manual dengan Infisical**
```bash
infisical run -- php artisan migrate
```

Jika ada pertanyaan "Do you want to run this command in production?", ketik `yes`.

#### Export Secrets ke File `.env` (Jika Diperlukan)

Jika Anda ingin membuat file `.env` lokal dari Infisical secrets:

```bash
cd be
infisical export --format=dotenv > .env
```

File `.env` akan dibuat dengan isi semua secrets dari Infisical.

> **Peringatan**: File `.env` sudah ada di `.gitignore`, jangan pernah commit file ini ke Git!

#### Logout dari Infisical
```bash
infisical logout
```

### Environment Variables yang Digunakan

| Variable | Deskripsi | Contoh |
|----------|-----------|--------|
| `APP_NAME` | Nama aplikasi | `Laravel` |
| `APP_ENV` | Environment | `production` / `local` |
| `APP_KEY` | Laravel encryption key | `base64:...` |
| `APP_URL` | URL backend | `https://becompro.fizualstd.my.id` |
| `DB_HOST` | Host database remote | `mysql.fizualstd.my.id` |
| `DB_PORT` | Port database | `10805` |
| `DB_DATABASE` | Nama database | `webcompro` |
| `DB_USERNAME` | Username database | `root` |
| `DB_PASSWORD` | Password database | `***` |
| `R2_ACCESS_KEY_ID` | Cloudflare R2 access key | `***` |
| `R2_BUCKET` | Nama bucket R2 | `fizualstd` |
| `R2_ENDPOINT` | Endpoint R2 | `https://...r2.cloudflarestorage.com` |
| `R2_PUBLIC_URL` | Public URL CDN | `https://cdn.fizualstd.my.id` |
