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
      <a href="index.php" class="block min-w-28 text-sm sm:text-base text-center border border-neutral-500 <?= getColorClass('bg-gray-300 text-slate-900', 'bg-zinc-800 text-white') ?>  px-4 py-1 rounded-xl hover:bg-blue-500 hover:text-white transition">Default</a>
      <a href="index.php?filter=murah" class="block min-w-28 text-sm sm:text-base text-center border border-neutral-500 <?= getColorClass('bg-gray-300 text-slate-900', 'bg-zinc-800 text-white') ?> px-4 py-1 rounded-xl hover:bg-blue-500 hover:text-white transition">Termurah</a>
      <a href="index.php?filter=mahal" class="block min-w-28 text-sm sm:text-base text-center border border-neutral-500 <?= getColorClass('bg-gray-300 text-slate-900', 'bg-zinc-800 text-white') ?> px-4 py-1 rounded-xl hover:bg-blue-500 hover:text-white transition">Termahal</a>
    </nav>
  </header>

  <!-- Search Bar -->
  <div class="flex justify-center mt-4 px-4">
  <div class="w-full max-w-md relative">
    <input type="text" id="search-input" placeholder="Cari produk..." class="w-full px-4 py-2 rounded-xl border border-neutral-500 <?= getColorClass('bg-gray-300 text-slate-900', 'bg-zinc-800 text-white') ?> focus:outline-none">
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
            <div id="product-card" class="<?= getColorClass('bg-gray-300 text-slate-900', 'bg-zinc-800 text-gray-100') ?> w-80 md:w-96 p-6 border border-neutral-500 rounded-xl">
                <figure class="overflow-hidden rounded-xl border border-neutral-500">
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
     <article class="form-container w-80 md:w-96 h-max rounded-xl  p-12 shadow-lg border border-neutral-500 <?= getColorClass('bg-gray-300 text-slate-900', 'bg-zinc-800 text-white') ?>">
      <div class="flex gap-4 items-center">
        <button id="closePopup" class="text-xl"><i class="bx bx-arrow-back"></i></button>
         <h1 class="text-center text-xl md:text-3xl font-bold">Tambah Produk</h1>
      </div>
       <form action="include/productManagement.php" enctype="multipart/form-data"  method="POST" class="flex flex-col items-center m-4 space-y-4 ">
         <div>
           <input required autocomplete="off" name="name" placeholder="Nama" type="text" class="w-72 p-2 border-b border-slate-400 outline-none bg-transparent">
         </div>
         <div>
           <input required autocomplete="off" name="description" placeholder="Deskripsi" type="text" class="w-72 p-2 border-b border-slate-400 outline-none bg-transparent">
         </div>
         <div>
           <input required autocomplete="off" name="price" placeholder="Harga Produk" type="number" min="1" class="w-72 p-2 border-b border-slate-400 outline-none bg-transparent appearance-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none [&::-moz-number-spin-box]:appearance-none">
         </div>
          <div>
            <input required name="image" id="upload" type="file" accept="image/*" class="hidden">
            <label for="upload" class="flex justify-between w-72 p-2 border-b border-slate-400 outline-none bg-transparent text-gray-400 cursor-pointer">
              <span>Upload Gambar</span>
               <i id="uploadIcon" class="bx bx-upload text-xl"></i>
            </label> 
          </div>
         <div>
           <button type="submit" name="addProduct" class="w-72 py-2 px-4 bg-blue-500 text-white rounded-3xl hover:bg-blue-600 transition">Tambah</button>
         </div>
         </form>
     </article>
   </div>
   <footer class="p-4 font-medium text-lg text-center <?= getColorClass('text-slate-900', 'text-white') ?>">&copy;ElloRabyndra</footer>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="js/script.js"></script>
</body>
</html>