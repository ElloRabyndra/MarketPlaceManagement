<?php
// Ambil tema sekarang dari cookie
$current = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'dark';

// Toggle tema
$newTheme = $current === 'dark' ? 'light' : 'dark';

// Set cookie selama 1 tahun
setcookie('theme', $newTheme, time() + (365 * 24 * 60 * 60), '/');

// Redirect ke halaman sebelumnya (atau index.php)
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
