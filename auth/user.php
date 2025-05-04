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
<body class="font-[Poppins] <?= getColorClass('bg-gray-200 text-slate-900', 'bg-zinc-900 text-white') ?> flex flex-col md:items-center md:flex-row">
    <nav class="w-full md:w-64 border-r border-slate-400 font-bold shadow-md h-auto md:h-screen md:sticky top-0 p-5">
        <div class="flex flex-col justify-center font-bold text-center gap-2">
            <a href="../index.php" class="flex justify-center items-center gap-2 px-4 py-1 text-2xl text-center rounded-xl transition"> <i class="bx bx-arrow-back text-3xl"></i> Kembali</a>
            <h2 class="hidden md:block text-xl px-4 py-1"><?= ucfirst($username) ?></h2>
            <a href="../utils/setTheme.php" class="flex items-center justify-center gap-2 text-xl bg-blue-500 px-4 py-1 rounded-xl hover:bg-blue-600 transition"><i class="<?= getThemeButtonIcon() ?>"></i> <?= getThemeButtonText() ?></a>
            <a href="../include/authController.php?logout=true" class="text-xl bg-red-500 px-4 py-1 rounded-xl hover:bg-red-400 transition">Logout</a>
        </div>
    </nav>
    
    <!-- Form Edit Profile -->
     <main class="flex-1 py-1 px-5 md:py-10 md:px-24 justify-center items-center <?= getColorClass('text-slate-900', 'text-white') ?>">
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
                    <input id="username" required autocomplete="off" name="username" placeholder="Username" type="text" class="p-3 rounded-lg border border-slate-400 bg-transparent outline-none" value="<?= $username ?>">
                    </div>
                    <div class="w-full md:w-full flex flex-col gap-2">
                    <label for="current_password">Password Saat Ini</label>
                    <input id="current_password" required autocomplete="off" name="current_password" placeholder="Password Saat Ini" type="password" class=" p-3 rounded-lg border border-slate-400 bg-transparent outline-none">
                    </div>
                    <div class="w-full md:w-full flex flex-col gap-2">
                    <label for="new_password">Password Terbaru</label>
                    <input id="new_password" autocomplete="off" name="new_password" placeholder="Password Terbaru" type="password" class=" p-3 rounded-lg border border-slate-400 bg-transparent outline-none">
                    </div>
                    <div class="w-full md:w-full flex flex-col gap-2">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <input id="confirm_password" autocomplete="off" name="confirm_password" placeholder="Password Terbaru" type="password" class=" p-3 rounded-lg border border-slate-400 bg-transparent outline-none">
                    </div>
                    <div class="w-full md:w-full flex flex-col gap-2">
                        <button type="submit" class="w-full py-2 px-4 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition">Edit Profile</button>
                    </div>
                    </form>
            </section>
     </main>
     <script src="../js/script.js"></script>
</body>
</html>