<?php
if (!isset($_GET['page'])) {
    // Jika tidak ada, tambahkan parameter page secara otomatis
    header("Location: {$_SERVER['PHP_SELF']}?page=plg-content");
    exit();
}
// else { $page = $_GET['page']; }


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>Marni - Wedding Organizer</title>

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
    <link href="assets/css/plg-catalog.css" rel="stylesheet">
    <!-- Alpine JS -->
    <!-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> -->
    <script src="assets/js/plg-main.js" async></script>
    <!-- midtrans -->
    <meta http-equiv="Permissions-Policy" content="clipboard-read=(), clipboard-write=(self)">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-cy4OpTGJPkQIvD_g"></script>
    <style>
        /* General styles */
        .cd-headline {
            display: flex;
            flex-wrap: wrap;
            /* position: relative; */
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .cd-headline span {
            flex: 1 1 auto;
            padding: 0 10px;
        }

        .cd-words-wrapper {
            display: inline-block;
            position: relative;
            /* Adjust this as needed */
            overflow: hidden;
            vertical-align: top;
        }

        .cd-words-wrapper b {
            display: block;
            position: absolute;
            width: 100%;
            text-align: center;
            opacity: 0;
            white-space: nowrap;
        }

        /* For large screens */
        @media (min-width: 992px) {
            .cd-headline {
                font-size: 2.5em;
                /* Adjust this as needed */
            }

            .cd-words-wrapper b {
                font-size: 1em;
                /* Adjust this as needed */
            }
        }

        /* For medium screens */
        @media (min-width: 768px) and (max-width: 991px) {
            .cd-headline {
                font-size: 2em;
                /* Adjust this as needed */
            }

            .cd-words-wrapper b {
                font-size: 0.9em;
                /* Adjust this as needed */
            }
        }

        /* For small screens */
        @media (max-width: 767px) {
            .cd-headline {
                font-size: 1.5em;
                /* Adjust this as needed */
            }

            .cd-words-wrapper b {
                font-size: 0.8em;
                /* Adjust this as needed */
            }
        }
    </style>
</head>

<body>
    <?php include('pages/templates/plg-navbar.php'); ?>
    <?php include('pages/config/routes.php') ?>
    <section class="contact-section section-padding" id="contact">
        <div class="container">
            <div class="row">

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
    </section>
    <?php include('pages/templates/plg-footer.php') ?>

</body>

</html>