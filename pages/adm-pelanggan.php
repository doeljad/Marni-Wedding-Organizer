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
$sql = "SELECT * FROM pelanggan";
$result = $conn->query($sql);
?>
<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Pelanggan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Pelanggan
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header--> <!--begin::App Content-->
    <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Tabel Pelanggan</h3>
                    <div class="col-sm-6 position-absolute mt-3 end-0 me-2">
                        <ol class="breadcrumb float-end">
                            <li> <a href="?page=tambah-pelanggan"><button class="btn btn-success"><i class="bi bi-plus-circle"></i> Tambah Pelanggan</button></a>
                            </li>
                        </ol>
                    </div>
                </div> <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">No.</th>
                                <th>ID Pelanggan</th>
                                <th>ID User</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>Nomor Telepon</th>
                                <th>Email</th>
                                <th>Tanggal Bergabung</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0) : ?>
                                <?php $i = 1; ?>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr class="align-middle">
                                        <td><?= $i++ ?>.</td>
                                        <td><?= $row['id_pelanggan']; ?></td>
                                        <td><?= $row['id_user']; ?></td>
                                        <td><?= $row['nama']; ?></td>
                                        <td><?= $row['jenis_kelamin']; ?></td>
                                        <td><?= $row['alamat']; ?></td>
                                        <td><?= $row['nomor_telepon']; ?></td>
                                        <td><?= $row['email']; ?></td>
                                        <td><?= date('d-m-Y', strtotime($row['tanggal_bergabung'])); ?></td>
                                    </tr>
                                <?php endwhile ?>
                            <?php else : echo "Data tidak tersedia";
                            endif ?>
                        </tbody>
                    </table>
                </div> <!-- /.card-body -->
            </div>
        </div> <!--end::Container-->
    </div> <!--end::App Content-->
</main> <!--end::App Main--> <!--begin::Footer-->