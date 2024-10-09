<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php
    // Tampilkan kesalahan PHP
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Periksa apakah user sudah login
    session_start();
    include('pages/config/connection.php');

    // Jika user sudah login, arahkan ke halaman sesuai role
    if (isset($_SESSION['user'])) {
        if ($_SESSION['user']['role'] == 1) {
            header('Location: index.php');
        } else {
            header('Location: index.php');
            // header('Location: pages/pelanggan.php');
        }
        exit; // Pastikan kode berhenti di sini jika redirect
    }

    // Jika user belum login, tampilkan form login
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Periksa username dan password
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query data user dari database dengan parameterisasi
        $query = "SELECT * FROM users WHERE username = ?"; // Prepared statement
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Periksa apakah user ditemukan
        if ($result && mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            // Periksa apakah password cocok
            if (password_verify($password, $user['password'])) {
                // Simpan data user ke session
                $_SESSION['user'] = $user;
                // Arahkan ke halaman sesuai role
                if ($user['role'] == 1) {
                    echo "<script>
                        Swal.fire({
                            title: 'Berhasil Login',
                            text: 'Selamat datang Admin',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1300,
                        }).then(() => { window.location.href = 'index.php'; });
                      </script>";
                } else {
                    echo "<script>
                        Swal.fire({
                        title: 'Berhasil Login',
                        text: 'Selamat datang',
                        icon: 'success',
                        timer:1300,
                        showConfirmButton: false,
                    }).then(() => { window.location.href = 'index.php'; });
                  </script>";
                }
                exit; // Hindari eksekusi kode selanjutnya setelah redirect
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Username atau password salah!',
                        icon: 'error',
                        showConfirmButton: false,
                    }).then(() => { window.location.href = 'index.php'; });
                  </script>";
            }
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Username dan password tidak ditemukan',
                    icon: 'error',
                    showConfirmButton: false,
                }).then(() => { window.location.href = 'index.php'; });
              </script>";
        }
        exit; // Hindari eksekusi kode selanjutnya setelah pesan ditampilkan
    }
    ?>
</body>

</html>