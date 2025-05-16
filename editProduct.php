<?php
session_start();
include 'include/productManagement.php';
require_once 'classes/Product.php';
$Product = new Product();

// Cek apakah user sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  // Jika belum login, redirect ke halaman login
  header("Location: auth/login.php");
  exit();
}

// Cek apakah user adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== "admin") {
  // Jika bukan admin, redirect ke halaman utama
  header("Location: index.php");
  exit();
}

// Ambil data produk berdasarkan ID 
$product = null;
if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $product = $Product->getProductById($id);
}

// Redirect jika produk tidak ditemukan
if (!$product) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Produk</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Righteous&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"/>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-[Poppins] min-h-screen <?= getColorClass('bg-gray-50 text-slate-900', 'bg-zinc-900 text-white') ?>">
  <div class="container mx-auto py-16 px-4 flex justify-center items-center">
    <div class="w-full max-w-2xl">
      <!-- Kartu Edit Produk -->
      <div class="<?= getColorClass('bg-white', 'bg-zinc-800') ?> rounded-2xl shadow-lg overflow-hidden">
        <!-- Header Kartu -->
        <div class="bg-blue-500 text-white p-5">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
              <i class="bx bx-edit-alt text-2xl"></i>
              <h2 class="text-xl font-bold">Edit Produk</h2>
            </div>
          </div>
        </div>
        
        <!-- Konten Kartu -->
        <div class="p-6">
          <!-- Form Edit Produk -->
          <form action="include/productManagement.php" enctype="multipart/form-data" method="POST" class="space-y-5 -mt-6">
            <input readonly name="id" type="number" class="hidden" value="<?= $id ?>">
            
            <div>
              <label for="name" class="block text-sm font-medium mb-1 <?= getColorClass('text-gray-600', 'text-gray-300') ?>">Nama Produk</label>
              <div class="relative">
                <i class="bx bx-package absolute left-4 top-4 <?= getColorClass('text-gray-500', 'text-gray-400') ?>"></i>
                <input required autocomplete="off" id="name" name="name" placeholder="Nama produk" type="text" 
                value="<?= htmlspecialchars($product["name"]) ?>"
                class="w-full pl-10 pr-4 py-3 rounded-lg focus:ring-2 <?= getColorClass('bg-gray-100 focus:ring-blue-500 focus:bg-white', 'bg-zinc-700 focus:ring-blue-500') ?> border-0 outline-none transition">
              </div>
            </div>
            
            <div>
              <label for="description" class="block text-sm font-medium mb-1 <?= getColorClass('text-gray-600', 'text-gray-300') ?>">Deskripsi</label>
              <div class="relative">
                <i class="bx bx-text absolute left-4 top-4 <?= getColorClass('text-gray-500', 'text-gray-400') ?>"></i>
                <textarea required autocomplete="off" id="description" name="description" placeholder="Deskripsi produk" rows="2" 
                class="w-full pl-10 pr-4 py-3 rounded-lg focus:ring-2 <?= getColorClass('bg-gray-100 focus:ring-blue-500 focus:bg-white', 'bg-zinc-700 focus:ring-blue-500') ?> border-0 outline-none transition"><?= htmlspecialchars($product["description"]) ?></textarea>
              </div>
            </div>
            
            <div>
              <label for="price" class="block text-sm font-medium mb-1 <?= getColorClass('text-gray-600', 'text-gray-300') ?>">Harga (Rp)</label>
              <div class="relative">
                <i class="bx bx-money absolute left-4 top-4 <?= getColorClass('text-gray-500', 'text-gray-400') ?>"></i>
                <input required autocomplete="off" id="price" name="price" placeholder="Harga produk" type="number" 
                value="<?= htmlspecialchars($product["price"]) ?>"
                class="w-full pl-10 pr-4 py-3 rounded-lg focus:ring-2 <?= getColorClass('bg-gray-100 focus:ring-blue-500 focus:bg-white', 'bg-zinc-700 focus:ring-blue-500') ?> border-0 outline-none transition">
              </div>
            </div>
            
            <div>
              <label class="block text-sm font-medium mb-1 <?= getColorClass('text-gray-600', 'text-gray-300') ?>">Gambar Produk</label>
              <div class="relative">
                <input name="image" id="upload" type="file" accept="image/*" class="hidden">
                <label for="upload" class="flex items-center justify-between w-full gap-2 px-4 py-3 rounded-lg cursor-pointer <?= getColorClass('bg-gray-100 hover:bg-gray-200', 'bg-zinc-700 hover:bg-zinc-600') ?> transition-colors">
                  <span class="flex items-center">
                    <i class="bx bx-image-add text-xl mr-2 <?= getColorClass('text-gray-500', 'text-gray-400') ?>"></i>
                    <span class="<?= getColorClass('text-gray-500', 'text-gray-400') ?>" id="file-name">Pilih gambar baru</span>
                  </span>
                  <i id="uploadIcon" class="bx bx-upload text-xl <?= getColorClass('text-gray-500', 'text-gray-400') ?>"></i>
                </label>
              </div>
            </div>
            
            <div class="pt-4 flex gap-4">
              <a href="index.php" class="w-1/2 py-3 <?= getColorClass('bg-gray-200 hover:bg-gray-300 text-gray-700', 'bg-zinc-700 hover:bg-zinc-600 text-white') ?> rounded-lg font-medium flex items-center justify-center gap-2 transition-colors shadow-md">
                <i class="bx bx-x"></i>
                <span>Batal</span>
              </a>
              <button type="submit" name="editProduct" class="w-1/2 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-medium flex items-center justify-center gap-2 transition-colors shadow-md">
                <i class="bx bx-save"></i>
                <span>Simpan</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>