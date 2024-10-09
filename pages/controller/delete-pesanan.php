<?php
require_once '../config/connection.php';
session_start();

// Pastikan user sudah login dan memiliki hak akses admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) {
    http_response_code(403);
    exit;
}

// Ambil data dari permintaan
$id_pemesanan = $_POST['id_pemesanan'];

// Validasi data
if (empty($id_pemesanan)) {
    http_response_code(400);
    echo "Invalid input.";
    exit;
}

// Query untuk menghapus pesanan
$sql = "DELETE FROM pemesanan WHERE id_pemesanan = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $id_pemesanan);

if ($stmt->execute()) {
    echo "Success";
} else {
    http_response_code(500);
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
