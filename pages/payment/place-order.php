<?php
session_start();
require_once dirname(__FILE__) . '/midtrans/Midtrans.php';
require_once '../config/connection.php'; // Ganti dengan file konfigurasi database Anda
require_once '../controller/generate_invoice.php';
require_once '../../assets/vendors/PHPMailer-master/send_invoice.php'; // Correct path

// Mengambil data JSON dari input
$jsonData = file_get_contents('php://input');
$dataCheckout = json_decode($jsonData, true);

// Memastikan data JSON berhasil diuraikan
if ($dataCheckout === null && json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menguraikan data JSON']);
    exit;
}

$idPaket = $dataCheckout['id_paket'] ?? '';
$namaPaket = $dataCheckout['nama_paket'] ?? '';
$harga = $dataCheckout['harga'] ?? 0;
$idUser = $_SESSION['user']['id_user'];
$namaPelanggan = $dataCheckout['nama_pelanggan'] ?? '';
$email = $dataCheckout['email'] ?? '';
$nomorTelepon = $dataCheckout['nomor_telepon'] ?? '';
$tanggalResepsi = $dataCheckout['tanggal_resepsi'] ?? '';
$alamatAcara = $dataCheckout['alamat'] ?? '';
$pembayaran = $dataCheckout['pembayaran'] ?? '';
$catatanKhusus = $dataCheckout['catatan'] ?? '';

// Jika pembayaran adalah uang muka, maka harga menjadi 30% dari harga asli
if ($pembayaran === '0') {
    $harga *= 0.3;
}

// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SB-Mid-server-nOxjhOn7sC3KNo_vtPYxIh2U';
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false;
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;

// Membuat ID unik untuk setiap pemesanan
$orderId = uniqid();
$tanggalPemesanan = date('Y-m-d H:i:s');
$statusPesanan = 0;

// Menentukan deskripsi dan status transaksi berdasarkan pembayaran
$deskripsi = ($pembayaran === '0') ? 'Pembayaran DP' : 'Pembayaran Lunas';
$statusTransaksi = 1;

try {
    // Membuka koneksi ke database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Memeriksa koneksi
    if ($conn->connect_error) {
        throw new Exception('Connection failed: ' . $conn->connect_error);
    }

    // Mengambil id_pelanggan dari tabel pelanggan berdasarkan id_user
    $stmtPelanggan = $conn->prepare("SELECT id_pelanggan FROM pelanggan WHERE id_user = ?");
    if (!$stmtPelanggan) {
        throw new Exception('Failed to prepare pelanggan statement');
    }
    $stmtPelanggan->bind_param("s", $idUser);
    $stmtPelanggan->execute();
    $resultPelanggan = $stmtPelanggan->get_result();

    // Memeriksa apakah id_pelanggan ditemukan
    if ($resultPelanggan->num_rows === 0) {
        throw new Exception('Customer ID not found for user: ' . $idUser);
    }

    $rowPelanggan = $resultPelanggan->fetch_assoc();
    $idPelanggan = $rowPelanggan['id_pelanggan'];

    // Menutup statement pelanggan
    $stmtPelanggan->close();

    // Memeriksa apakah alamat_acara kosong
    if (empty($alamatAcara)) {
        $conn->close();
        exit();
    }

    // Memeriksa apakah pesanan dengan ID yang sama sudah ada
    $stmtCheck = $conn->prepare("SELECT id_pemesanan FROM pemesanan WHERE id_pemesanan = ? AND tanggal_pemesanan = ? AND id_pelanggan = ?");
    $stmtCheck->bind_param("sss", $orderId, $tanggalPemesanan, $idPelanggan);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    // Jika pesanan sudah ada, maka tidak perlu melakukan insert
    if ($stmtCheck->num_rows > 0) {
        $stmtCheck->close();
        throw new Exception('Duplicate order ID found. Order already exists.');
    }
    $stmtCheck->close();

    // Menyiapkan statement SQL untuk memasukkan data pemesanan
    $stmt = $conn->prepare("INSERT INTO pemesanan (id_pemesanan, tanggal_pemesanan, id_pelanggan, tanggal_acara, id_paket_layanan, kontak_pemesan, alamat_acara, status_pesanan, catatan_khusus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception('Failed to prepare statement');
    }

    // Mengikat parameter ke dalam statement SQL
    $stmt->bind_param("sssssssss", $orderId, $tanggalPemesanan, $idPelanggan, $tanggalResepsi, $idPaket, $nomorTelepon, $alamatAcara, $statusPesanan, $catatanKhusus);

    // Menjalankan statement SQL untuk mengeksekusi pemesanan
    if (!$stmt->execute()) {
        throw new Exception('Failed to execute statement: ' . $stmt->error);
    }

    // Menyiapkan parameter untuk Midtrans Snap
    $params = [
        'transaction_details' => [
            'order_id' => $orderId,
            'gross_amount' => $harga,
        ],
        'item_details' => [
            [
                'id' => $idPaket,
                'price' => $harga,
                'quantity' => 1,
                'name' => $namaPaket
            ]
        ],
        'customer_details' => [
            'first_name' => $namaPelanggan,
            'email' => $email,
            'phone' => $nomorTelepon,
        ],
    ];

    // Mendapatkan Snap Token dari Midtrans
    $snapToken = \Midtrans\Snap::getSnapToken($params);
    if (!$snapToken) {
        throw new Exception('Failed to get Snap token from Midtrans');
    }

    // Menyiapkan statement SQL untuk memasukkan data transaksi
    $stmtTrans = $conn->prepare("INSERT INTO transaksi (id_pemesanan, id_pembayaran_midtrans, deskripsi, tanggal_transaksi, total, status_transaksi) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmtTrans) {
        throw new Exception('Failed to prepare statement');
    }

    // Mengikat parameter ke dalam statement SQL
    $stmtTrans->bind_param("ssssss", $orderId, $snapToken, $deskripsi, $tanggalPemesanan, $harga, $statusTransaksi);

    // Menjalankan statement SQL untuk mengeksekusi transaksi
    if (!$stmtTrans->execute()) {
        throw new Exception('Failed to execute statement: ' . $stmtTrans->error);
    }

    $invoicePdfPath = generateInvoicePDF($orderId);
    $message = "Kepada pelanggan yang terhormat,<br>
Terlampir adalah faktur Anda.<br>
Salam hangat,<br>
Marni WO";

    // Mengirim email dengan lampiran invoice
    if (sendInvoiceEmail($email, $invoicePdfPath, $message)) {
        // Mengembalikan Snap Token ke frontend sebagai respons sukses
        echo json_encode(['status' => 'success', 'snapToken' => $snapToken, 'message' => 'Invoice telah dikirim ke email pelanggan.']);
    } else {
        echo json_encode(['status' => 'success', 'snapToken' => $snapToken, 'message' => 'Gagal mengirim invoice.']);
    }

    // Menutup statement dan koneksi database
    $stmt->close();
    $stmtTrans->close();
    $conn->close();
} catch (Exception $e) {
    // Mengembalikan pesan error jika terjadi kesalahan
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
