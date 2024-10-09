<?php include('pages/templates/plg-navbar.php');
include('pages/config/connection.php');
$query = "SELECT * FROM paket_layanan";
$result = mysqli_query($conn, $query);

$paket_layanan = [];
while ($row = $result->fetch_assoc()) {
    $paket_layanan[] = $row;
}
?>
<section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
    <div class="section-overlay"></div>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#3D405B" fill-opacity="1" d="M0,224L34.3,192C68.6,160,137,96,206,90.7C274.3,85,343,139,411,144C480,149,549,107,617,122.7C685.7,139,754,213,823,240C891.4,267,960,245,1029,224C1097.1,203,1166,181,1234,160C1302.9,139,1371,117,1406,106.7L1440,96L1440,0L1405.7,0C1371.4,0,1303,0,1234,0C1165.7,0,1097,0,1029,0C960,0,891,0,823,0C754.3,0,686,0,617,0C548.6,0,480,0,411,0C342.9,0,274,0,206,0C137.1,0,69,0,34,0L0,0Z"></path>
    </svg>
    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-12 mb-5 mb-lg-0">
                <h2 class="text-white">Selamat Datang di</h2>

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

            <div class="col-lg-6 col-12">
                <div class="ratio ratio-16x9">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/MGNgbNGOzh8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>

        </div>
    </div>

    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#ffffff" fill-opacity="1" d="M0,224L34.3,192C68.6,160,137,96,206,90.7C274.3,85,343,139,411,144C480,149,549,107,617,122.7C685.7,139,754,213,823,240C891.4,267,960,245,1029,224C1097.1,203,1166,181,1234,160C1302.9,139,1371,117,1406,106.7L1440,96L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
    </svg>
</section>


<section class="about-section section-padding" id="tentang">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-12 text-center">
                <h2 class="mb-lg-5 mb-4">Tentang Marni Wedding Organizer</h2>
            </div>

            <div class="col-lg-5 col-12 me-auto mb-4 mb-lg-0">
                <h3 class="mb-3">Histori Marni Wedding Organizer</h3>

                <p><strong>Since 1984</strong>, Marni is ranked #8 in the top 10 golf courses in the world. Marni is Bootstrap 5 HTML CSS template for golf clubs. Anyone can modify and use this layout for commercial purposes.</p>

                <p>Marni Golf Club is 100% free CSS template provided by TemplateMo website. Please tell your friends about our website. Thank you for visiting.</p>
            </div>

            <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0 mb-md-0">
                <div class="member-block">
                    <div class="member-block-image-wrap">
                        <img src="assets/img/members/portrait-young-handsome-businessman-wearing-suit-standing-with-crossed-arms-with-isolated-studio-white-background.jpg" class="member-block-image img-fluid" alt="">

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
                        <h4>Michael</h4>

                        <p class="ms-auto">Founder</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-12">
                <div class="member-block">
                    <div class="member-block-image-wrap">
                        <img src="assets/img/members/successful-asian-lady-boss-red-blazer-holding-clipboard-with-documens-pen-working-looking-happy-white-background.jpg" class="member-block-image img-fluid" alt="">

                        <ul class="social-icon">
                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link bi-linkedin"></a>
                            </li>
                            <li class="social-icon-item">
                                <a href="#" class="social-icon-link bi-twitter"></a>
                            </li>
                        </ul>
                    </div>

                    <div class="member-block-info d-flex align-items-center">
                        <h4>Sandy</h4>

                        <p class="ms-auto">Co-Founder</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>



<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#f4f1de" fill-opacity="1" d="M0,224L21.8,218.7C43.6,213,87,203,131,165.3C174.5,128,218,64,262,53.3C305.5,43,349,85,393,128C436.4,171,480,213,524,208C567.3,203,611,149,655,138.7C698.2,128,742,160,785,154.7C829.1,149,873,107,916,112C960,117,1004,171,1047,192C1090.9,213,1135,203,1178,176C1221.8,149,1265,107,1309,80C1352.7,53,1396,43,1418,37.3L1440,32L1440,320L1418.2,320C1396.4,320,1353,320,1309,320C1265.5,320,1222,320,1178,320C1134.5,320,1091,320,1047,320C1003.6,320,960,320,916,320C872.7,320,829,320,785,320C741.8,320,698,320,655,320C610.9,320,567,320,524,320C480,320,436,320,393,320C349.1,320,305,320,262,320C218.2,320,175,320,131,320C87.3,320,44,320,22,320L0,320Z"></path>
</svg>





