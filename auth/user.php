<?php 
session_start();
include '../utils/theme.php'; 

// Cek apakah user sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jika belum login, redirect ke halaman login
    header("Location: auth/login.php");
    exit();
}

// Ambil data user saat ini
$userId = $_SESSION['user_id'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Righteous&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"/>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-[Poppins] <?= getColorClass('bg-gray-200 text-slate-900', 'bg-zinc-900 text-white') ?> flex flex-col md:items-start md:flex-row">
    <nav class="w-full md:w-72 border-r <?= getColorClass('border-gray-300 bg-white', 'border-zinc-700 bg-zinc-800') ?> shadow-xl h-auto md:h-screen md:sticky top-0 transition-all duration-300">
        <!-- User Profile Section -->
        <div class="flex flex-col items-center py-8 px-4 border-b <?= getColorClass('border-gray-300', 'border-zinc-700') ?>">
            <div class="bg-blue-500 w-20 h-20 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-4">
                <?= strtoupper(substr($username, 0, 1)) ?>
            </div>
            <h2 class="text-xl font-bold"><?= ucfirst($username) ?></h2>
            <p class="text-sm <?= getColorClass('text-gray-500', 'text-gray-400') ?> mt-1"><?= $email ?? 'user@example.com' ?></p>
        </div>
        
        <!-- Navigation Links -->
        <div class="py-6 px-4">
            <div class="mb-8">
                <h3 class="text-xs uppercase font-semibold mb-4 <?= getColorClass('text-gray-500', 'text-gray-400') ?>">Navigasi Utama</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="../index.php" class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 <?= getColorClass('hover:bg-gray-100', 'hover:bg-zinc-700') ?>">
                            <i class="bx bx-home text-2xl <?= getColorClass('text-blue-600', 'text-blue-500') ?>"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-3 p-3 rounded-lg transition-all duration-200 <?= getColorClass('bg-blue-50 text-blue-600', 'bg-blue-900/20 text-blue-500') ?>">
                            <i class="bx bx-user text-2xl"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Theme & Logout Options -->
            <div class="space-y-3">
                <h3 class="text-xs uppercase font-semibold mb-4 <?= getColorClass('text-gray-500', 'text-gray-400') ?>">Preferensi</h3>
                <a href="../utils/setTheme.php" class="flex items-center justify-between p-3 rounded-lg transition-all duration-200 <?= getColorClass('hover:bg-gray-100', 'hover:bg-zinc-700') ?>">
                    <div class="flex items-center gap-3">
                        <i class="<?= getThemeButtonIcon() ?> text-2xl <?= getColorClass('text-yellow-500', 'text-blue-500') ?>"></i>
                        <span><?= getThemeButtonText() ?></span>
                    </div>
                </a>
                <a href="../include/authController.php?logout=true" class="flex items-center gap-3 p-3 rounded-lg text-white bg-red-500 hover:bg-red-600 transition-all duration-200">
                    <i class="bx bx-log-out text-2xl"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Form Edit Profile -->
     <main class="flex-1 py-6 px-5 md:py-16 md:px-24 justify-center items-center <?= getColorClass('text-slate-900', 'text-white') ?>">
        <div class="p-8 rounded-2xl <?= getColorClass('bg-white', 'bg-zinc-800') ?> shadow-lg">
            <header>
                <h1 class="text-2xl font-bold mb-5">Edit Profile</h1>
            </header>

            <?php if(isset($_SESSION['profile_success'])): ?>
             <section class="flex items-center gap-2 bg-green-400 text-white px-4 py-2 rounded-lg mb-4">
                <i class="text-xl bx bx-check"></i>
                <div><?= $_SESSION['profile_success']; ?></div>
                <?php unset($_SESSION['profile_success']); ?>
            </section>
            <?php endif; ?>
            <?php if(isset($_SESSION['profile_error'])): ?>
             <section class="flex items-center gap-2 bg-red-400 text-white px-4 py-2 rounded-lg mb-4">
                <i class="text-xl bx bx-error"></i>
                <div><?= $_SESSION['profile_error']; ?></div>
                <?php unset($_SESSION['profile_error']); ?>
            </section>
            <?php endif; ?>
            <section>
                <form action="../include/authController.php" method="POST" class="space-y-4">
                    <input type="hidden" name="user_id" value="<?= $userId ?>"> 
                    <div class="w-full md:w-full flex flex-col gap-2">
                    <label for="username">Username</label>
                    <input id="username" required autocomplete="off" name="username" placeholder="Username" type="text" class="p-3 rounded-lg focus:ring-2 <?= getColorClass('bg-gray-100 focus:ring-blue-500 focus:bg-white', 'bg-zinc-700 focus:ring-blue-500') ?> outline-none" value="<?= $username ?>">
                    </div>
                    <div class="w-full md:w-full flex flex-col gap-2">
                    <label for="current_password">Password Saat Ini</label>
                    <input id="current_password" required autocomplete="off" name="current_password" placeholder="Password Saat Ini" type="password" class=" p-3 rounded-lg focus:ring-2 <?= getColorClass('bg-gray-100 focus:ring-blue-500 focus:bg-white', 'bg-zinc-700 focus:ring-blue-500') ?> outline-none">
                    </div>
                    <div class="w-full md:w-full flex flex-col gap-2">
                    <label for="new_password">Password Terbaru</label>
                    <input id="new_password" autocomplete="off" name="new_password" placeholder="Password Terbaru" type="password" class=" p-3 rounded-lg focus:ring-2 <?= getColorClass('bg-gray-100 focus:ring-blue-500 focus:bg-white', 'bg-zinc-700 focus:ring-blue-500') ?> outline-none">
                    </div>
                    <div class="w-full md:w-full flex flex-col gap-2">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <input id="confirm_password" autocomplete="off" name="confirm_password" placeholder="Password Terbaru" type="password" class=" p-3 rounded-lg focus:ring-2 <?= getColorClass('bg-gray-100 focus:ring-blue-500 focus:bg-white', 'bg-zinc-700 focus:ring-blue-500') ?> outline-none">
                    </div>
                    <div class="w-full md:w-full flex flex-col gap-2">
                        <button type="submit" class="w-full py-2 px-4 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition">Edit Profile</button>
                    </div>
                    </form>
            </section>
        </div>
     </main>
</body>
</html>