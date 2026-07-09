# Si Inventaris Telkom — Sistem Manajemen Inventaris

Sistem Manajemen Inventaris ini dirancang untuk mempermudah pencatatan, pelacakan stok barang, transaksi peminjaman, serta penyajian laporan visual dan ekspor data laporan inventaris secara terpusat untuk lingkungan perusahaan Telkom/Telkomsel. Aplikasi ini dibangun menggunakan Laravel, Tailwind CSS, MySQL, dan REST API dengan Laravel Sanctum.

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
- **REST API Terproteksi:**
  - Menyediakan endpoint API untuk data produk dan riwayat peminjaman dengan autentikasi berbasis token (Laravel Sanctum).

## 🏢 Aturan Domain Email Perusahaan

Untuk keamanan dan integritas data, aplikasi ini menerapkan kebijakan domain email yang ketat. Semua akun yang melakukan pendaftaran (registrasi) maupun masuk (login) **wajib menggunakan domain email resmi perusahaan**: `@telkomsel.id`.

---

## 🛠️ Panduan Instalasi

Langkah-langkah untuk menjalankan aplikasi di lingkungan lokal:

### 1. Clone dan Masuk ke Direktori Proyek
```bash
git clone https://github.com/agiladiwidya13/SiInventaris.git
cd SiInventaris
```

### 2. Instal Dependensi
* **Dependensi PHP (Composer):**
  ```bash
  composer install
  ```
* **Dependensi JavaScript (NPM):**
  ```bash
  npm install
  ```

### 3. Konfigurasi Environment
Salin file `.env.example` menjadi `.env`. File `.env.example` sudah otomatis terkonfigurasi menggunakan **Database Hosting (Cloud MySQL)** sehingga aplikasi bisa langsung terhubung ke database online.
```bash
copy .env.example .env
```

> [!NOTE]
> Proyek ini menggunakan database online:
> - **Host**: `3yw7zm.h.filess.io`
> - **Database**: `db_SiInventaris_production`
>
> Jika Anda ingin beralih menggunakan database lokal sendiri, silakan ubah kredensial database di file `.env`.

### 4. Generate Application Key
Jalankan perintah berikut untuk menggenerasi `APP_KEY` unik aplikasi Anda:
```bash
php artisan key:generate
```

### 5. Hubungkan Storage Link
Buat symlink agar file gambar barang yang diunggah dapat diakses secara publik:
```bash
php artisan storage:link
```

### 6. Konfigurasi Database Lokal (Opsional — Lewati langkah ini jika menggunakan DB Hosting bawaan)
Jika Anda ingin bermigrasi ke database lokal sendiri:
* **Opsi A: Menggunakan Migrasi dan Seeder Laravel**
  Jalankan migrasi schema database dan seeder data awal bawaan:
  ```bash
  php artisan migrate --seed
  ```
* **Opsi B: Mengimpor File SQL Dump (`database.sql`)**
  Buat database baru di MySQL lokal Anda, lalu impor file `database.sql` di root direktori proyek.

### 7. Kompilasi Aset Frontend
* **Mode Pengembangan (Hot Reloading):**
  ```bash
  npm run dev
  ```
* **Mode Produksi (Build Aset):**
  ```bash
  npm run build
  ```

### 8. Jalankan Server Aplikasi
Jalankan server lokal Laravel:
```bash
php artisan serve
```
Aplikasi dapat diakses melalui browser di [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## 👥 Akun Demo Pengujian

Akun-akun berikut telah didaftarkan melalui seeder database untuk kebutuhan pengujian:

| Role | Email | Password |
|---|---|---|
| 👑 **Admin** | `admin@telkomsel.id` | `password` |
| 🧑‍💼 **Staff** | `staff@telkomsel.id` | `password` |
| 📈 **Manager** | `manager@telkomsel.id` | `password` |

---

## ⚡ API Endpoints

Aplikasi ini menyediakan REST API untuk integrasi dengan sistem eksternal. Semua API mengembalikan data dalam format JSON.

### 🔐 Autentikasi API

#### **1. Login Akun (Mendapatkan Token)**
* **Endpoint:** `POST /api/login`
* **Request Body:**
  ```json
  {
    "email": "admin@telkomsel.id",
    "password": "password",
    "device_name": "device_name_pilihan"
  }
  ```
* **Response (200 OK):**
  ```json
  {
    "token": "1|LaravelSanctumTokenSekianSekian...",
    "user": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@telkomsel.id",
      "role": "admin"
    }
  }
  ```

#### **2. Logout Akun**
* **Endpoint:** `POST /api/logout`
* **Header:** `Authorization: Bearer <token>`
* **Response (200 OK):**
  ```json
  {
    "message": "Berhasil logout dari API."
  }
  ```

### 📦 Endpoints Terproteksi (Membutuhkan Header `Authorization: Bearer <token>`)

#### **3. Mendapatkan Daftar Produk**
* **Endpoint:** `GET /api/products`
* **Query Parameters (Opsional):**
  * `search` (string): mencari berdasarkan nama atau kode barang.
  * `category_id` (integer): menyaring berdasarkan ID kategori.
* **Response (200 OK):**
  ```json
  {
    "data": [
      {
        "id": 1,
        "code": "PRD-001",
        "name": "Laptop ASUS ROG",
        "category": "Elektronik",
        "stock": 10,
        "location": "Gudang A - Rak 1",
        "condition": "baik",
        "image_url": "http://localhost:8000/storage/products/namafile.png",
        "created_at": "2026-07-02T19:08:09+00:00",
        "updated_at": "2026-07-02T19:08:09+00:00"
      }
    ]
  }
  ```

#### **4. Mendapatkan Detail Produk**
* **Endpoint:** `GET /api/products/{id}`
* **Response (200 OK):** Detail dari produk dengan format serupa di atas.

#### **5. Mendapatkan Daftar Riwayat Peminjaman**
* **Endpoint:** `GET /api/borrowings`
* **Response (200 OK):**
  ```json
  {
    "data": [
      {
        "id": 1,
        "borrower": {
          "id": 2,
          "name": "Staff User",
          "email": "staff@telkomsel.id"
        },
        "borrow_date": "2026-06-28",
        "return_date": "2026-07-03",
        "status": "dikembalikan",
        "items": [
          {
            "product_id": 1,
            "product_code": "PRD-001",
            "product_name": "Laptop ASUS ROG",
            "quantity": 1,
            "condition_after": "baik"
          }
        ],
        "created_at": "2026-07-02T19:08:09+00:00",
        "updated_at": "2026-07-02T19:08:09+00:00"
      }
    ]
  }
  ```

#### **6. Mendapatkan Detail Peminjaman**
* **Endpoint:** `GET /api/borrowings/{id}`
* **Response (200 OK):** Detail peminjaman spesifik dengan format serupa di atas.

---

## 🧪 Pengujian Otomatis

Aplikasi ini dilengkapi dengan pengujian unit dan fungsional. Anda dapat menjalankan pengujian otomatis menggunakan perintah berikut:
```bash
php artisan test
```
