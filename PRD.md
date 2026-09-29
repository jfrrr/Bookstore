# PRODUCT REQUIREMENTS DOCUMENT (PRD) — MASTER SPECIFICATION
# BOOKSTORE FULL-STACK E-COMMERCE APPLICATION

> **Dokumen Spesifikasi Lengkap & Panduan Rekonstruksi Sistem (Source of Truth)**  
> Versi: 2.0 (Post-Revisi & Finalisasi)  
> Bahasa Panduan: Bahasa Indonesia & Standar Teknis Internasional  
> Target: Reproduksi 100% Identik untuk Developer / AI Coding Agent

---

## 1. IKHTISAR SISTEM & TECH STACK

Aplikasi web **BookStore** adalah platform e-commerce toko buku daring (online bookstore) lengkap dengan antarmuka pelanggan bernuansa literatur hangat (*Warm Literary Aesthetic*) dan panel administrasi modern bernuansa *Executive Slate Dark Mode*.

### 1.1 Core Technology Stack
* **Framework:** Laravel 11.x (PHP 8.2+)
* **Arsitektur:** MVC (Model-View-Controller) + Service Layer terdedikasi (`CartService`, `CheckoutService`, `OrderService`)
* **Database:** MySQL 8.x / MariaDB
* **Frontend Template:** Laravel Blade Engine
* **Styling Framework:** Tailwind CSS v3 / v4 (via CDN + Vite compile)
* **Asset Bundler:** Vite
* **Tipografi:** Google Fonts (`Playfair Display` untuk Serif/Headings, `Inter` untuk Sans/Body)
* **Iconography:** Google Material Symbols Outlined
* **Penyimpanan Berkas (Storage):** Laravel Local Public Disk (`storage/app/public/books/` terhubung ke `public/storage/books/`)
* **Metode Pembayaran:** COD (Cash on Delivery / Bayar di Tempat)

### 1.2 User Roles & Hak Akses
1. **GUEST (Pengunjung Umum):**
   * Melihat Beranda, Katalog Buku, Detail Buku, Tentang Kami, dan Kontak.
   * Melakukan registrasi akun baru dan login.
2. **USER / CUSTOMER (Pelanggan Terotentikasi):**
   * Seluruh hak akses Guest.
   * Menambahkan buku ke Keranjang Belanja (`/cart`), mengubah jumlah, dan menghapus item.
   * Melakukan Checkout pemesanan COD (`/checkout`).
   * Melihat riwayat pesanan pribadi (`/orders`) dan detail status pesanan (`/orders/{id}`).
   * Mengirim pesan via formulir kontak (`/contact`).
3. **ADMIN (Administrator Toko):**
   * Login khusus admin via role `admin`.
   * Akses penuh ke panel admin (`/admin`).
   * Dashboard statistik utama ringkas.
   * CRUD Buku (Katalog Produk Admin).
   * CRUD Kategori Buku.
   * Manajemen Status Pesanan (Disederhanakan: Belum Selesai & Selesai).
   * Daftar Pelanggan Terdaftar.

---

## 2. DESIGN SYSTEM & IDENTITAS VISUAL

Aplikasi ini menggunakan 2 tema visual yang terpisah namun harmonis:
1. **Public Storefront:** *Warm Literary Aesthetic* (Warna kertas krem hangat, cokelat buku klasik, emas elegan).
2. **Admin Panel:** *Executive Dark Slate* (Warna slate gelap premium, border halus, teks kontras tinggi).

### 2.1 Palet Warna Toko Publik (Storefront)
```css
/* Background & Surface */
--color-surface:                   #fff8f5; /* Background utama body */
--color-surface-container:         #f6ece6; /* Kontainer kartu / input filter */
--color-surface-container-high:    #f0e6e0; /* Hover state kontainer */
--color-surface-container-highest: #eae1da; /* Spine buku / kontras krem */
--color-surface-container-lowest:  #ffffff; /* Kartu buku & navbar */

/* Typography & Text */
--color-on-surface:                #1f1b17; /* Teks utama hitam-cokelat pekat */
--color-on-surface-variant:        #554336; /* Teks subjudul / label sekunder */
--color-outline:                   #887364; /* Teks muted / placeholder */
--color-outline-variant:           #dbc2b0; /* Border lembut */

/* Brand & Aksen */
--color-primary:                   #8d4b00; /* Amber/Terracotta Cokelat primer */
--color-primary-container:         #b15f00; /* Tombol hover / aksen aktif */
--color-primary-fixed:             #ffdcc3; /* Background badge / highlight */
--color-secondary-container:       #ffc329; /* Aksen emas menyala (Hero tag) */
--color-secondary-fixed:           #ffdf9f; /* Aksen teks emas muda */

/* Feedback States */
--color-emerald-success:           #059669; /* Status Selesai / Notifikasi Sukses */
--color-amber-pending:             #d97706; /* Status Belum Selesai */
--color-red-danger:                #dc2626; /* Stok habis / Error */
```

