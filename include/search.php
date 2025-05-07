<?php
require_once __DIR__ . '/../classes/Product.php';

// Memastikan request adalah AJAX
if(isset($_GET['query'])) {
    $query = trim($_GET['query']);
    $product = new Product();
    
    // Mencari produk berdasarkan nama
    $results = $product->searchProducts($query);
    
    // Mengirim hasil sebagai JSON
    header('Content-Type: application/json');
    echo json_encode($results);
    exit();
}
?>