<?php
// session_start(); // Pastikan session dimulai

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

if (isset($_FILES['foto']) && $_FILES['foto']['error'][0] != UPLOAD_ERR_NO_FILE) {
    $id_paket_layanan = "PL" . rand(1, 9999);
    $nama_paket = $_POST['nama_paket'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $fasilitas = $_POST['fasilitas'];
    $diskon = $_POST['diskon'];
    $status = $_POST['status'];

    // Simpan data paket layanan
    $query = "INSERT INTO paket_layanan (id_paket_layanan, nama_paket, deskripsi, harga, fasilitas, diskon, status_paket) VALUES ('$id_paket_layanan', '$nama_paket', '$deskripsi', '$harga', '$fasilitas', '$diskon', '$status')";
    mysqli_query($conn, $query);

    // Periksa setiap file yang diupload
    foreach ($_FILES['foto']['name'] as $key => $value) {
        // Dapatkan nama file dan ekstensi
        $nama_file = $_FILES['foto']['name'][$key];
        $ekstensi = pathinfo($nama_file, PATHINFO_EXTENSION);

        // Buat nama file baru dengan format id_paket_layanan-nama_file_baru.ext
        $nama_file_baru = uniqid() . '.' . $ekstensi;

        // Tentukan direktori upload
        $direktori_upload = 'assets/img/produk/';

        // Pindahkan file ke direktori upload
        if (move_uploaded_file($_FILES['foto']['tmp_name'][$key], $direktori_upload . $nama_file_baru)) {
            // Kompresi gambar
            compress_image($direktori_upload . $nama_file_baru, $direktori_upload . $nama_file_baru);

            // Simpan data foto paket
            $query = "INSERT INTO foto_paket (id_paket_layanan, foto) VALUES ('$id_paket_layanan', '$nama_file_baru')";
            mysqli_query($conn, $query);
        } else {
            echo "Gagal mengunggah file.";
        }
    }
    unset($_FILES['foto']);
    echo "<script type='text/javascript'>Swal.fire('Berhasil!', 'Data berhasil disimpan.', 'success');</script>";
}
// Tutup koneksi
mysqli_close($conn);

function compress_image($source_url, $destination_url, $quality = 70)
{
    $info = getimagesize($source_url);

    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source_url);
        imagejpeg($image, $destination_url, round($quality / 10));
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source_url);
        imagepng($image, $destination_url, round($quality / 10));
    } elseif ($info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($source_url);
        imagegif($image, $destination_url);
    }

    // Hapus gambar sementara dari memori
    imagedestroy($image);
}
?>
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Tambah Paket</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="?page=paket-layanan">Paket Layanan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Paket</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="p-4 mb-4">
        <form method="post" action="" enctype="multipart/form-data">
            <div class="body">
                <div class="row mb-3">
                    <label for="foto" class="col-sm-2 col-form-label">Upload Foto</label>
                    <div class="col-sm-10">
                        <input type="file" name="foto[]" class="form-control" id="foto" multiple required onchange="previewImages()">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10" id="imagePreview"></div>
                </div>
                <div class="row mb-3">
                    <label for="nama_paket" class="col-sm-2 col-form-label">Nama Paket</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_paket" class="form-control" id="nama_paket" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                        <textarea class="form-control"" name=" deskripsi" id="deskripsi" required></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-10">
                        <input type="text" name="harga" class="form-control" id="harga" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="fasilitas" class="col-sm-2 col-form-label">Fasilitas</label>
                    <div class="col-sm-10">
                        <input type="text" name="fasilitas" class="form-control" id="fasilitas" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="diskon" class="col-sm-2 col-form-label">Diskon</label>
                    <div class="col-sm-10">
                        <input type="text" name="diskon" class="form-control" id="diskon" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="status" class="col-sm-2 col-form-label">Paket Layanan Status</label>
                    <div class="col-sm-10">
                        <!-- untuk mencari data pada menu dropdown -->
                        <!-- <select class="form-control js-example-basic-single" name="status" required> -->
                        <select class="form-control" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="1">Tersedia</option>
                            <option value="0">Tidak Tersedia</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-warning">Simpan</button>
                <button type="reset" class="btn btn-danger float-end">Batal</button>
            </div>
        </form>
    </div>
</main>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    function previewImages() {
        var preview = document.getElementById('imagePreview');
        preview.innerHTML = ''; // Clear any previous previews

        var files = document.getElementById('foto').files;

        if (files) {
            [].forEach.call(files, function(file) {
                if (/image\/.*/.test(file.type)) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '150px';
                        img.style.marginRight = '10px';
                        img.style.marginBottom = '10px';
                        preview.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    }
</script>