### 2.2 Palet Warna Panel Admin (Executive Dark Slate)
* **Background Utama:** `#020617` (Deep Dark Slate)
* **Sidebar & Card Container:** `#0f172a` (Slate 900)
* **Border & Dividers:** `rgba(51, 65, 85, 0.6)` / `#334155` (Slate 700/800)
* **Active Navigation Highlight:** `rgba(245, 158, 11, 0.1)` dengan teks `#fbbf24` (Amber 400)
* **Teks Primer Admin:** `#f8fafc` (Slate 50)
* **Teks Sekunder Admin:** `#94a3b8` (Slate 400)

### 2.3 Tipografi & Ikonografi
* **Display Font (Headings `h1`, `h2`, `h3`):** `'Playfair Display', Georgia, serif`
* **Body Font (Teks paragraf, tombol, form):** `'Inter', system-ui, sans-serif`
* **Tabular Numbers (Harga & Metrik):** Wajib menggunakan kelas `tabular-nums` agar angka sejajar rapi.
* **Format Mata Uang:** Standar Indonesia: `Rp 85.000` (menggunakan titik pemisah ribuan).
* **Ikon:** Google Material Symbols Outlined (`<span class="material-symbols-outlined">...</span>`).

### 2.4 Aturan Kelas CSS Khusus
* **`.book-card-hover`:** Efek kartu buku naik `transform: translateY(-4px)` saat di-hover dengan bayangan hangat `box-shadow: 0 12px 24px -6px rgba(180, 83, 9, 0.12)`.
* **`.book-spine`:** Bayangan lekukan buku di sisi kiri cover `box-shadow: inset 3px 0 4px rgba(0, 0, 0, 0.25)`.
* **`.glass-header`:** Efek kaca blur pada navbar `background-color: rgba(255, 248, 245, 0.9); backdrop-filter: blur(12px)`.
* **`whitespace-nowrap shrink-0`:** **WAJIB** diterapkan pada elemen harga kartu buku agar harga tidak pernah patah menjadi 2 baris pada ukuran layar apapun.

---

## 3. DATABASE SCHEMA & HUBUNGAN RELASI (ERD)

Database terdiri dari 8 tabel utama. Seluruh foreign key menggunakan constraint referensial.

```
                    ┌──────────────┐
                    │    users     │
                    └──────┬───────┘
                           │ 1
        ┌──────────────────┼──────────────────┐
        │ 1                │ 1                │ 1
        ▼                  ▼                  ▼
   ┌─────────┐        ┌─────────┐     ┌──────────────────┐
   │  carts  │        │ orders  │     │ contact_messages │
   └────┬────┘        └────┬────┘     └──────────────────┘
        │ 1                │ 1
        ▼ N                ▼ N
 ┌──────────────┐   ┌──────────────┐
 │  cart_items  │   │ order_items  │
 └──────┬───────┘   └──────┬───────┘
        │ N                │ N
        ▼ 1                ▼ 1
 ┌──────────────┐◄─────────┘
 │    books     │
 └──────┬───────┘
        │ N
        ▼ 1
 ┌──────────────┐
 │  categories  │
 └──────────────┘
```

### 3.1 Tabel `users`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED, PK, AI | Primary Key |
| `name` | VARCHAR(255) | Nama lengkap user |
| `email` | VARCHAR(255), UNIQUE | Email user untuk login |
| `password` | VARCHAR(255) | Hash password (Bcrypt) |
| `role` | ENUM('admin', 'user') | Default: `'user'` |
| `phone` | VARCHAR(20), NULLABLE | Nomor telepon |
| `address` | TEXT, NULLABLE | Alamat default pengiriman |
| `remember_token` | VARCHAR(100), NULLABLE | Token remember me |
| `created_at`, `updated_at` | TIMESTAMP | Timestamps |

