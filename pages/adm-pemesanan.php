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
$sql = "SELECT p.*, pl.*, pel.nama, t.status_transaksi,
IFNULL((SELECT t.deskripsi 
        FROM transaksi t 
        WHERE t.id_pemesanan = p.id_pemesanan 
        LIMIT 1), 'Tidak Diketahui') AS deskripsi 
FROM pemesanan p 
JOIN paket_layanan pl ON p.id_paket_layanan = pl.id_paket_layanan
JOIN pelanggan pel ON p.id_pelanggan = pel.id_pelanggan
LEFT JOIN transaksi t ON t.id_pemesanan = p.id_pemesanan
";

$result = $conn->query($sql);
if ($result->num_rows > 0) :
?>
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Pemesanan</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pemesanan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Tabel Pemesanan</h3>
                        <div class="col-sm-6 position-absolute mt-3 end-0 me-2">
                            <ol class="breadcrumb float-end">
                                <li><a href="?page=tambah-pemesanan"><button class="btn btn-success"><i class="bi bi-plus-circle"></i> Tambah Pemesanan</button></a></li>
                            </ol>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">No.</th>
                                    <!-- <th>ID Pemesanan</th> -->
                                    <th>Tanggal Pemesanan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Tanggal Acara</th>
                                    <th>Paket Layanan</th>
                                    <th>Lunas</th>
                                    <th>Kontak</th>
                                    <th>Alamat Acara</th>
                                    <th>Status</th>
                                    <th>Catatan Khusus</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($row = $result->fetch_assoc()) : ?>
                                    <tr class="align-middle">
                                        <td><?= $i++; ?>.</td>
                                        <!-- <td><?= $row['id_pemesanan']; ?></td> -->
                                        <td><?= date('d-m-Y', strtotime($row['tanggal_pemesanan'])); ?></td>
                                        <td><?= $row['nama']; ?></td>
                                        <td><?= date('d-m-Y', strtotime($row['tanggal_acara'])); ?></td>
                                        <td><?= $row['nama_paket']; ?></td>
                                        <td>
                                            <span class="badge <?= ($row['deskripsi'] == "Pembayaran Lunas") ? 'text-bg-success' : (($row['deskripsi'] == "Pembayaran DP") ? 'text-bg-danger' : 'text-bg-secondary'); ?>">
                                                <?= ($row['deskripsi'] == "Pembayaran Lunas") ? 'Lunas' : (($row['deskripsi'] == "Pembayaran DP") ? 'DP' : 'Tidak Diketahui'); ?>
                                            </span>
                                        </td>

                                        <td><?= $row['kontak_pemesan']; ?></td>
                                        <td><?= $row['alamat_acara']; ?></td>
                                        <td>
    <span class="badge <?= ($row['status_transaksi'] == 0) ? 'text-bg-danger' : (($row['status_pesanan'] == 1) ? 'text-bg-success' : 'text-bg-warning'); ?>">
        <?= ($row['status_transaksi'] == 0) ? 'Dibatalkan' : (($row['status_pesanan'] == 1) ? 'Selesai' : 'Belum Selesai'); ?>
    </span>
</td> <td><?= $row['catatan_khusus']; ?></td>
                                        <td>
                                            <button class="mb-2 btn btn-sm btn-warning edit-btn" data-id="<?= $row['id_pemesanan']; ?>" data-status="<?= $row['status_pesanan']; ?>"><i class="bi bi-pencil-square"></i></button>
                                            <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $row['id_pemesanan']; ?>"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Status Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm">
                    <div class="modal-body">
                        <input type="hidden" id="editIdPemesanan" name="id_pemesanan">
                        <div class="mb-3">
                            <label for="editStatus" class="form-label">Status</label>
                            <select class="form-select" id="editStatus" name="status_pesanan">
                                <option value="1">Selesai</option>
                                <option value="0">Belum Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editBtns = document.querySelectorAll('.edit-btn');
            const deleteBtns = document.querySelectorAll('.delete-btn');

            editBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const idPemesanan = this.getAttribute('data-id');
                    const status = this.getAttribute('data-status');

                    document.getElementById('editIdPemesanan').value = idPemesanan;
                    document.getElementById('editStatus').value = status;

                    const modal = new bootstrap.Modal(document.getElementById('editModal'));
                    modal.show();
                });
            });

            document.getElementById('editForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                fetch('pages/controller/update-status.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Status pesanan telah diperbarui!',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    });
            });

            deleteBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const idPemesanan = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: "Apakah Anda yakin ingin menghapus pesanan ini?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('pages/controller/delete-pesanan.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: new URLSearchParams({
                                        id_pemesanan: idPemesanan
                                    })
                                })
                                .then(response => response.text())
                                .then(data => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Dihapus',
                                        text: 'Pesanan telah dihapus!',
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        location.reload();
                                    });
                                });
                        }
                    });
                });
            });
        });
    </script>
<?php endif; ?>