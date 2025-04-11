<?php
include 'include/productManagement.php';
require_once 'classes/Product.php';
$Product = new Product();

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
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"/>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen p-12 flex flex-wrap justify-center items-center gap-16 font-[Poppins] bg-zinc-900 text-gray-100">
  <main class="form-container bg-zinc-800 rounded-xl p-12 shadow-lg border border-neutral-500">
    <!-- Header Pembelian -->
    <header class="flex gap-4 items-center">
        <a href="index.php" class="text-xl"><i class="bx bx-arrow-back"></i></a>
        <h1 class="text-center text-3xl font-bold">Pembelian Produk</h1>
    </header>

    <!-- Form Pembelian -->
    <form method="POST" class="flex flex-col items-center m-4 space-y-4">
      <div>
        <input type="text" name="product_name" class="w-72 p-2 border-b border-slate-400 bg-transparent outline-none" value="<?= $product["name"] ?>" readonly>
      </div>
      <div>
        <input required autocomplete="off" name="name" placeholder="Nama" type="text" class="w-72 p-2 border-b border-slate-400 bg-transparent outline-none">
      </div>
      <div>
        <input required autocomplete="off" name="email" placeholder="Email" type="email" class="w-72 p-2 border-b border-slate-400 bg-transparent outline-none">
      </div>
      <div>
        <input required autocomplete="off" name="product_count" placeholder="Jumlah Produk" type="number" min="1" class="w-72 p-2 border-b border-slate-400 bg-transparent outline-none">
      </div>
      <div>
        <button type="submit" class="w-72 py-2 px-4 bg-blue-500 text-white rounded-3xl hover:bg-blue-600 transition">Pesan</button>
      </div>
    </form>
  </main>

    <!-- Invoice Pembelian -->
    <?php if($_SERVER["REQUEST_METHOD"] == "POST") : ?>
      <section class="submit-container shadow p-5 bg-zinc-800 text-gray-100 font-medium rounded-xl text-lg border border-neutral-500">
  <header class="text-2xl text-center font-bold border-b border-slate-400 mb-4">
    Invoice Pembelian
  </header>
  
  <table class="w-full border-collapse border border-slate-400 text-center">
    <thead>
      <tr>
        <th class="px-5 py-2 border border-slate-400">Pemesan</th>
        <th class="px-5 py-2 border border-slate-400">Produk</th>
        <th class="px-5 py-2 border border-slate-400">Jumlah</th>
        <th class="px-5 py-2 border border-slate-400">Harga</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="px-5 py-2 border border-slate-400"><?= bersihkanInput($_POST["name"]) ?></td>
        <td class="px-5 py-2 border border-slate-400"><?= bersihkanInput($_POST["product_name"]) ?></td>
        <td class="px-5 py-2 border border-slate-400"><?= bersihkanInput($_POST["product_count"]) ?></td>
        <td class="px-5 py-2 border border-slate-400">Rp. <?= $_POST["product_count"] * $product["price"] ?></td>
      </tr>
    </tbody>
  </table>

  <p class="mt-4 text-center text-green-500 font-semibold">Pemesanan Berhasil!</p>
</section>

    <?php endif ?>
</body>
</html>
