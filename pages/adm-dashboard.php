<?php
include('config/connection.php');
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

// Periksa apakah user adalah admin
if ($_SESSION['user']['role'] != 1) {
    // header('Location: plg-main.php');
    exit;
}
$sql_paket = "SELECT pl.*, fp.foto 
              FROM paket_layanan pl
              LEFT JOIN (SELECT id_paket_layanan, foto, ROW_NUMBER() 
              OVER (PARTITION BY id_paket_layanan ORDER BY id_paket_layanan) as rn
              FROM foto_paket) fp ON pl.id_paket_layanan = fp.id_paket_layanan AND fp.rn = 1;";
$result_paket = $conn->query($sql_paket);
include('config/connection.php');
$sql_pesanan = "SELECT p.*,pl.*,pel.nama FROM pemesanan p
JOIN paket_layanan pl ON pl.id_paket_layanan=p.id_paket_layanan
JOIN pelanggan pel ON pel.id_pelanggan=p.id_pelanggan";
$result_pesanan = $conn->query($sql_pesanan);

$sql_total = "SELECT
(SELECT COUNT(*) FROM paket_layanan) AS total_paket_layanan,
(SELECT COUNT(*) FROM pelanggan) AS total_pelanggan,
(SELECT COUNT(*) FROM pemesanan) AS total_pemesanan,
(SELECT COUNT(*) FROM transaksi) AS total_transaksi;";
$total = $conn->query($sql_total);

$sql_laporan = " SELECT p.*, t.status_transaksi, t.total FROM pemesanan p
    JOIN paket_layanan pl ON p.id_paket_layanan = pl.id_paket_layanan
    JOIN transaksi t ON p.id_pemesanan = t.id_pemesanan
    WHERE DATE_FORMAT(p.tanggal_pemesanan, '%Y-%m') = DATE_FORMAT(CURRENT_DATE, '%Y-%m')";
