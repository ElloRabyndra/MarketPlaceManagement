<?php 
session_start();
require_once __DIR__ . '/../classes/Auth.php';
$auth = new Auth();

function bersihkanInput($data) {
  $data = trim($data); // Menghapus spasi di awal dan akhir
  $data = stripslashes($data); // Menghapus backslashes (\)
  $data = htmlspecialchars($data); // Mengubah karakter khusus menjadi entitas HTML
  return $data;
}

// Registrasi user
if (isset($_POST['register'])) {
    $username = bersihkanInput($_POST['username']);
    $email = bersihkanInput($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    
    // Validasi input
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $_SESSION['auth_error'] = "Semua field harus diisi";
        header("Location: ../auth/register.php");
        exit();
    }
    
    if ($password !== $confirmPassword) {
        $_SESSION['auth_error'] = "Password tidak cocok";
        header("Location: ../auth/register.php");
        exit();
    }
    
    // Minimal panjang password
    if (strlen($password) < 6) {
        $_SESSION['auth_error'] = "Password minimal 6 karakter";
        header("Location: ../auth/register.php");
        exit();
    }
    
    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['auth_error'] = "Format email tidak valid";
        header("Location: ../auth/register.php");
        exit();
    }
    
    $result = $auth->register($username, $email, $password);
    
    if ($result['success']) {
        $_SESSION['auth_success'] = $result['message'];
        header("Location: ../auth/login.php");
        exit();
    } else {
        $_SESSION['auth_error'] = $result['message'];
        header("Location: ../auth/register.php");
        exit();
    }
}

// Login user
if (isset($_POST['login'])) {
    $username = bersihkanInput($_POST['username']);
    $password = $_POST['password'];
    
    // Validasi input
    if (empty($username) || empty($password)) {
        $_SESSION['auth_error'] = "Username dan password harus diisi";
        header("Location: ../auth/login.php");
        exit();
    }
    
    $result = $auth->login($username, $password);
    
    if ($result['success']) {
        $_SESSION['auth_success'] = $result['message'];
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['auth_error'] = $result['message'];
        header("Location: ../auth/login.php");
        exit();
    }
}

// Logout user
if (isset($_GET['logout'])) {
    $auth->logout();
    header("Location: ../auth/login.php");
    exit();
}

// Update username
if (isset($_POST['username']) && empty($_POST['new_password'])) {

    $userId = intval($_POST['user_id']);
    $newUsername = bersihkanInput($_POST['username']);
    $currentPassword = $_POST['current_password'];
    
    // Validasi input
    if (empty($newUsername) || empty($currentPassword)) {
        $_SESSION['profile_error'] = "Semua field harus diisi";
        header("Location: ../auth/user.php");
        exit();
    }
    
    $result = $auth->updateUsername($userId, $newUsername, $currentPassword);
    
    if ($result['success']) {
        $_SESSION['profile_success'] = $result['message'];
    } else {
        $_SESSION['profile_error'] = $result['message'];
    }
    
    header("Location: ../auth/user.php");
    exit();
}

// Update password
if (isset($_POST['new_password'])) {
    $userId = intval($_POST['user_id']);
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmNewPassword = $_POST['confirm_password'];
    
    // Validasi input
    if (empty($currentPassword) || empty($newPassword) || empty($confirmNewPassword)) {
        $_SESSION['profile_error'] = "Semua field harus diisi";
        header("Location: ../auth/user.php");
        exit();
    }
    
    // Validasi konfirmasi password
    if ($newPassword !== $confirmNewPassword) {
        $_SESSION['profile_error'] = "Konfirmasi password baru tidak cocok";
        header("Location: ../auth/user.php");
        exit();
    }
    
    // Validasi panjang password
    if (strlen($newPassword) < 6) {
        $_SESSION['profile_error'] = "Password minimal 6 karakter";
        header("Location: ../auth/user.php");
        exit();
    }
    
    $result = $auth->updatePassword($userId, $currentPassword, $newPassword);
    
    if ($result['success']) {
        $_SESSION['profile_success'] = $result['message'];
    } else {
        $_SESSION['profile_error'] = $result['message'];
    }
    
    header("Location: ../auth/user.php");
    exit();
}
?>