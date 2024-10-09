<?php
require('../../assets/vendors/fpdf/fpdf.php');
require_once '../config/connection.php';

if (isset($_POST['bulan']) && isset($_POST['tahun'])) {
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];

    // Query data pesanan berdasarkan bulan dan tahun
    $sql = "SELECT p.*, pl.nama_paket, pl.harga, pel.nama AS nama_pelanggan
            FROM pemesanan p 
            JOIN paket_layanan pl ON p.id_paket_layanan = pl.id_paket_layanan 
            JOIN pelanggan pel ON p.id_pelanggan = pel.id_pelanggan
            WHERE MONTH(p.tanggal_pemesanan) = ? AND YEAR(p.tanggal_pemesanan) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $bulan, $tahun);
    $stmt->execute();
    $result = $stmt->get_result();

    // Inisialisasi PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // Judul laporan
    $pdf->Cell(0, 10, 'Laporan Pesanan Bulanan', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Bulan: ' . $bulan . ' Tahun: ' . $tahun, 0, 1, 'C');
    $pdf->Ln(10);

    // Header tabel
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(50, 10, 'Nama Pelanggan', 1, 0, 'C'); // Menyesuaikan lebar dan header kolom
    $pdf->Cell(60, 10, 'Nama Paket', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Tanggal Pesanan', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Harga', 1, 1, 'C'); // 1 pada parameter terakhir berarti pindah ke baris baru

    // Data tabel
    $pdf->SetFont('Arial', '', 10);
    $totalPendapatan = 0;
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(50, 10, $row['nama_pelanggan'], 1, 0, 'L');
        $pdf->Cell(60, 10, $row['nama_paket'], 1, 0, 'L');
        $pdf->Cell(40, 10, date('d-m-Y', strtotime($row['tanggal_pemesanan'])), 1, 0, 'C');
        $pdf->Cell(40, 10, number_format($row['harga'], 2, ',', '.'), 1, 1, 'R');
        $totalPendapatan += $row['harga'];
    }

    // Menampilkan total pendapatan
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(150, 10, 'Total Pendapatan', 1, 0, 'R');
    $pdf->Cell(40, 10, number_format($totalPendapatan, 2, ',', '.'), 1, 1, 'R');
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

    // Output PDF
    $pdf->Output('D', 'Laporan_Bulanan_' . $bulan . '_' . $tahun . '.pdf');
}
