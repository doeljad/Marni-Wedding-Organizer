<?php
require_once dirname(__FILE__) . '/midtrans/Midtrans.php';
require_once '../config/connection.php'; // Ganti dengan file konfigurasi database Anda

// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SB-Mid-server-nOxjhOn7sC3KNo_vtPYxIh2U';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_transaksi = $conn->real_escape_string($_POST['id_transaksi']); // Sanitasi input

    // Fetch transaction details from the database
    $sql = "SELECT t.*, pel.nama, pel.email FROM transaksi t 
    JOIN pemesanan p ON t.id_pemesanan = p.id_pemesanan 
    JOIN pelanggan pel ON pel.id_pelanggan=p.id_pelanggan
    WHERE t.id_transaksi = '$id_transaksi'";

    if (!$result = $conn->query($sql)) {
        echo json_encode(['status' => 'error', 'message' => 'Database query failed: ' . $conn->error]);
        exit;
    }

    $transaction = $result->fetch_assoc();

    if ($transaction) {
        // Check if the transaction has a snap token already
        if (!empty($transaction['id_pembayaran_midtrans'])) {
            // If snap token exists, use it
            echo json_encode(['status' => 'success', 'snapToken' => $transaction['id_pembayaran_midtrans']]);
        } else {
            $params = array(
                'transaction_details' => array(
                    'order_id' => $transaction['id_pemesanan'],
                    'gross_amount' => $transaction['total'],
                ),
                'customer_details' => array(
                    'first_name' => $transaction['nama'],
                    'email' => $transaction['email'],
                ),
            );

            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);

                // Save snap token to the database
                $updateSql = "UPDATE transaksi SET id_pembayaran_midtrans = '$snapToken' WHERE id_transaksi = '$id_transaksi'";

                if (!$conn->query($updateSql)) {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update token: ' . $conn->error]);
                    exit;
                }

                echo json_encode(['status' => 'success', 'snapToken' => $snapToken]);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'Midtrans error: ' . $e->getMessage()]);
            }
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Transaction not found.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