### 3.2 Tabel `categories`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED, PK, AI | Primary Key |
| `name` | VARCHAR(255), UNIQUE | Nama kategori (Fiksi, Teknologi, dll.) |
| `slug` | VARCHAR(255), UNIQUE | URL-friendly slug |
| `description` | TEXT, NULLABLE | Deskripsi kategori |
| `status` | ENUM('active', 'inactive') | Default: `'active'` |
| `created_at`, `updated_at` | TIMESTAMP | Timestamps |

### 3.3 Tabel `books`
| Kolom | Tipe Data | Keterangan |
|---|---|---|
| `id` | BIGINT UNSIGNED, PK, AI | Primary Key |
| `category_id` | BIGINT UNSIGNED, FK | `foreignId()->constrained()->restrictOnDelete()` |
| `title` | VARCHAR(255) | Judul buku |
| `slug` | VARCHAR(255), UNIQUE | URL slug buku |
| `author` | VARCHAR(255) | Nama pengarang/penulis |
| `description` | TEXT | Sinopsis & rincian buku |
| `price` | DECIMAL(12, 2) | Harga buku (Rupiah) |
| `stock` | INT UNSIGNED | Sisa stok fisik (default: 0) |
| `cover_image` | VARCHAR(255), NULLABLE | Path relatif file: `books/nama-file.jpg` |
| `status` | ENUM('active', 'inactive') | Default: `'active'` |
| `is_bestseller` | BOOLEAN | Default: `false` (Flag buku unggulan) |
| `deleted_at` | TIMESTAMP, NULLABLE | Soft Deletes |
| `created_at`, `updated_at` | TIMESTAMP | Timestamps |

### 3.4 Tabel `carts` & `cart_items`
* **`carts`:**
  * `id`: PK
  * `user_id`: FK ke `users.id` (1 user memiliki 1 active cart, `cascadeOnDelete()`).
  * `created_at`, `updated_at`
* **`cart_items`:**
  * `id`: PK
  * `cart_id`: FK ke `carts.id` (`cascadeOnDelete()`).
  * `book_id`: FK ke `books.id` (`cascadeOnDelete()`).
  * `quantity`: INT UNSIGNED (minimal 1).
  * `price`: DECIMAL(12, 2) (Snapshot harga buku saat dimasukkan ke keranjang).
  * `created_at`, `updated_at`

### 3.5 Tabel `orders` & `order_items`
* **`orders`:**
  * `id`: PK
  * `user_id`: FK ke `users.id` (`cascadeOnDelete()`).
  * `order_number`: VARCHAR(50), UNIQUE (Format: `BS-YYYYMMDD-XXXX`).
  * `customer_name`: VARCHAR(255)
  * `phone`: VARCHAR(20)
  * `delivery_address`: TEXT (Alamat tujuan kurir COD).
  * `payment_method`: VARCHAR(50) (Default: `'cod'`).
  * `status`: ENUM('pending', 'delivered') — **Hanya 2 Status Sederhana**:
    * `pending` = Label Tampilan: **"Belum Selesai"** (Badge Amber)
    * `delivered` = Label Tampilan: **"Selesai"** (Badge Emerald)
  * `subtotal`: DECIMAL(12, 2)
  * `total`: DECIMAL(12, 2)
  * `notes`: TEXT, NULLABLE
  * `created_at`, `updated_at`
* **`order_items`:**
  * `id`: PK
  * `order_id`: FK ke `orders.id` (`cascadeOnDelete()`).
  * `book_id`: FK ke `books.id` (`restrictOnDelete()`).
  * `book_title`: VARCHAR(255) (Snapshot historis judul buku).
  * `author`: VARCHAR(255) (Snapshot nama penulis).
  * `price`: DECIMAL(12, 2) (Snapshot harga satuan transaksi).
  * `quantity`: INT UNSIGNED
  * `subtotal`: DECIMAL(12, 2)
  * `created_at`, `updated_at`

### 3.6 Tabel `contact_messages`
* `id`: PK
* `user_id`: FK ke `users.id`, NULLABLE.
* `name`: VARCHAR(255)
* `email`: VARCHAR(255)
* `subject`: VARCHAR(255)
* `message`: TEXT
* `created_at`, `updated_at`

---

## 4. DATA AWAL (SEEDER) & IDENTITAS BUKU

Sistem dikonfigurasi secara presisi dengan **4 Kategori Utama** dan **10 Buku Pilihan** beserta file cover mockup fisik berkualitas tinggi yang bebas hak cipta (*copyright-free*).

