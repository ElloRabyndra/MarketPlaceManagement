<?php
session_start();
include 'config.php';

// Fungsi untuk mendapatkan semua produk dari database
function getAllProducts($conn) {
    $query = "SELECT * FROM products";

    // Filter jika ada query string
    if (isset($_GET["filter"])) {
        if ($_GET["filter"] == "murah") {
            $query .= " ORDER BY price ASC";
        } elseif ($_GET["filter"] == "mahal") {
            $query .= " ORDER BY price DESC";
        } else {
            $query .= " ORDER BY name ASC"; // Default: urut abjad
        }
    } else {
        $query .= " ORDER BY name ASC";
    }

    $result = mysqli_query($conn, $query);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $products;
}

// Fungsi untuk menampilkan produk
function displayProducts($products) {
    if (empty($products)) {
        echo '<p class="text-gray-100 text-xl bg-zinc-800 p-3 rounded-lg">Tidak ada produk yang tersedia</p>';
        return;
    }

    foreach ($products as $index => $product) {
        echo '<div id="product-card" class="bg-zinc-800 w-[380px] p-6 border border-neutral-500 rounded-xl text-gray-100">';
        echo '<figure class="overflow-hidden rounded-xl border border-neutral-500"><img src="uploads/'. $product["image"] . '" class="w-[350px] h-[220px] m-auto object-cover hover:scale-110 transition"></figure>';
        echo '<div id="product-detail" class="text-center p-2 space-y-1">';
        echo '<h1 class="font-bold text-xl">' . $product["name"] . '</h1>';
        echo '<h3 class="font-medium">' .  $product["description"] . '</h3>';
        echo '<div class="flex justify-center gap-4 pt-2">';
        echo '<p class="py-2 px-4 text-lg font-semibold">Rp' . number_format($product["price"], 0, ",", ".") . '</p>';
        echo '<a href="buy.php?id=' . $product["id"] . '" class="block h-max py-2 px-6 bg-blue-500 text-white rounded-2xl hover:bg-blue-600 transition">Beli</a>';
        echo '<a href="editProduct.php?id=' . $product["id"] . '"><i class="bx bx-pencil text-3xl text-blue-500 hover:text-blue-600"></i></a>';
        echo '<form method="POST" action="include/productManagement.php">';
        echo '<input type="hidden" name="delete" value="' . $product["id"] . '">';
        echo '<button type="submit"><i class="bx bx-trash text-3xl text-red-600 hover:text-red-700"></i></button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}

// Fungsi untuk menambahkan produk ke database
function addProduct($conn, $newProduct) {
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $newProduct['name'], $newProduct['description'], $newProduct['price'], $newProduct['image']);
    return $stmt->execute();
}

// Fungsi untuk menghapus produk dari database
function deleteProduct($conn, $product_id) {
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    return $stmt->execute();
}

// Fungsi untuk memperbarui produk di database
function updateProduct($conn, $id, $updatedProduct) {
    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
    $stmt->bind_param("ssisi", $updatedProduct['name'], $updatedProduct['description'], $updatedProduct['price'], $updatedProduct['image'], $id);
    return $stmt->execute();
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
    
            addProduct($conn, $newProduct);
            header("Location: ../index.php");
            exit();
        } else {
            die("Error: Gagal mengunggah gambar.");
        }

    }

   // Jika ada produk yang dihapus
   if(isset($_POST['delete'])) {
    $id = intval($_POST["delete"]);

    // Ambil nama file gambar dari database
    $query = "SELECT image FROM products WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);
        
    if ($product) {
            $imagePath = "../uploads/" . $product["image"]; // Path file gambar
        if (file_exists($imagePath)) {
            unlink($imagePath); // Hapus file gambar dari folder uploads
        }
    }

    deleteProduct($conn, $id);
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
    $query = "SELECT image FROM products WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);
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

    if (updateProduct($conn, $id, $updatedProduct)) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "<p class='text-red-500'>Gagal memperbarui produk.</p>";
    }
   }
}
?>