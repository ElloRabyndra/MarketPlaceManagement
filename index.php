<?php
session_start();
include 'utils/theme.php'; 
include 'include/productManagement.php';
require_once 'classes/Product.php';
$Product = new Product();
$products = $Product->getAllProducts();

// Cek apakah user sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  // Jika belum login, redirect ke halaman login
  header("Location: auth/login.php");
  exit();
}

// Mengambil Username
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$profile = $isLoggedIn ? strtoupper(substr($_SESSION['username'], 0, 1)) : '?';
?>  


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Marketplace</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Righteous&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"/>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-[Poppins] <?= getColorClass('bg-gray-200 text-slate-900', 'bg-zinc-900 text-white') ?>">
  <!-- Header Product -->
  <header>
    <h1 class="text-center font-bold text-2xl md:text-4xl mt-6">Daftar Produk</h1>
    <nav class="flex justify-center mt-4 gap-4">
      <a href="index.php" class="block min-w-28 text-sm sm:text-base text-center <?= getColorClass('bg-gray-300 text-slate-900', 'bg-zinc-800 text-white') ?>  px-4 py-1 rounded-xl hover:bg-blue-500 hover:text-white transition">Default</a>
      <a href="index.php?filter=murah" class="block min-w-28 text-sm sm:text-base text-center <?= getColorClass('bg-gray-300 text-slate-900', 'bg-zinc-800 text-white') ?> px-4 py-1 rounded-xl hover:bg-blue-500 hover:text-white transition">Termurah</a>
      <a href="index.php?filter=mahal" class="block min-w-28 text-sm sm:text-base text-center <?= getColorClass('bg-gray-300 text-slate-900', 'bg-zinc-800 text-white') ?> px-4 py-1 rounded-xl hover:bg-blue-500 hover:text-white transition">Termahal</a>
    </nav>
  </header>

  <!-- Search Bar -->
  <div class="flex justify-center mt-4 px-4">
  <div class="w-full max-w-md relative">
    <input type="text" id="search-input" placeholder="Cari produk..." class="w-full px-4 py-2 rounded-xl focus:border border-neutral-500 <?= getColorClass('bg-gray-300 text-slate-900', 'bg-zinc-800 text-white') ?> focus:outline-none">
    <button id="clear-search" class="absolute right-3 top-2 text-gray-400 hover:text-gray-600" style="display: none;">
      <i class="bx bx-x text-xl"></i>
    </button>
  </div>

</div>
   <!-- Daftar Produk -->
  <main id="product-container" class="p-6 flex justify-center gap-10 flex-wrap">
  <?php if (empty($products)): ?>
        <p class="text-gray-100 text-xl bg-zinc-800 p-3 rounded-lg">Tidak ada produk yang tersedia</p>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div id="product-card" class="<?= getColorClass('bg-gray-300 text-slate-900', 'bg-zinc-800 text-gray-100') ?> w-80 md:w-96 p-6 rounded-xl">
                <figure class="overflow-hidden rounded-xl">
                    <img src="uploads/<?= $product["image"] ?>" class="w-[350px] h-[220px] m-auto object-cover hover:scale-110 transition">
                </figure>

                <!-- Sebagai Admin -->
                 <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <div id="product-detail-admin" class="text-center p-2 space-y-1">
                    <h1 class="font-bold text-xl"><?= $product["name"] ?></h1>
                    <h3 class="font-medium"><?= $product["description"] ?></h3>
                    <div class="flex justify-center gap-2 md:gap-4 pt-2">
                        <p class="py-2 px-4 text-lg font-semibold">Rp<?= number_format($product["price"], 0, ",", ".") ?></p>
                        <a href="editProduct.php?id=<?= $product["id"] ?>"><i class="bx bxs-pencil text-3xl text-blue-500 hover:text-blue-600"></i></a>
                        <form method="POST" action="include/productManagement.php">
                            <input type="hidden" name="delete" value="<?= $product["id"] ?>">
                            <button type="submit"><i class="bx bx-trash text-3xl text-red-600 hover:text-red-700"></i></button>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
                <!-- Sebagai User -->
                 <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>
                <div id="product-detail-user" class="text-center p-2 space-y-1">
                    <h1 class="font-bold text-xl"><?= $product["name"] ?></h1>
                    <h3 class="font-medium"><?= $product["description"] ?></h3>
                    <div class="flex justify-center gap-2 md:gap-4 pt-2">
                        <p class="py-2 px-4 text-lg font-semibold">Rp<?= number_format($product["price"], 0, ",", ".") ?></p>
                        <a href="buy.php?id=<?= $product["id"] ?>" class="block h-max py-2 px-8 bg-blue-500 text-white rounded-2xl hover:bg-blue-600 transition">Beli</a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
  </main>
  <!-- Tombol User Settings -->
  <aside class="fixed top-0 right-0 px-8 py-6">
    <a href="auth/user.php" class="px-4 py-2 text-xl bg-blue-500 text-white rounded-full hover:bg-blue-600 transition"><?= $profile ?></a>
  </aside>
  
  <?php if (isset($_SESSION['role']) && $_SESSION["role"] == "admin"): ?>
  <!-- Tombol Add Product -->
  <aside class="fixed bottom-0 right-0 p-8">
    <button id="addProductButton" class="py-2 px-4 text-2xl bg-blue-500 text-white rounded-3xl hover:bg-blue-600 transition">+</button>
  </aside>
  <?php endif; ?>