### 4.1 Kategori Terdaftar (`CategorySeeder.php`)
1. **Fiksi** (`fiksi`)
2. **Teknologi** (`teknologi`)
3. **Bisnis** (`bisnis`)
4. **Pengembangan Diri** (`pengembangan-diri`)

### 4.2 Data 10 Buku Terdaftar (`BookSeeder.php`)
| No | Judul Buku | Penulis | Kategori | Harga | Stok | Bestseller | Path Cover |
|---|---|---|---|---|---|---|---|
| 1 | **Laskar Pelangi** | Andrea Hirata | Fiksi | Rp 85.000 | 45 | Tidak | `books/laskar-pelangi.jpg` |
| 2 | **Bumi Manusia** | Pramoedya Ananta Toer | Fiksi | Rp 95.000 | 30 | **Ya (Spotlight)** | `books/bumi-manusia.jpg` |
| 3 | **Perahu Kertas** | Dewi Lestari | Fiksi | Rp 79.000 | 60 | Tidak | `books/perahu-kertas.jpg` |
| 4 | **Clean Code** | Robert C. Martin | Teknologi | Rp 175.000 | 20 | Tidak | `books/clean-code.jpg` |
| 5 | **The Pragmatic Programmer** | David Thomas & Andrew Hunt | Teknologi | Rp 190.000 | 15 | Tidak | `books/the-pragmatic-programmer.jpg` |
| 6 | **Laravel: Up & Running** | Matt Stauffer | Teknologi | Rp 210.000 | 18 | Tidak | `books/laravel-up-and-running.jpg` |
| 7 | **Zero to One** | Peter Thiel | Bisnis | Rp 129.000 | 35 | Tidak | `books/zero-to-one.jpg` |
| 8 | **The Lean Startup** | Eric Ries | Bisnis | Rp 115.000 | 28 | Tidak | `books/the-lean-startup.jpg` |
| 9 | **Atomic Habits** | James Clear | Pengembangan Diri | Rp 119.000 | 65 | Tidak | `books/atomic-habits.jpg` |
| 10 | **The 7 Habits of Highly Effective People** | Stephen R. Covey | Pengembangan Diri | Rp 109.000 | 40 | Tidak | `books/the-7-habits-of-highly-effective-people.jpg` |

### 4.3 Kredensial Awal (`UserSeeder.php`)
* **Admin:**
  * Email: `admin@bookstore.com`
  * Password: `password`
  * Role: `admin`
* **Customer Demo:**
  * Email: `budi@gmail.com`
  * Password: `password`
  * Role: `user`

---

## 5. SPESIFIKASI HALAMAN & FITUR PUBLIK (STOREFRONT)

### 5.1 Global Navbar & Header (`components/navbar.blade.php`)
* **Branding:** Logo bertuliskan `BookStore` dengan ikon buku Material Symbol di samping kiri.
* **Menu Navigasi:** Beranda (`/`), Buku (`/books`), Pesanan Saya (`/orders`), Tentang Kami (`/about`), Kontak (`/contact`).
* **Pencarian Header:** **DITIADAKAN** (Pencarian dipusatkan secara eksklusif pada halaman katalog produk agar antarmuka header bersih dan elegan).
* **Keranjang Belanja:** Ikon shopping bag dengan badge penghitung jumlah item aktif milik user.
* **Autentikasi:**
  * Jika belum login: Tombol `Masuk` dan `Daftar`.
  * Jika login user: Avatar inisial nama, nama user, dan dropdown Logout.
  * Jika login admin: Tombol badge khusus `Admin Panel` menuju dashboard admin.

### 5.2 Halaman Beranda (`/` - `home/index.blade.php`)
* **Hero Section:**
  * Background gradien dark literatur hangat (`linear-gradient(135deg, #1C1917 0%, #292524 50%, #451A03 100%)`).
  * Headline: *"Jelajahi Dunia Lewat Lembaran Buku Impian Anda"*.
  * Call-to-action (CTA): Tombol *"Eksplor Katalog Buku"* & *"Tentang BookStore"*.
  * 3 Nilai Kepercayaan: *100% Original*, *Layanan COD (Bayar di Tempat)*, *24/7 Ramah*.
  * **Kartu Bestseller Hero Spotlight:** Menampilkan buku bestseller (*Bumi Manusia*) lengkap dengan cover visual, badge kategori, dan harga `Rp 95.000` (`whitespace-nowrap`).
