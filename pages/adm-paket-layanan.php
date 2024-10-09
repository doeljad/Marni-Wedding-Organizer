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
$sql = "SELECT pl.*FROM paket_layanan pl ORDER BY nama_paket";
$result = $conn->query($sql);

?>

<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Paket Layanan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Paket Layanan
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
                    <h3 class="card-title">Tabel Paket Pelayanan</h3>
                    <div class="col-sm-6 position-absolute mt-3 end-0 me-2">
                        <ol class="breadcrumb float-end">
                            <li> <a href="?page=tambah-paket"><button class="btn btn-success"><i class="bi bi-plus-circle"></i> Tambah Paket Pelayanan</button></a>
                            </li>
                        </ol>
                    </div>
                </div> <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 2px">No.</th>
                                <th>ID Layanan</th>
                                <th>Nama Paket</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Fasilitas</th>
                                <th>Diskon</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0) : ?>
                                <?php
                                $i = 1; // Inisialisasi variabel hitung
                                while ($row = $result->fetch_assoc()) : ?>
                                    <tr class=" align-middle">
                                        <td><?= $i++; ?>.</td>
                                        <td><?= $row['id_paket_layanan']; ?></td>
                                        <td><?= $row['nama_paket']; ?></td>
                                        <td class="col-deskripsi"><?= truncate_text($row['deskripsi'], 25)  ?></td>
                                        <td><?= rupiah($row['harga']) ?></td>
                                        <td><?= $row['fasilitas']; ?></td>
                                        <td><?= rupiah($row['diskon']) ?></td>
                                        <td>
                                            <span class="badge <?= ($row['status_paket'] == 1) ? 'text-bg-success' : 'text-bg-danger'; ?>"><?= ($row['status_paket'] == 1) ? 'Tersedia' : 'Tidak tersedia'; ?></span>
                                        </td>
                                        <td>
                                            <form action="?page=edit-paket" method="post">
                                                <input type="hidden" name="id_paket" value="<?= $row['id_paket_layanan']; ?>">
                                                <button class="mb-1 btn btn-sm btn-warning" type="submit"><i class="bi bi-pencil-square"></i></button>

                                            </form>
                                            <form action="?page=delete-paket" method="post">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($row['id_paket_layanan']); ?>">
                                                <button class="btn btn-sm btn-danger" type="submit"><i class="bi bi-trash"></i></button>
                                            </form>

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