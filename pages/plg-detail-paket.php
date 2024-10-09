<?php
if (empty($_SESSION)) {
    echo '<script type="text/javascript">
            Swal.fire({
                title: "Perhatian",
                text: "Anda harus login terlebih dahulu",
                icon: "warning",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "index.php?page=plg-content";
                }
            });
          </script>';
    exit();
}
include('pages/templates/plg-navbar.php');
include('config/connection.php');

$id_paket = $_POST['id_paket'];
$id_user = $_SESSION['user']['id_user'];

// Query untuk mengambil data paket layanan dan foto
$query_paket = "SELECT pl.*, fp.foto FROM paket_layanan pl
LEFT JOIN foto_paket fp ON pl.id_paket_layanan = fp.id_paket_layanan
WHERE pl.id_paket_layanan ='$id_paket'";
$result_paket = $conn->query($query_paket);

// Fetch all results into an array
$layanan_paket = [];
while ($row = $result_paket->fetch_assoc()) {
    $layanan_paket[] = $row;
}

// Get the first row for main package details
$p = $layanan_paket[0];

// Query untuk mengambil data pelanggan
$query_pelanggan = "SELECT pelanggan.nama, pelanggan.email, pelanggan.nomor_telepon 
                    FROM pelanggan 
                    INNER JOIN users ON pelanggan.id_user = users.id_user 
                    WHERE users.id_user = '$id_user'";
$result_pelanggan = $conn->query($query_pelanggan);

$detail_pelanggan = $result_pelanggan->fetch_assoc();
$d = $detail_pelanggan;
?>

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

                <h1 class="text-white mb-4 pb-2">Detail Paket</h1>

                <a href="#section_2" class="btn custom-btn smoothscroll me-3">Learn more</a>
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

            <div class="col-lg-6 col-md-8 col-12 mx-auto">
                <h2 class="mb-lg-5 mb-4"><?= $p['nama_paket']; ?></h2>
                <div class="custom-block-image-wrap">
                    <div class="card">
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                $active = true; // Tentukan apakah item pertama akan aktif
                                foreach ($layanan_paket as $row) {
                                    $foto = $row['foto'];
                                    $active_class = $active ? 'active' : '';

                                    echo '<div class="carousel-item ' . $active_class . '">
                                            <img src="assets/img/produk/' . $foto . '" class="d-block w-100" alt="...">
                                          </div>';

                                    $active = false; // Setelah item pertama, atur menjadi tidak aktif
                                }
                                ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="custom-block-info">
                <h3 class="mb-3">Deskripsi</h3>

                <p><?= $p['deskripsi']; ?></p>

                <h3 class="mt-4 mb-3">Catatan</h3>
                <p>Pemasangan akan dilakukan H-1 sebelum acara. Paket hanya berlaku untuk 1 hari, apabila acara lebih dari 1 hari maka hubungi admin untuk penyesuaian harga</p>
                <div class="events-detail-info row my-5">
                    <div class="col-lg-12 col-12">
                        <h4 class="mb-3">Harga : <?= rupiah($p['harga']); ?></h4>
                    </div>

                    <div class="col-lg-6 col-12">
                        <span class="custom-block-span">Fasilitas:</span>

                        <p class="mb-0"><?= $p['fasilitas']; ?></p>
                    </div>

                    <div class="col-lg-3 col-12 my-3 my-lg-0">
                        <span class="custom-block-span">Diskon</span>

                        <p class="mb-0"><?= rupiah($p['diskon']); ?></p>
                    </div>

                    <div class="col-lg-2 col-12">
                        <span class="custom-block-span">Status</span>
                        <p class="mb-0 badge <?= ($p['status_paket'] == 1) ? 'text-bg-success' : 'text-bg-danger'; ?>"><?= ($p['status_paket'] == 1) ? 'Tersedia' : 'Tidak Tersedia'; ?></p>
                    </div>
                    <div class="mt-5 d-flex justify-content-center checkout">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#checkout" <?= ($p['status_paket'] != 1) ? 'disabled' : ''; ?>>
                            Checkout
                        </button>
                    </div>
                </div>

                <div class="contact-info">
                    <div class="contact-info-item">
                        <div class="contact-info-body">
                            <strong>Bakalan RT/RW 02/01 Bakalan Polokarto Sukoharjo Jawa Tengah Indonesia</strong>

                            <p class="mt-2 mb-1">
                                <a href="https://wa.me/+628562516379" class="contact-link">
                                    Admin | +628562516379
                                </a>
                            </p>

                            <p class="mb-0">
                                <a href="mailto:marniweddingorganizer@gmail.com" class="contact-link">
                                    marniweddingorganizer@gmail.com
                                </a>
                            </p>
                        </div>

                        <div class="contact-info-footer">
                            <a href="https://maps.app.goo.gl/rjqL4jm9yRyAbEdD7?g_st=com.google.maps.preview.copy" target="_blank">Lokasi Maps</a>
                        </div>

                    </div>

                    <img src="assets/img/WorldMap.svg" class="img-fluid" alt="">
                </div>
            </div>
        </div>

    </div>
    </div>
</section>

