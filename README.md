# 📦 Sistem Manajemen Produk Marketplace 
**Dibuat oleh: M. Rabyndra Janitra Binello**  

Sistem Manajemen Produk Marketplace adalah sebuah aplikasi berbasis web untuk mengelola persediaan barang dalam toko online. Aplikasi ini mendukung fitur CRUD (Create, Read, Update, Delete) dan penyimpanan gambar produk dengan nama unik.

## 🚀 Fitur Utama
- **Lihat Daftar Produk**: Menampilkan daftar produk yang tersedia.
- **Tambah Produk**: Menambahkan produk dengan informasi lengkap.
- **Edit Produk**: Memperbarui informasi produk.
- **Hapus Produk**: Menghapus produk dari database.
- **Upload Gambar Produk**: Menyimpan gambar dengan nama unik di folder `uploads/`.

## 🛠️ Teknologi yang Digunakan
- **Frontend**: HTML, Tailwind CSS, Javascript
- **Backend**: PHP (Native)
- **Database**: MySQL

## ⚙️ Instalasi dan Konfigurasi
1. **Clone repository ini**
   ```sh
   git clone https://github.com/ElloRabyndra/MarketPlaceManagement.git
   cd repository
   ```
2. **Konfigurasi Database**
   - Buat database baru dengan nama `uts_pemweb`.
   - Import file `marketplace_pemweb.sql` ke MySQL.
3. **Edit Konfigurasi Database**
   - Ubah file `config.php` sesuai dengan kredensial database Anda:
   ```php
   $host = 'localhost';
   $user = 'root';
   $password = '';
   $database = 'uts_pemweb';
   ```
4. **Jalankan Server Lokal**
   - Gunakan XAMPP atau Laragon untuk menjalankan `Apache` dan `MySQL`.
   - Akses Website di `http://localhost/nama-folder/`.

