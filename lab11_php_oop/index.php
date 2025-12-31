<?php
// 1. Jalankan session pertama kali sebelum kode apa pun
session_start();

// 2. Load konfigurasi dan library
include "config.php";
include "class/database.php";
include "class/form.php";

// 3. Tangkap URL untuk Routing
$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/home/index';
$segments = explode('/', trim($path, '/'));

$mod = (isset($segments[0]) && $segments[0] != '') ? $segments[0] : 'home';
$page = (isset($segments[1]) && $segments[1] != '') ? $segments[1] : 'index';

// 4. PROTEKSI LOGIN
// Cek apakah ini halaman login (user/login)
$isLoginPage = ($mod == 'user' && $page == 'login');

// Jika belum login DAN bukan di halaman login, lempar balik ke login
if (!isset($_SESSION['login']) && !$isLoginPage) {
    header("Location: /lab11_php_oop/user/login");
    exit;
}

// 5. Tentukan file modul yang akan dimuat
$file = "module/{$mod}/{$page}.php";

// 6. LOAD TAMPILAN
// Jika sedang di halaman login, jangan tampilkan header & sidebar
if (!$isLoginPage) {
    include "template/header.php";
}

if (file_exists($file)) {
    include $file;
} else {
    echo '<div class="alert alert-danger">Halaman tidak ditemukan!</div>';
}

if (!$isLoginPage) {
    include "template/footer.php";
}
?>