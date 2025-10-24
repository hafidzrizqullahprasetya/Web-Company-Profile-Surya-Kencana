# Petunjuk AI Agent: Melanjutkan Proyek Vue.js & Tailwind (Company Profile)

## 1. Ringkasan Proyek

Proyek ini adalah **Company Profile (Compro)** yang dibangun dengan:

* **Frontend:** Vue.js  (disarankan Composition API)
* **Styling:** Tailwind CSS
* **Backend:** Laravel (sudah tersedia)

**Tugas:** Melanjutkan pengembangan frontend, membuat komponen, menghubungkan ke API backend, dan memastikan desain konsisten serta responsif.

---

## 2. Tumpukan Teknologi (Tech Stack)

| Bagian     | Teknologi / Tools              |
| ---------- | ------------------------------ |
| Frontend   | Vue.js                         |
| Styling    | Tailwind CSS                   |
| Backend    | Laravel                        |
| API Client | Axios (disarankan) / Fetch API |

---

## 3. Tema dan Warna (Theming)

* **Warna Primer:** `#4E240B` (Coklat Tua)
* Tambahkan ke `tailwind.config.js` agar dapat digunakan di seluruh aplikasi, misal: `bg-primary`, `text-primary`.

**Contoh konfigurasi Tailwind:**

```javascript
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#4E240B',
          '50': '#F9F5F3',
          '100': '#EFEAE7',
          '200': '#DED1C9',
          '300': '#C6AB9E',
          '400': '#A97C6A',
          '500': '#8E5542',
          '600': '#7F4C3B',
          '700': '#6A3F33',
          '800': '#58362C',
          '900': '#4E240B', // Warna utama
          '950': '#2F1A13',
        },
      }
    },
  },
  plugins: [],
}
```

---

## 4. Backend API (Laravel)

Backend sudah siap dengan rute API berikut:

### Authentication

```php
POST /admin/login          // Admin login
POST /superadmin/login     // Superadmin login
POST /logout               // Logout (middleware auth:sanctum)
```

### Vision & Mission

```php
GET /vision-mission        // Ambil data
PUT /vision-mission        // Update data (auth)
```

### Product

```php
GET /product               // List produk
GET /product/{id}          // Detail produk
POST /product              // Create (auth)
PUT /product/{id}          // Update (auth)
DELETE /product/{id}       // Delete (auth)
```

### Client

```php
GET /our-client
GET /our-client/{id}
POST /our-client           // Create (auth)
PUT /our-client/{id}       // Update (auth)
DELETE /our-client/{id}    // Delete (auth)
```

### Contact

```php
GET /contact
PUT /contact               // Update (auth)
```

### Testimonial

```php
GET /testimonial
POST /testimonial          // Create (auth)
PUT /testimonial/{id}      // Update (auth)
DELETE /testimonial/{id}   // Delete (auth)
```

### Admin (Superadmin)

```php
GET /admin
GET /admin/{id}
POST /admin
PUT /admin/{id}
DELETE /admin/{id}
```

> Semua rute `PUT`, `POST`, `DELETE` membutuhkan **token otentikasi** (`auth:sanctum`).

---

## 5. Tugas Selanjutnya (Next Steps)

### a. Otentikasi

* Buat **halaman login** untuk Admin dan Superadmin.
* Simpan token setelah login berhasil (misal token Sanctum).
* Buat **route guard / middleware** di Vue untuk melindungi halaman admin.
* Implementasikan **logout**.

### b. Halaman Admin / Dashboard

* Buat **layout dashboard admin** yang responsif.
* Implementasikan CRUD penuh untuk:

  * Products
  * Our Clients
  * Testimonials
  * Admins (khusus Superadmin)
* Update untuk:

  * Vision & Mission
  * Contact
* Sertakan token otentikasi di setiap request ke rute yang dilindungi.
* Gunakan **state management** (misal Pinia) untuk login dan data global.
