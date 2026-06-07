# Tubes WGTIK

Tubes WGTIK adalah aplikasi berbasis web yang dikembangkan sebagai **Tugas Besar (Tubes)** untuk mata kuliah terkait pengembangan Web. Sistem ini dirancang untuk memenuhi spesifikasi kebutuhan proyek akhir dengan mengimplementasikan konsep *Model-View-Controller* (MVC) menggunakan framework Laravel.

---

## 📚 Latar Belakang

[Deskripsikan masalah utama yang ingin diselesaikan oleh aplikasi Anda di sini. Contoh: Kebutuhan akan sistem informasi yang terstruktur untuk mengelola data XYZ...]

Aplikasi ini hadir sebagai solusi dengan menyediakan:
- [Poin keunggulan aplikasi 1]
- [Poin keunggulan aplikasi 2]
- [Poin keunggulan aplikasi 3]

---

## 🎯 Tujuan Sistem

Tujuan utama dari pengembangan sistem ini adalah:

- Menerapkan konsep pemrograman web tingkat lanjut berbasis framework Laravel.
- [Tujuan spesifik aplikasi 1]
- [Tujuan spesifik aplikasi 2]

---

## 👥 Jenis Pengguna

Sistem ini dirancang untuk digunakan oleh [ubah jika perlu, misal: dua] jenis pengguna utama.

### 1️⃣ Admin
Admin bertugas mengelola keseluruhan sistem dan data master.

Fitur yang tersedia:
- Mengelola data pengguna
- Mengelola [Entitas master, misal: data barang/jadwal]
- Melihat laporan sistem

---

### 2️⃣ Pengguna / User
Pengguna umum yang berinteraksi langsung dengan layanan utama aplikasi.

Fitur yang tersedia:
- Registrasi dan login
- [Fitur utama user 1]
- [Fitur utama user 2]

---

## ⚙️ Fitur Utama

### 🔐 Manajemen Akun
- Registrasi
- Login
- Logout
- Manajemen profil

---

### 📂 Manajemen Data Inti
- [Nama modul, misal: CRUD Data Transaksi]
- Pencarian data spesifik
- Filter dan validasi form

---

## 💻 Arsitektur & Teknologi yang Digunakan

### Backend & Frontend
- Laravel (v.10+ / Sesuaikan versi)
- Blade Template Engine
- [Bootstrap / Tailwind CSS] *(Pilih salah satu)*

### Database
- MySQL

---

## 🔒 Batasan Sistem

- [Sebutkan batasan sistem, misal: Hanya mendukung pengunggahan file maksimal 2MB]
- [Sebutkan batasan lain, misal: Aplikasi saat ini belum mendukung integrasi payment gateway]

---

## 🚀 Cara Menjalankan Project

Sebelum menjalankan project ini, pastikan beberapa software berikut sudah terinstall di laptop/komputer Anda:

- **PHP** (minimal versi yang disyaratkan Laravel)
- **Composer**
- **Git**
- **XAMPP / Laragon** (untuk menjalankan MySQL database)

Cek instalasi dengan perintah berikut di terminal:

php -v
composer -v
git -v

### 1️⃣ Clone Repository
git clone https://github.com/Noapllabib06/Tubes-WGTIK.git

### 2️⃣ Masuk Folder Project
cd Tubes-WGTIK

### 3️⃣ Install Dependencies
composer install

### 4️⃣ Copy File Environment
cp .env.example .env

### 5️⃣ Generate App Key
php artisan key:generate

### 6️⃣ Konfigurasi Database

Edit file **.env** menggunakan text editor, lalu sesuaikan konfigurasi database:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_wgtik
DB_USERNAME=root
DB_PASSWORD=

*(Pastikan Anda telah membuat database kosong bernama db_wgtik di phpMyAdmin sebelum lanjut ke langkah berikutnya)*

### 7️⃣ Jalankan Migration
php artisan migrate

### 8️⃣ Menjalankan Server
php artisan serve

Aplikasi akan berjalan di:

http://127.0.0.1:8000

---

## 📂 Struktur Project

Project ini menggunakan struktur standar **Laravel MVC**:

- **app/Models** → Model database
- **app/Http/Controllers** → Controller logic
- **resources/views** → Blade template (UI)
- **routes/web.php** → Routing web

---

## 👨‍💻 Tim Pengembang

- **Naufal Labib Asyidiq** - *[Peran Anda, misal: Backend Developer]* • [Noapllabib06](https://github.com/Noapllabib06)
- **Arkaan** - *[Peran Arkaan, misal: Frontend Developer]*
- **Wahyu** - *[Peran Wahyu, misal: UI/UX & Project Manager]*

**Dosen Pengampu:** Pak Dimas

#

<div align="center">
  
**Program Studi S1 Teknik Informatika** · **Telkom University Purwokerto**

<img src="https://img.shields.io/badge/Telkom_University_Purwokerto-8B0000?style=for-the-badge&logo=laravel&logoColor=white" />

</div>