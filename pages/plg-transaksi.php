<?php
require_once 'config/connection.php';

// Check if user is logged in and is a customer
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 2) {
    echo "<script type='text/javascript'>
        window.location.href = 'login.php';
    </script>";
    exit;
}

$id_user = $_SESSION['user']['id_user'];

// Get customer details
$sql_customer = "SELECT * FROM pelanggan WHERE id_user = '$id_user'";
$result_customer = $conn->query($sql_customer);
$customer = $result_customer->fetch_assoc();

// Get transaction history
$sql_transactions = "SELECT t.*,pl.harga, pl.nama_paket 
                     FROM transaksi t 
                     JOIN pemesanan p ON t.id_pemesanan = p.id_pemesanan 
                     JOIN pelanggan plg ON plg.id_pelanggan=p.id_pelanggan
                     JOIN paket_layanan pl ON p.id_paket_layanan = pl.id_paket_layanan 
                     WHERE p.id_pelanggan = '{$customer['id_pelanggan']}'";

$result_transactions = $conn->query($sql_transactions);
?>

<head>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="YOUR_CLIENT_KEY"></script> -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-cy4OpTGJPkQIvD_g"></script>

</head>

<section class="hero-section hero-50 d-flex justify-content-center align-items-center" id="section_1">

    <div class="section-overlay"></div>

    <svg viewBox="0 0 1962 178" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <path fill="#3D405B" d="M 0 114 C 118.5 114 118.5 167 237 167 L 237 167 L 237 0 L 0 0 Z" stroke-width="0"></path>
        <path fill="#3D405B" d="M 236 167 C 373 167 373 128 510 128 L 510 128 L 510 0 L 236 0 Z" stroke-width="0"></path>
        <path fill="#3D405B" d="M 509 128 C 607 128 607 153 705 153 L 705 153 L 705 0 L 509 0 Z" stroke-width="0"></path>
        <path fill="#3D405B" d="M 704 153 C 812 153 812 113 920 113 L 920 113 L 920 0 L 704 0 Z" stroke-width="0"></path>
        <path fill="#3D405B" d="M 919 113 C 1048.5 113 1048.5 148 1178 148 L 1178 148 L 1178 0 L 919 0 Z" stroke-width="0"></path>
        <path fill="#3D405B" d="M 1177 148 C 1359.5 148 1359.5 129 1542 129 L 1542 129 L 1542 0 L 1177 0 Z" stroke-width="0"></path>
        <path fill="#3D405B" d="M 1541 129 C 1751.5 129 1751.5 138 1962 138 L 1962 138 L 1962 0 L 1541 0 Z" stroke-width="0"></path>
    </svg>

    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-12">

                <h1 class="text-white mb-4 pb-2">Transaksi</h1>
            </div>

        </div>
    </div>

    <svg viewBox="0 0 1962 178" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <path fill="#ffffff" d="M 0 114 C 118.5 114 118.5 167 237 167 L 237 167 L 237 0 L 0 0 Z" stroke-width="0"></path>
        <path fill="#ffffff" d="M 236 167 C 373 167 373 128 510 128 L 510 128 L 510 0 L 236 0 Z" stroke-width="0"></path>
        <path fill="#ffffff" d="M 509 128 C 607 128 607 153 705 153 L 705 153 L 705 0 L 509 0 Z" stroke-width="0"></path>
        <path fill="#ffffff" d="M 704 153 C 812 153 812 113 920 113 L 920 113 L 920 0 L 704 0 Z" stroke-width="0"></path>
        <path fill="#ffffff" d="M 919 113 C 1048.5 113 1048.5 148 1178 148 L 1178 148 L 1178 0 L 919 0 Z" stroke-width="0"></path>
        <path fill="#ffffff" d="M 1177 148 C 1359.5 148 1359.5 129 1542 129 L 1542 129 L 1542 0 L 1177 0 Z" stroke-width="0"></path>
        <path fill="#ffffff" d="M 1541 129 C 1751.5 129 1751.5 138 1962 138 L 1962 138 L 1962 0 L 1541 0 Z" stroke-width="0"></path>
    </svg>
