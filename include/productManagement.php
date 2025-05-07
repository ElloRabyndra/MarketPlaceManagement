<?php
require_once __DIR__ . '/../utils/theme.php';
require_once __DIR__ . '/../classes/Product.php';
$Product = new Product();

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