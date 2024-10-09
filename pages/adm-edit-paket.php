<?php
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

// Periksa apakah user adalah admin
if ($_SESSION['user']['role'] != 1) {
    exit;
}

include('pages/config/connection.php');

$id_paket = $_POST['id_paket'];
// Proses ketika form disubmit
if (isset($_POST['submit'])) {
    $nama_paket = $_POST['nama_paket'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $fasilitas = $_POST['fasilitas'];
    $diskon = $_POST['diskon'];
    $status = $_POST['status'];

    // Proses upload file
    if (isset($_FILES['foto']) && $_FILES['foto']['error'][0] != UPLOAD_ERR_NO_FILE) {
        foreach ($_FILES['foto']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['foto']['name'][$key];
            $file_tmp = $_FILES['foto']['tmp_name'][$key];
            $target_dir = "assets/img/produk/";

            // Pindahkan file yang diunggah ke folder tujuan
            if (move_uploaded_file($file_tmp, $target_dir . $file_name)) {
                // Simpan informasi foto ke dalam database
                $query_foto = "INSERT INTO foto_paket (id_paket_layanan, foto) VALUES ('$id_paket', '$file_name')";
                $conn->query($query_foto);
            }
        }
    }

    // Update data paket layanan
    $query_update = "UPDATE paket_layanan 
                     SET nama_paket = ?, deskripsi = ?, harga = ?, fasilitas = ?, diskon = ?, status_paket = ? 
                     WHERE id_paket_layanan = ?";
    $stmt = $conn->prepare($query_update);
    $stmt->bind_param('sssssis', $nama_paket, $deskripsi, $harga, $fasilitas, $diskon, $status, $id_paket);

    if ($stmt->execute()) {
        // echo "<script>alert('Data berhasil diperbarui'); window.location.href='?page=paket-layanan';</script>";
        echo "<script>alert('Data berhasil diperbarui');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menyimpan data');</script>";
    }

    $stmt->close();
}

$query_paket = "SELECT * FROM paket_layanan WHERE id_paket_layanan = '$id_paket'";
$result_paket = $conn->query($query_paket);
$layanan_paket = $result_paket->fetch_assoc();

// Ambil data foto dari tabel foto_paket
$query_foto = "SELECT foto FROM foto_paket WHERE id_paket_layanan = '$id_paket'";
$result_foto = $conn->query($query_foto);
$fotos = [];
while ($row = $result_foto->fetch_assoc()) {
    $fotos[] = $row['foto'];
}

$conn->close();
?>
<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Paket</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="?page=paket-layanan">Paket Layanan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edit Paket
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div>
    <div class="p-4 mb-4"> <!--begin::Header-->
        <form method="post" action="" enctype="multipart/form-data">
            <div class="body">
                <div class="row mb-3">
                    <label for="foto" class="col-sm-2 col-form-label">Upload Foto</label>
                    <div class="col-sm-10">
                        <input type="file" name="foto[]" class="form-control" id="foto" multiple onchange="previewImages()">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Gambar yang Diunggah</label>
                    <div class="col-sm-10" id="imagePreview">
                        <?php if (!empty($fotos)) : ?>
                            <div class="row">
                                <?php foreach ($fotos as $file) : ?>
                                    <div class="col-sm-3">
                                        <img src="assets/img/produk/<?= htmlspecialchars($file) ?>" class="img-fluid" alt="Gambar yang Diunggah">
                                        <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeImage('<?= htmlspecialchars($file) ?>')">Hapus</button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <p>Tidak ada gambar yang diunggah.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <input type="hidden" name="id_paket" class="form-control" id="id_paket" value="<?= $layanan_paket['id_paket_layanan']; ?>" required>
                <div class="row mb-3">
                    <label for="nama_paket" class="col-sm-2 col-form-label">Nama Paket</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_paket" class="form-control" id="nama_paket" value="<?= $layanan_paket['nama_paket']; ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                        <textarea name="deskripsi" class="form-control" id=" deskripsi"><?= $layanan_paket['deskripsi']; ?></textarea>
                        <!-- <input type="text" name="deskripsi" class="form-control" id="deskripsi" value="<?= $layanan_paket['deskripsi']; ?>" required> -->
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-10">
                        <input type="text" name="harga" class="form-control" id="harga" value="<?= $layanan_paket['harga']; ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="fasilitas" class="col-sm-2 col-form-label">Fasilitas</label>
                    <div class="col-sm-10">
                        <input type="text" name="fasilitas" class="form-control" id="fasilitas" value="<?= $layanan_paket['fasilitas']; ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="diskon" class="col-sm-2 col-form-label">Diskon</label>
                    <div class="col-sm-10">
                        <input type="text" name="diskon" class="form-control" id="diskon" value="<?= $layanan_paket['diskon']; ?>" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="status" class="col-sm-2 col-form-label">Paket Layanan Status</label>
                    <div class="col-sm-10">
                        <select class="form-control js-example-basic-single" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="1" <?= $layanan_paket['status_paket'] == 1 ? 'selected' : ''; ?>>Tersedia</option>
                            <option value="0" <?= $layanan_paket['status_paket'] == 0 ? 'selected' : ''; ?>>Tidak Tersedia</option>
                        </select>
                    </div>
                </div>
            </div> <!--end::Body--> <!--begin::Footer-->
            <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-warning">Simpan Perubahan</button>
            </div> <!--end::Footer-->
        </form> <!--end::Form-->
    </div> <!--end::Horizontal Form-->
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

    function removeImage(filename) {
        // Optionally add an AJAX request to remove the image from the server
        console.log('Removing image:', filename);
    }
</script>