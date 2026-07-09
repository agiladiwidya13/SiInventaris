# Sistem Manajemen Inventaris - Telkom Indonesia

Sistem Manajemen Inventaris ini dirancang untuk mempermudah pencatatan, pelacakan stok barang, transaksi peminjaman, serta penyajian laporan visual dan ekspor data laporan inventaris secara terpusat. Aplikasi ini dibangun menggunakan Laravel, Tailwind CSS, dan MySQL.

## 🔑 Fitur Utama

- **Multi-role Authentication:**
  - **Admin:** Akses penuh untuk manajemen Kategori, Barang (termasuk upload foto), Transaksi Peminjaman/Pengembalian, dan Dashboard.
  - **Staff:** Hak akses untuk melihat barang, mencatat peminjaman, dan memproses pengembalian barang.
  - **Manager:** Hak akses read-only untuk memantau dashboard statistik dan mengunduh laporan.
- **Manajemen Barang & Kategori:**
  - Pencarian barang berdasarkan kode, nama, atau lokasi penyimpanan.
  - Upload gambar produk dengan validasi format.
  - Proteksi hapus barang (barang tidak dapat dihapus jika masih dalam peminjaman aktif).
- **Transaksi Peminjaman & Pengembalian:**
  - Peminjaman multi-item dalam satu transaksi.
  - Otomatisasi pengurangan dan pengembalian stok barang.
  - Pemantauan status keterlambatan pengembalian barang secara otomatis.
- **Dashboard & Pelaporan:**
  - Grafik tren peminjaman interaktif menggunakan Chart.js.
  - Peringatan stok menipis (di bawah 5 unit).
  - Ekspor laporan peminjaman dalam format CSV (mendukung filter pencarian).

## 🛠️ Panduan Instalasi

Langkah-langkah untuk menjalankan aplikasi di lingkungan lokal:

1. **Clone dan masuk ke direktori proyek:**
   ```bash
   cd sistem-inventaris
   ```

2. **Instal dependensi PHP:**
   ```bash
   composer install
   ```

3. **Instal dependensi JavaScript:**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment:**
   Salin file `.env.example` menjadi `.env` dan sesuaikan pengaturan database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sistem_inventaris
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Jalankan migrasi database dan seeder:**
   ```bash
   php artisan migrate --seed
   ```

6. **Kompilasi aset frontend:**
   ```bash
   npm run build
   ```

7. **Jalankan server aplikasi:**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui browser di `http://127.0.0.1:8000`.

## 👥 Akun Demo Pengujian

| Role | Email | Password |
|---|---|---|
| **Admin** | `admin@example.com` | `password` |
| **Staff** | `staff@example.com` | `password` |
| **Manager** | `manager@example.com` | `password` |

## 🧪 Pengujian Otomatis

Jalankan perintah berikut untuk menjalankan unit/feature testing:
```bash
php artisan test
```