* **Jelajahi 4 Kategori Buku:** Grid responsive 4 kolom (`grid-cols-2 sm:grid-cols-4 gap-4`) menampilkan ikon kategori, nama kategori, dan jumlah buku terkait.
* **Koleksi Terbaru:** Grid buku responsif menggunakan komponen `book-card`.
* **Banner Kutipan & Statistik:** Quote inspiratif dan metrik reputasi toko.

### 5.3 Halaman Katalog Buku (`/books` - `books/index.blade.php`)
* **Sidebar Filter (Kiri - Sticky):**
  * **Input Cari Buku:** Input teks real-time pencarian judul atau nama pengarang.
  * **Radio Filter Kategori:** Opsi *"Semua Kategori"* dan masing-masing 4 kategori buku dengan badge jumlah buku.
  * **Dropdown Urutan:** *Terbaru*, *Judul A-Z*, *Judul Z-A*, *Harga Terendah*, *Harga Tertinggi*.
  * **Tombol Reset Filter:** Tampil dinamis jika ada parameter filter yang aktif.
* **Grid Produk (Kanan):**
  * Teks status hasil: *"Menampilkan 1-10 dari 10 buku"*.
  * Grid responsif: `grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-5`.
* **Komponen Kartu Buku (`components/book-card.blade.php`):**
  * Rasio aspek cover `aspect-[3/4]` dengan efek `.book-spine`.
  * Badge kategori di sudut kiri atas cover.
  * Judul buku 2 baris (`line-clamp-2`) font *Playfair Display*.
  * Nama penulis di bawah judul.
  * **Baris Bawah (Footer Kartu):**
    * **Elemen Harga:** `<span class="font-bold text-[#8d4b00] text-sm sm:text-base tabular-nums whitespace-nowrap shrink-0">Rp XX.XXX</span>` (Diproteksi agar tidak pernah turun ke baris baru).
    * **Tombol Keranjang:** Tombol cokelat terracotta dengan ikon keranjang dan teks *"Keranjang"*.

### 5.4 Halaman Detail Buku (`/books/{slug}` - `books/show.blade.php`)
* Kolom kiri: Cover buku besar resolusi tinggi (`aspect-[3/4]`) dengan badge ketersediaan stok (`Tersedia (X stok)` atau `Stok Habis`).
* Kolom kanan:
  * Badge kategori.
  * Judul buku besar (*Playfair Display 3xl-4xl*).
  * Nama penulis.
  * Tampilan harga besar (`Rp XX.XXX`) dengan badge informasi *"Bayar di Tempat (COD)"*.
  * Form kontrol kuantitas (+ dan -) dan tombol *"Tambah ke Keranjang"*.
  * Sinopsis/deskripsi lengkap buku.
* Rekomendasi Buku Terkait: 4 buku dari kategori yang sama di bagian bawah.

### 5.5 Halaman Keranjang Belanja (`/cart` - `cart/index.blade.php`)
* Daftar item buku yang dimasukkan oleh pembeli.
* Informasi cover mini, judul, nama penulis, dan harga satuan.
* Input pengatur kuantitas dengan tombol update otomatis.
* Tombol hapus item keranjang dengan dialog konfirmasi.
* Ringkasan Pesanan (Sidebar kanan): Subtotal, gratis ongkir COD, total pembayaran, dan tombol *"Lanjut ke Checkout"*.
* Validasi stok real-time: Pelanggan tidak dapat memasukkan kuantitas melebihi stok yang ada.

### 5.6 Halaman Checkout (`/checkout` - `checkout/index.blade.php`)
* Validasi: Jika keranjang kosong, otomatis redirect kembali ke `/cart` dengan notifikasi error.
* Formulir Pengiriman:
  * Nama Lengkap Penerima (Wajib).
  * Nomor Telepon / WhatsApp Aktif (Wajib).
  * Alamat Pengiriman Lengkap (Wajib, minimal 10 karakter untuk panduan kurir COD).
  * Catatan Tambahan (Opsional).
* Pilihan Pembayaran: Terkunci pada **Cash on Delivery (COD)** dengan penjelasan kurir menerima uang tunai saat paket tiba.
* Tombol *"Buat Pesanan Sekarang"*.

### 5.7 Halaman Konfirmasi Sukses (`/orders/{order}/success` - `checkout/success.blade.php`)
* Animasi centang hijau sukses.
* Nomor Pesanan resmi (`BS-YYYYMMDD-XXXX`).
* Rincian alamat pengiriman dan total tagihan tunai COD.
* Tombol navigasi menuju *"Lihat Pesanan Saya"* atau *"Lanjut Belanja"*.

