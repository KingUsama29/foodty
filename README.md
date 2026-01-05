# FoodTY – Web Donasi Pangan 🍚🥫

FoodTY adalah aplikasi web berbasis Laravel yang digunakan untuk
mengelola donasi pangan secara terstruktur dan transparan.
Aplikasi ini menghubungkan **Admin**, **Petugas**, dan **Penerima Bantuan**
dalam satu sistem terintegrasi.

---

## 🎯 Tujuan Aplikasi
- Mempermudah pengelolaan donasi pangan
- Menjamin penyaluran bantuan tepat sasaran
- Meningkatkan transparansi proses donasi

---

## 👥 Role Pengguna
- **Admin**
  - Mengelola data petugas & pengajuan
- **Petugas**
  - Verifikasi penerima
  - Mengelola penyaluran bantuan
- **Donor/User**
  - Melakukan donasi pangan
  - Melihat status donasi

---

## ✨ Fitur Utama
- Autentikasi (Login & Register)
- Multi Role User
- Manajemen Donasi Pangan
- Verifikasi & Penyaluran Bantuan
- Dashboard Admin & Petugas
- Validasi form user-friendly
- Status donasi (Pending / Approved / Disalurkan)

---

## 🛠️ Teknologi yang Digunakan
- **Laravel**
- **PHP**
- **MySQL**
- **Blade Template**
- **Bootstrap / Tailwind CSS**
- **JavaScript**

---

## 📊 Database
- Menggunakan MySQL
- ERD tersedia sebagai dokumentasi database

---

## ⚙️ Cara Instalasi
1. Clone repository
   ```bash
   git clone https://github.com/KingUsama29/foodty.git
2. cd foodty
3. composer install
4. cp .env.example .env
5. DB_DATABASE=foodty
   DB_USERNAME=root
   DB_PASSWORD=
6. php artisan key:generate
7. php artisan migrate --seed
8. php artisan storage:link
9. php artisan serve

