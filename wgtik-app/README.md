# Tubes WGTIK

Berikut adalah panduan langkah demi langkah untuk menjalankan proyek Tubes WGTIK di komputer lokal.

## Prasyarat
Pastikan Anda sudah menginstal perangkat lunak berikut sebelum memulai:
- PHP
- Composer
- Git
- XAMPP / Laragon (untuk MySQL)

## Cara Menjalankan Proyek

1. Clone Repository
Buka terminal dan jalankan perintah berikut untuk mengkloning repositori ke komputer Anda:
git clone https://github.com/Noapllabib06/Tubes-WGTIK.git

2. Masuk ke Folder Proyek
Arahkan terminal ke direktori proyek yang baru saja diunduh:
cd Tubes-WGTIK

3. Install Dependencies
Unduh dan instal semua package yang dibutuhkan oleh Laravel:
composer install

4. Setup Environment Variable
Buat file konfigurasi .env dengan menyalin dari file example:
cp .env.example .env
*(Catatan: Jika menggunakan CMD Windows dan error, silakan copy-paste file secara manual di File Explorer lalu rename menjadi .env)*

5. Generate Application Key
Hasilkan key keamanan untuk aplikasi Laravel:
php artisan key:generate

6. Konfigurasi Database
- Buka XAMPP/Laragon dan pastikan MySQL sudah berjalan.
- Buat database baru yang kosong (misalnya bernama db_wgtik).
- Buka file .env di text editor, lalu ubah baris berikut sesuai dengan database Anda:
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=db_wgtik
  DB_USERNAME=root
  DB_PASSWORD=

7. Migrasi Database
Jalankan perintah ini untuk membuat struktur tabel di dalam database Anda:
php artisan migrate

8. Jalankan Server
Langkah terakhir, jalankan aplikasi menggunakan server bawaan Laravel:
php artisan serve

Aplikasi sekarang sudah berjalan dan dapat diakses melalui browser di alamat: http://127.0.0.1:8000