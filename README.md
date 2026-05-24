# FruitPulse AI - Tugas WGTIK

FruitPulse AI adalah antarmuka dashboard cerdas berbasis web yang dirancang untuk melakukan klasifikasi dan deteksi objek (kualitas buah) secara real-time.
Aplikasi ini memanfaatkan model Machine Learning yang dilatih menggunakan Teachable Machine dan dijalankan langsung di browser menggunakan TensorFlow.js.
Sistem ini dirancang sebagai prototipe implementasi AI pada sistem Quality Control (QC) untuk memenuhi tugas mata kuliah WGTIK.

## 📚 Latar Belakang
Proses penyortiran dan pengecekan kualitas buah secara manual seringkali memakan waktu dan rentan terhadap human error.
FruitPulse AI hadir sebagai solusi automasi dengan menyediakan:

* Pemindaian objek secara real-time melalui kamera (webcam).
* Analisis gambar statis melalui fitur unggah foto.
* Visualisasi tingkat akurasi (confidence level) pada dashboard yang interaktif.

Dengan sistem ini, proses klasifikasi objek menjadi lebih cepat, terukur, dan modern.

## 🎯 Tujuan Sistem
Tujuan utama dari FruitPulse AI adalah:

* Mengimplementasikan model AI dari Teachable Machine ke dalam antarmuka web.
* Menyediakan platform scanning kualitas buah yang responsif.
* Membantu operator QC dalam melihat metrik akurasi (confidence) dari setiap objek yang dipindai.
* Menyediakan alternatif pemindaian (kamera langsung vs unggah gambar).

## 👥 Jenis Pengguna
Sistem ini dirancang untuk satu peran pengguna utama dalam skenario operasional.

### 1️⃣ Operator / Quality Control (QC)
Operator menggunakan dashboard ini di stasiun kerja penyortiran.
Fitur yang tersedia:
* Menyalakan dan mematikan sensor kamera (Start/Stop System).
* Melihat hasil klasifikasi secara real-time (Status & Akurasi).
* Mengunggah foto buah yang pencahayaannya kurang optimal untuk dianalisis ulang oleh AI.

## ⚙️ Fitur Utama

### 📹 Live Scan (Webcam Integration)
* Mengakses kamera perangkat untuk memindai objek secara terus-menerus.
* Menampilkan bounding box / UI pemindaian ala radar modern.

### 🖼️ Static Scan (Image Upload)
* Mode fallback jika kamera tidak dapat memindai dengan baik.
* Analisis machine learning pada gambar statis (mendukung format .jpg, .png).

### 📊 Real-time Dashboard Metrics
Sistem langsung memproses data dari TensorFlow.js untuk menampilkan:
* Animasi Progress Ring SVG.
* Teks prediksi dominan (pisahan antara Status dan Jenis buah).
* Rata-rata akurasi (Average Confidence).

## 💻 Arsitektur & Teknologi yang Digunakan

### Frontend UI
* HTML5 & Vanilla JavaScript
* Tailwind CSS (via CDN) untuk tata letak dan styling modern
* Google Material Symbols untuk ikon antarmuka

### AI & Machine Learning Integrations
* TensorFlow.js (Menjalankan model secara lokal di klien)
* Teachable Machine Image Library

## 🔒 Batasan Sistem
* Keamanan CORS (Cross-Origin Resource Sharing): Sistem harus dijalankan menggunakan Local Web Server (tidak bisa dibuka langsung dengan cara double-click file HTML).
* Model dibatasi pada label yang telah dilatih sebelumnya (misal: Fresh Apple, Rotten Banana, dll).
* Aplikasi membutuhkan izin akses kamera (Webcam Permission) dari browser pengguna.

## 🚀 Cara Menjalankan Project
Karena sistem ini berbasis Client-Side Architecture dan mengambil model lokal secara asinkron, ikuti langkah berikut untuk menjalankannya:

### 1️⃣ Persiapan Software
Pastikan kamu telah menginstal:
* Visual Studio Code (VS Code)
* Ekstensi Live Server (oleh Ritwick Dey) di dalam VS Code.
* Git (untuk melakukan clone repository).

### 2️⃣ Clone Repository
Buka terminal atau command prompt, lalu jalankan perintah berikut:
```bash
git clone https://github.com/Noapllabib06/Tubes-WGTIK.git
```
*(Tautan repositori: https://github.com/Noapllabib06/Tubes-WGTIK/tree/main)*

### 3️⃣ Masuk Folder Project
Buka folder hasil clone di VS Code:
```bash
cd Tubes-WGTIK
```

### 4️⃣ Siapkan File Model (Jika Belum Ada)
Pastikan kamu sudah memiliki model TensorFlow.js dari Teachable Machine. Jika belum ada di dalam repositori, ekstrak file tersebut (`model.json`, `metadata.json`, `weights.bin`) ke dalam folder bernama `my_model`.

### 5️⃣ Jalankan Local Server
* Buka file `index.html`.
* Klik kanan di area kode, lalu pilih "Open with Live Server".
* Browser akan otomatis terbuka di `http://127.0.0.1:5500/index.html`.

### 6️⃣ Testing
* Klik tombol "START SYSTEM" di sudut kanan atas.
* Izinkan akses kamera pada pop-up browser.
* Arahkan objek ke kamera atau gunakan tombol "UPLOAD FOTO".

## 📂 Struktur Project
```text
📁 Tubes-WGTIK/
 ├── 📄 index.html        (File utama antarmuka & logika JavaScript)
 ├── 📄 README.md         (Dokumentasi project)
 └── 📁 my_model/         (Direktori model AI dari Teachable Machine)
      ├── 📄 model.json
      ├── 📄 metadata.json
      └── 📄 weights.bin
```

## 👨‍💻 Pengembang
* **Naufal Labib Asyidiq** - Informatics
* **Ikfina Kamalia Rahmah - Informatics
* **Amelia Candradewi - Informatics
* **Nabila Zain - Informatics
* **Syifa Kirana Putri Surya - Informatics
* **Hafis Akbar Anugrah - Informatics

<br>
<div align="center">
  
**S1 Teknik Informatika** · **Fakultas Informatika** · **Telkom University**

<img src="https://img.shields.io/badge/Telkom University Purwokerto-8B0000?style=for-the-badge&logo=react&logoColor=white" />

</div>
