<?php
session_start();
include('pages/config/connection.php');

function rupiah($angka)
{
    $rupiah = "Rp. " . number_format($angka, 0, ',', '.');
    return $rupiah;
}
function truncate_text($text, $word_limit)
{
    $words = explode(' ', $text);
    if (count($words) > $word_limit) {
        return implode(' ', array_slice($words, 0, $word_limit)) . '...';
    }
    return $text;
}
// Jika user sudah login, arahkan ke halaman sesuai role
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] == 1) {
        include('pages/index.php');
    } else {
        include('pages/plg-main.php');
    }
} else { ?>

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

        <title>Marni Wedding Organizer</title>

        <!-- CSS FILES -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
        <link href="assets/css/plg-catalog.css" rel="stylesheet">
        <!-- Alpine JS -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="assets/js/plg-main.js" async></script>
        <!-- midtrans -->
        <!-- <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-Zb4Bsg-fpAM4ytjm"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    </head>

    <body>
        <?php include('pages/config/routes.php') ?>

        <?php include('pages/templates/plg-footer.php') ?>
        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });

            function previewImages() {
                var preview = document.getElementById('imagePreview');
                preview.innerHTML = ''; // Clear any previous previews

                if (this.files) {
                    [].forEach.call(this.files, function(file) {
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

            document.getElementById('foto').addEventListener('change', previewImages);
        </script>
    </body>

    </html>

<?php } ?>