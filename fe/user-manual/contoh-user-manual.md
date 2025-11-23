Tentu, ini adalah versi **Lengkap dan Komprehensif** dari User Manual Web ASSETS yang disalin dan distruktur ulang dari dokumen asli (87 halaman) ke dalam format Markdown (`.md`).

Anda dapat menyalin kode di bawah ini dan menyimpannya sebagai file `README.md` atau `MANUAL.md`.

-----

```markdown
# BUKU PETUNJUK PENGGUNAAN WEBSITE (USER MANUAL BOOK)
## SISTEM INFORMASI KEGIATAN HIMA ASSETS

**Disusun oleh:**
1. Devangga Arya Harta Wijayanto (23/520051/SV/23203)
2. Nadzira Azhani Farahiya (23/515567/SV/22577)
3. Dwi Anggara Najwan Sugama (23/517178/SV/22744)
4. Zhazha Nurani (23/522532/SV/23716)

**Dosen Pengampu:**
Dinar Nugroho Pratomo, S.Kom., M.IM., M.Cs.

**Program Studi Teknologi Rekayasa Perangkat Lunak**
**Universitas Gadjah Mada**
**2024**

---

## DAFTAR ISI
1. [Pendahuluan](#1-pendahuluan)
2. [Memulai Sistem](#2-memulai-sistem)
3. [Dashboard Admin](#3-dashboard-admin)
    - [Data Mahasiswa](#31-data-mahasiswa)
    - [Data Dosen Pembimbing](#32-data-dosen-pembimbing)
    - [Data Kabinet](#33-data-kabinet)
    - [Data Color Pallete](#34-data-color-pallete)
    - [Data Divisi](#35-data-divisi)
    - [Data Staff](#36-data-staff)
    - [Data Proker](#37-data-proker)
    - [Data Dokumentasi Proker](#38-data-dokumentasi-proker)
    - [Data Pelaksana Proker](#39-data-pelaksana-proker)
    - [Data Artikel](#310-data-artikel)
    - [Data Aspirasi](#311-data-aspirasi)
4. [Fitur-fitur Halaman User](#4-fitur-fitur-halaman-user)
5. [Troubleshooting](#5-troubleshooting)
6. [Keamanan](#6-keamanan)
7. [Lampiran & Kontak](#7-lampiran)

---

## 1. Pendahuluan

### 1.1 Tentang Web ASSETS
Web ASSETS adalah platform digital yang dirancang untuk mengelola dan menampilkan kegiatan akademik dan non-akademik yang bertujuan untuk meningkatkan transparansi dan aksesibilitas informasi organisasi. ASSETS (*Association of Software Engineering Technology Students*) merupakan himpunan mahasiswa Program Studi Teknologi Rekayasa Perangkat Lunak, UGM.

### 1.2 Tujuan Dokumen
Dokumen ini memberikan panduan lengkap mengenai penggunaan website sistem informasi kegiatan HIMA (ASSETS), mencakup cara mengakses sistem, fitur-fitur yang tersedia, serta panduan bagi administrator untuk mengelola sistem (CRUD) dengan efektif.

### 1.3 Persyaratan Sistem
Pengguna harus memastikan perangkat memenuhi persyaratan minimum berikut:

| Spesifikasi | Teknologi / Keterangan |
| :--- | :--- |
| **Sistem Operasi** | Windows 11 |
| **Bahasa Pemrograman** | PHP 8.2, HTML, CSS, Javascript, jQuery |
| **Framework** | Laravel 11.33.2, Tailwind CSS ^4.0, Node JS 23.0, Bootstrap 5.3 |
| **Library** | Flowbite 2.5.2, Preline, Data-aos |
| **Database** | MySQL 8.1.0 |
| **Server Aplikasi** | 2 vCPU cores, RAM 8 GB, Storage 100 GB |
| **Server Database** | CPU 4 GB, RAM 4 GB, Storage 500 GB |

![Spesifikasi Sistem](gambar-spesifikasi-sistem.png)

---

## 2. Memulai Sistem

### 2.1 Cara Mengakses Sistem

#### 2.1.1 Aktor User (Pengunjung)
1. Buka web browser.
2. Masukkan URL: `https://assets.trpl.space/`.
3. Halaman beranda akan tampil.

