<?php
session_start();
include '../utils/theme.php'; 

// Redirect jika sudah login
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Marketplace</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Righteous&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"/>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col justify-center items-center font-[poppins] <?= getColorClass('bg-gray-100 text-slate-800', 'bg-zinc-900 text-gray-100') ?>">
  <main class="w-full max-w-lg mx-auto px-4">
    <div class="<?= getColorClass('bg-white', 'bg-zinc-800') ?> rounded-2xl shadow-xl overflow-hidden border <?= getColorClass('border-gray-200', 'border-zinc-700') ?>">
      
      <!-- Header dengan dekorasi -->
      <div class="relative bg-blue-600 py-8 px-6">
        <h1 class="text-3xl font-bold text-white text-center relative z-10">Create Account</h1>
      </div>
      
      <!-- Error message -->
      <?php if(isset($_SESSION['auth_error'])): ?>
      <div class="mx-6 mt-6 flex items-center gap-2 bg-red-100 text-red-600 px-4 py-3 rounded-lg border border-red-200">
        <i class="text-xl bx bx-error-circle"></i>
        <div class="text-sm font-medium"><?= $_SESSION['auth_error']; ?></div>
        <?php unset($_SESSION['auth_error']); ?>
      </div>
      <?php endif; ?>

      <!-- Form Register -->
      <form action="../include/authController.php" method="POST" class="p-6 space-y-5">
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium opacity-90 mb-1.5" for="username">Username</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 flex items-center pl-3 opacity-60">
                <i class="bx bx-user"></i>
              </span>
              <input 
                id="username" 
                required 
                autocomplete="off" 
                name="username" 
                placeholder="Enter your username" 
                type="text" 
                class="w-full pl-10 py-3 rounded-lg <?= getColorClass('bg-gray-50 border-gray-200', 'bg-zinc-700/50 border-zinc-600') ?> border focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
              >
            </div>
          </div>
          
          <div>
            <label class="block text-sm font-medium opacity-90 mb-1.5" for="email">Email</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 flex items-center pl-3 opacity-60">
                <i class="bx bx-envelope"></i>
              </span>
              <input 
                id="email" 
                required 
                autocomplete="off" 
                name="email" 
                placeholder="Masukkan alamat email" 
                type="email" 
                class="w-full pl-10 py-3 rounded-lg <?= getColorClass('bg-gray-50 border-gray-200', 'bg-zinc-700/50 border-zinc-600') ?> border focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
              >
            </div>
          </div>
          
          <div>
            <label class="block text-sm font-medium opacity-90 mb-1.5" for="password">Password</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 flex items-center pl-3 opacity-60">
                <i class="bx bx-lock-alt"></i>
              </span>
              <input 
                id="password" 
                required 
                name="password" 
                placeholder="Masukkan password" 
                type="password" 
                class="w-full pl-10 py-3 rounded-lg <?= getColorClass('bg-gray-50 border-gray-200', 'bg-zinc-700/50 border-zinc-600') ?> border focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
              >
            </div>
          </div>
          
          <div>
            <label class="block text-sm font-medium opacity-90 mb-1.5" for="confirm_password">Konfirmasi Password</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 flex items-center pl-3 opacity-60">
                <i class="bx bx-check-shield"></i>
              </span>
              <input 
                id="confirm_password" 
                required 
                name="confirm_password" 
                placeholder="Masukkan konfirmasi password" 
                type="password" 
                class="w-full pl-10 py-3 rounded-lg <?= getColorClass('bg-gray-50 border-gray-200', 'bg-zinc-700/50 border-zinc-600') ?> border focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
              >
            </div>
          </div>
        </div>
        
        <div class="pt-2">
          <button 
            type="submit" 
            name="register" 
            class="w-full py-3 px-4 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/50 transition-all shadow-lg hover:shadow-blue-500/25 flex items-center justify-center gap-2"
          >
            <span>Buat Akun</span>
            <i class="bx bx-right-arrow-alt text-xl"></i>
          </button>
        </div>
      </form>
      
      <div class="border-t <?= getColorClass('border-gray-200', 'border-zinc-700') ?> py-4 px-6 text-center">
        <p class="text-sm opacity-80">
          Sudah punya akun? 
          <a href="login.php" class="text-blue-500 font-medium hover:text-blue-600 hover:underline transition-colors">
            Login sekarang
          </a>
        </p>
      </div>
    </div>
  </main>
</body>
</html>