<!-- Modal Checkout-->
<div class="modal fade" id="checkout" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Checkout Paket Layanan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idPaket" name="idPaket" value="<?= $p['id_paket_layanan']; ?>">
                <input type="hidden" id="namaPaket" name="namaPaket" value="<?= $p['nama_paket']; ?>">
                <input type="hidden" id="harga" name="harga" value="<?= $p['harga']; ?>">
                <input type="hidden" id="namaPelanggan" name="namaPelanggan" value="<?= $d['nama']; ?>">
                <input type="hidden" id="email" name="email" value="<?= $d['email']; ?>">
                <input type="hidden" id="nomorTelepon" name="nomorTelepon" value="<?= $d['nomor_telepon']; ?>">
                <div class="mb-3">
                    <label for="tanggalResepsi" class="col-form-label">Tanggal Resepsi</label>
                    <input type="date" class="form-control" id="tanggalResepsi">
                </div>
                <div class="mb-3">
                    <label for="alamat" class="col-form-label">Alamat Resepsi</label>
                    <input type="text" class="form-control" id="alamat">
                </div>
                <div class="mb-3">
                    <label for="catatan" class="col-form-label">Catatan</label>
                    <input type="text" class="form-control" id="catatan">
                </div>
                <div>
                    <label for="pembayaran" class="col-form-label">Pembayaran</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pembayaran" id="uangMuka" value="0">
                        <label class="form-check-label" for="uangMuka">
                            Uang Muka 30%
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pembayaran" id="lunas" value="1" checked>
                        <label class="form-check-label" for="lunas">
                            Lunas
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-success checkoutBtn" id="submitBtn">Bayar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
    $(document).ready(function() {
        let snapInProgress = false;

        $('.checkoutBtn').click(function(event) {
            event.preventDefault();

            if (snapInProgress) {
                Swal.fire({
                    icon: 'info',
                    title: 'Tunggu Sebentar',
                    text: 'Transaksi sedang diproses. Silakan tunggu.'
                });
                return;
            }

            var alamatAcara = $('#alamat').val();
            if (!alamatAcara) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Periksa Data',
                    text: 'Alamat acara tidak boleh kosong.'
                });
                return;
            }

            snapInProgress = true;
            $('#submitBtn').attr('disabled', 'disabled'); // Nonaktifkan tombol submit

            var hargaAsli = parseFloat($('#harga').val());
            var pembayaran = $('input[name="pembayaran"]:checked').val();
            var harga = pembayaran === '0' ? hargaAsli * 0.3 : hargaAsli; // Jika uang muka, harga 30% dari harga asli

            var data = {
                id_paket: $('#idPaket').val(),
                nama_paket: $('#namaPaket').val(),
                harga: harga, // Gunakan harga yang telah disesuaikan
                nama_pelanggan: $('#namaPelanggan').val(),
                email: $('#email').val(),
                nomor_telepon: $('#nomorTelepon').val(),
                tanggal_resepsi: $('#tanggalResepsi').val(),
                alamat: alamatAcara,
                catatan: $('#catatan').val(),
                pembayaran: pembayaran
            };

            $.ajax({
                url: 'pages/payment/place-order.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    try {
                        // Tambahkan console log untuk melihat response mentah
                        console.log('Raw response:', response);

                        response = JSON.parse(response);
                        if (response.status === 'success') {
                            var transactionToken = response.snapToken;
                            window.snap.pay(transactionToken, {
                                onSuccess: function(result) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Pembayaran Berhasil',
                                        text: 'Pembayaran Anda telah berhasil!'
                                    });
                                    snapInProgress = false;
                                    $('#submitBtn').removeAttr('disabled'); // Aktifkan kembali tombol submit

                                    $.ajax({
                                        url: 'pages/payment/callback.php',
                                        method: 'POST',
                                        contentType: 'application/json',
                                        data: JSON.stringify({
                                            order_id: result.order_id,
                                            payment_type: result.payment_type
                                        }),
                                        success: function(callbackResponse) {
                                            try {
                                                callbackResponse = JSON.parse(callbackResponse);
                                                if (callbackResponse.status === 'success') {
                                                    console.log('Transaction updated successfully.');
                                                } else {
                                                    console.error('Failed to update transaction.');
                                                }
                                            } catch (e) {
                                                console.error('Error parsing callback response:', e);
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('AJAX request failed:', status, error);
                                        }
                                    }).always(() => {
                                        location.reload();
                                    });
                                },
                                onPending: function(result) {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Pembayaran Tertunda',
                                        text: 'Menunggu pembayaran Anda!'
                                    });
                                    console.log(result);
                                    snapInProgress = false;
                                    $('#submitBtn').removeAttr('disabled');
                                },
                                onError: function(result) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Pembayaran Gagal',
                                        text: 'Pembayaran Anda gagal!'
                                    });
                                    console.log(result);
                                    snapInProgress = false;
                                    $('#submitBtn').removeAttr('disabled');
                                },
                                onClose: function() {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Pembayaran Ditutup',
                                        text: 'Anda menutup popup tanpa menyelesaikan pembayaran.'
                                    });
                                    snapInProgress = false;
                                    $('#submitBtn').removeAttr('disabled');
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal mendapatkan token transaksi.'
                            });
                            snapInProgress = false;
                            $('#submitBtn').removeAttr('disabled');
                        }
                    } catch (e) {
                        console.error('Error parsing JSON response:', e);
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan',
                            text: 'Terjadi kesalahan saat memproses transaksi.'
                        });
                        snapInProgress = false;
                        $('#submitBtn').removeAttr('disabled');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request failed:', status, error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: 'Gagal mengirim data ke server.'
                    });
                    snapInProgress = false;
                    $('#submitBtn').removeAttr('disabled');
                }
            });

        });

    });
</script>