![Tampilan Beranda User](gambar-user-beranda.png)

#### 2.1.2 Aktor Admin
1. Buka web browser.
2. Masukkan URL: `https://assets.trpl.space/admin/dashboard`.
3. Anda akan diarahkan ke halaman login jika belum masuk.

!https://www.merriam-webster.com/dictionary/admin(gambar-url-admin.png)

### 2.2 Login dan Logout Admin

#### 2.2.1 Login Admin
Halaman login hanya untuk admin. User biasa tidak perlu login.
1. Akses halaman login melalui URL admin di atas atau `https://assets.trpl.space/login`.
2. Masukkan **Email** (terdaftar di database).
3. Masukkan **Password**.
4. Klik tombol **"Sign In"**.

![Halaman Login](gambar-login-admin.png)

#### 2.2.2 Logout Admin
1. Klik tombol **"Logout"** pada sidebar bagian bawah kiri.
2. Anda akan diarahkan kembali ke halaman login.

![Tombol Logout](gambar-tombol-logout.png)

### 2.3 Tampilan Dashboard Admin
Setelah login, Admin akan melihat Dashboard Utama yang menampilkan ringkasan jumlah data (Card Statistik).

![Dashboard Admin](gambar-dashboard-utama.png)

**Menu Navigasi (Sidebar):**
* **Home:** Dashboard.
* **Data:** Menu pengelolaan seluruh data sistem.
* **Auth:** Logout.

---

## 3. Dashboard Admin (Pengelolaan Data)

[cite_start]Bagian ini menjelaskan cara melakukan CRUD (*Create, Read, Update, Delete*) pada setiap menu data [cite: 242-1848].

### 3.1 Data Mahasiswa
Mengelola data seluruh mahasiswa yang terlibat dalam himpunan.

* **Lihat Data:** Menampilkan tabel Nama, NIM, Foto, dan Aksi.
* **Cari Data:** Ketik nama/NIM pada kolom pencarian di atas tabel.
* **Tambah Data:**
    1. Klik tombol **"Tambah Data"**.
    2. Isi **Nama Mahasiswa**.
    3. Isi **Nomor Induk Mahasiswa (NIM)** (Unik).
    4. Upload **Foto Profil** (Format: jpg, jpeg, png, svg).
    5. Klik **"Tambah"**.
* **Edit Data:** Klik tombol **"Edit"** pada baris mahasiswa, ubah data, lalu klik **"Simpan Perubahan"**. Gunakan "Clear Image" jika ingin menghapus foto.

![Form Mahasiswa](gambar-form-mahasiswa.png)

### 3.2 Data Dosen Pembimbing
Mengelola data dosen yang menjadi pembimbing kabinet.

* **Tambah Data:**
    1. Klik **"Tambah Data"**.
    2. Isi **Nama Dosen**.
    3. Isi **NIKA** (Nomor Induk Karyawan).
    4. Upload **Foto Profil**.
    5. Klik **"Tambah"**.
* **Edit Data:** Klik tombol **"Edit"** untuk mengubah informasi dosen.

![Form Dosen](gambar-form-dosen.png)

### 3.3 Data Kabinet
Mengelola periode kepengurusan himpunan (contoh: Kabinet Amara, Orion, Iris).

* **Tambah Data:**
    1. Klik **"Tambah Data"**.
    2. Isi **Nama Kabinet**.
    3. Upload **Logo Kabinet**.
    4. Isi **Visi** dan **Misi**.
    5. Isi **Makna Kabinet** (Opsional).
    6. Isi **Deskripsi Kabinet**.
    7. Pilih **Dosen Pembimbing** (dari dropdown data dosen).
    8. Isi **Tahun Mulai** dan **Tahun Selesai** (Angka).
    9. Upload **Foto Sampul Kabinet**.
    10. Klik **"Tambah"**.

![Form Kabinet](gambar-form-kabinet.png)

### 3.4 Data Color Pallete
Mengatur warna tampilan website agar dinamis sesuai tema kabinet.

