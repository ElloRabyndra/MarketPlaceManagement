<?php
include 'include/config.php';
include 'include/productManagement.php';


// Ambil data produk berdasarkan ID 
$product = null;
if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);
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
    <form action="include/productManagement.php" enctype="multipart/form-data" method="POST" class="flex flex-col items-center m-4 space-y-4">
      <div>
        <input readonly name="id" type="number" class="w-72 p-2 border-b border-slate-400 bg-transparent outline-none hidden" value="<?= $id ?>">
      </div>
      <div>
        <input required autocomplete="off" name="name" placeholder="Nama" type="text" class="w-72 p-2 border-b border-slate-400 bg-transparent outline-none" value="<?= htmlspecialchars($product["name"]) ?>">
      </div>
      <div>
        <input required autocomplete="off" name="description" placeholder="Deskripsi" type="text" class="w-72 p-2 border-b border-slate-400 bg-transparent outline-none" value="<?= htmlspecialchars($product["description"]) ?>">
      </div>
      <div>
        <input required autocomplete="off" name="price" placeholder="Harga" type="number" class="w-72 p-2 border-b border-slate-400 bg-transparent outline-none" value="<?= htmlspecialchars($product["price"]) ?>">
      </div>
      <div>
            <input name="image" id="upload" type="file" accept="image/*" class="hidden">
            <label for="upload" class="flex justify-between w-72 p-2 border-b border-slate-400 outline-none bg-transparent text-gray-400 cursor-pointer">
              <span>Upload Gambar</span>
               <i id="uploadIcon" class="bx bx-upload text-xl"></i>
            </label> 
          </div>
      <div>
        <button type="submit" name="editProduct" class="w-72 py-2 px-4 bg-blue-500 text-white rounded-3xl hover:bg-blue-600 transition">Edit</button>
      </div>
    </form>
  </main>
  <script src="js/script.js"></script>
</body>
</html>
