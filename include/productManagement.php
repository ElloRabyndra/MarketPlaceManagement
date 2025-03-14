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
        echo '<figure class="overflow-hidden rounded-xl border border-neutral-500"><img src="'. $product["image"] . '" class="w-[350px] h-[220px] m-auto object-cover hover:scale-110 transition"></figure>';
        echo '<div id="product-detail" class="text-center p-2 space-y-1">';
        echo '<h1 class="font-bold text-xl">' . $product["name"] . '</h1>';
        echo '<h3 class="font-medium">' .  $product["description"] . '</h3>';
        echo '<div class="flex justify-center gap-4 pt-2">';
        echo '<p class="py-2 px-4 text-lg font-semibold">Rp' . number_format($product["price"], 0, ",", ".") . '</p>';
        echo '<a href="buy.php?id=' . $product["id"] . '" class="block h-max py-2 px-6 bg-blue-500 text-white rounded-2xl hover:bg-blue-600 transition">Beli</a>';
        echo '<a href="editProduct.php?id=' . $product["id"] . '"><i class="bx bx-pencil text-3xl text-blue-500 hover:text-blue-600"></i></a>';
        echo '<form method="POST" action="index.php">';
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
?>