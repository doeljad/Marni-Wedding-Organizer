<?php

if (isset($_SESSION['user'])) {
    $id_user = $_SESSION['user']['id_user'];
    // Query untuk mengambil data pelanggan
    $query_pelanggan = "SELECT pelanggan.nama, pelanggan.email, pelanggan.nomor_telepon 
                        FROM pelanggan 
                        INNER JOIN users ON pelanggan.id_user = users.id_user 
                        WHERE users.id_user = '$id_user'";
    $result_pelanggan = $conn->query($query_pelanggan);

    $d = $result_pelanggan->fetch_assoc();
}
?>

<main>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.html">
                <img src="assets\img\MarniWO-circle.png" class="navbar-brand-image img-fluid" alt="Tiya Golf Club">
                <span class="navbar-brand-text">
                    Marni
                    <small>Wedding Organizer</small>
                </span>
            </a>

            <!-- <div class="d-lg-none ms-auto me-3">
                <a class="btn custom-btn custom-border-btn" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">Member Login</a>
            </div> -->

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-lg-auto">
                    <li class="nav-item">
                        <a class="nav-link click-scroll" href="?page=plg-content">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link click-scroll" href="?page=plg-content#tentang">Tentang</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link click-scroll" href="?page=plg-content#paket">Paket Layanan</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link click-scroll" href="?page=plg-content#contact">Hubungi Kami</a>
                    </li>

                    <li class="nav-item dropdown">
                        <?php if (isset($d)) { ?>
                            <button class="btn custom-btn custom-border-btn nav-link" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $d['nama']; ?>
                            </button>
                            <ul class="dropdown-menu animated-dropdown-menu" aria-labelledby="navbarLightDropdownMenuLink">
                                <li><a class="dropdown-item" href="?page=plg-transaksi">Transaksi</a></li>
                                <li><a class="dropdown-item" href="?page=plg-setting">Setting Akun</a></li>
                                <hr>
                                <li><a class="dropdown-item text-danger" href="pages/logout.php">Logout</a></li>
                            </ul>
                        <?php } else { ?>
                            <button class="btn custom-btn custom-border-btn nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample">
                                Login
                            </button>
                        <?php } ?>

                    </li>

                </ul>


            </div>
        </div>
    </nav>
</main>

<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Silahkan Login</h5>

        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column">
        <form class="custom-form member-login-form" action="login.php" method="post">

            <div class="member-login-form-body">
                <div class="mb-4">
                    <label class="form-label mb-2" for="username">Username</label>

                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                </div>

                <div class="mb-4">
                    <label class="form-label mb-2" for="password">Password</label>

                    <input type="password" name="password" id="password" pattern="[0-9a-zA-Z]{4,10}" class="form-control" placeholder="Password" required title="Kata sandi harus sepanjang 4-10 karakter dan hanya boleh berisi huruf dan angka.">
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">

                    <label class="form-check-label" for="flexCheckDefault">
                        Remember me
                    </label>
                </div>

                <div class="col-lg-5 col-md-7 col-8 mx-auto">
                    <button type="submit" class="form-control">Login</button>
                </div>

                <div class="text-center my-4">
                    <a href="register.php">Buat Akun</a>
                </div>
                <!-- <div class="text-center my-4">
                    <a href="#">Forgotten password?</a>
                </div> -->
            </div>
        </form>

        <div class="mt-auto mb-5">
            <p>
                <strong class="text-white me-3">Ada Pertanyaan?</strong>

                <a href="wa.me/+628562516379" class="contact-link">
                    +628562516379
                </a>
            </p>
        </div>
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#3D405B" fill-opacity="1" d="M0,224L34.3,192C68.6,160,137,96,206,90.7C274.3,85,343,139,411,144C480,149,549,107,617,122.7C685.7,139,754,213,823,240C891.4,267,960,245,1029,224C1097.1,203,1166,181,1234,160C1302.9,139,1371,117,1406,106.7L1440,96L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
    </svg>
</div>