### 5.8 Halaman Pesanan Saya & Lacak Status (`/orders` & `/orders/{order}`)
* **Riwayat Pesanan (`orders/index.blade.php`):**
  * Daftar pesanan pelanggan dengan paginasi.
  * Menampilkan nomor pesanan, tanggal pesan, ringkasan judul buku, total biaya, dan badge status sederhana.
  * Tombol *"Detail Pesanan"*.
* **Detail Pesanan (`orders/show.blade.php`):**
  * **Stepper/Lacak Pesanan Multi-Langkah Ditiadakan**: Disederhanakan menjadi tampilan status pesanan tunggal yang bersih.
  * Status Pesanan hanya ada 2:
    1. **Belum Selesai** (Badge warna Amber / Kuning).
    2. **Selesai** (Badge warna Emerald / Hijau).
  * Rincian lengkap buku yang dipesan, harga saat transaksi (snapshot), alamat tujuan, dan total tagihan COD.

### 5.9 Halaman Informasi Statis
* **Tentang Kami (`/about`):** Penjelasan profil BookStore, filosofi literasi, dan komitmen pelayanan.
* **Kontak Kami (`/contact`):** Formulir kontak (Nama, Email, Subjek, Pesan). Pesan tersimpan di database model `ContactMessage`.

---

## 6. SPESIFIKASI PANEL ADMINISTRASI (ADMIN PANEL)

Panel admin dapat diakses di `/admin` dengan autentikasi khusus role `admin`. Antarmuka mengusung tema gelap (*Dark Slate*).

### 6.1 Layout & Navigasi Admin (`layouts/admin.blade.php`)
* **Sidebar Kiri (`components/admin/sidebar.blade.php`):**
  * Brand: Logo `BookStore` dengan badge `Admin`.
  * Menu Navigasi:
    * Dashboard (`/admin`)
    * Katalog Buku (`/admin/books`)
    * Kategori Buku (`/admin/categories`)
    * Kelola Pesanan (`/admin/orders`)
    * Pelanggan (`/admin/users`)
  * Link Toko: Tautan *"Lihat Toko Publik"* di bagian bawah sidebar.
* **Topbar Admin:**
  * Tombol toggle sidebar mobile.
  * **Tombol "Lihat Toko" di Header:** **DITIADAKAN** (Dipusatkan di menu sidebar).
  * Profil ringkas admin dan tombol Logout.

### 6.2 Dashboard Admin (`/admin` - `admin/dashboard.blade.php`)
* **Daftar Kartu Statistik Ringkas:**
  1. Total Judul Buku (`Book::count()`).
  2. Total Kategori (`Category::count()`).
  3. Total Pelanggan (`User::where('role', 'user')->count()`).
  4. Total Seluruh Pesanan (`Order::count()`).
  5. Pesanan Belum Selesai (`Order::where('status', '!=', 'delivered')->count()`).
  6. Pesanan Selesai (`Order::where('status', 'delivered')->count()`).
* **Fitur yang Ditiadakan dari Dashboard:**
  * Tampilan *"Stok Menipis"* **DITIADAKAN**.
  * Tampilan *"Pelanggan Baru"* **DITIADAKAN**.
* **Tabel Pesanan Terbaru:** 5 transaksi terakhir dengan aksi cepat lihat detail.

### 6.3 Katalog Buku Admin (`/admin/books` - `admin/books/index.blade.php`)
* **Statistik Atas:** Menampilkan total judul buku dan total unit stok.
* **Fitur yang Ditiadakan dari Katalog Buku Admin:**
  * Kartu *"Valuasi Stok"* **DITIADAKAN**.
  * Kartu *"Stok Kritis"* **DITIADAKAN**.
  * Kolom dan filter dropdown *"Status Publikasi (Draft/Active)"* **DITIADAKAN** (Semua buku default aktif).
* **Tabel Data Buku:** Cover mini, judul & pengarang, kategori, harga Rupiah, jumlah stok fisik, dan tombol aksi (Edit, Hapus).
* **Form Tambah / Edit Buku (`create.blade.php` & `edit.blade.php`):**
  * Input Judul Buku, Penulis, Kategori (Dropdown), Harga (Rp), Stok Fisik, Deskripsi, Checkbox Bestseller, dan Upload Cover Gambar.
  * Upload file disimpan ke `storage/app/public/covers` dan di-link ke publik.
  * Fitur status nonaktif pada form buku ditiadakan.

