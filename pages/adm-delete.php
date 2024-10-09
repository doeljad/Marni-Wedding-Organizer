<?php
ob_start(); // Mulai output buffering

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "marni_wo";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Mendapatkan nilai dari parameter URL
$page = isset($_GET['page']) ? $_GET['page'] : '';

// Memeriksa apakah request method adalah POST dan ada parameter id
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id']; // Tidak mengubah id karena berisi perpaduan huruf dan angka

    if (!empty($id)) {
        try {
            if ($page == 'delete-paket') {
                // Begin a transaction
                $conn->beginTransaction();

                // Get the list of file names from foto_paket table
                $sql = "SELECT foto FROM foto_paket WHERE id_paket_layanan = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_STR);
                $stmt->execute();
                $files = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

                // Delete data from paket_layanan table
                $sql = "DELETE FROM paket_layanan WHERE id_paket_layanan = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_STR);
                $stmt->execute();

                // Delete data from foto_paket table
                $sql = "DELETE FROM foto_paket WHERE id_paket_layanan = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_STR);
                $stmt->execute();

                // Commit the transaction
                $conn->commit();

                // Delete the files from the server
                $directory = 'assets/img/produk/';
                foreach ($files as $file) {
                    $filePath = $directory . $file;
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                $message = "Paket layanan dan foto terkait telah dihapus.";
                $redirectUrl = "?page=paket-layanan";
            } elseif ($page == 'delete-pemesanan') {
                // Hapus data dari tabel pemesanan
                $sql = "DELETE FROM pemesanan WHERE id_pemesanan = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_STR);
                $stmt->execute();

                $message = "Data pemesanan telah dihapus.";
                $redirectUrl = "?page=pemesanan";
            } elseif ($page == 'delete-pelanggan') {
                // Hapus data dari tabel pelanggan
                $sql = "DELETE FROM pelanggan WHERE id_pelanggan = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_STR);
                $stmt->execute();

                $message = "Data pelanggan telah dihapus.";
                $redirectUrl = "?page=pelanggan";
            } else {
                $message = "Aksi tidak valid.";
                $redirectUrl = "?page=$page";
            }
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
            $redirectUrl = "?page=$page";
        }

        // Redirect ke URL yang sesuai dengan pesan menggunakan SweetAlert
        echo "<script>
                Swal.fire({
                    title: 'Berhasil',
                    text: '$message',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '$redirectUrl';
                    }
                });
              </script>";
        exit;
    } else {
        $message = "ID tidak valid.";
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: '$message',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '?page=$page';
                    }
                });
              </script>";
        exit;
    }
}

$conn = null;
ob_end_flush(); // Kirim output buffer dan hentikan buffering
