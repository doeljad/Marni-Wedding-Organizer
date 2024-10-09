<?php
require_once 'config/connection.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

// Periksa apakah user adalah admin
if ($_SESSION['user']['role'] != 1) {
    // header('Location: plg-main.php');
    exit;
}

if (isset($_POST['submit'])) {
    $random_number = rand(1, 9999);
    $id_pelanggan = "PLG" . $random_number;
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $id_user = $random_number;
    $tanggal_bergabung = date('Y-m-d');

    // Password default
    $current_year = date('Y');
    $default_password = 'marni' . $current_year;
    $hashed_password = password_hash($default_password, PASSWORD_BCRYPT);

    // Periksa apakah username sudah digunakan
    $check_username_query = "SELECT username FROM users WHERE username='$username'";
    $result = $conn->query($check_username_query);

    if ($result->num_rows > 0) {
        echo "<script type='text/javascript'>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Username sudah pernah dipakai.',
                    icon: 'error'
                });
              </script>";
    } else {
        // Insert data into pelanggan table
        $sql = "INSERT INTO pelanggan (id_pelanggan, id_user, nama, jenis_kelamin, alamat, nomor_telepon, email, tanggal_bergabung) VALUES ('$id_pelanggan', '$id_user', '$nama', '$jenis_kelamin', '$alamat', '$nomor_telepon', '$email', '$tanggal_bergabung');";

        // Insert data into users table
        $sql .= "INSERT INTO users (id_user, nama, username, email, password, role) VALUES ('$id_user', '$nama', '$username', '$email', '$hashed_password', 2);";

        // Execute query
        if ($conn->multi_query($sql) === TRUE) {
            echo "<script type='text/javascript'>
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data berhasil disimpan.',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'index.php?page=tambah-pelanggan'; // ganti dengan halaman yang ingin Anda redirect
                    });
                  </script>";
        } else {
            echo "<script type='text/javascript'>
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Data tidak berhasil disimpan. Silakan coba lagi.',
                        icon: 'error'
                    });
                  </script>";
        }
    }
}
?>
<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Tambah Pelanggan</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="?page=pelanggan">Pelanggan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Tambah Pelanggan
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div>
    <div class="p-4 mb-4"> <!--begin::Header-->
        <form method="post"> <!--begin::Body-->
            <div class="body">
                <div class="row mb-3"> <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-10"> <input type="text" name="nama" class="form-control" id="nama" required> </div>
                </div>
                <div class="row mb-3"> <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-10">
                        <div class="form-check"> <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin1" value="Laki-laki" checked> <label class="form-check-label" for="jenis_kelamin1">
                                Laki - laki
                            </label> </div>
                        <div class="form-check"> <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin2" value="Perempuan"> <label class="form-check-label" for="jenis_kelamin2">
                                Perempuan
                            </label> </div>
                        <div class="form-check"> <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin3" value="Lainnya"> <label class="form-check-label" for="jenis_kelamin3">
                                Lainnya
                            </label> </div>

                    </div>
                </div>
                <div class="row mb-3"> <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10"> <input type="text" name="alamat" class="form-control" id="alamat" required> </div>
                </div>
                <div class="row mb-3"> <label for="nomor_telepon" class="col-sm-2 col-form-label">Nomor Telepon</label>
                    <div class="col-sm-10"> <input type="text" name="nomor_telepon" class="form-control" id="nomor_telepon" required> </div>
                </div>
                <div class="row mb-3"> <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10"> <input type="text" name="username" class="form-control" id="username" required> </div>
                </div>
                <div class="row mb-3"> <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10"> <input type="email" name="email" class="form-control" id="email" required> </div>
                </div>
            </div> <!--end::Body--> <!--begin::Footer-->
            <div class="card-footer"> <button type="submit" name="submit" class="btn btn-warning">Simpan</button> <button type="reset" class="btn float-end">Batal</button> </div> <!--end::Footer-->
        </form> <!--end::Form-->
    </div> <!--end::Horizontal Form-->
</main>