<?php
session_start();
require_once '../config/connection.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 2) {
    header('Location: ../login.php');
    exit;
}

if (isset($_POST['id_transaksi']) && isset($_POST['metode']) && isset($_POST['sisa_pembayaran'])) {
    $id_transaksi = $_POST['id_transaksi'];
    $metode = $_POST['metode'];
    $sisa = $_POST['sisa_pembayaran'];

    // Fetch the current total value
    $sql = "SELECT total FROM transaksi WHERE id_transaksi = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_transaksi);
    $stmt->execute();
    $stmt->bind_result($currentTotal);
    $stmt->fetch();
    $stmt->close();

    // Calculate the new total
    $newTotal = $currentTotal + $sisa;

    // Update the transaction
    $sql = "UPDATE transaksi SET status_transaksi = 2, metode = ?, total = ?, deskripsi = 'Pembayaran Lunas' WHERE id_transaksi = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sii', $metode, $newTotal, $id_transaksi);

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
