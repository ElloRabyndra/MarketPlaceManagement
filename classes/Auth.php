<?php 
require_once __DIR__ . '/../classes/Database.php';

class Auth {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Fungsi untuk registrasi user baru
    public function register($username, $email, $password) {
        // Cek apakah username atau email sudah ada
        $checkQuery = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $this->conn->prepare($checkQuery);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($user['username'] === $username) {
                return ["success" => false, "message" => "Username sudah digunakan"];
            } else {
                return ["success" => false, "message" => "Email sudah terdaftar"];
            }
        }
        
        // Hash password sebelum menyimpan ke database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert user baru ke database
        $insertQuery = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($insertQuery);
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
        
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Registrasi berhasil!"];
        } else {
            return ["success" => false, "message" => "Terjadi kesalahan saat registrasi."];
        }
    }
    
    // Fungsi untuk login user
    public function login($username, $password) {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['logged_in'] = true;
                
                return ["success" => true, "message" => "Login berhasil!"];
            } else {
                return ["success" => false, "message" => "Password salah"];
            }
        } else {
            return ["success" => false, "message" => "Username tidak ditemukan"];
        }
    }
    
    // Fungsi untuk logout
    public function logout() {
        // Hapus semua variable session
        $_SESSION = array();
        
        // Hapus session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Destroy session
        session_destroy();
        
        return ["success" => true, "message" => "Logout berhasil"];
    }
    
    // Fungsi untuk mengecek status login
    public function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    // Fungsi untuk mendapatkan data user yang sedang login
    public function getCurrentUser() {
        if ($this->isLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username'],
                'email' => $_SESSION['email']
            ];
        }
        return null;
    }

    // Fungsi untuk update username
    public function updateUsername($userId, $newUsername, $currentPassword) {
        // Cek apakah password sesuai
        $query = "SELECT password FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows !== 1) {
            return ["success" => false, "message" => "User tidak ditemukan"];
        }
        
        $user = $result->fetch_assoc();
        if (!password_verify($currentPassword, $user['password'])) {
            return ["success" => false, "message" => "Password salah"];
        }
        
        // Cek apakah username sudah digunakan
        $checkQuery = "SELECT id FROM users WHERE username = ? AND id != ?";
        $stmt = $this->conn->prepare($checkQuery);
        $stmt->bind_param("si", $newUsername, $userId);
        $stmt->execute();
        $checkResult = $stmt->get_result();
        
        if ($checkResult->num_rows > 0) {
            return ["success" => false, "message" => "Username sudah digunakan"];
        }
        
        // Update username
        $updateQuery = "UPDATE users SET username = ? WHERE id = ?";
        $stmt = $this->conn->prepare($updateQuery);
        $stmt->bind_param("si", $newUsername, $userId);
        
        if ($stmt->execute()) {
            // Update session
            $_SESSION['username'] = $newUsername;
            return ["success" => true, "message" => "Username berhasil diubah"];
        } else {
            return ["success" => false, "message" => "Gagal mengubah username"];
        }
    }

    // Fungsi untuk update password
    public function updatePassword($userId, $currentPassword, $newPassword) {
        // Cek apakah password lama sesuai
        $query = "SELECT password FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows !== 1) {
            return ["success" => false, "message" => "User tidak ditemukan"];
        }
        
        $user = $result->fetch_assoc();
        if (!password_verify($currentPassword, $user['password'])) {
            return ["success" => false, "message" => "Password lama salah"];
        }
        
        // Hash password baru
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Update password
        $updateQuery = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $this->conn->prepare($updateQuery);
        $stmt->bind_param("si", $hashedPassword, $userId);
        
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Password berhasil diubah"];
        } else {
            return ["success" => false, "message" => "Gagal mengubah password"];
        }
    }
}
 ?>