### 6.4 Kategori Buku Admin (`/admin/categories` - `admin/categories/index.blade.php`)
* **Tabel Kategori:** Nama kategori, deskripsi, jumlah buku terkait, dan tombol aksi.
* **Fitur yang Ditiadakan dari Halaman Kategori Admin:**
  * Kotak kartu *"Kategori Terpopuler"* di bagian atas **DITIADAKAN**.
  * Fitur dan filter *"Kategori Nonaktif"* **DITIADAKAN** (Semua kategori langsung aktif).
  * Tampilan input/kolom *"Slug"* di antarmuka frontend **DITIADAKAN** (Slug digenerate otomatis di background menggunakan `Str::slug($name)`).
* **Proteksi Integritas Data:** Kategori yang masih memiliki relasi buku **TIDAK BISA DIHAPUS** (Sistem memunculkan pesan error instruksi untuk memindahkan buku terlebih dahulu).

### 6.5 Daftar Pelanggan Admin (`/admin/users` - `admin/users/index.blade.php`)
* Menampilkan daftar nama, email, nomor telepon, tanggal bergabung, dan total pesanan yang pernah dibuat oleh pelanggan.
* **Fitur yang Ditiadakan:**
  * Kotak kartu *"Pelanggan dalam Pesanan"* di bagian atas **DITIADAKAN**.

### 6.6 Kelola Pesanan Admin (`/admin/orders` & `/admin/orders/{order}`)
* **Filter Status:** Filter disederhanakan menjadi 2 opsi:
  1. **Belum Selesai** (Mewakili status pending/proses).
  2. **Selesai** (Mewakili pesanan sukses terkirim).
* **Pembaruan Status Pesanan:**
  * Admin dapat mengubah status pesanan dari *"Belum Selesai"* menjadi *"Selesai"* (atau sebaliknya jika ada koreksi).
  * Opsi status lama (*shipped, confirmed, processing, cancelled*) telah dihapus dari antarmuka dropdown admin.

---

## 7. ARSITEKTUR KODE, SERVICE LAYER, & INTEGRITAS DATA

### 7.1 Service Layer Pattern
Untuk menjaga kode Controller tetap bersih dan mudah dipelajari, seluruh transaksi rumit didelegasikan ke class Service terdedikasi:
1. **`App\Services\CartService`:**
   * `getOrCreateCart(User $user)`: Mengambil keranjang aktif atau membuat baru.
   * `addItem(User $user, Book $book, int $quantity)`: Menambah buku ke keranjang dengan validasi stok server-side.
   * `updateItem(CartItem $item, int $quantity)`: Update kuantitas buku dengan validasi stok.
   * `removeItem(CartItem $item)`: Hapus item dari keranjang belanja.
   * `clearCart(User $user)`: Mengosongkan keranjang belanja.
2. **`App\Services\CheckoutService`:**
   * `process(User $user, array $data)`:
     * Dijalankan di dalam `DB::transaction(...)`.
     * Mengunci baris database (`lockForUpdate()`) untuk mencegah *race condition* stok saat ada pembelian bersamaan.
     * Mengkalkulasi subtotal dan total langsung dari database (tidak pernah mempercayai angka dari browser klien).
     * Mengurangi stok buku secara atomik (`$book->decrement('stock', $qty)`).
     * Membuat snapshot historis judul buku, nama penulis, dan harga ke tabel `order_items`.
     * Mengosongkan keranjang dan melakukan commit transaksi database.
3. **`App\Services\OrderService`:**
   * `generateOrderNumber()`: Membuat kode invoice format `BS-YYYYMMDD-XXXX`.
   * `createOrder(...)`: Membuat record order induk.
   * `createOrderItem(...)`: Menyimpan rincian item dengan snapshot data lengkap.

### 7.2 Bahasa Komentar Kode (Educational Documentation)
Semua file logika utama (`Controllers`, `Services`, `Models`) menggunakan komentar dalam **Bahasa Indonesia** yang edukatif, terstruktur dengan nomor langkah, dan menjelaskan alasan keamanan kode (misal: proteksi `abort_if(..., 403)`, transaksi database, dan query scope).

---

## 8. DAFTAR LENGKAP ROUTE APLIKASI (`routes/web.php`)

