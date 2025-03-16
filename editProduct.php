<?php
include 'include/config.php';
include 'include/productManagement.php';


// Ambil data produk berdasarkan ID dari database
$product = null;
if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $query = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);
}

// Redirect jika produk tidak ditemukan
if (!$product) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $updatedProduct = [
      "name" => bersihkanInput($_POST["name"]),
      "description" => bersihkanInput($_POST["description"]),
      "price" => intval($_POST["price"]),
      "image" => bersihkanInput($_POST["image"])
  ];

  if (updateProduct($conn, $id, $updatedProduct)) {
      header("Location: index.php");
      exit();
  } else {
      echo "<p class='text-red-500'>Gagal memperbarui produk.</p>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Produk</title>
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"/>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen p-12 flex justify-center items-center gap-9 font-[Poppins] bg-zinc-900 text-gray-100">
  <main class="form-container bg-zinc-800 rounded-xl p-12 shadow-lg border border-neutral-500">
    <!-- Header Edit Produk -->
    <header class="flex gap-4 items-center">
        <a href="index.php" class="text-xl"><i class="bx bx-arrow-back"></i></a>
        <h1 class="text-center text-3xl font-bold">Edit Produk</h1>
    </header>

    <!-- Form Edit Produk -->
    <form method="POST" class="flex flex-col items-center m-4 space-y-4">
      <div>
        <input required autocomplete="off" name="name" placeholder="Nama" type="text" class="w-72 p-2 border-b border-slate-400 bg-transparent outline-none" value="<?= $product["name"] ?>">
      </div>
      <div>
        <input required autocomplete="off" name="description" placeholder="Deskripsi" type="text" class="w-72 p-2 border-b border-slate-400 bg-transparent outline-none" value="<?= $product["description"] ?>">
      </div>
      <div>
        <input required autocomplete="off" name="price" placeholder="Harga" type="int" class="w-72 p-2 border-b border-slate-400 bg-transparent outline-none" value="<?= $product["price"] ?>">
      </div>
      <div>
        <input required autocomplete="off" name="image" placeholder="Gambar" type="text" class="w-72 p-2 border-b border-slate-400 bg-transparent outline-none" value="<?= $product["image"] ?>">
      </div>
      <div>
        <button type="submit" class="w-72 py-2 px-4 bg-blue-500 text-white rounded-3xl hover:bg-blue-600 transition">Edit</button>
      </div>
    </form>
  </main>
</body>
</html>