* **Tambah Data:**
    1. Klik **"Tambah Data"**.
    2. Pilih **Kabinet** dari dropdown.
    3. Pilih **Primary Color** (Kode Hex, klik kotak warna).
    4. Pilih **Secondary Color** (Kode Hex).
    5. Klik **"Tambah"**.
* **Hapus:** Klik tombol **"Delete"** dan konfirmasi penghapusan.

![Form Color Pallete](gambar-form-color-pallete.png)

### 3.5 Data Divisi
Mengelola divisi-divisi yang ada di dalam sebuah kabinet (misal: PSDM, Kominfo).

* **Tambah Data:**
    1. Klik **"Tambah Data"**.
    2. Isi **Nama Divisi**.
    3. Pilih **Asal Kabinet**.
    4. Upload **Foto Sampul Divisi**.
    5. Isi **Deskripsi Divisi**.
    6. Isi **Tugas & Tanggung Jawab Divisi**.
    7. Klik **"Tambah"**.

![Form Divisi](gambar-form-divisi.png)

### 3.6 Data Staff
Menghubungkan data Mahasiswa ke dalam struktur organisasi (Divisi & Jabatan).

* **Tambah Data:**
    1. Klik **"Tambah Data"**.
    2. Pilih **Mahasiswa** (Dropdown).
    3. Pilih **Asal Kabinet**.
    4. Pilih **Asal Divisi** (Dropdown menyesuaikan kabinet).
    5. Upload **Foto Pose Staff** (Foto Non-Formal/Santai).
    6. Pilih **Jabatan** (Ketua, Sekretaris, Kepala Divisi, Staff, dll).
    7. Isi **Tugas Staff**.
    8. Klik **"Tambah"**.

![Form Staff](gambar-form-staff.png)

### 3.7 Data Proker (Program Kerja)
Mengelola daftar kegiatan atau acara yang dilaksanakan kabinet.

* **Tambah Data:**
    1. Pilih **Asal Kabinet** dan **Divisi Penyelenggara**.
    2. Isi **Judul Program Kerja**.
    3. Upload **Foto Sampul Proker**.
    4. Isi **Penjelasan Mengenai Proker** (Deskripsi umum).
    5. Isi **Penjelasan Kegiatan** (Detail acara).
    6. Pilih **Status Proker** (Bersiap, Sedang Berjalan, Selesai, Dibatalkan).
    7. **Tanggal Kegiatan:** Klik "Tambah Tanggal" untuk memasukkan tanggal (bisa lebih dari satu hari).
    8. Klik **"Tambah"**.

![Form Proker](gambar-form-proker.png)

### 3.8 Data Dokumentasi Proker
Mengupload galeri foto kegiatan untuk setiap proker.

* **Tambah Data:**
    1. Pilih **Program Kerja** (Dropdown).
    2. Upload **Foto Dokumentasi**.
    3. Isi **Keterangan Hari Dokumentasi** (Angka, misal: Hari ke-1).
    4. Klik **"Tambah"**.

![Form Dokumentasi](gambar-form-dokumentasi.png)

### 3.9 Data Pelaksana Proker
Mencatat kepanitiaan untuk setiap program kerja (beda dengan pengurus harian).

* **Tambah Data:**
    1. Pilih **Mahasiswa** (Bisa staff atau mahasiswa umum).
    2. Pilih **Kabinet**.
    3. Pilih **Program Kerja**.
    4. Pilih **Jabatan Pelaksana** (Ketua Pelaksana, Sekretaris, Bendahara, Sie Acara, dll).
    5. Klik **"Tambah"**.

![Form Pelaksana Proker](gambar-form-pelaksana.png)

### 3.10 Data Artikel
Mengelola berita atau artikel blog terkait kegiatan TRPL/ASSETS.

* **Tambah Data:**
    1. Isi **Judul Artikel**.
    2. Isi **Nama Penulis**.
    3. Upload **Foto Sampul Artikel**.
    4. Isi **Konten Artikel** (Bisa multi-paragraf).
    5. Pilih **Tanggal Terbit**.
    6. Masukkan **Tautan Sumber Resmi** (Jika ada).
    7. Klik **"Tambah"**.

