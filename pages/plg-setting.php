<?php
// session_start();
require_once 'pages/config/connection.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 2) {

    echo '<script type="text/javascript">window.location.href = "login.php";</script>';
    exit;
}

// Ambil data pelanggan dan pengguna
$id_user = $_SESSION['user']['id_user'];
$sql = "SELECT p.*, u.username, u.email as user_email FROM pelanggan p JOIN users u ON p.id_user = u.id_user WHERE u.id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_user);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $customer['password'];

    // Update data pelanggan
    $sql = "UPDATE pelanggan SET nama = ?, jenis_kelamin = ?, alamat = ?, nomor_telepon = ?, email = ? WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssi', $nama, $jenis_kelamin, $alamat, $nomor_telepon, $email, $id_user);
    $stmt->execute();
    

    // Update data user
    if (!empty($_POST['password'])) {
        $sql = "UPDATE users SET username = ?, email = ?, password = ? WHERE id_user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $username, $email, $password, $id_user);
    } else {
        $sql = "UPDATE users SET nama = ?,username = ?, email = ? WHERE id_user = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $nama, $username, $email, $id_user);
    }
    $stmt->execute();

    // Set success message and refresh
    $_SESSION['success'] = "Data berhasil diperbarui.";
    echo '<script type="text/javascript">window.location.href = "index.php?page=plg-setting";</script>';

    exit;
}
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

                <h1 class="text-white mb-4 pb-2">Setting Akun</h1>
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


            <div class="container">

                <?php if (isset($_SESSION['success'])) : ?>
                    <div class="alert alert-success">
                        <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group mb-2">
                        <label for="nama">Nama:</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($customer['nama']); ?>" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="jenis_kelamin">Jenis Kelamin:</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="Laki-laki" <?php echo $customer['jenis_kelamin'] == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="Perempuan" <?php echo $customer['jenis_kelamin'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="alamat">Alamat:</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo htmlspecialchars($customer['alamat']); ?>" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="nomor_telepon">Nomor Telepon:</label>
                        <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" value="<?php echo htmlspecialchars($customer['nomor_telepon']); ?>" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($customer['username']); ?>" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <small class="form-text text-muted">Biarkan kosong jika Anda tidak ingin mengubah password.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</section>