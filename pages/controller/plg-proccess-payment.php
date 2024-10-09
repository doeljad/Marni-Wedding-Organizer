<?php
session_start();
require_once '../config/connection.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 2) {
    header('Location: ../login.php');
    exit;
}

if (isset($_POST['id_transaksi']) && isset($_POST['metode'])) {
    $id_transaksi = $_POST['id_transaksi'];
    $metode = $_POST['metode'];

    $sql = "UPDATE transaksi SET status_transaksi = 2, metode = ? WHERE id_transaksi = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $metode, $id_transaksi);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Parameter tidak lengkap.']);
}
