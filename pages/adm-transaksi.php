<?php
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

// Periksa apakah user adalah admin
if ($_SESSION['user']['role'] != 1) {
    // header('Location: plg-main.php');
    exit;
}

include('config/connection.php');

$sql = "SELECT t.*,p.*,pel.nama FROM transaksi t
JOIN pemesanan p ON  p.id_pemesanan = t.id_pemesanan
JOIN pelanggan pel ON pel.id_pelanggan=p.id_pelanggan";
$result = $conn->query($sql);

?>

<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Transaksi</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Transaksi
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header--> <!--begin::App Content-->
    <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="card mb-4">

                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 2px">No.</th>
                                <th>ID Transaksi</th>
                                <th>Nama Pemesan</th>
                                <th>Deskripsi</th>
                                <th>Tanggal Transaksi</th>
                                <th>Total</th>
                                <th>Metode Pembayaran</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0) : ?>
                                <?php
                                $i = 1; // Inisialisasi variabel hitung
                                while ($row = $result->fetch_assoc()) : ?>
                                    <tr class=" align-middle">
                                        <td><?= $i++; ?>.</td>
                                        <td><?= $row['id_transaksi']; ?></td>
                                        <td><?= $row['nama']; ?></td>
                                        <td class="col-deskripsi"><?= $row['deskripsi']  ?></td>
                                        <td><?= $row['tanggal_transaksi'] ?></td>
                                        <td><?= rupiah($row['total']); ?></td>
                                        <td><?= $row['metode'] ?></td>
                                        <td>
                                            <span class="badge <?= ($row['status_transaksi'] == 2) ? 'text-bg-success' : (($row['status_transaksi'] == 1) ? 'text-bg-warning' : 'text-bg-danger'); ?>">
                                                <?= ($row['status_transaksi'] == 2) ? 'Settlement' : (($row['status_transaksi'] == 1) ? 'Pending' : 'Cancel'); ?>
                                            </span>
                                        </td>
                                    </tr>

                                <?php endwhile ?>
                            <?php else : echo "0 results";
                            endif ?>
                        </tbody>
                    </table>
                </div> <!-- /.card-body -->
            </div>
        </div> <!--end::Container-->
    </div> <!--end::App Content-->
</main> <!--end::App Main--> <!--begin::Footer-->