$result_laporan = $conn->query($sql_laporan);
?>
<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Dashboard
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div>
    <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <?php if ($total->num_rows > 0) :
                $t = $total->fetch_assoc(); ?>
                <div class="row"> <!--begin::Col-->
                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                        <div class="small-box text-bg-primary">
                            <div class="inner">
                                <h3><?= $t['total_pemesanan']; ?></h3>
                                <p>Pesanan Terbaru</p>
                            </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"></path>
                            </svg> <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                More info <i class="bi bi-link-45deg"></i> </a>
                        </div> <!--end::Small Box Widget 1-->
                    </div> <!--end::Col-->
                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 2-->
                        <div class="small-box text-bg-success">
                            <div class="inner">
                                <h3><?= $t['total_paket_layanan']; ?><sup class="fs-5"></h3>
                                <p>Total Paket Layanan</p>
                            </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"></path>
                            </svg> <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                More info <i class="bi bi-link-45deg"></i> </a>
                        </div> <!--end::Small Box Widget 2-->
                    </div> <!--end::Col-->
                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 4-->
                        <div class="small-box text-bg-danger">
                            <div class="inner">
                                <h3><?= $t['total_transaksi']; ?></h3>
                                <p>Total Transaksi</p>
                            </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"></path>
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"></path>
                            </svg> <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                More info <i class="bi bi-link-45deg"></i> </a>
                        </div> <!--end::Small Box Widget 4-->
                    </div> <!--end::Col-->
                    <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 3-->
                        <div class="small-box text-bg-warning">
                            <div class="inner">
                                <h3><?= $t['total_pelanggan']; ?></h3>
                                <p>Total Pelanggan</p>
                            </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"></path>
                            </svg> <a href="#" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                                More info <i class="bi bi-link-45deg"></i> </a>
                        </div> <!--end::Small Box Widget 3-->
                    </div> <!--end::Col-->

                </div> <!--end::Row--> <!--begin::Row-->
            <?php endif ?>
            <div class="row"> <!-- Start col -->
                <div class="col-lg-7 connectedSortable">
                    <div class="card mb-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-header">
                                    <h5 class="card-title">Laporan Rekap Bulanan</h5>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                        </button>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-tool dropdown-toggle" data-bs-toggle="dropdown">
                                                <i class="bi bi-wrench"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" role="menu">
                                                <a href="#" class="dropdown-item">Action</a>
                                                <a href="#" class="dropdown-item">Another action</a>
                                                <a href="#" class="dropdown-item">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a href="#" class="dropdown-item">Separated link</a>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                </div> <!-- /.card-header -->
                                <div class="card-body"> <!--begin::Row-->
                                    <div class="row">
                                        <div class="col-md-12   ">
                                            <p class="text-center"> <strong>Sales: 1 <?= date('M, Y') ?> - <?= date('t M, Y') ?></strong> </p>
                                            <div id="sales-chart"></div>
                                        </div> <!-- /.col -->
                                    </div> <!--end::Row-->
                                </div> <!-- ./card-body -->
                            </div> <!-- /.col -->
                        </div> <!--end::Row--> <!--begin::Row-->
                    </div> <!-- /.card --> <!-- DIRECT CHAT -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pesanan Terbaru</h3>
                            <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                        </div> <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Item</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Tanggal Resepsi</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result_pesanan->num_rows > 0) : ?>
                                            <?php  // Inisialisasi variabel hitung
                                            while ($row = $result_pesanan->fetch_assoc()) : ?>
                                                <tr>
                                                    <td> <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"><?= $row['id_pemesanan']; ?></a> </td>
                                                    <td><?= $row['nama_paket']; ?></td>
                                                    <td><?= $row['nama']; ?></td>
                                                    <td><?= $row['alamat_acara']; ?></td>
                                                    <td><?= $row['tanggal_acara']; ?></td>
                                                    <td><span class="badge <?= ($row['status_pesanan'] == 1) ? 'text-bg-success' : 'text-bg-danger'; ?>"><?= ($row['status_pesanan'] == 1) ? 'Selesai' : 'Belum Selesai'; ?></span></td>
                                                </tr>
                                            <?php endwhile ?>
                                        <?php else : echo "0 results";
                                        endif ?>
                                    </tbody>
                                </table>
                            </div> <!-- /.table-responsive -->
                        </div> <!-- /.card-body -->
                        <div class="card-footer clearfix"> <a href="?page=tambah-pemesanan" class="btn btn-sm btn-primary float-start">
                                Tambah Pesanan
                            </a> <a href="?page=pemesanan" class="btn btn-sm btn-secondary float-end">
                                Lihat Semua Pesanan
                            </a> </div> <!-- /.card-footer -->
                    </div> <!-- /.card -->
                </div> <!-- /.Start col --> <!-- Start col -->
                <div class="col-lg-5 connectedSortable">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Paket Layanan Baru</h3>
                            <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                        </div> <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="px-2">

                                <?php if ($result_paket->num_rows > 0) : ?>
                                    <?php  // Inisialisasi variabel hitung
                                    while ($row = $result_paket->fetch_assoc()) : ?>

                                        <div class="d-flex border-top py-2 px-1">
                                            <div class="col-2"> <img src="assets/img/produk/<?= $row['foto']; ?>" alt="Product Image" class="img-size-50"> </div>
                                            <div class="col-10"> <a href="javascript:void(0)" class="fw-bold">
                                                    <?= $row['nama_paket']; ?>
                                                    <span class="badge text-bg-warning float-end">
                                                        <?= rupiah($row['harga']); ?>
                                                    </span> </a>
                                                <div class="text-truncate">
                                                    <?= $row['deskripsi']; ?>
                                                </div>
                                            </div>
                                        </div> <!-- /.item -->
                                    <?php endwhile ?>
                                <?php else : echo "0 results";
                                endif ?>
                            </div>
                        </div> <!-- /.card-body -->
                        <div class="card-footer text-center"> <a href="?page=paket-layanan" class="uppercase">
                                View All Products
                            </a> </div> <!-- /.card-footer -->
                    </div> <!-- /.card -->
                </div> <!-- /.Start col -->
            </div> <!-- /.row (main row) -->
        </div> <!--end::Container-->
    </div> <!--end::App Content-->
</main>