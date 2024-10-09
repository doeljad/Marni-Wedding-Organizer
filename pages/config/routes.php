<?php
// Ambil parameter dari URL
$params = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Definisikan route
$routes = [
    // Login 
    'login' => 'login.php',

    // Admin
    'dashboard' => 'pages/adm-dashboard.php',
    'pemesanan' => 'pages/adm-pemesanan.php',
    'tambah-pemesanan' => 'pages/adm-tambah-pemesanan.php',
    'delete-pemesanan' => 'pages/adm-delete.php',
    'paket-layanan' => 'pages/adm-paket-layanan.php',
    'tambah-paket' => 'pages/adm-tambah-paket.php',
    'edit-paket' => 'pages/adm-edit-paket.php',
    'delete-paket' => 'pages/adm-delete.php',
    'pelanggan' => 'pages/adm-pelanggan.php',
    'delete-pelanggan' => 'pages/adm-delete.php',
    'tambah-pelanggan' => 'pages/adm-tambah-pelanggan.php',
    'adm-transaksi' => 'pages/adm-transaksi.php',
    'laporan' => 'pages/adm-laporan.php',

    // Pelanggan
    'plg-content' => 'pages/plg-content.php',
    'plg-setting' => 'pages/plg-setting.php',
    'plg-transaksi' => 'pages/plg-transaksi.php',
    'plg-detail-paket' => 'pages/plg-detail-paket.php',

];

// Periksa apakah URL ada di route
if (isset($routes[$params])) {
    // Tentukan halaman yang akan dimuat
    $page = $routes[$params];
    // Include halaman yang sesuai
    include_once($page);
} else {
    // Jika URL tidak ada di route, redirect ke halaman 404 atau halaman lain yang sesuai
    echo "<script>window.location.href = '404.php'</script>";
    exit(); // Penting untuk menghentikan eksekusi skrip setelah melakukan redirect
}
