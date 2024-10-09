<?php
session_start();
require_once '../config/connection.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 2) {
    header('Location: ../login.php');
    exit;
}

if (isset($_POST['id_transaksi'])) {
    $id_transaksi = $_POST['id_transaksi'];

    $sql = "UPDATE transaksi SET status_transaksi = 0 WHERE id_transaksi = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_transaksi);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }

    $stmt->close();
    $conn->close();
}
