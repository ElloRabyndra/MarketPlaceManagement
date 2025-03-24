<?php
include 'include/productManagement.php';
$products = getAllProducts($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Market Place - Tes Fix</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Righteous&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"/>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-[Poppins] bg-zinc-900">
  <!-- Header Product -->
  <header>
    <h1 class="text-center font-bold text-4xl mt-6 text-gray-100">Daftar Produk</h1>
    <nav class="flex justify-center mt-4 gap-4">
      <a href="index.php" class="block min-w-28 text-center bg-gray-100 text-neutral-500 px-4 py-1 rounded-xl hover:bg-blue-500 hover:text-white transition">Default</a>
      <a href="index.php?filter=murah" class="block min-w-28 text-center bg-gray-100 text-neutral-500 px-4 py-1 rounded-xl hover:bg-blue-500 hover:text-white transition">Termurah</a>
      <a href="index.php?filter=mahal" class="block min-w-28 text-center bg-gray-100 text-neutral-500 px-4 py-1 rounded-xl hover:bg-blue-500 hover:text-white transition">Termahal</a>
    </nav>
  </header>
   <!-- Daftar Produk -->
  <main class="p-6 flex justify-center gap-10 flex-wrap">
    <?php displayProducts($products); ?>
  </main>
    <!-- Tombol Add Product -->
  <aside class="fixed bottom-0 right-0 p-8">
    <button id="addProductButton" class="py-2 px-4 text-2xl bg-blue-500 text-white rounded-3xl hover:bg-blue-600 transition">+</button>
  </aside>
  <!-- Popup Add Product -->
  <div id="popup" class="hidden fixed inset-0 justify-center items-center bg-zinc-800 bg-opacity-60 backdrop-blur-0">
     <article class="form-container w-96 h-max bg-zinc-800 rounded-xl  p-12 shadow-lg border border-neutral-500 text-gray-100">
      <div class="flex gap-4 items-center">
        <button id="closePopup" class="text-xl"><i class="bx bx-arrow-back"></i></button>
         <h1 class="text-center text-3xl font-bold">Tambah Produk</h1>
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
   <script src="js/script.js"></script>
</body>
</html>