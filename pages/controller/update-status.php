<?php
require_once '../config/connection.php';
session_start();

// Pastikan user sudah login dan memiliki hak akses admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) {
    http_response_code(403);
    exit;
}

// Ambil data dari form
$id_pemesanan = $_POST['id_pemesanan'];
$status_pesanan = $_POST['status_pesanan'];

// Validasi data
if (empty($id_pemesanan) || !in_array($status_pesanan, [0, 1])) {
    http_response_code(400);
    echo "Invalid input.";
    exit;
}

// Query untuk memperbarui status pesanan
$sql = "UPDATE pemesanan SET status_pesanan = ? WHERE id_pemesanan = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('is', $status_pesanan, $id_pemesanan);

if ($stmt->execute()) {
    echo "Success";
} else {
    http_response_code(500);
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
