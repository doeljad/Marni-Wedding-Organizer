<?php
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

// Periksa apakah user adalah admin
if ($_SESSION['user']['role'] != 1) {
    exit;
}

include('config/connection.php');

// Ambil data pelanggan
$query_pelanggan = "SELECT * FROM pelanggan";
$result_pelanggan = $conn->query($query_pelanggan);

$pelanggan = [];
while ($row = $result_pelanggan->fetch_assoc()) {
    $pelanggan[] = $row;
}

// Ambil data paket layanan
$query_paket_layanan = "SELECT * FROM paket_layanan";
$result_paket = $conn->query($query_paket_layanan);

$paket_layanan = [];
while ($row = $result_paket->fetch_assoc()) {
    $paket_layanan[] = $row;
}

if (isset($_POST['submit'])) {
    $random_number = rand(1, 9999);
    $id_pemesanan = "PSN" . $random_number;
    $id_pelanggan = $_POST['id_pelanggan'];
    $tanggal_acara = $_POST['tgl_acara'];
    $id_paket_layanan = $_POST['paket_layanan'];

    // Menghapus "Rp " dan tanda titik dari harga lalu konversi ke integer
    $harga_str = $_POST['harga'];
    $harga_str = str_replace('Rp ', '', $harga_str);
    $harga_str = str_replace('.', '', $harga_str);
    $harga = intval($harga_str);

    $kontak_pemesan = $_POST['kontak_pemesan'];
    $alamat_acara = $_POST['alamat_acara'];
    $catatan_khusus = $_POST['catatan'];

    // Buat query INSERT untuk tabel pemesanan
    $sql = "INSERT INTO pemesanan (id_pemesanan, tanggal_pemesanan, id_pelanggan, tanggal_acara, id_paket_layanan, kontak_pemesan, alamat_acara, status_pesanan, catatan_khusus) 
            VALUES ('$id_pemesanan', CURRENT_DATE, '$id_pelanggan', '$tanggal_acara', '$id_paket_layanan', '$kontak_pemesan', '$alamat_acara', 0, '$catatan_khusus')";

    if ($conn->query($sql) === TRUE) {
        // Menyimpan data ke tabel transaksi setelah berhasil menyimpan pemesanan
        $id_transaksi = "TRX" . rand(1, 9999);
        $id_pembayaran_midtrans = "MID" . rand(1000, 9999); // Menghasilkan ID pembayaran Midtrans secara acak
        $deskripsi = "Pembayaran Lunas";
        $tanggal_transaksi = date('Y-m-d');
        $metode = "cash";
        $status_transaksi = 1;

        // Buat query INSERT untuk tabel transaksi
        $sql_transaksi = "INSERT INTO transaksi (id_transaksi, id_pemesanan, id_pembayaran_midtrans, deskripsi, tanggal_transaksi, total, metode, status_transaksi) 
                          VALUES ('$id_transaksi', '$id_pemesanan', '$id_pembayaran_midtrans', '$deskripsi', '$tanggal_transaksi', '$harga', '$metode', '$status_transaksi')";

        if ($conn->query($sql_transaksi) === TRUE) {
            echo "<script type='text/javascript'>Swal.fire('Berhasil!', 'Data berhasil disimpan.', 'success');</script>";
        } else {
            echo "<script type='text/javascript'>Swal.fire('Gagal!', 'Data tidak berhasil disimpan ke tabel transaksi. Silakan coba lagi.', 'error');</script>";
        }
    } else {
        echo "<script type='text/javascript'>Swal.fire('Gagal!', 'Data tidak berhasil disimpan ke tabel pemesanan. Silakan coba lagi.', 'error');</script>";
    }

    $conn->close();
}
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Tambah Pemesanan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="?page=pemesanan">Pemesanan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Pemesanan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="p-4 mb-4">
        <form method="post">
            <div class="body">
                <div class="row mb-3">
                    <label for="id_pelanggan" class="col-sm-2 col-form-label">Nama Pemesan</label>
                    <div class="col-sm-10">
                        <select class="js-example-basic-single form-control" name="id_pelanggan" required>
                            <option value="">Pilih Pelanggan</option>
                            <?php foreach ($pelanggan as $p) { ?>
                                <option value="<?= $p['id_pelanggan'] ?>"><?= $p['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tgl_acara" class="col-sm-2 col-form-label">Tanggal Acara</label>
                    <div class="col-sm-10">
                        <input type="date" name="tgl_acara" class="form-control" id="tgl_acara" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="paket_layanan" class="col-sm-2 col-form-label">Paket Layanan</label>
                    <div class="col-sm-10">
                        <select class="js-example-basic-single pilih-paket form-control" name="paket_layanan" required>
                            <option value="">Pilih Paket Layanan</option>
                            <?php foreach ($paket_layanan as $p) { ?>
                                <option value="<?= $p['id_paket_layanan'] ?>" data-harga="<?= $p['harga'] ?>">
                                    <?= $p['nama_paket'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-10">
                        <input type="text" name="harga" class="form-control" id="harga" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="kontak_pemesan" class="col-sm-2 col-form-label">Kontak Pemesan</label>
                    <div class="col-sm-10">
                        <input type="text" name="kontak_pemesan" class="form-control" id="kontak_pemesan" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="alamat_acara" class="col-sm-2 col-form-label">Alamat Acara</label>
                    <div class="col-sm-10">
                        <input type="text" name="alamat_acara" class="form-control" id="alamat_acara" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="catatan" class="col-sm-2 col-form-label">Catatan</label>
                    <div class="col-sm-10">
                        <textarea name="catatan" id="catatan" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-warning">Simpan</button>
                <button type="reset" class="btn float-end">Batal</button>
            </div>
        </form>
    </div>
</main>

<script>
    document.querySelector('.pilih-paket').addEventListener('change', function() {
        var harga = this.options[this.selectedIndex].getAttribute('data-harga');
        document.getElementById('harga').value = 'Rp ' + parseInt(harga).toLocaleString('id-ID');
    });
</script>