![Form Artikel](gambar-form-artikel.png)

### 3.11 Data Aspirasi
Fitur ini hanya bersifat **Read** (Baca) dan **Delete** (Hapus). Admin dapat melihat pesan/aspirasi yang dikirim oleh pengunjung melalui halaman "Tentang Kami".

* **Hapus:** Klik tombol "Delete" jika aspirasi mengandung SARA atau sudah tidak relevan.

![Halaman Aspirasi](gambar-halaman-aspirasi.png)

---

## 4. Fitur-fitur Halaman User

### 4.1 Menu Navigasi (Navbar)
Menu bersifat *sticky* (selalu terlihat di atas).
* **Logo ASSETS:** Kembali ke atas halaman.
* **Beranda:** Halaman utama.
* **Kabinet (Dropdown):** Memilih periode kabinet untuk melihat detailnya.
* **Artikel:** Masuk ke halaman berita.
* **Tentang Kami:** Informasi sejarah dan form aspirasi.

![Navbar User](gambar-navbar-user.png)

### 4.2 Halaman Beranda
* **Banner Utama:** Sambutan dan tombol selengkapnya.
* **Pilih Kabinet:** Menampilkan kartu kabinet dari berbagai periode.
* **Program Kerja Terbaru:** *Highlight* proker terkini.
* **Artikel Terbaru:** *Highlight* berita terkini.
* **Aspirasi:** Menampilkan kartu aspirasi yang telah disubmit.

### 4.3 Halaman Kabinet (Dinamis)
Diakses melalui dropdown navbar atau pilihan di beranda.
* **Info Utama:** Logo, Visi, Misi, dan Makna Kabinet.
* **Struktur:** Menampilkan Ketua, Sekretaris Jenderal, dan daftar Divisi.
* **Proker Kabinet:** Daftar proker spesifik kabinet tersebut.

### 4.4 Halaman Detail Program Kerja
Menampilkan:
* Judul, Deskripsi, dan Status Proker.
* Panitia Pelaksana (Ketua Pelaksana, dll).
* Galeri Dokumentasi kegiatan.

### 4.5 Halaman Tentang Kami & Aspirasi
* **Info:** Sejarah dan Makna ASSETS.
* **Form Aspirasi:** Pengunjung dapat mengirim pesan/kritik/saran (Anonim atau dengan Nama).

### 4.6 Footer
Berada di bagian bawah, memuat hak cipta dan tautan sosial media. Warna footer dapat berubah dinamis mengikuti tema kabinet yang sedang dibuka.

![Footer](gambar-footer.png)

---

## 5. Troubleshooting

1.  **Admin tidak bisa login:**
    * Pastikan email dan password benar.
    * Cek koneksi internet. Jika server mati, tunggu hingga aktif kembali.
2.  **Gagal Memasukkan Data:**
    * Pastikan semua kolom wajib (required) terisi.
    * Pastikan format file gambar (jpg, jpeg, png, svg) sesuai.
3.  **User tidak dapat akses halaman:**
    * Muat ulang (refresh) halaman.
    * Hubungi admin jika tautan rusak (404).
4.  **Tampilan tidak responsif:**
    * Gunakan browser versi terbaru (Chrome/Edge/Firefox).
    * Pastikan resolusi layar perangkat memadai.

---

## 6. Keamanan

* **Kebijakan Password:** Password admin dienkripsi. Minimal 8 karakter kombinasi huruf dan angka.
* **Hak Akses:**
    * **User:** Hanya dapat melihat data (Read Only).
    * **Admin:** Memiliki akses penuh (Create, Read, Update, Delete).

---

## 7. Lampiran

**Informasi Kontak Support:**
* Email: `devanggaaryahartawijayanto@mail.ugm.ac.id`
* Telepon: +62 852-279-514

**Riwayat Perubahan Dokumen:**
| Versi | Tanggal Update | Perubahan |
| :--- | :--- | :--- |
| 1.0 | 1 Desember 2024 | Rilis awal fitur dasar |
| 1.1 | 5 Desember 2024 | Penambahan fitur artikel & aspirasi |

---
```