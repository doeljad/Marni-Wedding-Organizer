<?php
require('../../assets/vendors/fpdf/fpdf.php');
require_once '../config/connection.php';

// Memastikan tidak ada keluaran sebelumnya
ob_start();

if (isset($_POST['tahun'])) {
    $tahun = $_POST['tahun'];

    // Query data pesanan berdasarkan tahun
    $sql = "SELECT p.*, pl.nama_paket, pl.harga, pel.nama AS nama_pelanggan, IFNULL(t.deskripsi, 'Tidak ada deskripsi') AS deskripsi
            FROM pemesanan p 
            JOIN paket_layanan pl ON p.id_paket_layanan = pl.id_paket_layanan
            JOIN pelanggan pel ON p.id_pelanggan = pel.id_pelanggan
            LEFT JOIN transaksi t ON p.id_pemesanan = t.id_pemesanan 
            WHERE YEAR(p.tanggal_pemesanan) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $tahun);
    $stmt->execute();
    $result = $stmt->get_result();

    // Inisialisasi PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Judul laporan
    $pdf->Cell(0, 10, 'Laporan Pesanan Tahunan', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Tahun: ' . $tahun, 0, 1, 'C');
    $pdf->Ln(10);

    // Header tabel
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(60, 10, 'Nama Pelanggan', 1); // Mengganti header dari ID Pesanan menjadi Nama Pelanggan
    $pdf->Cell(60, 10, 'Nama Paket', 1);
    $pdf->Cell(40, 10, 'Tanggal Pesanan', 1);
    $pdf->Cell(30, 10, 'Harga', 1);
    $pdf->Ln();

    // Data tabel
    $pdf->SetFont('Arial', '', 10);
    $totalPendapatan = 0;
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(60, 10, $row['nama_pelanggan'], 1); // Menampilkan Nama Pelanggan
        $pdf->Cell(60, 10, $row['nama_paket'], 1);
        $pdf->Cell(40, 10, date('d-m-Y', strtotime($row['tanggal_pemesanan'])), 1);
        $pdf->Cell(30, 10, number_format($row['harga'], 2, ',', '.'), 1);
        $pdf->Ln();
        $totalPendapatan += $row['harga'];
    }

    // Menampilkan total pendapatan
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(160, 10, 'Total Pendapatan', 1);
    $pdf->Cell(30, 10, number_format($totalPendapatan, 2, ',', '.'), 1);
    $pdf->Ln(10); // Jarak sebelum kalimat penanggung jawab

    // Penanggung jawab
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, 'Penanggung jawab:', 0, 1, 'L');

    // Spasi untuk tanda tangan
    $pdf->Ln(10); // Jarak sebelum nama penanggung jawab
    $pdf->SetFont('Arial', 'U', 12); // Font underline untuk penekanan
    $pdf->Cell(0, 10, 'Marni', 0, 1, 'L');

    $stmt->close();
    $conn->close();

    // Bersihkan buffer keluaran
    ob_end_clean();

    // Output PDF
    $pdf->Output('D', 'Laporan_Tahunan_' . $tahun . '.pdf');
}
