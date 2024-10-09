<?php
require('../../assets/vendors/fpdf/fpdf.php');

// Pastikan koneksi database sudah tersedia secara global atau ditambahkan di sini
require_once '../config/connection.php';

function generateInvoicePDF($orderId)
{
    global $conn; // Menggunakan koneksi database global

    // Query untuk mengambil data pesanan
    $sql = "SELECT p.*, pl.* 
            FROM pemesanan p 
            JOIN paket_layanan pl ON p.id_paket_layanan = pl.id_paket_layanan 
            WHERE p.id_pemesanan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $orderId); // Gunakan 's' jika orderId adalah string
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if (!$result) {
        error_log("No data found for orderId: $orderId");
        return null;
    }

    // Inisialisasi PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);

    // Header
    $pdf->Cell(0, 10, 'INVOICE', 0, 1, 'C');
    $pdf->Ln(10);

    // Informasi Perusahaan
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Marni Wedding Organizer', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, 'Bakalan RT/RW 02/01 Bakalan Polokarto Sukoharjo Jawa Tengah Indonesia', 0, 1, 'C');
    $pdf->Cell(0, 10, 'No HP: +628562516379', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Email: marniweddingorganizer@gmail.com', 0, 1, 'C');
    $pdf->Ln(10);

    // Detail Invoice
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'ID Pemesanan:', 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, $result['id_pemesanan'], 0, 1);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Nama Paket:', 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, $result['nama_paket'], 0, 1);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Tgl Pemesanan:', 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, date('d-m-Y', strtotime($result['tanggal_pemesanan'])), 0, 1);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'Harga:', 0, 0);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, number_format($result['harga'], 0, ',', '.'), 0, 1);
    $pdf->Ln(10);

    // Catatan
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 10, 'Catatan: Terima kasih atas pemesanan Anda!', 0, 1, 'C');

    // Footer
    $pdf->Ln(20);
    $pdf->SetY(-15);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(0, 10, 'Halaman ' . $pdf->PageNo(), 0, 0, 'C');

    // Direktori dan jalur file PDF
    $invoiceDir = '../invoices/';
    if (!file_exists($invoiceDir)) {
        mkdir($invoiceDir, 0755, true); // Buat direktori jika belum ada
    }
    $invoicePath = $invoiceDir . 'invoice_' . $orderId . '.pdf';

    // Simpan PDF
    $pdf->Output('F', $invoicePath);

    return $invoicePath;
}