```php
// --- RUTE PUBLIK ---
GET  /                          -> HomeController@index              (home)
GET  /books                     -> BookController@index              (books.index)
GET  /books/{book:slug}         -> BookController@show               (books.show)
GET  /about                     -> AboutController@index             (about)
GET  /contact                   -> ContactController@index           (contact)
POST /contact                   -> ContactController@store           (contact.store)

// --- AUTENTIKASI ---
GET  /login                     -> Auth\LoginController@showForm     (login)
POST /login                     -> Auth\LoginController@login
POST /logout                    -> Auth\LoginController@logout       (logout)
GET  /register                  -> Auth\RegisterController@showForm  (register)
POST /register                  -> Auth\RegisterController@register
GET  /forgot-password           -> Auth\PasswordResetController@... (password.request)
POST /forgot-password           -> Auth\PasswordResetController@... (password.email)
GET  /reset-password/{token}    -> Auth\PasswordResetController@... (password.reset)
POST /reset-password            -> Auth\PasswordResetController@... (password.update)

// --- AREA PELANGGAN (AUTH) ---
GET    /cart                    -> CartController@index              (cart.index)
POST   /cart                    -> CartController@store              (cart.store)
PATCH  /cart/{item}             -> CartController@update             (cart.update)
DELETE /cart/{item}             -> CartController@destroy            (cart.destroy)
GET    /checkout                -> CheckoutController@index          (checkout.index)
POST   /checkout                -> CheckoutController@store          (checkout.store)
GET    /orders                  -> OrderController@index             (orders.index)
GET    /orders/{order}          -> OrderController@show              (orders.show)
GET    /orders/{order}/success  -> OrderController@success           (orders.success)

// --- PANEL ADMIN (AUTH + ROLE:ADMIN) ---
GET    /admin                   -> Admin\DashboardController@index   (admin.dashboard)
GET    /admin/books             -> Admin\BookController@index        (admin.books.index)
GET    /admin/books/create      -> Admin\BookController@create       (admin.books.create)
POST   /admin/books             -> Admin\BookController@store        (admin.books.store)
GET    /admin/books/{book}/edit -> Admin\BookController@edit         (admin.books.edit)
PUT    /admin/books/{book}      -> Admin\BookController@update       (admin.books.update)
DELETE /admin/books/{book}      -> Admin\BookController@destroy      (admin.books.destroy)
GET    /admin/categories        -> Admin\CategoryController@index    (admin.categories.index)
GET    /admin/categories/create -> Admin\CategoryController@create   (admin.categories.create)
POST   /admin/categories        -> Admin\CategoryController@store    (admin.categories.store)
GET    /admin/categories/{cat}/edit -> Admin\CategoryController@edit (admin.categories.edit)
PUT    /admin/categories/{cat}  -> Admin\CategoryController@update   (admin.categories.update)
DELETE /admin/categories/{cat}  -> Admin\CategoryController@destroy  (admin.categories.destroy)
GET    /admin/orders            -> Admin\OrderController@index       (admin.orders.index)
GET    /admin/orders/{order}    -> Admin\OrderController@show        (admin.orders.show)
PATCH  /admin/orders/{order}    -> Admin\OrderController@update      (admin.orders.update)
GET    /admin/users             -> Admin\UserController@index        (admin.users.index)
```

---

## 9. PANDUAN REKONSTRUKSI & INSTALASI PROYEK

Untuk membangun ulang website ini secara identik di komputer atau server baru:

1. **Clone & Setup Dependensi:**
   ```bash
   git clone <repository-url> bookstore
   cd bookstore
   composer install
   npm install
   ```

2. **Konfigurasi Environment (`.env`):**
   ```env
   APP_NAME="BookStore"
   APP_ENV=local
   APP_KEY=base64:...
   APP_DEBUG=true
   APP_TIMEZONE=Asia/Jakarta
   APP_URL=http://127.0.0.1:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bookstore
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Migrasi Database & Seeder:**
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Tautan Penyimpanan Gambar (Storage Link):**
   ```bash
   php artisan storage:link
   ```
   *Pastikan berkas gambar cover ke-10 buku diletakkan pada folder `storage/app/public/books/`.*

5. **Jalankan Aplikasi:**
   ```bash
   # Terminal 1: Laravel Server
   php artisan serve

   # Terminal 2: Vite Dev Server
   npm run dev
   ```
   Buka browser di: `http://127.0.0.1:8000`.
