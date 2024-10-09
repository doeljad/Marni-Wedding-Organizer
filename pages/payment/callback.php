<?php
require_once dirname(__FILE__) . '/midtrans/Midtrans.php';
require_once '../config/connection.php'; // Ganti dengan file konfigurasi database Anda
require_once '../controller/generate_success.php';
require_once '../../assets/vendors/PHPMailer-master/send_invoice.php'; // Correct path

// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SB-Mid-server-nOxjhOn7sC3KNo_vtPYxIh2U';
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false;
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;

// Mengambil data JSON dari input
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

// Memastikan data JSON berhasil diuraikan
if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menguraikan data JSON']);
    exit;
}

// Mengambil order_id dan metode pembayaran dari data Midtrans
$orderId = $data['order_id'] ?? '';
$paymentType = $data['payment_type'] ?? '';
$bankName = '';

// Memeriksa apakah payment type adalah bank_transfer dan mengambil nama bank
if ($paymentType === 'bank_transfer' && isset($data['va_numbers'][0]['bank'])) {
    $bankName = strtoupper($data['va_numbers'][0]['bank']);
    $paymentType .= " - VA $bankName";
}

// Memeriksa koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

try {
    // Menyiapkan statement SQL untuk memperbarui metode pembayaran dan status transaksi
    $stmt = $conn->prepare("UPDATE transaksi SET metode = ?, status_transaksi = ? WHERE id_pemesanan = ?");
    if (!$stmt) {
        throw new Exception('Failed to prepare statement');
    }

    // Status transaksi diubah menjadi 2 untuk menandakan Settlement
    $statusTransaksi = 2;

    // Mengikat parameter ke dalam statement SQL
    $stmt->bind_param("sis", $paymentType, $statusTransaksi, $orderId);

    // Menjalankan statement SQL untuk memperbarui data transaksi
    if (!$stmt->execute()) {
        throw new Exception('Failed to execute statement: ' . $stmt->error);
    }

    // Mengambil email dari tabel pelanggan berdasarkan id_pemesanan
    $emailStmt = $conn->prepare("
        SELECT pel.email
        FROM pemesanan p
        JOIN pelanggan pel ON p.id_pelanggan = pel.id_pelanggan
        WHERE p.id_pemesanan = ?
    ");
    if (!$emailStmt) {
        throw new Exception('Failed to prepare email statement');
    }

    // Mengikat parameter dan menjalankan statement untuk mengambil email
    $emailStmt->bind_param('s', $orderId);
    $emailStmt->execute();
    $emailResult = $emailStmt->get_result();
    if ($emailResult->num_rows === 0) {
        throw new Exception('Email not found for orderId: ' . $orderId);
    }

    $emailRow = $emailResult->fetch_assoc();
    $email = $emailRow['email'];

    // Menutup statement email
    $emailStmt->close();

    // Menghasilkan invoice PDF
    $invoicePdfPath = generateInvoicePDF($orderId);

    // Mengirim email dengan lampiran invoice
    $message = "Terimakasih telah melakukan pembayaran. Berikut faktur Anda terlampir.";
    sendInvoiceEmail($email, $invoicePdfPath, $message);

    // Menutup statement dan koneksi database
    $stmt->close();
    $conn->close();

    // Mengembalikan respons sukses
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    // Mengembalikan pesan error jika terjadi kesalahan
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
