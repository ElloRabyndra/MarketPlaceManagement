<?php
session_start();
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
<body class="h-screen flex justify-center items-center font-[Poppins] bg-zinc-900 text-gray-100">
  <main class="form-container bg-zinc-800 rounded-xl p-12 shadow-lg border border-neutral-500">
    <!-- Header Register -->
    <header class="text-center">
      <h1 class="text-3xl font-bold mb-6">Register</h1>
      <?php if(isset($_SESSION['auth_error'])): ?>
        <div class="flex items-center gap-2 bg-red-400 text-white px-4 py-2 rounded-lg mb-4">
          <i class="text-xl bx bx-error"></i>
          <div><?= $_SESSION['auth_error']; ?></div>
          <?php unset($_SESSION['auth_error']); ?>
        </div>
        <?php endif; ?>
    </header>

    <!-- Form Register -->
     <section>
       <form action="../include/authController.php" method="POST" class="flex flex-col items-center space-y-4">
         <div class="w-64 sm:w-72 md:w-96 flex flex-col gap-2">
           <label class="text-sm" for="username">Username</label>
           <input id="username" required autocomplete="off" name="username" placeholder="Username" type="text" class="p-3 rounded-lg border border-slate-400 bg-transparent outline-none">
         </div>
         <div class="w-64 sm:w-72 md:w-96 flex flex-col gap-2">
           <label class="text-sm" for="email">Email</label>
           <input id="email" required autocomplete="off" name="email" placeholder="Email" type="email" class="p-3 rounded-lg border border-slate-400 bg-transparent outline-none">
         </div>
         <div class="w-64 sm:w-72 md:w-96 flex flex-col gap-2">
           <label class="text-sm" for="password">Password</label>
           <input id="password" required name="password" placeholder="Password" type="password" class="p-3 rounded-lg border border-slate-400 bg-transparent outline-none">
         </div>
         <div class="w-64 sm:w-72 md:w-96 flex flex-col gap-2"> 
           <label class="text-sm" for="confirm_password">Konfirmasi Password</label>
           <input id="confirm_password" required name="confirm_password" placeholder="Konfirmasi Password" type="password" class="p-3 rounded-lg border border-slate-400 bg-transparent outline-none">
         </div>
         <div class="w-64 sm:w-72 md:w-96">
           <button type="submit" name="register" class="w-full py-2 px-4 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition">Register</button>
         </div>
         <footer class="text-center mt-4">
           <p>Sudah punya akun? <a href="login.php" class="text-blue-500 hover:underline">Login</a></p>
         </footer>
       </form>
     </section>
  </main>
</body>
</html>