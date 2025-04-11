<?php 
require_once "Database.php";

class Product {
  private $conn;

  public function __construct() {
      $database = new Database();
      $this->conn = $database->getConnection();
  }

  public function getAllProducts() {
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

    $result = mysqli_query($this->conn, $query);
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $products;
  }

  public function getProductById($product_id) { 
    $query = "SELECT * FROM products WHERE id = '$product_id'";
    $result = mysqli_query($this->conn, $query);
    $product = mysqli_fetch_assoc($result);
    return $product;
  }

  // Fungsi untuk menambahkan produk baru
  public function addProduct($newProduct) {
    $stmt = $this->conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $newProduct['name'], $newProduct['description'], $newProduct['price'], $newProduct['image']);
    return $stmt->execute();
  }

    // Fungsi untuk memperbarui produk di database
    public function updateProduct($id, $updatedProduct) {
      $stmt = $this->conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
      $stmt->bind_param("ssisi", $updatedProduct['name'], $updatedProduct['description'], $updatedProduct['price'], $updatedProduct['image'], $id);
      return $stmt->execute();
    }

  // Fungsi untuk menghapus produk dari database
  public function deleteProduct($product_id) {
    $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    return $stmt->execute();
  }

  // Fungsi untuk menghapus foto produk
  public function deleteImage($id) {
    $query = "SELECT image FROM products WHERE id = ?";
    $stmt = mysqli_prepare($this->conn, $query);
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
  }

}
?>