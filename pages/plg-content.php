<?php
include('pages/config/connection.php');
include('pages/templates/plg-navbar.php');
$query = "SELECT * FROM paket_layanan";
$result = mysqli_query($conn, $query);
// $paket_layanan = [];
// while ($row = $result->fetch_assoc()) {
//     $paket_layanan[] = $row;
// }

?>
<section class="hero-section d-flex justify-content-center align-items-center" id="#">
    <div class="section-overlay"></div>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#40445c" fill-opacity="1" d="M0,192L80,181.3C160,171,320,149,480,122.7C640,96,800,64,960,64C1120,64,1280,96,1360,112L1440,128L1440,0L1360,0C1280,0,1120,0,960,0C800,0,640,0,480,0C320,0,160,0,80,0L0,0Z"></path>
    </svg>
    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-12 mb-5 mb-lg-0">
                <h2 class="text-white cd-headline">Selamat Datang di</h2>

                <h1 class="cd-headline rotate-1 text-white mb-4 pb-2">
                    <span>Marni Wedding Organizer</span>
                    <span class="cd-words-wrapper">
                        <b class="is-visible">Impian Menjadi Kenyataan</b>
                        <b>Menyelenggarakan Cinta</b>
                        <b>Menciptakan Memori</b>
                        <b>Detail, Dedikasi, Dan Keindahan</b>
                    </span>
                </h1>

                <div class="custom-btn-group">
                    <a href="#tentang" class="btn custom-btn smoothscroll me-3">Our Story</a>


                </div>
            </div>

            <!-- <div class="col-lg-6 col-12">
                <div class="ratio ratio-16x9">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/ZjwKeHD1f5k" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div> -->

        </div>
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#ffffff" fill-opacity="1" d="M0,224L34.3,192C68.6,160,137,96,206,90.7C274.3,85,343,139,411,144C480,149,549,107,617,122.7C685.7,139,754,213,823,240C891.4,267,960,245,1029,224C1097.1,203,1166,181,1234,160C1302.9,139,1371,117,1406,106.7L1440,96L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
    </svg>
</section>


<section class="about-section section-padding" id="tentang">
    <div class="container">
        <div class="row">

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-12 text-center">
                        <h2 class="mb-lg-5 mb-4">Tentang Marni Wedding Organizer</h2>
                    </div>

                    <div class="col-lg-5 col-12 mb-4 mb-lg-0 order-lg-1">
                        <h3 class="mb-3">Histori Marni Wedding Organizer</h3>

                        <p><strong>Sejak awal tahun 2013</strong>, kami telah berkomitmen untuk menyediakan yang terbaik bagi pelanggan kami. Marni Wedding Organizer berdedikasi untuk memberikan layanan pernikahan yang tak terlupakan dan berkualitas tinggi.</p>

                        <p>Kami selalu berusaha untuk memastikan setiap detail acara berjalan sempurna dan memenuhi harapan Anda. Terima kasih telah mempercayakan momen istimewa Anda kepada kami.</p>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0 order-lg-2">
                        <div class="member-block">
                            <div class="member-block-image-wrap">
                                <img src="assets/img/founder.jpg" class="member-block-image img-fluid" alt="Founder Image">

                                <ul class="social-icon">
                                    <li class="social-icon-item">
                                        <a href="#" class="social-icon-link bi-twitter"></a>
                                    </li>

                                    <li class="social-icon-item">
                                        <a href="#" class="social-icon-link bi-whatsapp"></a>
                                    </li>
                                </ul>
                            </div>

                            <div class="member-block-info d-flex align-items-center">
                                <h4>Marni</h4>
                                <p class="ms-auto">Founder</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>
</section>

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#f4f1de" fill-opacity="1" d="M0,224L21.8,218.7C43.6,213,87,203,131,165.3C174.5,128,218,64,262,53.3C305.5,43,349,85,393,128C436.4,171,480,213,524,208C567.3,203,611,149,655,138.7C698.2,128,742,160,785,154.7C829.1,149,873,107,916,112C960,117,1004,171,1047,192C1090.9,213,1135,203,1178,176C1221.8,149,1265,107,1309,80C1352.7,53,1396,43,1418,37.3L1440,32L1440,320L1418.2,320C1396.4,320,1353,320,1309,320C1265.5,320,1222,320,1178,320C1134.5,320,1091,320,1047,320C1003.6,320,960,320,916,320C872.7,320,829,320,785,320C741.8,320,698,320,655,320C610.9,320,567,320,524,320C480,320,436,320,393,320C349.1,320,305,320,262,320C218.2,320,175,320,131,320C87.3,320,44,320,22,320L0,320Z"></path>
</svg>

<section class="events-section section-bg section-padding" id="paket">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
                <h2 class="mb-lg-3">Paket Layanan</h2>
            </div>
            <?php
            if ($result) :
                $count = 0;
                while ($row = mysqli_fetch_assoc($result)) :
                    $id_paket_layanan = $row['id_paket_layanan'];

                    // Fetch one photo from the foto_paket table
                    $query_foto = "SELECT * FROM foto_paket WHERE id_paket_layanan = '$id_paket_layanan' LIMIT 1";
                    $result_foto = mysqli_query($conn, $query_foto);
                    $foto = mysqli_fetch_assoc($result_foto);
            ?>

                    <?php
                    $custom_block_class = $count % 2 == 0 ? 'row custom-block mb-3 custom-block-bg' : 'row custom-block mb-3';
                    ?>
                    <div class="<?= $custom_block_class; ?>">


                        <div class="col-lg-4 col-md-8 col-12 order-1 order-lg-0">
                            <div class="custom-block-image-wrap">
                                <a href="event-detail.html">
                                    <img src="assets/img/produk/<?= $foto['foto']; ?>" class="custom-block-image img-fluid" alt="">
                                    <i class="custom-block-icon bi-link"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12 order-3 order-lg-0">
                            <div class="custom-block-info mt-2 mt-lg-0">
                                <a href="event-detail.html" class="events-title mb-3"><?= $row['nama_paket']; ?></a>
                                <p class="mb-0"><?= truncate_text($row['deskripsi'], 20); ?></p>
                                <div class="d-flex flex-wrap border-top mt-4 pt-3">
                                    <div class="mb-4 mb-lg-0">
                                        <div class="d-flex flex-wrap align-items-center mb-1">
                                            <span class="custom-block-span">Fasilitas:</span>
                                            <p class="mb-0"><?= $row['fasilitas']; ?></p>
                                        </div>
                                        <div class="d-flex flex-wrap align-items-center">
                                            <span class="custom-block-span">Harga:</span>
                                            <p class="mb-0"><?= rupiah($row['harga']); ?></p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center ms-lg-auto">
                                        <form action="?page=plg-detail-paket" method="post">
                                            <input type="hidden" name="id_paket" value="<?= $row['id_paket_layanan']; ?>">
                                            <button class="btn custom-btn" type="submit">Detail Paket</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                    $count++;
                endwhile;
            else :
                echo "Gagal mengambil data paket layanan.";
            endif;
            ?>
        </div>
    </div>
</section>



<?php
mysqli_close($conn);
?>