<!-- Popup Add Product -->
<div id="popup" class="hidden fixed inset-0 justify-center items-center bg-zinc-800 bg-opacity-60 backdrop-blur-0">
  <div class="container mx-auto py-16 px-4 flex justify-center items-center">
    <div class="w-full max-w-md">
      <!-- Kartu Tambah Produk -->
      <div class="<?= getColorClass('bg-white', 'bg-zinc-800') ?> rounded-2xl shadow-lg overflow-hidden">
        <!-- Header Kartu -->
        <div class="bg-blue-500 text-white p-5">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
              <i class="bx bx-plus-circle text-2xl"></i>
              <h2 class="text-xl font-bold">Tambah Produk</h2>
            </div>
            <button id="closePopup" class="text-xl">
              <i class="bx bx-x"></i>
            </button>
          </div>
        </div>
        
        <!-- Konten Kartu -->
        <div class="p-6">
          <!-- Form Tambah Produk -->
          <form action="include/productManagement.php" enctype="multipart/form-data" method="POST" class="space-y-5">
            <div>
              <label for="name" class="block text-sm font-medium mb-1 <?= getColorClass('text-gray-600', 'text-gray-300') ?>">Nama Produk</label>
              <div class="relative">
                <i class="bx bx-package absolute left-4 top-4 <?= getColorClass('text-gray-500', 'text-gray-400') ?>"></i>
                <input required autocomplete="off" id="name" name="name" placeholder="Nama produk" type="text" 
                class="w-full pl-10 pr-4 py-3 rounded-lg focus:ring-2 <?= getColorClass('bg-gray-100 focus:ring-blue-500 focus:bg-white', 'bg-zinc-700 focus:ring-blue-500') ?> border-0 outline-none transition">
              </div>
            </div>
            
            <div>
              <label for="description" class="block text-sm font-medium mb-1 <?= getColorClass('text-gray-600', 'text-gray-300') ?>">Deskripsi</label>
              <div class="relative">
                <i class="bx bx-text absolute left-4 top-4 <?= getColorClass('text-gray-500', 'text-gray-400') ?>"></i>
                <textarea required autocomplete="off" id="description" name="description" placeholder="Deskripsi produk" rows="2" 
                class="w-full pl-10 pr-4 py-3 rounded-lg focus:ring-2 <?= getColorClass('bg-gray-100 focus:ring-blue-500 focus:bg-white', 'bg-zinc-700 focus:ring-blue-500') ?> border-0 outline-none transition"></textarea>
              </div>
            </div>
            
            <div>
              <label for="price" class="block text-sm font-medium mb-1 <?= getColorClass('text-gray-600', 'text-gray-300') ?>">Harga (Rp)</label>
              <div class="relative">
                <i class="bx bx-money absolute left-4 top-4 <?= getColorClass('text-gray-500', 'text-gray-400') ?>"></i>
                <input required autocomplete="off" id="price" name="price" placeholder="Harga produk" type="number" min="1"
                class="w-full pl-10 pr-4 py-3 rounded-lg focus:ring-2 <?= getColorClass('bg-gray-100 focus:ring-blue-500 focus:bg-white', 'bg-zinc-700 focus:ring-blue-500') ?> border-0 outline-none transition appearance-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none [&::-moz-number-spin-box]:appearance-none">
              </div>
            </div>
            
            <div>
              <label class="block text-sm font-medium mb-1 <?= getColorClass('text-gray-600', 'text-gray-300') ?>">Gambar Produk</label>
              <div class="relative">
                <input required name="image" id="upload" type="file" accept="image/*" class="hidden">
                <label for="upload" class="flex items-center justify-between w-full gap-2 px-4 py-3 rounded-lg cursor-pointer <?= getColorClass('bg-gray-100 hover:bg-gray-200', 'bg-zinc-700 hover:bg-zinc-600') ?> transition-colors">
                  <span class="flex items-center">
                    <i class="bx bx-image-add text-xl mr-2 <?= getColorClass('text-gray-500', 'text-gray-400') ?>"></i>
                    <span class="<?= getColorClass('text-gray-500', 'text-gray-400') ?>" id="file-name">Upload Gambar</span>
                  </span>
                  <i id="uploadIcon" class="bx bx-upload text-xl <?= getColorClass('text-gray-500', 'text-gray-400') ?>"></i>
                </label>
              </div>
            </div>
            
            <div class="pt-4">
              <button type="submit" name="addProduct" class="w-full py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-medium flex items-center justify-center gap-2 transition-colors shadow-md">
                <i class="bx bx-plus"></i>
                <span>Tambah Produk</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
   <footer class="p-4 font-medium text-lg text-center <?= getColorClass('text-slate-900', 'text-white') ?>">&copy;ElloRabyndra</footer>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="js/script.js"></script>
</body>
</html>