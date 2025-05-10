<?php
session_start();
require_once __DIR__ . '/../classes/Product.php';

// Memastikan request adalah AJAX
if (isset($_GET['query'])) {
    $query = trim($_GET['query']);
    $product = new Product();
    
    // Mencari produk berdasarkan nama
    $results = $product->searchProducts($query);
    
    // Ambil role dari session (default ke 'user' jika tidak ada)
    $role = $_SESSION['role'] ?? 'user';
    
    // Sisipkan role ke setiap produk
    foreach ($results as &$item) {
        $item['role'] = $role;
    }

    // Kirim sebagai JSON
    header('Content-Type: application/json');
    echo json_encode($results);
    exit();
}
?>
