# Aplikasi Manajemen Tugas — Case 3 DKP

Tugas mata kuliah **Dasar Komputer dan Pemrograman**. Aplikasi web untuk mencatat dan mengelola daftar tugas per pengguna, dibangun dengan **Laravel 13**, **Livewire 4**, **Flux UI**, **Tailwind CSS 4**, dan **Alpine.js**.

Fitur utama: autentikasi (login/register) buatan sendiri dengan hashing & auth Laravel, CRUD tugas dengan **soft delete** (tempat sampah + pulihkan + hapus permanen), pencarian, dashboard statistik ber-**cache**, antarmuka responsif, serta job terjadwal untuk membersihkan sampah lama.

---

## Teknologi

| Komponen | Versi |
|----------|-------|
| PHP | ^8.3 |
| Laravel | ^13 |
| Livewire | ^4 |
| Flux UI | ^2 |
| Tailwind CSS | ^4 |
| Alpine.js | bawaan bundle Livewire/Flux |
| Vite | ^8 |

---

## Pemenuhan Syarat Tugas

### Persyaratan Utama

| # | Syarat | Implementasi |
|---|--------|--------------|
| 1 | Login & Register mandiri + Hash & Auth (tanpa template bawaan) | `app/Livewire/Auth/Login.php` (Auth::attempt), `app/Livewire/Auth/Register.php` (Hash::make + Auth::login). Tidak memakai Breeze/Jetstream. |
| 2 | CRUD + soft delete | `app/Livewire/Tasks.php` (create, read, update, delete, restore, forceDelete) + trait `SoftDeletes` di `app/Models/Task.php`. |
| 3 | Migration & Seeder | `database/migrations/*`, `database/seeders/DatabaseSeeder.php` & `TaskSeeder.php` (membuat 1 akun demo + 5 tugas). |
| 4 | UI Tailwind CSS & Flux | `resources/css/app.css` (import Tailwind + Flux) dan komponen `<flux:*>` di seluruh tampilan. |
| 5 | Port forwarding tanpa merusak layout | Aset di-build (`npm run build`) lalu diakses lewat `php artisan serve --host=0.0.0.0` — lihat bagian *Akses dari HP*. |
| 6 | Responsif / mobile-friendly | Layout adaptif (`sm:`/`md:`/`lg:`), menu hamburger untuk mobile di `layouts/app.blade.php`. |
| 7 | Minimal 1 halaman memakai Cache | `app/Livewire/Dashboard.php` menggunakan `Cache::remember(..., 300, ...)` untuk statistik. |
| 8 | Livewire | Komponen `Dashboard`, `Tasks`, `Auth/Login`, `Auth/Register`. |
| 9 | Alpine.js | Direktif `x-data`, `x-show`, `x-transition`, `@click.outside` pada layout dan tampilan. |
| 10 | Job, Queue & Schedule *(opsional)* | Job `PurgeOldTrashedTasks` (`ShouldQueue`) dijadwalkan harian di `routes/console.php`; `QUEUE_CONNECTION=database`. |

### Opsional Khusus Linux/WSL

| # | Syarat | Status |
|---|--------|--------|
| 11 | Laravel Octane | Tidak diterapkan (lingkungan pengembangan Windows) |
| 12 | Redis | Tidak diterapkan (cache memakai driver `database`) |

---

## Struktur Penting

```
app/
├── Jobs/PurgeOldTrashedTasks.php   # hapus permanen tugas di sampah > 30 hari (terjadwal)
├── Livewire/
│   ├── Auth/Login.php, Register.php
│   ├── Dashboard.php               # statistik + cache
│   └── Tasks.php                   # CRUD + soft delete
└── Models/Task.php                 # SoftDeletes
database/
├── migrations/                     # users, cache, jobs, tasks
└── seeders/TaskSeeder.php          # data awal
resources/views/
├── layouts/app.blade.php           # layout utama (nav, dark mode, mobile)
├── layouts/guest.blade.php         # layout halaman auth
└── Livewire/…                      # tampilan komponen
routes/web.php                      # /login /register /dashboard /tasks
```

---

## Cara Menjalankan

Prasyarat: PHP 8.3+, Composer, Node.js.

```bash
# 1. Dependensi
composer install
npm install

# 2. Konfigurasi environment
cp .env.example .env
php artisan key:generate
#   -> sesuaikan DB_CONNECTION / DB_DATABASE di .env

# 3. Database + data awal
php artisan migrate --seed

# 4. Build aset frontend
npm run build

# 5. Jalankan server
php artisan serve
```

Buka `http://localhost:8000` (otomatis diarahkan ke halaman login).

### Akun Demo

Dibuat oleh seeder:

- **Email:** `mhs@example.com`
- **Password:** `password`

Atau daftar akun baru lewat halaman **Register**.

---

## Akses dari HP (Port Forwarding)

1. Build aset (jangan pakai `npm run dev` saat demo):
   ```bash
   npm run build
   ```
2. Jalankan server dengan bind ke semua interface:
   ```bash
   php artisan serve --host=0.0.0.0 --port=8000
   ```
3. Izinkan PHP di Windows Firewall (jaringan Private).
4. Dari HP di **Wi-Fi yang sama**, buka `http://<IP-LAN-PC>:8000`.
   Cek IP LAN: `ipconfig` (IPv4).

> Catatan: `npm run dev` menyuntik `localhost:5173` sehingga aset gagal dimuat di perangkat lain. Gunakan hasil `npm run build` agar tampilan Tailwind tetap utuh.

---

## Job & Scheduler (opsional)

Menghapus permanen tugas yang sudah di tempat sampah lebih dari 30 hari:

```bash
# proses antrian
php artisan queue:work

# penjadwal (jalankan tiap menit, atau `php artisan schedule:work` untuk lokal)
php artisan schedule:work
```

Jadwal didefinisikan di `routes/console.php` (`Schedule::job(new PurgeOldTrashedTasks)->daily()`).

---

## Lisensi

Dibuat untuk keperluan tugas akademik. Framework Laravel berlisensi [MIT](https://opensource.org/licenses/MIT).
