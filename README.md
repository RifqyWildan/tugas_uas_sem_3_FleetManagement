# Fleet Management

Sistem manajemen logistik dan armada berbasis Laravel untuk mengelola data armada, rute, driver, gudang, tarif, diskon, tracking, serta layanan publik yang dapat diakses pelanggan.

## Tentang Proyek

Proyek ini dikembangkan untuk membantu operasional perusahaan logistik dalam mengelola:

- data armada dan kendaraan
- data rute dan area layanan
- driver dan tim operasional
- tracking status pengiriman
- gudang dan stok barang
- tarif pengiriman berdasarkan area dan berat
- diskon dan promo
- notifikasi operasional untuk admin/staff

Aplikasi ini terdiri dari bagian publik untuk pelanggan dan panel admin untuk pengelola sistem.

## Fitur Utama

### Publik
- Halaman beranda untuk brand dan informasi perusahaan
- Daftar armada dan kendaraan tersedia
- Cek area layanan
- Profil tim dan driver
- Cek resi / tracking pengiriman
- Informasi lokasi gudang
- Informasi layanan / perawatan
- Cek ongkir otomatis

### Admin
- Manajemen armada
- Manajemen rute
- Manajemen driver
- Manajemen tracking
- Manajemen gudang dan stok
- Manajemen tarif dan tarif per kg
- Manajemen diskon
- Role-based access: Super Admin dan Staff
- Notifikasi aktif untuk perubahan data dan stok

### Manajemen Stok Gudang
- Tambah stok
- Kurangi stok
- Validasi kapasitas gudang
- Deteksi over-capacity
- Status otomatis gudang
- Progress bar visual stok
- Histori perubahan stok

## Stack Teknologi

- PHP 8.1+
- Laravel 10
- MySQL / MariaDB
- AdminLTE
- Tailwind CSS
- Vite
- Spatie Permission
- Laravel Sanctum

## Struktur Proyek

```bash
.
├── app/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── artisan
├── composer.json
├── package.json
├── vite.config.js
├── tailwind.config.js
├── phpunit.xml
├── .env.example
├── README.md
└── GUDANG_STOK_MANAGEMENT.md
```

## Persyaratan

Pastikan perangkat Anda sudah memiliki:

- PHP 8.1+
- Composer
- Node.js 18+
- NPM
- Database MySQL/PostgreSQL/SQLite
- Web server (Laragon / XAMPP / Apache / Nginx)

## Cara Menjalankan Proyek

### 1. Clone repository

```bash
git clone https://github.com/username/armada-project.git
cd armada-project
```

### 2. Install dependency PHP

```bash
composer install
```

### 3. Install dependency Frontend

```bash
npm install
```

### 4. Konfigurasi environment

Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database serta APP_URL:

```bash
copy .env.example .env
```

Atau pada Linux/macOS:

```bash
cp .env.example .env
```

Lalu ubah konfigurasi database seperti:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=armada_project
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate application key

```bash
php artisan key:generate
```

### 6. Jalankan migrasi database

```bash
php artisan migrate
```

Jika ada seed default, jalankan:

```bash
php artisan db:seed
```

### 7. Jalankan aplikasi

```bash
php artisan serve
```

Untuk frontend development:

```bash
npm run dev
```

Untuk build production:

```bash
npm run build
```

## Halaman Utama

Setelah aplikasi berjalan, akses:

- Frontend publik: `http://localhost:8000`
- Login admin: `http://localhost:8000/login`
- Dashboard admin: `http://localhost:8000/admin/dashboard`

## Role Pengguna

Aplikasi menggunakan role-based access control:

- Super Admin
- Staff

Role ini digunakan untuk membatasi akses ke modul admin tertentu.

## Kontribusi

Kontribusi sangat terbuka. Jika Anda ingin meningkatkan proyek ini:

1. Fork repository ini
2. Buat branch baru
3. Commit perubahan Anda
4. Push ke branch Anda
5. Buat Pull Request

## Lisensi

Proyek ini dilisensikan di bawah MIT License.

## Catatan

Dokumen tambahan mengenai fitur stok gudang tersedia di [GUDANG_STOK_MANAGEMENT.md](GUDANG_STOK_MANAGEMENT.md).

---

Dibuat untuk kebutuhan sistem manajemen armada dan logistik internal perusahaan.
