<?php
require_once __DIR__ . '/../utils/theme.php';
require_once __DIR__ . '/../classes/Product.php';
$Product = new Product();

// Fungsi untuk menampilkan produk
function displayProducts($products) {
    if (empty($products)) {
        echo '<p class="text-gray-100 text-xl bg-zinc-800 p-3 rounded-lg">Tidak ada produk yang tersedia</p>';
        return;
    }

    foreach ($products as $product) {
        echo '<div id="product-card" class="'. getColorClass('bg-gray-300 text-slate-900', 'bg-zinc-800 text-gray-100') . ' w-80 md:w-96 p-6 border border-neutral-500 rounded-xl">';
        echo '<figure class="overflow-hidden rounded-xl border border-neutral-500"><img src="uploads/'. $product["image"] . '" class="w-[350px] h-[220px] m-auto object-cover hover:scale-110 transition"></figure>';
        echo '<div id="product-detail" class="text-center p-2 space-y-1">';
        echo '<h1 class="font-bold text-xl">' . $product["name"] . '</h1>';
        echo '<h3 class="font-medium">' .  $product["description"] . '</h3>';
        echo '<div class="flex justify-center gap-2 md:gap-4 pt-2">';
        echo '<p class="py-2 px-4 text-lg font-semibold">Rp' . number_format($product["price"], 0, ",", ".") . '</p>';
        echo '<a href="buy.php?id=' . $product["id"] . '" class="block h-max py-2 px-6 bg-blue-500 text-white rounded-2xl hover:bg-blue-600 transition">Beli</a>';
        echo '<a href="editProduct.php?id=' . $product["id"] . '"><i class="bx bxs-pencil text-3xl text-blue-500 hover:text-blue-600"></i></a>';
        echo '<form method="POST" action="include/productManagement.php">';
        echo '<input type="hidden" name="delete" value="' . $product["id"] . '">';
        echo '<button type="submit"><i class="bx bx-trash text-3xl text-red-600 hover:text-red-700"></i></button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}

// Fungsi untuk membersihkan input
function bersihkanInput($data) {
    $data = trim($data); // Menghapus spasi di awal dan akhir
    $data = stripslashes($data); // Menghapus backslashes (\)
    $data = htmlspecialchars($data); // Mengubah karakter khusus menjadi entitas HTML
    return $data;
}

// Jika ada request POST
if($_SERVER['REQUEST_METHOD' ] == 'POST') {
  // Jika ada input produk terbaru
    if(isset($_POST['addProduct'])) {
        $name = bersihkanInput($_POST["name"]);
        $description = bersihkanInput($_POST["description"]);
        $price = intval($_POST["price"]);
    
        // Cek apakah ada file yang diunggah
        if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
            die("Error: Gambar wajib diunggah!");
        }
    
        $image = $_FILES['image'];
        $imageName = hash('sha256', time() . $image['name']) . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
        $targetPath = '../uploads/' . $imageName;
    
        // Pindahkan file ke folder uploads
        if (move_uploaded_file($image['tmp_name'], $targetPath)) {
            $newProduct = [
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'image' => $imageName
            ];
    
            $Product->addProduct($newProduct);
            header("Location: ../index.php");
            exit();
        } else {
            die("Error: Gagal mengunggah gambar.");
        }

    }

   // Jika ada produk yang dihapus
   if(isset($_POST['delete'])) {
    // Ambil nama file gambar dari database
    $id = intval($_POST["delete"]);
    $Product->deleteImage($id);
    $Product->deleteProduct($id);
    header("Location: ../index.php");
    exit();
   }

   // Jika ada produk yang diupdate
   if(isset($_POST['editProduct'])) {
    $id = intval($_POST["id"]);
    $name = bersihkanInput($_POST["name"]);
    $description = bersihkanInput($_POST["description"]);
    $price = intval($_POST["price"]);

    // Ambil data produk lama
    $product = $Product->getProductById($id);
    $oldImage = $product["image"];

    // Cek apakah ada file gambar baru yang diunggah
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image'];
        $imageName = hash('sha256', time() . $image['name']) . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
        $targetPath = '../uploads/' . $imageName;

        // Pindahkan file ke folder uploads
        if (move_uploaded_file($image['tmp_name'], $targetPath)) {
            // Hapus gambar lama jika ada
            if (!empty($oldImage) && file_exists("../uploads/$oldImage")) {
                unlink("../uploads/$oldImage");
            }
        } else {
            die("Error: Gagal mengunggah gambar baru.");
        }
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $imageName = $oldImage;
    }

    $updatedProduct = [
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'image' => $imageName
    ];

    if ($Product->updateProduct($id, $updatedProduct)) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "<p class='text-red-500'>Gagal memperbarui produk.</p>";
    }
   }
}
?>