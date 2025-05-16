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
  <title>Pembelian Produk</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Righteous&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"/>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-[Poppins] min-h-screen <?= getColorClass('bg-gray-50 text-slate-900', 'bg-zinc-900 text-white') ?>">
  <!-- Header Navigasi -->
  <header class="fixed top-4 right-4 z-10 px-4 py-2 rounded-xl text-md <?= getColorClass('bg-white', 'bg-zinc-800') ?>">
      <a href="index.php" class="flex items-center gap-1 <?= getColorClass('text-gray-600 hover:text-gray-900', 'text-gray-300 hover:text-white') ?> theadetion-colors">
        <i class="bx bx-arrow-back"></i>
        <span>Kembali</span>
      </a>
  </header>
  
  <div class="pt-20 pb-10 px-4">
    <div class="container mx-auto max-w-6xl">
      <div class="flex flex-col lg:flex-row gap-8 items-start">
        <!-- Kolom Kiri - Gambar Produk & Detail -->
        <div class="w-full lg:w-1/2  <?= getColorClass('bg-white', 'bg-zinc-800') ?> rounded-2xl shadow-lg overflow-hidden">
          <div class="aspect-video bg-gray-200 flex items-center justify-center">
            <?php if (isset($product["image"]) && !empty($product["image"])): ?>
              <img src="uploads/<?= $product["image"] ?>" alt="<?= $product["name"] ?>" class="w-full h-full object-cover">
            <?php else: ?>
              <i class="bx bx-image text-6xl <?= getColorClass('text-gray-400', 'text-gray-600') ?>"></i>
            <?php endif; ?>
          </div>
          
          <div class="px-6 py-3">
            <h1 class="text-2xl font-bold mb-2"><?= $product["name"] ?></h1>
            <div class="flex items-center gap-2 mb-4">
              <div class="flex text-yellow-400">
                <i class="bx bxs-star"></i>
                <i class="bx bxs-star"></i>
                <i class="bx bxs-star"></i>
                <i class="bx bxs-star"></i>
                <i class="bx bxs-star-half"></i>
              </div>
            </div>
            
            <p class="text-2xl font-bold mb-4">Rp. <?= number_format($product["price"], 0, ',', '.') ?></p>
            
            <div class="<?= getColorClass('bg-gray-100', 'bg-zinc-700') ?> p-3 rounded-lg mb-4">
              <h3 class="font-medium mb-2">Deskripsi Produk:</h3>
              <p class="<?= getColorClass('text-gray-600', 'text-gray-300') ?> text-sm">
                  <?= $product["description"] ?>
              </p>
            </div>
          </div>
        </div>
        
        <!-- Kolom Kanan - Form Pembelian -->
        <div class="w-full lg:w-1/2">
          <div class="<?= getColorClass('bg-white', 'bg-zinc-800') ?> rounded-2xl shadow-lg p-6 mb-6">
            <h2 class="text-xl font-bold mb-6 pb-2 border-b <?= getColorClass('border-gray-200', 'border-zinc-700') ?>">
              <i class="bx bx-cart-add mr-2 text-blue-500"></i>Form Pembelian
            </h2>
            
            <form method="POST" class="space-y-5">
              <input type="hidden" name="product_name" value="<?= $product["name"] ?>">
              
              <div>
                <label class="block text-sm font-medium mb-1 <?= getColorClass('text-gray-600', 'text-gray-300') ?>">Produk</label>
                <div class="flex items-center <?= getColorClass('bg-gray-100', 'bg-zinc-700') ?> px-4 py-3 rounded-lg">
                  <i class="bx bx-package text-xl mr-2 <?= getColorClass('text-gray-500', 'text-gray-400') ?>"></i>
                  <span class="font-medium"><?= $product["name"] ?></span>
                </div>
              </div>
              
              <div>
                <label for="name" class="block text-sm font-medium mb-1 <?= getColorClass('text-gray-600', 'text-gray-300') ?>">Nama Lengkap</label>
                <div class="relative">
                  <i class="bx bx-user absolute left-4 top-4 <?= getColorClass('text-gray-500', 'text-gray-400') ?>"></i>
                  <input required autocomplete="off" id="name" name="name" placeholder="Masukkan nama lengkap" type="text" 
                  class="w-full pl-10 pr-4 py-3 rounded-lg focus:ring-2 <?= getColorClass('bg-gray-100  focus:ring-blue-500 focus:bg-white', 'bg-zinc-700 focus:ring-blue-500') ?> border-0 outline-none transition">
                </div>
              </div>
              
              <div>
                <label for="email" class="block text-sm font-medium mb-1 <?= getColorClass('text-gray-600', 'text-gray-300') ?>">Email</label>
                <div class="relative">
                  <i class="bx bx-envelope absolute left-4 top-4 <?= getColorClass('text-gray-500', 'text-gray-400') ?>"></i>
                  <input required autocomplete="off" id="email" name="email" placeholder="Masukkan alamat email" type="email" 
                  class="w-full pl-10 pr-4 py-3 rounded-lg focus:ring-2 <?= getColorClass('bg-gray-100 focus:ring-blue-500 focus:bg-white', 'bg-zinc-700 focus:ring-blue-500') ?> border-0 outline-none transition">
                </div>
              </div>
              
              <div>
                <label for="product_count" class="block text-sm font-medium mb-1 <?= getColorClass('text-gray-600', 'text-gray-300') ?>">Jumlah</label>
                <div class="relative">
                  <i class="bx bx-hash absolute left-4 top-4 <?= getColorClass('text-gray-500', 'text-gray-400') ?>"></i>
                  <input required autocomplete="off" id="product_count" name="product_count" placeholder="Jumlah produk" type="number" min="1" value="1"
                  class="w-full pl-10 pr-4 py-3 rounded-lg focus:ring-2 <?= getColorClass('bg-gray-100 focus:ring-blue-500 focus:bg-white', 'bg-zinc-700 focus:ring-blue-500') ?> border-0 outline-none transition">
                </div>
              </div>
              
              <div class="pt-4">
                <button type="submit" class="w-full py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-medium flex items-center justify-center gap-2 transition-colors shadow-md">
                  <i class="bx bx-credit-card"></i>
                  <span>Pesan Sekarang</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      
      <!-- Invoice Pembelian -->
      <?php if($_SERVER["REQUEST_METHOD"] == "POST") : ?>
      <div class="mt-10 mb-2 max-w-3xl mx-auto">
        <div class="<?= getColorClass('bg-white', 'bg-zinc-800') ?> rounded-2xl shadow-lg overflow-hidden">
          <!-- Invoice Header -->
          <div class="bg-blue-500 text-white p-5">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-2">
                <i class="bx bx-receipt text-2xl"></i>
                <h2 class="text-xl font-bold">Invoice Pembelian</h2>
              </div>
            </div>
          </div>
          
          <!-- Invoice Content -->
          <div class="p-6">
            <!-- Informasi Pembeli -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <h3 class="text-sm font-medium mb-2 <?= getColorClass('text-gray-500', 'text-gray-400') ?>">Informasi Pembeli</h3>
                <p class="font-medium"><?= bersihkanInput($_POST["name"]) ?></p>
                <p class="<?= getColorClass('text-gray-600', 'text-gray-300') ?> text-sm"><?= bersihkanInput($_POST["email"]) ?></p>
              </div>
              <div>
                <h3 class="text-sm font-medium mb-2 <?= getColorClass('text-gray-500', 'text-gray-400') ?>">Status Pembayaran</h3>
                <div class="text-md inline-flex items-center px-5 py-2 rounded-full font-medium bg-green-100 text-green-800">
                  <i class="bx bx-check-circle mr-1"></i>
                  <span>Berhasil</span>
                </div>
              </div>
            </div>
            
            <!-- Detail Produk -->
            <table class="w-full border-collapse <?= getColorClass('bg-gray-50', 'bg-zinc-700') ?> rounded-lg overflow-hidden">
              <thead>
                <tr class="<?= getColorClass('bg-gray-100', 'bg-zinc-600') ?>">
                  <th class="px-4 py-3 text-left">Produk</th>
                  <th class="px-4 py-3 text-center">Jumlah</th>
                  <th class="px-4 py-3 text-center">Harga Satuan</th>
                  <th class="px-4 py-3 text-right">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="px-4 py-4 text-left">
                    <div class="font-medium"><?= bersihkanInput($_POST["product_name"]) ?></div>
                  </td>
                  <td class="px-4 py-4 text-center"><?= bersihkanInput($_POST["product_count"]) ?></td>
                  <td class="px-4 py-4 text-center">Rp. <?= number_format($product["price"], 0, ',', '.') ?></td>
                  <td class="px-4 py-4 text-right font-medium">Rp. <?= number_format($_POST["product_count"] * $product["price"], 0, ',', '.') ?></td>
                </tr>
              </tbody>
              <tfoot class="<?= getColorClass('bg-gray-100', 'bg-zinc-600') ?> font-medium">
                <tr>
                  <td colspan="3" class="px-4 py-3 text-right">Total</td>
                  <td class="px-4 py-3 text-right">Rp. <?= number_format($_POST["product_count"] * $product["price"], 0, ',', '.') ?></td>
                </tr>
              </tfoot>
            </table>
            
            <!-- Footer Invoice -->
            <div class="mt-6 text-center">
              <div class="mb-4 flex items-center justify-center gap-2 text-green-500">
                <i class="bx bx-check-circle text-2xl"></i>
                <span class="text-lg font-bold">Pemesanan Berhasil!</span>
              </div>
              
              <div class="flex justify-center gap-3">
                <a href="index.php" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg flex items-center gap-1 text-sm transition-colors">
                  <i class="bx bx-shopping-bag"></i>
                  <span>Belanja Lagi</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>