</section>
<section class="events-section events-detail-section section-padding" id="section_2">
    <div class="container">
        <div class="row">

            <div class="container mt-5">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Paket</th>
                            <th>Deskripsi</th>
                            <th>Tanggal Transaksi</th>
                            <th>Total</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while ($row = $result_transactions->fetch_assoc()) :
                            $sisa_pembayaran = $row['harga'] - $row['total']; ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['nama_paket']; ?></td>
                                <td><?php echo $row['deskripsi']; ?></td>
                                <td><?php echo $row['tanggal_transaksi']; ?></td>
                                <td><?php echo "Rp " . number_format($row['total'], 0, ',', '.'); ?></td>
                                <td><?php echo $row['metode']; ?></td>
                                <td>
                                    <?php
                                    if ($row['status_transaksi'] == 0) {
                                        echo 'Cancelled';
                                    } elseif ($row['status_transaksi'] == 1) {
                                        echo 'Pending';
                                    } else {
                                        echo 'Success';
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?php if ($row['status_transaksi'] == 1) : ?>
                                        <button class="btn btn-success btn-pay" data-id="<?php echo $row['id_transaksi']; ?>">Bayar</button>
                                        <button class="btn btn-danger btn-cancel" data-id="<?php echo $row['id_transaksi']; ?>">Cancel</button>
                                    <?php endif; ?>

                                    <?php if ($row['status_transaksi'] == 2 && $sisa_pembayaran > 0) : ?>
                                        <button class="btn btn-success btn-pelunasan" data-id="<?php echo $row['id_transaksi']; ?>" data-sisa="<?php echo $sisa_pembayaran; ?>">Pelunasan</button>

                                    <?php endif; ?>
                                    <?php if ($row['status_transaksi'] == 2): ?>
                                        <button class="btn btn-danger btn-cancel" data-id="<?php echo $row['id_transaksi']; ?>">Cancel</button>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        endwhile; ?>
                    </tbody>
                </table>
            </div>
            <h3 class="mt-4">Catatan:</h3>
            <h4 class="text-danger">Cancel/Pembatalan</h4>
            <p>Pembayaran lunas = Hubungi admin untuk mengembalian dana 70% <br>Pembayaran DP 30% = Hangus</p>
            <p></p>

        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-pay').click(function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Anda yakin ingin membayar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, bayar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'pages/payment/plg-proses-pembayaran.php',
                        method: 'POST',
                        data: {
                            id_transaksi: id
                        },
                        dataType: 'json', // Pastikan data yang diterima adalah JSON
                        success: function(response) {
                            console.log(response); // For debugging
                            if (response.status === 'success' && response.snapToken) {
                                snap.pay(response.snapToken, {
                                    onSuccess: function(result) {
                                        // Extract payment method from result
                                        var paymentMethod = result.payment_type;

                                        $.ajax({
                                            url: 'pages/controller/plg-proccess-payment.php',
                                            method: 'POST',
                                            data: {
                                                id_transaksi: id,
                                                metode: paymentMethod
                                            },
                                            success: function(response) {
                                                Swal.fire('Berhasil!', 'Pembayaran berhasil dilakukan.', 'success').then(() => {
                                                    location.reload();
                                                });
                                            },
                                            error: function() {
                                                Swal.fire('Gagal!', 'Pembayaran berhasil, tetapi ada kesalahan dalam memperbarui status.', 'error');
                                            }
                                        });
                                    },
                                    onPending: function(result) {
                                        Swal.fire('Pending!', 'Pembayaran dalam proses.', 'info');
                                    },
                                    onError: function(result) {
                                        Swal.fire('Gagal!', 'Pembayaran gagal. Silakan coba lagi.', 'error');
                                    }
                                });
                            } else {
                                Swal.fire('Gagal!', response.message || 'Pembayaran gagal. Silakan coba lagi.', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Gagal!', 'Pembayaran gagal. Silakan coba lagi.', 'error');
                        }
                    });
                }
            });
        });
    });

    $(document).ready(function() {
        $('.btn-pelunasan').click(function() {
            var id = $(this).data('id');
            var sisaPembayaran = $(this).data('sisa');

            Swal.fire({
                title: 'Anda yakin ingin melunasi pembayaran?',
                text: "Sisa pembayaran: Rp " + sisaPembayaran,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, bayar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'pages/payment/plg-proses-pelunasan.php',
                        method: 'POST',
                        data: {
                            id_transaksi: id,
                            sisa_pembayaran: sisaPembayaran
                        },
                        success: function(response) {
                            console.log("Server Response:", response); // Log respons server

                            if (response.status === 'success' && response.snapToken) {
                                snap.pay(response.snapToken, {
                                    onSuccess: function(result) {
                                        var paymentMethod = result.payment_type;
                                        $.ajax({
                                            url: 'pages/controller/plg-proccess-settlement.php',
                                            method: 'POST',
                                            data: {
                                                id_transaksi: id,
                                                metode: paymentMethod,
                                                status: 'pelunasan',
                                                sisa_pembayaran: sisaPembayaran
                                            },
                                            success: function(response) {
                                                Swal.fire('Berhasil!', 'Pelunasan berhasil dilakukan.', 'success').then(() => {
                                                    location.reload();
                                                });
                                            },
                                            error: function() {
                                                Swal.fire('Gagal!', 'Pelunasan berhasil, tetapi ada kesalahan dalam memperbarui status.', 'error');
                                            }
                                        });
                                    },
                                    onPending: function(result) {
                                        Swal.fire('Pending!', 'Pelunasan dalam proses.', 'info');
                                    },
                                    onError: function(result) {
                                        Swal.fire('Gagal!', 'Pelunasan gagal. Silakan coba lagi.', 'error');
                                    }
                                });
                            } else {
                                Swal.fire('Gagal!', response.message || 'Pelunasan gagal. Silakan coba lagi.', 'error');
                            }

                        },
                        error: function() {
                            Swal.fire('Gagal!', 'Pelunasan gagal. Silakan coba lagi.', 'error');
                        }
                    });
                }
            });
        });
    });

    $('.btn-cancel').click(function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Anda yakin ingin membatalkan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, batalkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'pages/controller/plg-cancel-payment.php',
                    method: 'POST',
                    data: {
                        id_transaksi: id,
                    },
                    success: function(response) {
                        Swal.fire('Berhasil!', 'Transaksi berhasil dibatalkan.', 'success').then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire('Gagal!', 'Pembatalan transaksi gagal. Silakan coba lagi.', 'error');
                    }
                });
            }
        });
    });
</script>


<?php
$conn->close();
?>