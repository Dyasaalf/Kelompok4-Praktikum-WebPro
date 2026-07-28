# Sistem Perpustakaan (CodeIgniter 4)
CRUD Buku & Anggota + Login Admin/Anggota + Fitur Pinjam/Kembalikan Buku

## Fitur

### Area Publik
- Halaman utama (`/`) — pilih login sebagai **Admin** atau **Anggota**

### Area Admin (login: username & password)
- Dashboard: total buku, total anggota, total buku sedang dipinjam
- CRUD Buku (kode, judul, pengarang, penerbit, tahun terbit, stok)
- CRUD Anggota (termasuk membuat akun login anggota: NIS/NIM + password)

### Area Customer / Anggota (login: NIS/NIM & password)
- Melihat semua buku yang terdaftar (bisa dicari)
- Meminjam buku — begitu dipinjam, status buku otomatis berubah jadi **"Dipinjam"** dan stok berkurang 1, buku itu tidak bisa dipinjam anggota lain sampai dikembalikan
- Halaman "Pinjaman Saya" — melihat buku yang sedang dipinjam & tombol **Kembalikan**

## Struktur File (dipisah per peran, supaya mudah diubah)

```
app/Config/
  Routes.php              <- semua rute (auth, admin/*, customer/*)
  Filters.php             <- registrasi filter adminAuth & anggotaAuth

app/Filters/
  AdminFilter.php         <- proteksi halaman admin (cek session admin)
  AnggotaFilter.php       <- proteksi halaman customer (cek session anggota)

app/Controllers/
  Home.php                <- halaman pilihan login
  Auth/
    AdminAuth.php         <- login & logout admin
    AnggotaAuth.php       <- login & logout anggota
  Admin/
    Dashboard.php         <- statistik ringkas
    Buku.php              <- CRUD buku (khusus admin)
    Anggota.php           <- CRUD anggota (khusus admin)
  Customer/
    Dashboard.php         <- daftar buku + aksi pinjam
    Pinjaman.php          <- daftar buku dipinjam + aksi kembalikan

app/Models/
  AdminModel.php
  AnggotaModel.php        <- + password (dihash otomatis), findByNisNim()
  BukuModel.php           <- + pinjamBuku(), kembalikanBuku(), pinjamanAnggota()

app/Views/
  home.php                <- halaman pilihan login
  auth/
    admin_login.php
    anggota_login.php
  admin/
    templates/main.php    <- layout khusus admin (navbar admin)
    dashboard.php
    buku/{index,create,edit}.php
    anggota/{index,create,edit}.php
  customer/
    templates/main.php    <- layout khusus customer (navbar customer)
    dashboard.php         <- daftar buku (tombol pinjam)
    pinjaman.php          <- daftar pinjaman saya (tombol kembalikan)

app/Database/Migrations/
  ..._CreateBukuTable.php
  ..._CreateAnggotaTable.php
  ..._AddPasswordToAnggota.php
  ..._AddPeminjamanFieldsToBuku.php   <- kolom status, anggota_id, tanggal_pinjam
  ..._CreateAdminTable.php            <- + seed akun admin default
```

## Langkah Instalasi

### 1. Siapkan Database
Pilih salah satu cara (jangan dua-duanya):

**Cara A — Import file SQL langsung:**
```bash
mysql -u root -p < db_perpustakaan.sql
```

**Cara B — Pakai migration CodeIgniter:**
```sql
CREATE DATABASE db_perpustakaan;
```
```bash
php spark migrate
```

### 2. Konfigurasi `.env`
Sudah tersedia di root project, sesuaikan kredensial MySQL kamu:
```
database.default.hostname = localhost
database.default.database = db_perpustakaan
database.default.username = root
database.default.password =
```

### 3. Install dependency (jika folder vendor belum lengkap)
```bash
composer install
```

### 4. Jalankan server
```bash
php spark serve
```
Buka `http://localhost:8080`

## Akun Default

| Peran   | Username/NIS | Password    |
|---------|--------------|-------------|
| Admin   | `admin`      | `admin123`  |
| Anggota | `2023001`    | `anggota123`|
| Anggota | `2023002`    | `anggota123`|

**Segera ganti password default ini setelah login pertama kali** (lewat form edit di masing-masing modul; untuk admin belum ada halaman ganti password sendiri — bisa diedit langsung lewat database atau ditambahkan sebagai fitur lanjutan).

## Alur Peminjaman Buku
1. Anggota login di `/login/anggota`
2. Buka menu **Daftar Buku** (`/customer/buku`)
3. Klik **Pinjam Buku** pada buku berstatus "Tersedia" → status buku langsung berubah jadi **"Dipinjam"**, stok berkurang 1, dan buku itu terkunci untuk anggota lain
4. Anggota bisa lihat & kembalikan buku di menu **Pinjaman Saya** (`/customer/pinjaman-saya`) → stok bertambah lagi, status kembali "Tersedia"

## Alur Admin
1. Admin login di `/login/admin`
2. Dashboard menampilkan ringkasan (total buku, anggota, & buku yang sedang dipinjam)
3. Menu **Data Buku** & **Data Anggota** untuk CRUD penuh
4. Saat menambah anggota baru, admin sekaligus membuat akun login anggota tersebut (NIS/NIM + password)

## Catatan Teknis
- Semua password (`admin`, `anggota`) disimpan ter-hash (bcrypt via `password_hash()`), tidak pernah disimpan plain text
- Validasi input & CSRF protection aktif di semua form
- Struktur controller/view dipisah per folder (`Admin/`, `Customer/`, `Auth/`) agar mudah dikembangkan lebih lanjut, misalnya menambah riwayat peminjaman, denda keterlambatan, dsb.
