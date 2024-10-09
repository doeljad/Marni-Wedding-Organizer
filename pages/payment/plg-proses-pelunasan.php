<?php
require_once dirname(__FILE__) . '/midtrans/Midtrans.php';
require_once '../config/connection.php'; // Ganti dengan file konfigurasi database Anda

// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SB-Mid-server-nOxjhOn7sC3KNo_vtPYxIh2U';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

ini_set('display_errors', 0);
error_reporting(E_ERROR | E_PARSE);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_transaksi = $_POST['id_transaksi'];
    $sisa_pembayaran = $_POST['sisa_pembayaran'];

    // Validate parameters
    if (empty($id_transaksi) || empty($sisa_pembayaran)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required parameters.']);
        exit;
    }

    // Fetch transaction details from the database
    $sql = "SELECT * FROM transaksi WHERE id_transaksi = '$id_transaksi'";
    $result = $conn->query($sql);
    $transaction = $result->fetch_assoc();

    if ($transaction) {
        $unique_order_id = $transaction['id_transaksi'] . '-pelunasan-' . time();
        $params = array(
            'transaction_details' => array(
                'order_id' => $unique_order_id,
                'gross_amount' => $sisa_pembayaran,
            ),
            'customer_details' => array(
                'first_name' => $transaction['nama_pelanggan'],
                'email' => $transaction['email'],
            ),
        );

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Optionally, you can save the snap token to the database if needed

            echo json_encode(['status' => 'success', 'snapToken' => $snapToken]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Transaction not found.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
