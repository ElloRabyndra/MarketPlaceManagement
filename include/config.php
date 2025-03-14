<?php
// config.php
// Konfigurasi koneksi database
$host     = 'localhost';
$user     = 'root';       
$password = '';           
$database = 'marketplace_pemweb'; 

// Membuat koneksi
$conn = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
