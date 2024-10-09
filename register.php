<?php
if (isset($_POST['submit'])) {
    // Ambil data dari form register
    include('pages/config/connection.php');
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $role = 2;
    $tanggal_bergabung = date('Y-m-d');

    // Query untuk menambahkan user ke tabel users
    $query_user = "INSERT INTO users (nama, username, email, password, role) VALUES ('$nama', '$username', '$email', '$password', '$role')";
    mysqli_query($conn, $query_user);

    // Ambil ID user yang baru saja dimasukkan
    $id_user = mysqli_insert_id($conn);

    // Query untuk menambahkan data ke tabel pelanggan
    $id_pelanggan = 'PLG' . uniqid();
    $query_pelanggan = "INSERT INTO pelanggan (id_pelanggan, id_user, nama, jenis_kelamin, alamat, nomor_telepon, email, tanggal_bergabung) VALUES ('$id_pelanggan', '$id_user', '$nama', '$jenis_kelamin', '$alamat', '$nomor_telepon', '$email', '$tanggal_bergabung')";
    mysqli_query($conn, $query_pelanggan);

    echo "<script>
        alert('Akun berhasil dibuat!');
        window.location.href = 'index.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Register Marni WO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE 4 | Register Page v2">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/adminlte.css">
</head>

<body class="register-page bg-body-secondary">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <a href="../index2.html" class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover">
                    <h1 class="mb-0"><b>Register</b> Marni WO</h1>
                </a>
            </div>
            <div class="card-body register-card-body">
                <p class="register-box-msg">Registrasi Pengguna Baru</p>
                <form method="post">
                    <div class="input-group mb-1">
                        <div class="form-floating">
                            <input id="nama" name="nama" type="text" class="form-control" placeholder="">
                            <label for="nama">Nama Lengkap</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-person"></span>
                        </div>
                    </div>
                    <div class="input-group mb-1">
                        <div class="form-floating">
                            <input id="email" name="email" type="email" class="form-control" placeholder="">
                            <label for="email">Email</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-envelope"></span>
                        </div>
                    </div>
                    <div class="input-group mb-1">
                        <div class="form-floating">
                            <input id="username" name="username" type="text" class="form-control" placeholder="">
                            <label for="username">Username</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-person"></span>
                        </div>
                    </div>
                    <div class="input-group mb-1">
                        <div class="form-floating">
                            <input id="password" name="password" type="password" class="form-control" placeholder="">
                            <label for="password">Password</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-lock-fill"></span>
                        </div>
                    </div>
                    <div class="input-group mb-1">
                        <div class="form-floating">
                            <div>
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                            </div>
                            <div>
                                <input id="jenis_kelamin_l" name="jenis_kelamin" type="radio" value="Laki-laki">
                                <label for="jenis_kelamin_l" class="me-4">Laki-laki</label>

                                <input id="jenis_kelamin_p" name="jenis_kelamin" type="radio" value="Perempuan">
                                <label for="jenis_kelamin_p">Perempuan</label>
                            </div>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-gender-ambiguous"></span>
                        </div>
                    </div>

                    <div class="input-group mb-1">
                        <div class="form-floating">
                            <input id="alamat" name="alamat" type="text" class="form-control" placeholder="">
                            <label for="alamat">Alamat</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-house-door"></span>
                        </div>
                    </div>
                    <div class="input-group mb-1">
                        <div class="form-floating">
                            <input id="nomor_telepon" name="nomor_telepon" type="text" class="form-control" placeholder="">
                            <label for="nomor_telepon">Nomor Telepon</label>
                        </div>
                        <div class="input-group-text">
                            <span class="bi bi-telephone"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8 d-inline-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-grid gap-2">
                                <button type="submit" name="submit" class="btn btn-primary">Register</button>
                            </div>
                        </div>
                    </div>
                </form>

                <p class="mb-0">
                    <a href="index.php" class="link-primary text-center">
                        Saya sudah memiliki akun
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script>
    <script src="assets/js/adminlte.js"></script>
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "l"
        };
        OverlayScrollbars(document.querySelectorAll(SELECTOR_SIDEBAR_WRAPPER), Default);
    </script>
</body>

</html>