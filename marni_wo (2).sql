-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 06 Agu 2024 pada 09.18
-- Versi server: 8.2.0
-- Versi PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `marni_wo`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `foto_paket`
--

DROP TABLE IF EXISTS `foto_paket`;
CREATE TABLE IF NOT EXISTS `foto_paket` (
  `id_foto` int NOT NULL AUTO_INCREMENT,
  `id_paket_layanan` varchar(200) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_foto`),
  KEY `id_paket_layanan` (`id_paket_layanan`)
) ENGINE=MyISAM AUTO_INCREMENT=188 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `foto_paket`
--

INSERT INTO `foto_paket` (`id_foto`, `id_paket_layanan`, `foto`) VALUES
(187, 'PL9524', '6645b7c60a950.png'),
(186, 'PL9524', '6645b7c4a004c.png'),
(185, 'PL2294', '6645b70bc35a6.png'),
(184, 'PL2294', '6645b709e44e2.png'),
(183, 'PL2541', '6645b66f0ce8e.png'),
(182, 'PL2541', '6645b66d218e9.png'),
(181, 'PL6652', '6645b5c1180bf.png'),
(178, 'PL4968', '6645b4777cf33.png'),
(179, 'PL6864', '6645b513caa22.png'),
(180, 'PL6652', '6645b5bfbcc9f.png'),
(177, 'PL684', '6645b3b05ba40.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `paket_layanan`
--

DROP TABLE IF EXISTS `paket_layanan`;
CREATE TABLE IF NOT EXISTS `paket_layanan` (
  `id_paket_layanan` varchar(200) NOT NULL,
  `nama_paket` varchar(100) DEFAULT NULL,
  `deskripsi` text,
  `harga` int DEFAULT NULL,
  `fasilitas` text,
  `diskon` int DEFAULT NULL,
  `status_paket` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_paket_layanan`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `paket_layanan`
--

INSERT INTO `paket_layanan` (`id_paket_layanan`, `nama_paket`, `deskripsi`, `harga`, `fasilitas`, `diskon`, `status_paket`) VALUES
('PL4968', 'Paket C', 'Area Lounge Pernikahan yang Romantis dan Elegan sempurna untuk pasangan yang mencari suasana intim dan mewah. Terdapat sofa dan kursi berwarna krem muda dengan desain klasik, yang dipadukan dengan meja kopi putih di tengah. Latar belakangnya dihiasi dengan panel putih yang dihiasi dengan rangkaian bunga-bunga warna-warni yang tersusun artistik, membentuk bentuk hati di tengah. Di atas dekorasi bunga, terdapat dedaunan hijau yang membentuk lengkungan, menambah estetika alami. Di kedua sisi area duduk, terdapat dua rangkaian bunga di atas stand yang terdiri dari mawar berbagai warna seperti merah, merah muda, dan putih. Lantai ditutupi dengan karpet berwarna gelap yang kontras dengan nada terang dari perabotan dan dekorasi.', 2000000, 'Dekorasi', 0, '1'),
('PL6864', 'Paket B', 'Pelaminan Mewah dengan Sentuhan Personal sebuah pelaminan pernikahan yang mewah dan elegan, dengan latar belakang busur bunga yang penuh warna. Di atas busur bunga, terdapat tulisan nama yang elegan, yang memberikan sentuhan personal pada dekorasi. Dua kolom putih yang dibungkus kain berdiri di kedua sisi panggung, menambahkan kesan megah. Di tengah terdapat sofa putih dengan meja kecil di depan yang dihiasi dengan rangkaian bunga. Di samping sofa pusat, terdapat dua kursi emas dengan desain yang rumit. Pencahayaan yang elegan menerangi seluruh pengaturan, meningkatkan keindahannya.', 2000000, 'Dekorasi', 100000, '1'),
('PL6652', 'Paket D', 'Area Duduk Mewah dengan Sentuhan Romantis sempurna untuk menjadi bagian dari paket wedding organizer Anda. Sofa berwarna krem dengan detail emas yang mewah menjadi pusat perhatian, dikelilingi oleh dekorasi bunga-bunga indah yang diletakkan di lantai di depannya. Latar belakang sofa adalah dinding yang dihiasi dengan garis-garis vertikal emas dan hitam sebagai aksen, serta hiasan bunga yang melimpah di bagian atas dinding, menciptakan suasana yang subur dan penuh warna. Dua bukaan berbentuk lengkungan ada di kedua sisi dinding; satu tertutup dengan tirai sementara yang lain menunjukkan lebih banyak dekorasi bunga. Ada dua jenis pencahayaan yang terlihat; satu memancarkan cahaya hangat dari belakang dekorasi bunga dan yang lainnya dari lentera gantung yang menambah suasana romantis.', 2000000, 'Dekorasi', 0, '1'),
('PL684', 'Paket A', 'Pelaminan Elegan dengan Nuansa Klasik dan Modern Pelaminan ini menawarkan kombinasi sempurna antara keanggunan klasik dan sentuhan modern. Dengan latar belakang bunga-bunga segar yang mekar dalam berbagai warna, pelaminan ini menciptakan suasana yang cerah namun elegan. Lampu emas yang mewah ditempatkan secara strategis di antara bunga-bunga, memberikan cahaya hangat dan mengundang. Pengaturan tempat duduk meliputi sofa putih dan emas yang empuk untuk pengantin, dikelilingi oleh kursi-kursi yang serasi untuk tamu terhormat lainnya. Karpet merah dengan desain yang rumit mengarah ke panggung, dikelilingi oleh tanaman hijau segar di kedua sisinya. Suasana keseluruhan adalah kemewahan, menjadikannya tempat yang ideal bagi pasangan yang ingin merayakan persatuan mereka dengan cara yang megah.', 3000000, 'Dekorasi', 0, '1'),
('PL2541', 'Paket E', 'Area Resepsi Pernikahan yang Mewah dan Elegan Bayangkan memasuki ruangan yang dipenuhi dengan keanggunan dan kemewahan, di mana setiap detail telah dirancang dengan sempurna untuk hari spesial Anda. Di tengah-tengah area resepsi, terdapat pelaminan yang megah dengan latar belakang bunga-bunga yang mekar dalam warna-warna cerah, menciptakan suasana yang romantis dan menyambut. Sofa mewah berwarna krem dengan aksen emas menawarkan tempat duduk yang nyaman bagi pengantin, sementara kursi-kursi elegan disediakan untuk para tamu terhormat. Cahaya lampu gantung yang lembut menambah kehangatan pada ruangan, sementara karpet merah yang terhampar memberikan sentuhan kemegahan. Setiap elemen, dari dekorasi bunga yang indah hingga pencahayaan yang dipilih dengan cermat, telah disesuaikan untuk menciptakan pengalaman yang tak terlupakan.', 2300000, 'Dekorasi', 50000, '1'),
('PL2294', 'Paket F', 'Setting Pernikahan Romantis dengan Sentuhan Personal Bayangkan sebuah setting pernikahan yang dihiasi dengan tirai putih yang tergantung dengan indah, menciptakan suasana yang elegan dan romantis. Di tengah-tengah, terdapat tanda khusus yang menampilkan nama pasangan, dikelilingi oleh rangkaian bunga segar yang memberikan sentuhan alam yang indah. Sofa-sofa putih mewah tersusun rapi, menawarkan tempat duduk yang nyaman dan mewah bagi tamu atau pengantin. Lantai yang dihiasi dengan lebih banyak bunga dan tanaman menambah atmosfer romantis, sementara pencahayaan hangat memberikan suasana yang nyaman dan mengundang.', 2500000, 'Dekorasi', 100000, '1'),
('PL9524', 'Paket G', 'Set Tempat Duduk Mewah untuk Resepsi Pernikahan Bayangkan sebuah area resepsi pernikahan yang dihiasi dengan kemewahan dan keeleganan. Di tengah-tengah terdapat sofa putih yang mewah dengan detail emas, dikelilingi oleh dua kursi yang serasi, menciptakan pusat perhatian yang sempurna. Dekorasi bunga-bunga indah dan tanaman hijau melingkari area duduk, menambahkan suasana romantis dan menyenangkan. Latar belakang tirai putih yang dihiasi dengan hiasan bunga dan lampu menambahkan sentuhan mewah dan hangat. Lantai yang ditutupi dengan tanaman hijau dan bunga kuning melengkapi tema secara keseluruhan, menjadikan setiap momen di pelaminan tak hanya sebuah perayaan, tetapi juga sebuah karya seni yang indah.', 2700000, 'Dekorasi', 100000, '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

DROP TABLE IF EXISTS `pelanggan`;
CREATE TABLE IF NOT EXISTS `pelanggan` (
  `id_pelanggan` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_user` varchar(200) NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan','Lainnya') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `alamat` text,
  `nomor_telepon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tanggal_bergabung` date DEFAULT NULL,
  PRIMARY KEY (`id_pelanggan`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `id_user`, `nama`, `jenis_kelamin`, `alamat`, `nomor_telepon`, `email`, `tanggal_bergabung`) VALUES
('PLG6431', '6431', 'Abdullah Sajad', 'Laki-laki', 'Jln. Hos. Conroaminoto', '0764565434', 'doeljad@gmail.com', '2024-07-28'),
('PLG5912', '5912', 'M. Khovivul Anam', 'Laki-laki', 'Jln. Sukoharjo', '07623457843', 'kopip@gmail.com', '2024-07-28'),
('PLG654', '432', 'Alwan Gaul', 'Laki-laki', 'Jln. Sukoharjo Bekonang', '0123456789', 'b.sharepoint123@gmail.com', '2024-07-11'),
('PLG2506', '2506', 'bagas', 'Laki-laki', 'solo', '0897654321', 'bagas@gmail.com', '2024-07-31'),
('PLG66b1e390ea408', '6433', 'Raihan', 'Laki-laki', 'notosuman', '098754832', 'raihan@gmail.com', '2024-08-06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

DROP TABLE IF EXISTS `pemesanan`;
CREATE TABLE IF NOT EXISTS `pemesanan` (
  `id_pemesanan` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tanggal_pemesanan` timestamp NULL DEFAULT NULL,
  `id_pelanggan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tanggal_acara` date DEFAULT NULL,
  `id_paket_layanan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `kontak_pemesan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `alamat_acara` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status_pesanan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `catatan_khusus` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (`id_pemesanan`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`id_pemesanan`, `tanggal_pemesanan`, `id_pelanggan`, `tanggal_acara`, `id_paket_layanan`, `kontak_pemesan`, `alamat_acara`, `status_pesanan`, `catatan_khusus`) VALUES
('66b1e3cb648a4', '2024-08-06 01:50:19', 'PLG654', '2024-08-16', 'PL684', '0123456789', 'Jln. Slamet riyadi', '1', 'Icikiwir');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id_transaksi` int NOT NULL AUTO_INCREMENT,
  `id_pemesanan` varchar(50) DEFAULT NULL,
  `id_pembayaran_midtrans` varchar(100) DEFAULT NULL,
  `deskripsi` varchar(100) DEFAULT NULL,
  `tanggal_transaksi` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `total` int DEFAULT NULL,
  `metode` varchar(50) DEFAULT NULL,
  `status_transaksi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pemesanan`, `id_pembayaran_midtrans`, `deskripsi`, `tanggal_transaksi`, `total`, `metode`, `status_transaksi`) VALUES
(1, '66b1e3cb648a4', '6e860dd2-e8b5-4635-9ea5-4ff0bb531af1', 'Pembayaran Lunas', '2024-08-06 01:50:19', 3000000, 'bank_transfer', '2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `role` int NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=6434 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `email`, `password`, `role`) VALUES
(3, 'Marni', 'marni', 'marni@gmail.com', '$2y$10$Z/Bvh2aGSkl5gFEAEzitaOkwi6kGGGJ65GpGmcLlNmq.CDo2cFQue', 1),
(5912, 'M. Khovivul Anam', 'kopip', 'kopip@gmail.com', '$2y$10$AQq.1f4F9P/ZreeQB4rjAuttURWo5pBtFKupZ5pe9DDlSJxu0kZcG', 2),
(432, 'Alwan', 'alwan', 'b.sharepoint123@gmail.com', '$2y$10$KWW6b9RWkx0EO9GwcsF7UOBDIaewn28rVM9ol/KtEL6Jgrthxv2qu', 2),
(6431, 'Abdullah Sajad', 'doeljad', 'doeljad@gmail.com', '$2y$10$iuPlar4mekaai77pcd2Fne7UOkqDcHGxoUH4o.Y/zvuigirB6RsIi', 2),
(2506, 'bagas', 'bagas', 'bagas@gmail.com', '$2y$10$7rbThBGwKLmldz990R8XSOQiEVfOGnOJWP/AONI2P5UQz09qlWFBe', 2),
(6433, 'Raihan', 'raihan', 'raihan@gmail.com', '$2y$10$/0BsWSwc/.3YoZWrU55C3.nr8UyOhzhkMuOsh5EXnQRaPy/GyQILi', 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