<section class="events-section section-bg section-padding" id="paket" x-data="paket_layanan">
    <div class="container">
        <div class="row">

            <div class="col-lg-12 col-12">
                <h2 class="mb-lg-3">Paket Layanan</h2>
                <?php
                $tes = mysqli_fetch_assoc($result);
                var_dump($tes) ?>
            </div>
            <div class="row">
                <!-- <?php while ($data = mysqli_fetch_assoc($result)) : ?> -->
                <div class="row custom-block mb-3">
                    <div class="col-lg-2 col-md-4 col-12 order-2 order-md-0 order-lg-0">
                        <div class="custom-block-date-wrap d-flex d-lg-block d-md-block align-items-center mt-3 mt-lg-0 mt-md-0">
                            <h6 class="custom-block-date text-warning mb-lg-1 mb-0 me-3 me-lg-0 me-md-0"><i class="bi bi-star-fill"></i></h6>
                            <strong class="text-white">Rating 4.8/5</strong>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-8 col-12 order-1 order-lg-0">
                        <div class="custom-block-image-wrap">
                            <a href="event-detail.html">
                                <img src="assets/img/frederik-rosar-NDSZcCfnsbY-unsplash.jpg" class="custom-block-image img-fluid" alt="">
                                <!-- <img :src="`assets/img/${item.img}`" class="custom-block-image img-fluid" alt=""> -->

                                <i class="custom-block-icon bi-link"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-6 col-12 order-3 order-lg-0">
                        <div class="custom-block-info mt-2 mt-lg-0">
                            <!-- <a href="event-detail.html" class="events-title mb-3"><?= $data['nama_paket']; ?></a> -->

                            <!-- <p class="mb-0" x-text="item.deskripsi"></p> -->
                            <!-- <form action="?page=plg-detail-paket" method="post">
                                            <input type="hidden" name="id_paket_layanan" x-model="item.id_paket"> -->
                            <div class="d-flex flex-wrap border-top mt-4 pt-3">

                                <div class="mb-4 mb-lg-0">
                                    <div class="d-flex flex-wrap align-items-center mb-1">
                                        <span class="custom-block-span">Fasilitas:</span>

                                        <!-- <p class="mb-0" x-text="item.fasilitas"></p> -->
                                    </div>

                                    <div class="d-flex flex-wrap align-items-center">
                                        <span class="custom-block-span">Harga:</span>

                                        <!-- <p class="mb-0" x-text="rupiah(item.harga)"></p> -->
                                    </div>
                                </div>

                                <div class="d-flex align-items-center ms-lg-auto">
                                    <form action="?page=plg-detail-paket" method="post">
                                        <input type="hidden" name="id_paket" x-model="item.id_paket_layanan">
                                        <button class="btn custom-btn" type="submit">Beli Paket</button>
                                    </form>



                                </div>
                            </div>
                            <!-- </form> -->
                        </div>
                    </div>

                </div>

                <!-- <div class="row custom-block custom-block-bg">
                        <div class="col-lg-2 col-md-4 col-12 order-2 order-md-0 order-lg-0">
                            <div class="custom-block-date-wrap d-flex d-lg-block d-md-block align-items-center mt-3 mt-lg-0 mt-md-0">
                                <h6 class="custom-block-date mb-lg-1 mb-0 me-3 me-lg-0 me-md-0">28</h6>

                                <strong class="text-white">Feb 2048</strong>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-8 col-12 order-1 order-lg-0">
                            <div class="custom-block-image-wrap">
                                <a href="event-detail.html">
                                    <img src="assets/img/girl-taking-selfie-with-friends-golf-field.jpg" class="custom-block-image img-fluid" alt="">

                                    <i class="custom-block-icon bi-link"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12 order-3 order-lg-0">
                            <div class="custom-block-info mt-2 mt-lg-0">
                                <a href="event-detail.html" class="events-title mb-3">Group tournament activities</a>

                                <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                                <div class="d-flex flex-wrap border-top mt-4 pt-3">

                                    <div class="mb-4 mb-lg-0">
                                        <div class="d-flex flex-wrap align-items-center mb-1">
                                            <span class="custom-block-span">Location:</span>

                                            <p class="mb-0">National Center, NYC</p>
                                        </div>

                                        <div class="d-flex flex-wrap align-items-center">
                                            <span class="custom-block-span">Ticket:</span>

                                            <p class="mb-0">$350</p>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center ms-lg-auto">
                                        <a href="event-detail.html" class="btn custom-btn">Buy Ticket</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                <!-- <?php endwhile ?> -->

            </div>
        </div>
    </div>
</section>


<section class="contact-section section-padding" id="contanct">
    <div class="container">
        <div class="row">

            <div class="col-lg-5 col-12">
                <form action="#" method="post" class="custom-form contact-form" role="form">
                    <h2 class="mb-4 pb-2">Contact Marni</h2>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-floating">
                                <input type="text" name="full-name" id="full-name" class="form-control" placeholder="Full Name" required="">

                                <label for="floatingInput">Full Name</label>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-floating">
                                <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Email address" required="">

                                <label for="floatingInput">Email address</label>
                            </div>
                        </div>

                        <div class="col-lg-12 col-12">
                            <div class="form-floating">
                                <textarea class="form-control" id="message" name="message" placeholder="Describe message here"></textarea>

                                <label for="floatingTextarea">Message</label>
                            </div>

                            <button type="submit" class="form-control">Submit Form</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-6 col-12">
                <div class="contact-info mt-5">
                    <div class="contact-info-item">
                        <div class="contact-info-body">
                            <strong>London, United Kingdom</strong>

                            <p class="mt-2 mb-1">
                                <a href="tel: 010-020-0340" class="contact-link">
                                    (020)
                                    010-020-0340
                                </a>
                            </p>

                            <p class="mb-0">
                                <a href="mailto:info@company.com" class="contact-link">
                                    info@company.com
                                </a>
                            </p>
                        </div>

                        <div class="contact-info-footer">
                            <a href="#">Directions</a>
                        </div>
                    </div>

                    <img src="assets/img/WorldMap.svg" class="img-fluid" alt="">
                </div>
            </div>

        </div>
    </div>
</section>