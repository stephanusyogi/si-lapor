-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2022 at 03:15 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_silapor`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(254) NOT NULL,
  `kode_kesatuan` varchar(255) NOT NULL,
  `nama_admin` varchar(255) NOT NULL,
  `nrp` varchar(255) NOT NULL,
  `notelp` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `kode_kesatuan`, `nama_admin`, `nrp`, `notelp`, `password`, `created_at`) VALUES
(1, 'POLRESTABES-SBY', 'BRIPDA AGUNG MUBAROK, S.H', '419813190', '08924613612631', '$2y$10$5NwDYZDY/VzmC4U6UofTVueuYGCfPWrk2aZtc0cUISzGsrYOJWcVm', '2022-08-24 15:15:27'),
(2, 'POLRESTABES-SBY', 'AIPDA SUPARNO, S.H', '901241248', '08562351763517', '$2y$10$.GGU/j/cktxqt2Nf5/ZXce8fZJcyIHoPPx.dtgBeMVajQ1l8G9RTS', '2022-08-24 15:16:17'),
(3, 'POLRESTA-MLG', 'BRIPTU SYARIB RAMA I.M,S.H', '1624513181', '08216576145131', '$2y$10$lBUzWvsp/RLW47f0F4LaOO8K9C7e6.VPCTFz3Mgqyo3DUiYnb3IAi', '2022-08-24 15:17:55'),
(5, 'ADMINSUPER', 'Stephanus Yogi', '215150209111014', '0817841371912', '$2y$10$3dim10S/Zmjy7Gsf.aUyu.fJZY8ezLDE1vp.sUcWlPSGvO2K548ru', '2022-08-26 02:16:52'),
(6, 'PRINCIPAL', 'Rendi Fernandito', '2174371983911', '08737123637131', '$2y$10$Sv5iGvPd6VT8ldGVj2kA6.1Y7cL9s10lEyh2FATfDWLaJ4JNz4u92', '2022-09-01 11:24:22');

-- --------------------------------------------------------

--
-- Table structure for table `tb_barangbukti`
--

CREATE TABLE `tb_barangbukti` (
  `id_barangbukti` int(255) NOT NULL,
  `id_kasus` int(255) NOT NULL,
  `id_tersangka` int(255) DEFAULT NULL,
  `kategori` enum('Ganja','Tembakau Gorilla','Hashish','Opium','Morphin','Heroin/Putaw','Kokain','Exstacy/Carnophen','Sabu','Daftar G','GOL IV','Lain-lain','Kosmetik','Jamu','GOL III') DEFAULT NULL,
  `nama_barangbukti` varchar(254) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `jumlah` float DEFAULT NULL,
  `berat` float DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `isDuplicate` tinyint(1) DEFAULT NULL,
  `id_duplicateTSK` int(255) DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_barangbukti`
--

INSERT INTO `tb_barangbukti` (`id_barangbukti`, `id_kasus`, `id_tersangka`, `kategori`, `nama_barangbukti`, `keterangan`, `jumlah`, `berat`, `satuan`, `isDuplicate`, `id_duplicateTSK`, `created_at`, `updated_at`) VALUES
(2, 2, 2, 'Sabu', 'Sabu', NULL, 20, 0, 'gram', 0, NULL, '2022-08-25', '2022-08-25'),
(3, 3, 3, 'Tembakau Gorilla', 'Tembakau Gorilla', NULL, 25, 0, 'gram', 0, NULL, '2022-08-26', '2022-08-26'),
(7, 4, 4, 'Heroin/Putaw', 'Heroin/Putaw', NULL, 20, 0, 'gram', 0, NULL, '2022-08-28', '2022-08-28'),
(8, 5, 5, 'Sabu', 'Sabu', NULL, 20, 0, 'gram', 0, NULL, '2022-08-29', '2022-08-29'),
(11, 7, 7, 'Hashish', 'Hashish', NULL, 200, 0, 'gram', 0, NULL, '2022-09-03', '2022-09-03'),
(13, 8, 9, 'Hashish', 'Hashish', NULL, 217, 0, 'gram', 0, NULL, '2022-09-03', '2022-09-03'),
(19, 9, 11, 'Morphin', 'Morphin', NULL, 25, 0, 'gram', 0, NULL, '2022-09-06', '2022-09-06'),
(20, 9, 10, 'Exstacy/Carnophen', 'Exstacy/Carnophen', 'Ekstasi', 50, 0, 'butir', 0, NULL, '2022-09-06', '2022-09-06'),
(21, 9, 12, 'Lain-lain', 'Handphone Asus', 'Alat Komunikasi', 2, 800, 'buah', 0, NULL, '2022-09-06', '2022-09-06'),
(22, 9, 11, 'Lain-lain', 'Exstacy/Carnophen', 'Ekstasi dengan jenis serbuk', 460, 0, 'gram', 0, NULL, '2022-09-06', '2022-09-06'),
(23, 7, 13, 'Hashish', NULL, NULL, NULL, NULL, NULL, 1, 7, '2022-09-06', '2022-09-06'),
(24, 7, 13, 'Morphin', 'Morphin', NULL, 28, 0, 'gram', 0, NULL, '2022-09-06', '2022-09-06'),
(25, 10, 14, 'Ganja', 'Ganja', NULL, 600, 0, 'gram', 0, NULL, '2022-09-10', '2022-09-10'),
(26, 5, 5, 'Sabu', 'Sabu', NULL, 375.4, 0, 'gram', 0, NULL, '2022-09-26', '2022-09-26'),
(27, 11, 15, 'GOL IV', 'GOL IV', 'Lexotan', 230, 0, 'gram', 0, NULL, '2022-10-18', '2022-10-18'),
(28, 11, 15, 'GOL IV', 'GOL IV', 'Pil Koplo', 10, 0, 'butir', 0, NULL, '2022-10-18', '2022-10-18'),
(29, 11, 15, 'GOL III', 'GOL III', 'Petidin', 250, 0, 'gram', 0, NULL, '2022-10-21', '2022-10-21');

-- --------------------------------------------------------

--
-- Table structure for table `tb_chat`
--

CREATE TABLE `tb_chat` (
  `id` int(11) NOT NULL,
  `incoming_msg_id` varchar(255) DEFAULT NULL,
  `outgoing_msg_id` varchar(255) DEFAULT NULL,
  `msg` varchar(255) NOT NULL,
  `isRead` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `isGroup` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_chat`
--

INSERT INTO `tb_chat` (`id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`, `isRead`, `created_at`, `isGroup`) VALUES
(28, NULL, 'POLRESTA-MLG', 'halo dari malang ke surabaya', 1, '2022-08-26 07:53:22', 1),
(29, NULL, 'POLRESTABES-SBY', 'Halo dari surabaya ke malang', 1, '2022-08-26 07:53:22', 1),
(36, NULL, 'POLRESTABES-SBY', 'TEST', 1, '2022-08-28 02:58:45', 1),
(38, 'POLRESTA-MLG', 'POLRESTABES-SBY', 'Halo polresta malang, apa kabar', 1, '2022-08-28 02:59:58', 0),
(39, 'POLRESTABES-SBY', 'POLRESTA-MLG', 'baik ndan', 1, '2022-08-28 03:01:39', 0),
(40, 'ADMINSUPER', 'POLRESTABES-SBY', 'halo admin', 1, '2022-08-31 00:48:48', 0),
(41, 'POLRESTABES-SBY', 'ADMINSUPER', 'hai jugaa', 1, '2022-08-31 00:49:39', 0),
(42, NULL, 'POLRESTABES-SBY', 'halo semuanyaaa', 1, '2022-09-25 01:54:37', 1),
(43, 'ADMINSUPER', 'POLRESTABES-SBY', 'halo superadmin', 0, '2022-09-25 01:55:42', 0),
(44, NULL, 'POLRESTABES-SBY', 'gimana apakah ada kendala?', 1, '2022-09-25 01:57:52', 1),
(45, NULL, 'POLRESTABES-SBY', 'dari surabaya sepertinya aman', 1, '2022-09-25 02:00:05', 1),
(46, NULL, 'POLRESTA-MLG', 'dari Malang juga masih belum ada kendala', 1, '2022-09-25 02:03:28', 1),
(47, NULL, 'POLRESTA-MLG', 'polres lain apa ada kendala?', 1, '2022-09-25 02:04:59', 1),
(48, 'POLRESTABES-SBY', 'POLRESTA-MLG', 'surabaya gimana? aman?', 1, '2022-09-25 02:11:09', 0),
(49, 'POLRESTA-MLG', 'POLRESTABES-SBY', 'Aman ndann', 0, '2022-09-25 02:16:56', 0),
(50, 'POLRESTABES-SBY', 'POLRESTA-MLG', 'Oke siapp', 0, '2022-09-25 02:17:35', 0),
(51, NULL, 'ADMINSUPER', 'okee kalau tidak ada kendala', 1, '2022-09-25 02:20:23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_file`
--

CREATE TABLE `tb_file` (
  `id_file` int(255) NOT NULL,
  `nrp` varchar(255) NOT NULL,
  `kode_kesatuan` varchar(255) NOT NULL,
  `ket_file` varchar(255) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `created at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_file`
--

INSERT INTO `tb_file` (`id_file`, `nrp`, `kode_kesatuan`, `ket_file`, `nama_file`, `created at`) VALUES
(2, '419813190', 'POLRESTABES-SBY', 'asdajdhka', '1661386187 - DITRESNARKOBA UNGKAP KASUS.xls', '2022-08-25 07:09:47'),
(3, '419813190', 'POLRESTABES-SBY', 'qoiwequeoiq', '1661386222 - CC-CT BLN JULI 2022.xlsx', '2022-08-25 07:10:22'),
(5, '419813190', 'POLRESTABES-SBY', 'Testing File Foto Tersangka', '1664080361 - foto-tersangka-3.jpg', '2022-09-25 11:32:41');

-- --------------------------------------------------------

--
-- Table structure for table `tb_history_login`
--

CREATE TABLE `tb_history_login` (
  `id_history` int(11) NOT NULL,
  `id_admin` int(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_history_login`
--

INSERT INTO `tb_history_login` (`id_history`, `id_admin`, `created_at`) VALUES
(75, 3, '2022-09-15 15:23:03'),
(76, 1, '2022-09-15 15:30:33'),
(77, 1, '2022-09-15 15:59:21'),
(78, 1, '2022-09-16 07:23:01'),
(79, 1, '2022-09-16 09:12:03'),
(80, 1, '2022-09-16 09:59:11'),
(81, 3, '2022-09-16 10:25:20'),
(82, 1, '2022-09-19 07:28:50'),
(83, 1, '2022-09-20 07:49:52'),
(84, 1, '2022-09-20 09:24:32'),
(85, 1, '2022-09-20 12:35:42'),
(86, 1, '2022-09-24 09:07:15'),
(87, 1, '2022-09-24 09:42:25'),
(88, 1, '2022-09-24 09:59:24'),
(89, 2, '2022-09-24 10:50:49'),
(90, 1, '2022-09-25 08:54:09'),
(91, 3, '2022-09-25 09:03:01'),
(92, 1, '2022-09-25 09:11:37'),
(93, 3, '2022-09-25 09:17:16'),
(94, 1, '2022-09-25 10:30:31'),
(95, 1, '2022-09-25 10:44:58'),
(96, 1, '2022-09-25 11:31:13'),
(97, 1, '2022-09-25 23:08:34'),
(98, 1, '2022-09-26 07:16:51'),
(99, 1, '2022-09-26 07:37:43'),
(100, 1, '2022-09-26 07:57:32'),
(101, 1, '2022-09-26 09:04:28'),
(102, 1, '2022-10-18 01:37:31'),
(103, 1, '2022-10-18 05:46:17'),
(104, 1, '2022-10-19 13:53:29'),
(105, 1, '2022-10-19 18:37:55'),
(106, 1, '2022-10-21 11:33:08'),
(107, 1, '2022-10-21 11:55:50'),
(108, 1, '2022-10-21 12:11:48'),
(109, 1, '2022-10-21 12:59:42'),
(110, 1, '2022-10-23 16:19:05'),
(111, 1, '2022-10-23 21:34:35'),
(112, 1, '2022-10-23 21:40:41'),
(113, 1, '2022-10-23 22:25:19'),
(114, 1, '2022-10-23 22:39:48'),
(115, 1, '2022-10-29 06:13:02'),
(116, 1, '2022-10-30 11:57:51'),
(117, 1, '2022-10-30 19:41:22'),
(118, 1, '2022-10-30 20:16:44'),
(119, 1, '2022-10-30 20:34:48'),
(120, 1, '2022-11-05 22:24:08'),
(121, 1, '2022-11-12 06:23:24'),
(122, 1, '2022-11-13 12:54:24'),
(123, 1, '2022-11-14 11:25:14'),
(124, 1, '2022-11-16 08:59:02');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kasus`
--

CREATE TABLE `tb_kasus` (
  `id_kasus` int(255) NOT NULL,
  `kode_kesatuan` varchar(254) NOT NULL,
  `no_laporanpolisi` varchar(255) NOT NULL,
  `pasal` text DEFAULT NULL,
  `deskripsi_waktudantkp` text DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `tkp` enum('Hotel/Villa/Kos','Ruko/Gedung/Mall/Pabrik','Tempat Umum','Pemukiman/Pondok','Diskotik/Tempat Karaoke','Terminal/Bandara/Pelabuhan','Rumah Tahanan') NOT NULL,
  `status_kasus` enum('SP3','TAHAP II','RJ','') NOT NULL,
  `ket_statusKasus` varchar(255) DEFAULT NULL,
  `date_statusKasus` date DEFAULT NULL,
  `nrp_admin` varchar(255) DEFAULT NULL,
  `isKasusMenonjol` tinyint(1) DEFAULT 0,
  `ket_pelimpahan` enum('diterima','dilimpahkan','','') DEFAULT NULL,
  `idKasusPelimpahan` int(254) DEFAULT NULL,
  `kodekesatuan_pelimpahanKe` varchar(255) DEFAULT NULL,
  `namaPolsekPelimpahan` varchar(255) DEFAULT NULL,
  `isLocked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp(),
  `tanggal_lp` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_kasus`
--

INSERT INTO `tb_kasus` (`id_kasus`, `kode_kesatuan`, `no_laporanpolisi`, `pasal`, `deskripsi_waktudantkp`, `ket`, `tkp`, `status_kasus`, `ket_statusKasus`, `date_statusKasus`, `nrp_admin`, `isKasusMenonjol`, `ket_pelimpahan`, `idKasusPelimpahan`, `kodekesatuan_pelimpahanKe`, `namaPolsekPelimpahan`, `isLocked`, `created_at`, `updated_at`, `tanggal_lp`) VALUES
(2, 'POLRESTABES-SBY', 'LP/A/4/V/2022/SPKT.SATRESNARKOBA/POLRESTABES SURABAYA/POLDA JAWA TIMUR', 'pqiruqiowe', 'asdlajl', NULL, 'Ruko/Gedung/Mall/Pabrik', 'SP3', 'spontan uhuyyy', '2022-09-12', '419813190', 0, '', 1, 'POLRESTA-MLG', 'POLSEK DAU', 1, '2022-08-25', '2022-08-25', NULL),
(3, 'POLRESTABES-SBY', 'LP/A/2/III/2022/SPKT/POLSEK GUBENG/POLRESTABES SURABAYA/POLDA JAWA TIMUR', 'iaoqioweqioe', 'asdjadjlak', NULL, 'Pemukiman/Pondok', 'RJ', 'keterangan baru', '2022-09-12', '419813190', 0, '', NULL, NULL, NULL, 1, '2022-08-26', '2022-08-26', NULL),
(4, 'POLRESTA-MLG', 'LP/A/2/IV/2022/SPKT/POLSEK GUBENG/POLRESTA MALANG/POLDA JAWA TIMUR', 'lkasjdlkajd', 'akldjakdajdk', NULL, 'Tempat Umum', '', '', '2022-09-14', '1624513181', 0, '', NULL, NULL, NULL, 1, '2022-08-28', '2022-08-28', NULL),
(5, 'POLRESTABES-SBY', 'LP/A/8/8/2022/SPKT/POLSEK WONOKROMO/POLRESTABES SURABAYA/POLDA JAWA TIMUR', 'hjgjhgj', 'hjgjhghj', NULL, 'Pemukiman/Pondok', '', NULL, NULL, '419813190', 1, '', NULL, NULL, NULL, 1, '2022-08-29', '2022-08-29', NULL),
(7, 'POLRESTA-MLG', 'LP/A/9/IV/2029/SPKT.SATRESNARKOBA/POLRESTA MALANG/POLDA JAWA TIMUR', 'qweioqweqeq', 'ahjsdgajda', NULL, 'Pemukiman/Pondok', '', NULL, NULL, '1624513181', 0, '', NULL, NULL, NULL, 1, '2022-09-03', '2022-09-03', NULL),
(8, 'POLRESTABES-SBY', 'LP/A/16/III/2022/SPKT.SATRESNARKOBA/POLRESTABES SURABAYA/POLDA JAWA TIMUR', 'asdkjadhasdu', 'asdhasdhqieu', NULL, 'Tempat Umum', '', NULL, NULL, '901241248', 0, '', NULL, NULL, NULL, 1, '2022-09-03', '2022-09-03', NULL),
(9, 'POLRESTABES-SBY', 'LP/A/12/12/2022/SPKT/POLSEK GUBENG/POLRESTABES SURABAYA/POLDA JAWA TIMUR', 'cmzxncmzbcalsjdqiwe', 'aksdhakjdahoqwejqoeiq', NULL, 'Hotel/Villa/Kos', 'RJ', '', '2022-09-14', '419813190', 0, 'dilimpahkan', 3, 'POLRESTA-MLG', 'POLSEK DAU', 1, '2022-09-06', '2022-09-06', NULL),
(10, 'POLRESTABES-SBY', 'LP/A/56/VII/2022/SPKT/POLSEK GUBENG/POLRESTABES SURABAYA/POLDA JAWA TIMUR', 'frdede', 'fttfdrdde', NULL, 'Diskotik/Tempat Karaoke', 'TAHAP II', 'ganti status dari sp3 ke tahap ii dengan pelimpahan ke polres malang', '2022-09-12', '419813190', 0, '', NULL, NULL, NULL, 1, '2022-09-10', '2022-09-10', NULL),
(11, 'POLRESTABES-SBY', 'LP/A/6/III/2022/SPKT.SATRESNARKOBA/POLRESTABES SURABAYA/POLDA JAWA TIMUR', 'jasdkjadkh', 'adnandab', NULL, 'Hotel/Villa/Kos', '', NULL, NULL, '419813190', 0, '', NULL, NULL, NULL, 1, '2022-10-18', '2022-10-18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kesatuan`
--

CREATE TABLE `tb_kesatuan` (
  `id` int(3) NOT NULL,
  `kode_kesatuan` varchar(254) NOT NULL,
  `nama` varchar(254) NOT NULL,
  `username` varchar(254) NOT NULL,
  `password` varchar(254) NOT NULL,
  `kode_lp` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_kesatuan`
--

INSERT INTO `tb_kesatuan` (`id`, `kode_kesatuan`, `nama`, `username`, `password`, `kode_lp`) VALUES
(1, 'POLDA-JATIM', 'POLDA JATIM', 'admin_poldajatim', 'ReserseNarkobaJatim_PoldaJatim@1945', 'DITRESNARKOBA/POLDA JATIM'),
(2, 'POLRESTABES-SBY', 'POLRESTABES SURABAYA', 'admin_polrestabes_sby', 'ReserseNarkobaJatim_PolrestabesSBY@1945', 'SATRESNARKOBA/POLRESTABES SURABAYA'),
(3, 'POLRESTA-SDA', 'POLRESTA SIDOARJO', 'admin_polresta_sda', 'ReserseNarkobaJatim_PolrestaSDA_@1945', 'SATRESNARKOBA/POLRESTA SIDOARJO'),
(4, 'POLRESTA-MLG', 'POLRESTA MALANG', 'admin_polresta_mlg', 'ReserseNarkobaJatim_PolrestaMLG_@1945', 'SATRESNARKOBA/POLRESTA MALANG'),
(5, 'POLRESTA-BYW', 'POLRESTA BANYUWANGI', 'admin_polresta_byw', 'ReserseNarkobaJatim_PolrestaBYW_@1945', 'SATRESNARKOBA/POLRESTA BANYUWANGI'),
(6, 'POLRES-BKL', 'POLRES BANGKALAN', 'admin_polres_bkl', 'ReserseNarkobaJatim_PolresBKL@1945', 'SATRESNARKOBA/POLRES BANGKALAN'),
(7, 'POLRES-BTU', 'POLRES BATU', 'admin_polres_btu', 'ReserseNarkobaJatim_PolresBTU@1945', 'SATRESNARKOBA/POLRES BATU'),
(8, 'POLRES-BLT', 'POLRES BLITAR', 'admin_polres_blt', 'ReserseNarkobaJatim_PolresBLT@1945', 'SATRESNARKOBA/POLRES BLITAR'),
(9, 'POLRES-BLT-KOTA', 'POLRES BLITAR KOTA', 'admin_polres_blt_kota', 'ReserseNarkobaJatim_PolresBLTKOTA@1945', 'SATRESNARKOBA/POLRES BLITAR KOTA'),
(10, 'POLRES-BJN', 'POLRES BOJONEGORO', 'admin_polres_bjn', 'ReserseNarkobaJatim_PolresBJN@1945', 'SATRESNARKOBA/POLRES BOJONEGORO'),
(11, 'POLRES-BDW', 'POLRES BONDOWOSO', 'admin_polres_bdw', 'ReserseNarkobaJatim_PolresBDW@1945', 'SATRESNARKOBA/POLRES BONDOWOSO'),
(12, 'POLRES-GSK', 'POLRES GRESIK', 'admin_polres_gsk', 'ReserseNarkobaJatim_PolresGSK@1945', 'SATRESNARKOBA/POLRES GRESIK'),
(13, 'POLRES-JMR', 'POLRES JEMBER', 'admin_polres_jmr', 'ReserseNarkobaJatim_PolresJMR@1945', 'SATRESNARKOBA/POLRES JEMBER'),
(14, 'POLRES-JBG', 'POLRES JOMBANG', 'admin_polres_jbg', 'ReserseNarkobaJatim_PolresJGB@1945', 'SATRESNARKOBA/POLRES JOMBANG'),
(15, 'POLRES-KDR', 'POLRES KEDIRI', 'admin_polres_kdr', 'ReserseNarkobaJatim_PolresKDR@1945', 'SATRESNARKOBA/POLRES KEDIRI'),
(16, 'POLRES-KDR-KOTA', 'POLRES KEDIRI KOTA', 'admin_polres_kdr_kota', 'ReserseNarkobaJatim_PolresKDRKOTA@1945', 'SATRESNARKOBA/POLRES KEDIRI KOTA'),
(17, 'POLRES-TJPERAK', 'POLRES PELABUHAN TANJUNG PERAK', 'admin_polres_tjperak', 'ReserseNarkobaJatim_PolresTJPERAK@1945', 'SATRESNARKOBA/POLRES PELABUHAN TANJUNG PERAK'),
(18, 'POLRES-LMG', 'POLRES LAMONGAN', 'admin_polres_lmg', 'ReserseNarkobaJatim_PolresLMG@1945', 'SATRESNARKOBA/POLRES LAMONGAN'),
(19, 'POLRES-LMJ', 'POLRES LUMAJANG', 'admin_polres_lmj', 'ReserseNarkobaJatim_PolresLMJ@1945', 'SATRESNARKOBA/POLRES LUMAJANG'),
(20, 'POLRES-MAD', 'POLRES MADIUN', 'admin_polres_mad', 'ReserseNarkobaJatim_PolresMAD@1945', 'SATRESNARKOBA/POLRES MADIUN'),
(21, 'POLRES-MAD-KOTA', 'POLRES MADIUN KOTA', 'admin_polres_mad_kota', 'ReserseNarkobaJatim_PolresMADKOTA@1945', 'SATRESNARKOBA/POLRES MADIUN KOTA'),
(22, 'POLRES-MGT', 'POLRES MAGETAN', 'admin_polres_mgt', 'ReserseNarkobaJatim_PolresMGT@1945', 'SATRESNARKOBA/POLRES MAGETAN'),
(23, 'POLRES-MLG', 'POLRES MALANG', 'admin_polres_mlg', 'ReserseNarkobaJatim_PolresMLG@1945', 'SATRESNARKOBA/POLRES MALANG'),
(24, 'POLRES-MJK', 'POLRES MOJOKERTO', 'admin_polres_mjk', 'ReserseNarkobaJatim_PolresMJK@1945', 'SATRESNARKOBA/POLRES MOJOKERTO'),
(25, 'POLRES-MJK-KOTA', 'POLRES MOJOKERTO KOTA', 'admin_polres_mjk_kota', 'ReserseNarkobaJatim_PolresMJKKOTA@1945', 'SATRESNARKOBA/POLRES MOJOKERTO KOTA'),
(26, 'POLRES-NJK', 'POLRES NGANJUK', 'admin_polres_njk', 'ReserseNarkobaJatim_PolresNJK@1945', 'SATRESNARKOBA/POLRES NGANJUK'),
(27, 'POLRES-NGW', 'POLRES NGAWI', 'admin_polres_ngw', 'ReserseNarkobaJatim_PolresNGW@1945', 'SATRESNARKOBA/POLRES NGAWI'),
(28, 'POLRES-PCT', 'POLRES PACITAN', 'admin_polres_pct', 'ReserseNarkobaJatim_PolresPCT@1945', 'SATRESNARKOBA/POLRES PACITAN'),
(29, 'POLRES-PMK', 'POLRES PAMEKASAN', 'admin_polres_pmk', 'ReserseNarkobaJatim_PolresPMK@1945', 'SATRESNARKOBA/POLRES PAMEKASAN'),
(30, 'POLRES-PSN', 'POLRES PASURUAN', 'admin_polres_psn', 'ReserseNarkobaJatim_PolresPSN@1945', 'SATRESNARKOBA/POLRES PASURUAN'),
(31, 'POLRES-PSN-KOTA', 'POLRES PASURUAN KOTA', 'admin_polres_psn_kota', 'ReserseNarkobaJatim_PolresPSNKOTA@1945', 'SATRESNARKOBA/POLRES PASURUAN KOTA'),
(32, 'POLRES-PNG', 'POLRES PONOROGO', 'admin_polres_png', 'ReserseNarkobaJatim_PolresPNG@1945', 'SATRESNARKOBA/POLRES PONOROGO'),
(33, 'POLRES-PBL', 'POLRES PROBOLINGGO', 'admin_polres_pbl', 'ReserseNarkobaJatim_PolresPBL@1945', 'SATRESNARKOBA/POLRES PROBOLINGGO'),
(34, 'POLRES-PBL-KOTA', 'POLRES PROBOLINGGO KOTA', 'admin_polres_pbl_kota', 'ReserseNarkobaJatim_PolresPBLKOTA@1945', 'SATRESNARKOBA/POLRES PROBOLINGGO KOTA'),
(35, 'POLRES-SPG', 'POLRES SAMPANG', 'admin_polres_spg', 'ReserseNarkobaJatim_PolresSPG@1945', 'SATRESNARKOBA/POLRES SAMPANG'),
(36, 'POLRES-SIT', 'POLRES SITUBONDO', 'admin_polres_sit', 'ReserseNarkobaJatim_PolresSIT@1945', 'SATRESNARKOBA/POLRES SITUBONDO'),
(37, 'POLRES-SMP', 'POLRES SUMENEP', 'admin_polres_smp', 'ReserseNarkobaJatim_PolresSMP@1945', 'SATRESNARKOBA/POLRES SUMENEP'),
(38, 'POLRES-TRK', 'POLRES TRENGGALEK', 'admin_polres_trk', 'ReserseNarkobaJatim_PolresTRK@1945', 'SATRESNARKOBA/POLRES TRENGGALEK'),
(39, 'POLRES-TBN', 'POLRES TUBAN', 'admin_polres_tbn', 'ReserseNarkobaJatim_PolresTBN@1945', 'SATRESNARKOBA/POLRES TUBAN'),
(40, 'POLRES-TLG', 'POLRES TULUNGAGUNG', 'admin_polres_tlg', 'ReserseNarkobaJatim_PolresTLG@1945', 'SATRESNARKOBA/POLRES TULUNGAGUNG'),
(41, 'ADMINSUPER', 'SUPER ADMIN', 'superadmin_resersenarkoba', 'SuperAdmin_ReserseNarkoba@1945', 'Admin Super'),
(42, 'PRINCIPAL', 'PRINCIPAL', 'PRINCIPAL', 'PRINCIPAL', 'PRINCIPAL');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengumuman`
--

CREATE TABLE `tb_pengumuman` (
  `id_pengumuman` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `nama_file` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pengumuman`
--

INSERT INTO `tb_pengumuman` (`id_pengumuman`, `judul`, `deskripsi`, `nama_file`, `created_at`) VALUES
(2, 'Dummy Title Pengumuman No File Download', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris finibus, nisi vitae elementum viverra, nibh lectus euismod sapien, quis scelerisque magna erat non dolor. Curabitur quis mauris velit. Cras ornare rhoncus mi. Praesent ac tellus eget orci fermentum venenatis. Ut aliquet nunc leo, eget consequat risus semper dignissim. Aliquam cursus lectus mi. Duis ultrices aliquam mi, et porttitor mi lacinia vel. Nullam lacinia mollis mi vitae fringilla. Suspendisse sapien elit, bibendum nec convallis vel, viverra vel est. Fusce aliquam quam sed augue tempor posuere. In efficitur nibh nisi, vitae ultricies lorem fermentum nec. Sed lobortis iaculis lectus finibus cursus. Sed ullamcorper vulputate ante, vel faucibus elit bibendum quis. Duis eu ligula tellus. Quisque tincidunt mi non consequat vulputate.', '', '2022-09-01 07:33:51'),
(3, 'Dummy Title With File Download', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris finibus, nisi vitae elementum viverra, nibh lectus euismod sapien, quis scelerisque magna erat non dolor. Curabitur quis mauris velit. Cras ornare rhoncus mi. Praesent ac tellus eget orci fermentum venenatis. Ut aliquet nunc leo, eget consequat risus semper dignissim. Aliquam cursus lectus mi. Duis ultrices aliquam mi, et porttitor mi lacinia vel. Nullam lacinia mollis mi vitae fringilla. Suspendisse sapien elit, bibendum nec convallis vel, viverra vel est. Fusce aliquam quam sed augue tempor posuere. In efficitur nibh nisi, vitae ultricies lorem fermentum nec. Sed lobortis iaculis lectus finibus cursus. Sed ullamcorper vulputate ante, vel faucibus elit bibendum quis. Duis eu ligula tellus. Quisque tincidunt mi non consequat vulputate.', '1661992456 - group.png', '2022-09-01 07:34:16'),
(4, 'Pengumuman Hari Ini', 'akdahkdahdjahdja', '', '2022-09-11 07:01:30'),
(5, 'Ada pengumuan baru guys', 'Berikut lampiran foto buronan bulan ini.', '1664077408 - foto-tersangka-5.jpg', '2022-09-25 10:43:28');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengumuman_tujuan`
--

CREATE TABLE `tb_pengumuman_tujuan` (
  `id_pengumuman_tujuan` int(11) NOT NULL,
  `id_pengumuman` int(255) NOT NULL,
  `kode_kesatuan` varchar(255) NOT NULL,
  `isRead` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pengumuman_tujuan`
--

INSERT INTO `tb_pengumuman_tujuan` (`id_pengumuman_tujuan`, `id_pengumuman`, `kode_kesatuan`, `isRead`) VALUES
(41, 2, 'POLDA-JATIM', 0),
(43, 2, 'POLRESTA-SDA', 0),
(44, 2, 'POLRESTA-MLG', 1),
(45, 2, 'POLRESTA-BYW', 0),
(46, 2, 'POLRES-BKL', 0),
(47, 2, 'POLRES-BTU', 0),
(48, 2, 'POLRES-BLT', 0),
(49, 2, 'POLRES-BLT-KOTA', 0),
(50, 2, 'POLRES-BJN', 0),
(51, 2, 'POLRES-BDW', 0),
(52, 2, 'POLRES-GSK', 0),
(53, 2, 'POLRES-JMR', 0),
(54, 2, 'POLRES-JBG', 0),
(55, 2, 'POLRES-KDR', 0),
(56, 2, 'POLRES-KDR-KOTA', 0),
(57, 2, 'POLRES-TJPERAK', 0),
(58, 2, 'POLRES-LMG', 0),
(59, 2, 'POLRES-LMJ', 0),
(60, 2, 'POLRES-MAD', 0),
(61, 2, 'POLRES-MAD-KOTA', 0),
(62, 2, 'POLRES-MGT', 0),
(63, 2, 'POLRES-MLG', 0),
(64, 2, 'POLRES-MJK', 0),
(65, 2, 'POLRES-MJK-KOTA', 0),
(66, 2, 'POLRES-NJK', 0),
(67, 2, 'POLRES-NGW', 0),
(68, 2, 'POLRES-PCT', 0),
(69, 2, 'POLRES-PMK', 0),
(70, 2, 'POLRES-PSN', 0),
(71, 2, 'POLRES-PSN-KOTA', 0),
(72, 2, 'POLRES-PNG', 0),
(73, 2, 'POLRES-PBL', 0),
(74, 2, 'POLRES-PBL-KOTA', 0),
(75, 2, 'POLRES-SPG', 0),
(76, 2, 'POLRES-SIT', 0),
(77, 2, 'POLRES-SMP', 0),
(78, 2, 'POLRES-TRK', 0),
(79, 2, 'POLRES-TBN', 0),
(80, 2, 'POLRES-TLG', 0),
(81, 3, 'POLDA-JATIM', 0),
(82, 3, 'POLRESTABES-SBY', 1),
(83, 3, 'POLRESTA-SDA', 0),
(84, 3, 'POLRESTA-MLG', 1),
(85, 3, 'POLRESTA-BYW', 0),
(86, 3, 'POLRES-BKL', 0),
(87, 3, 'POLRES-BTU', 0),
(88, 3, 'POLRES-BLT', 0),
(89, 3, 'POLRES-BLT-KOTA', 0),
(90, 3, 'POLRES-BJN', 0),
(91, 3, 'POLRES-BDW', 0),
(92, 3, 'POLRES-GSK', 0),
(93, 3, 'POLRES-JMR', 0),
(94, 3, 'POLRES-JBG', 0),
(95, 3, 'POLRES-KDR', 0),
(96, 3, 'POLRES-KDR-KOTA', 0),
(97, 3, 'POLRES-TJPERAK', 0),
(98, 3, 'POLRES-LMG', 0),
(99, 3, 'POLRES-LMJ', 0),
(100, 3, 'POLRES-MAD', 0),
(101, 3, 'POLRES-MAD-KOTA', 0),
(102, 3, 'POLRES-MGT', 0),
(103, 3, 'POLRES-MLG', 0),
(104, 3, 'POLRES-MJK', 0),
(105, 3, 'POLRES-MJK-KOTA', 0),
(106, 3, 'POLRES-NJK', 0),
(107, 3, 'POLRES-NGW', 0),
(108, 3, 'POLRES-PCT', 0),
(109, 3, 'POLRES-PMK', 0),
(110, 3, 'POLRES-PSN', 0),
(111, 3, 'POLRES-PSN-KOTA', 0),
(112, 3, 'POLRES-PNG', 0),
(113, 3, 'POLRES-PBL', 0),
(114, 3, 'POLRES-PBL-KOTA', 0),
(115, 3, 'POLRES-SPG', 0),
(116, 3, 'POLRES-SIT', 0),
(117, 3, 'POLRES-SMP', 0),
(118, 3, 'POLRES-TRK', 0),
(119, 3, 'POLRES-TBN', 0),
(120, 3, 'POLRES-TLG', 0),
(121, 4, 'POLDA-JATIM', 0),
(122, 4, 'POLRESTABES-SBY', 1),
(123, 4, 'POLRESTA-SDA', 0),
(124, 4, 'POLRESTA-MLG', 1),
(125, 4, 'POLRESTA-BYW', 0),
(126, 4, 'POLRES-BKL', 0),
(127, 4, 'POLRES-BTU', 0),
(128, 4, 'POLRES-BLT', 0),
(129, 4, 'POLRES-BLT-KOTA', 0),
(130, 4, 'POLRES-BJN', 0),
(131, 4, 'POLRES-BDW', 0),
(132, 4, 'POLRES-GSK', 0),
(133, 4, 'POLRES-JMR', 0),
(134, 4, 'POLRES-JBG', 0),
(135, 4, 'POLRES-KDR', 0),
(136, 4, 'POLRES-KDR-KOTA', 0),
(137, 4, 'POLRES-TJPERAK', 0),
(138, 4, 'POLRES-LMG', 0),
(139, 4, 'POLRES-LMJ', 0),
(140, 4, 'POLRES-MAD', 0),
(141, 4, 'POLRES-MAD-KOTA', 0),
(142, 4, 'POLRES-MGT', 0),
(143, 4, 'POLRES-MLG', 0),
(144, 4, 'POLRES-MJK', 0),
(145, 4, 'POLRES-MJK-KOTA', 0),
(146, 4, 'POLRES-NJK', 0),
(147, 4, 'POLRES-NGW', 0),
(148, 4, 'POLRES-PCT', 0),
(149, 4, 'POLRES-PMK', 0),
(150, 4, 'POLRES-PSN', 0),
(151, 4, 'POLRES-PSN-KOTA', 0),
(152, 4, 'POLRES-PNG', 0),
(153, 4, 'POLRES-PBL', 0),
(154, 4, 'POLRES-PBL-KOTA', 0),
(155, 4, 'POLRES-SPG', 0),
(156, 4, 'POLRES-SIT', 0),
(157, 4, 'POLRES-SMP', 0),
(158, 4, 'POLRES-TRK', 0),
(159, 4, 'POLRES-TBN', 0),
(160, 4, 'POLRES-TLG', 0),
(161, 5, 'POLDA-JATIM', 0),
(163, 5, 'POLRESTA-SDA', 0),
(164, 5, 'POLRESTA-MLG', 0),
(165, 5, 'POLRESTA-BYW', 0),
(166, 5, 'POLRES-BKL', 0),
(167, 5, 'POLRES-BTU', 0),
(168, 5, 'POLRES-BLT', 0),
(169, 5, 'POLRES-BLT-KOTA', 0),
(170, 5, 'POLRES-BJN', 0),
(171, 5, 'POLRES-BDW', 0),
(172, 5, 'POLRES-GSK', 0),
(173, 5, 'POLRES-JMR', 0),
(174, 5, 'POLRES-JBG', 0),
(175, 5, 'POLRES-KDR', 0),
(176, 5, 'POLRES-KDR-KOTA', 0),
(177, 5, 'POLRES-TJPERAK', 0),
(178, 5, 'POLRES-LMG', 0),
(179, 5, 'POLRES-LMJ', 0),
(180, 5, 'POLRES-MAD', 0),
(181, 5, 'POLRES-MAD-KOTA', 0),
(182, 5, 'POLRES-MGT', 0),
(183, 5, 'POLRES-MLG', 0),
(184, 5, 'POLRES-MJK', 0),
(185, 5, 'POLRES-MJK-KOTA', 0),
(186, 5, 'POLRES-NJK', 0),
(187, 5, 'POLRES-NGW', 0),
(188, 5, 'POLRES-PCT', 0),
(189, 5, 'POLRES-PMK', 0),
(190, 5, 'POLRES-PSN', 0),
(191, 5, 'POLRES-PSN-KOTA', 0),
(192, 5, 'POLRES-PNG', 0),
(193, 5, 'POLRES-PBL', 0),
(194, 5, 'POLRES-PBL-KOTA', 0),
(195, 5, 'POLRES-SPG', 0),
(196, 5, 'POLRES-SIT', 0),
(197, 5, 'POLRES-SMP', 0),
(198, 5, 'POLRES-TRK', 0),
(199, 5, 'POLRES-TBN', 0),
(200, 5, 'POLRES-TLG', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_permohonan_edit`
--

CREATE TABLE `tb_permohonan_edit` (
  `id_permohonan` int(11) NOT NULL,
  `kode_kesatuan` varchar(255) NOT NULL,
  `id_kasus` int(255) NOT NULL,
  `alasan_permohonan` varchar(255) NOT NULL,
  `isApproved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_temp_barangbukti`
--

CREATE TABLE `tb_temp_barangbukti` (
  `id_barangbukti` int(255) NOT NULL,
  `id_kasus` int(255) NOT NULL,
  `id_tersangka` int(255) DEFAULT NULL,
  `kategori` enum('Ganja','Tembakau Gorilla','Hashish','Opium','Morphin','Heroin/Putaw','Kokain','Exstacy/Carnophen','Sabu','Daftar G','GOL IV','Kosmetik','Lain-lain','Jamu','GOL III') DEFAULT NULL,
  `nama_barangbukti` varchar(254) DEFAULT NULL,
  `jumlah` float DEFAULT NULL,
  `berat` float DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `satuan` varchar(255) DEFAULT NULL,
  `isDuplicate` tinyint(1) DEFAULT NULL,
  `id_duplicateTSK` int(254) DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_temp_barangbukti`
--

INSERT INTO `tb_temp_barangbukti` (`id_barangbukti`, `id_kasus`, `id_tersangka`, `kategori`, `nama_barangbukti`, `jumlah`, `berat`, `keterangan`, `satuan`, `isDuplicate`, `id_duplicateTSK`, `created_at`, `updated_at`) VALUES
(9, 3, 4, 'Exstacy/Carnophen', 'Exstacy/Carnophen', 50, 0, 'Ekstasi', 'butir', 0, NULL, '2022-09-13', '2022-09-13'),
(10, 3, 5, 'Morphin', 'Morphin', 25, 0, NULL, 'gram', 0, NULL, '2022-09-13', '2022-09-13'),
(11, 3, 5, 'Lain-lain', 'Exstacy/Carnophen', 460, 0, 'Ekstasi dengan jenis serbuk', 'gram', 0, NULL, '2022-09-13', '2022-09-13'),
(12, 3, 6, 'Lain-lain', 'Handphone Asus', 2, 800, 'Alat Komunikasi', 'buah', 0, NULL, '2022-09-13', '2022-09-13');

-- --------------------------------------------------------

--
-- Table structure for table `tb_temp_kasus`
--

CREATE TABLE `tb_temp_kasus` (
  `id_kasus` int(255) NOT NULL,
  `kode_kesatuan` varchar(254) NOT NULL,
  `nama_polsek` varchar(255) DEFAULT NULL,
  `no_laporanpolisi` varchar(255) NOT NULL,
  `pasal` text DEFAULT NULL,
  `deskripsi_waktudantkp` text DEFAULT NULL,
  `ket` text DEFAULT NULL,
  `tkp` enum('Hotel/Villa/Kos','Ruko/Gedung/Mall/Pabrik','Tempat Umum','Pemukiman/Pondok','Diskotik/Tempat Karaoke','Terminal/Bandara/Pelabuhan','Rumah Tahanan') NOT NULL,
  `status_kasus` enum('SP3','Tahap II','RJ','') NOT NULL,
  `ket_statusKasus` varchar(255) DEFAULT NULL,
  `date_statusKasus` date DEFAULT NULL,
  `nrp_admin` varchar(255) DEFAULT NULL,
  `isKasusMenonjol` tinyint(1) DEFAULT NULL,
  `ket_pelimpahan` enum('diterima','dilimpahkan','','') DEFAULT NULL,
  `idkasus_pelimpahanDari` int(255) DEFAULT NULL,
  `kodekesatuan_pelimpahanDari` varchar(254) DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp(),
  `tanggal_lp` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_temp_kasus`
--

INSERT INTO `tb_temp_kasus` (`id_kasus`, `kode_kesatuan`, `nama_polsek`, `no_laporanpolisi`, `pasal`, `deskripsi_waktudantkp`, `ket`, `tkp`, `status_kasus`, `ket_statusKasus`, `date_statusKasus`, `nrp_admin`, `isKasusMenonjol`, `ket_pelimpahan`, `idkasus_pelimpahanDari`, `kodekesatuan_pelimpahanDari`, `created_at`, `updated_at`, `tanggal_lp`) VALUES
(3, 'POLRESTA-MLG', 'POLSEK DAU', 'LP/A/12/12/2022/SPKT/POLSEK GUBENG/POLRESTABES SURABAYA/POLDA JAWA TIMUR', 'cmzxncmzbcalsjdqiwe', 'aksdhakjdahoqwejqoeiq', NULL, 'Hotel/Villa/Kos', 'RJ', NULL, NULL, '1624513181', 0, 'diterima', 9, 'POLRESTABES-SBY', '2022-09-13', '2022-09-13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_temp_tersangka`
--

CREATE TABLE `tb_temp_tersangka` (
  `id_tersangka` int(255) NOT NULL,
  `id_kasus` int(255) NOT NULL,
  `nama` varchar(254) NOT NULL,
  `ttl` date DEFAULT NULL,
  `alamat` text NOT NULL,
  `nik` varchar(254) NOT NULL,
  `agama` enum('Islam','Kristen','Katolik','Hindu','Buddha','Konghucu') NOT NULL,
  `status` enum('Penanam','Produksi','Bandar','Pengedar','Pengguna') NOT NULL,
  `status_kewarganegaraan` enum('WNI','WNA','','') NOT NULL,
  `jenis_kelamin` enum('LK','PR','','') NOT NULL,
  `kategori_usia` enum('<14','15-18','19-24','25-64','>65') NOT NULL,
  `usia` varchar(255) DEFAULT NULL,
  `pendidikan` enum('Tidak Sekolah','SD','SMP','SMA','PT','Belum Diketahui') NOT NULL,
  `pekerjaan` enum('Pelajar','Mahasiswa','Swasta','Buruh/Karyawan','Petani/Nelayan','Pedagang','Wiraswasta/Pengusaha','Sopir/TukangOjek','Ikut Orang Tua','Ibu Rumah Tangga','Tidak Kerja','Notaris','TNI','POLRI','PNS','PEMBANTU','NAPI') NOT NULL,
  `file_foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_temp_tersangka`
--

INSERT INTO `tb_temp_tersangka` (`id_tersangka`, `id_kasus`, `nama`, `ttl`, `alamat`, `nik`, `agama`, `status`, `status_kewarganegaraan`, `jenis_kelamin`, `kategori_usia`, `usia`, `pendidikan`, `pekerjaan`, `file_foto`) VALUES
(4, 3, 'Tenli Boy', NULL, 'jkahdadhiuq', '92837931', 'Kristen', 'Produksi', 'WNA', 'PR', '19-24', '24', 'SMP', 'Swasta', NULL),
(5, 3, 'Celliboy', NULL, 'haksjdhakjdh', '213237616371', 'Katolik', 'Bandar', 'WNA', 'PR', '15-18', '16', 'SD', 'Mahasiswa', NULL),
(6, 3, 'Manda', NULL, 'adhadhajkd', '1231392178', 'Kristen', 'Bandar', 'WNI', 'PR', '25-64', '30', 'SD', 'Mahasiswa', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_tersangka`
--

CREATE TABLE `tb_tersangka` (
  `id_tersangka` int(255) NOT NULL,
  `id_kasus` int(255) NOT NULL,
  `nama` varchar(254) NOT NULL,
  `ttl` date DEFAULT NULL,
  `alamat` text NOT NULL,
  `nik` varchar(254) NOT NULL,
  `agama` enum('Islam','Kristen','Katolik','Hindu','Buddha','Konghucu') NOT NULL,
  `status` enum('Penanam','Produksi','Bandar','Pengedar','Pengguna') NOT NULL,
  `status_kewarganegaraan` enum('WNI','WNA','','') NOT NULL,
  `jenis_kelamin` enum('LK','PR','','') NOT NULL,
  `kategori_usia` enum('<14','15-18','19-24','25-64','>65') NOT NULL,
  `usia` varchar(254) DEFAULT NULL,
  `pendidikan` enum('Tidak Sekolah','SD','SMP','SMA','PT','Belum Diketahui') NOT NULL,
  `pekerjaan` enum('Pelajar','Mahasiswa','Swasta','Buruh/Karyawan','Petani/Nelayan','Pedagang','Wiraswasta/Pengusaha','Sopir/TukangOjek','Ikut Orang Tua','Ibu Rumah Tangga','Tidak Kerja','Notaris','TNI','POLRI','PNS','PEMBANTU','NAPI') NOT NULL,
  `file_foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_tersangka`
--

INSERT INTO `tb_tersangka` (`id_tersangka`, `id_kasus`, `nama`, `ttl`, `alamat`, `nik`, `agama`, `status`, `status_kewarganegaraan`, `jenis_kelamin`, `kategori_usia`, `usia`, `pendidikan`, `pekerjaan`, `file_foto`) VALUES
(2, 2, 'KIKI', NULL, 'dajdqioeq', '13198371893', 'Kristen', 'Produksi', 'WNA', 'PR', '19-24', '20', 'SD', 'Mahasiswa', NULL),
(3, 3, 'Candra', NULL, 'akjsdhasjdoiq', '29184192371', 'Kristen', 'Produksi', 'WNA', 'PR', '25-64', '30', 'Belum Diketahui', 'Buruh/Karyawan', NULL),
(4, 4, 'Bobi', NULL, 'ajdaiosd', '2109380931', 'Kristen', 'Produksi', 'WNA', 'PR', '15-18', '17', 'SD', 'Mahasiswa', NULL),
(5, 5, 'Boni', NULL, 'ghfgfhgf', '656756756', 'Hindu', 'Pengedar', 'WNA', 'LK', '19-24', '20', 'PT', 'TNI', NULL),
(7, 7, 'Alfonso Boy', '0000-00-00', 'jkahdasdqie', '217638173198', 'Kristen', 'Produksi', 'WNA', 'PR', '<14', '10', 'SD', 'Mahasiswa', NULL),
(9, 8, 'Ergo', NULL, 'ashdaiuyqweqeb', '2819831092381', 'Kristen', 'Produksi', 'WNA', 'PR', '15-18', '17', 'SD', 'Mahasiswa', '1663650907 - foto-tersangka-3.jpg'),
(10, 9, 'Tenli Boy', NULL, 'jkahdadhiuq', '92837931', 'Kristen', 'Produksi', 'WNA', 'PR', '19-24', '24', 'SMP', 'Swasta', '1663650884 - foto-tersangka-5.jpg'),
(11, 9, 'Celliboy', NULL, 'haksjdhakjdh', '213237616371', 'Katolik', 'Bandar', 'WNA', 'PR', '15-18', '16', 'SD', 'Mahasiswa', NULL),
(12, 9, 'Manda', NULL, 'adhadhajkd', '1231392178', 'Kristen', 'Bandar', 'WNI', 'PR', '25-64', '30', 'SD', 'Mahasiswa', NULL),
(13, 7, 'Bram', NULL, 'hjgadjhagdjhag', '26351361', 'Katolik', 'Bandar', 'WNA', 'PR', '19-24', '20', 'SMA', 'Mahasiswa', NULL),
(14, 10, 'Dono', NULL, 'vftvtfvtfvvvft', '6789097', 'Katolik', 'Bandar', 'WNI', 'LK', '19-24', '23', 'SMP', 'TNI', '1663650659 - foto-tersangka-1.jpg'),
(15, 11, 'Jimbon', '0000-00-00', 'ajhdkajhdajd', '21739831309', 'Kristen', 'Produksi', 'WNA', 'LK', '19-24', '20', 'SMP', 'Mahasiswa', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `nrp` (`nrp`),
  ADD KEY `kode_kesatuan` (`kode_kesatuan`);

--
-- Indexes for table `tb_barangbukti`
--
ALTER TABLE `tb_barangbukti`
  ADD PRIMARY KEY (`id_barangbukti`),
  ADD KEY `tb_barangbukti_ibfk_1` (`id_kasus`),
  ADD KEY `id_tersangka` (`id_tersangka`);

--
-- Indexes for table `tb_chat`
--
ALTER TABLE `tb_chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_file`
--
ALTER TABLE `tb_file`
  ADD PRIMARY KEY (`id_file`),
  ADD KEY `nrp` (`nrp`),
  ADD KEY `kode_kesatuan` (`kode_kesatuan`);

--
-- Indexes for table `tb_history_login`
--
ALTER TABLE `tb_history_login`
  ADD PRIMARY KEY (`id_history`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `tb_kasus`
--
ALTER TABLE `tb_kasus`
  ADD PRIMARY KEY (`id_kasus`),
  ADD UNIQUE KEY `no_laporanpolisi` (`no_laporanpolisi`),
  ADD KEY `kode_kesatuan` (`kode_kesatuan`),
  ADD KEY `tb_kasus_ibfk_3` (`nrp_admin`);

--
-- Indexes for table `tb_kesatuan`
--
ALTER TABLE `tb_kesatuan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_kesatuan` (`kode_kesatuan`);

--
-- Indexes for table `tb_pengumuman`
--
ALTER TABLE `tb_pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`);

--
-- Indexes for table `tb_pengumuman_tujuan`
--
ALTER TABLE `tb_pengumuman_tujuan`
  ADD PRIMARY KEY (`id_pengumuman_tujuan`),
  ADD KEY `tb_pengumuman_tujuan_ibfk_2` (`kode_kesatuan`),
  ADD KEY `id_pengumuman` (`id_pengumuman`);

--
-- Indexes for table `tb_permohonan_edit`
--
ALTER TABLE `tb_permohonan_edit`
  ADD PRIMARY KEY (`id_permohonan`),
  ADD KEY `id_kasus` (`id_kasus`);

--
-- Indexes for table `tb_temp_barangbukti`
--
ALTER TABLE `tb_temp_barangbukti`
  ADD PRIMARY KEY (`id_barangbukti`),
  ADD KEY `id_tersangka` (`id_tersangka`),
  ADD KEY `tb_temp_barangbukti_ibfk_1` (`id_kasus`);

--
-- Indexes for table `tb_temp_kasus`
--
ALTER TABLE `tb_temp_kasus`
  ADD PRIMARY KEY (`id_kasus`),
  ADD UNIQUE KEY `no_laporanpolisi` (`no_laporanpolisi`),
  ADD KEY `tb_temp_kasus_ibfk_2` (`kode_kesatuan`),
  ADD KEY `idkasus_pelimpahanDari` (`idkasus_pelimpahanDari`),
  ADD KEY `tb_temp_kasus_ibfk_4` (`nrp_admin`);

--
-- Indexes for table `tb_temp_tersangka`
--
ALTER TABLE `tb_temp_tersangka`
  ADD PRIMARY KEY (`id_tersangka`),
  ADD KEY `id_kasus` (`id_kasus`);

--
-- Indexes for table `tb_tersangka`
--
ALTER TABLE `tb_tersangka`
  ADD PRIMARY KEY (`id_tersangka`),
  ADD KEY `tb_tersangka_ibfk_1` (`id_kasus`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(254) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_barangbukti`
--
ALTER TABLE `tb_barangbukti`
  MODIFY `id_barangbukti` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tb_chat`
--
ALTER TABLE `tb_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `tb_file`
--
ALTER TABLE `tb_file`
  MODIFY `id_file` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_history_login`
--
ALTER TABLE `tb_history_login`
  MODIFY `id_history` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `tb_kasus`
--
ALTER TABLE `tb_kasus`
  MODIFY `id_kasus` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_kesatuan`
--
ALTER TABLE `tb_kesatuan`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tb_pengumuman`
--
ALTER TABLE `tb_pengumuman`
  MODIFY `id_pengumuman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_pengumuman_tujuan`
--
ALTER TABLE `tb_pengumuman_tujuan`
  MODIFY `id_pengumuman_tujuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `tb_permohonan_edit`
--
ALTER TABLE `tb_permohonan_edit`
  MODIFY `id_permohonan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_temp_barangbukti`
--
ALTER TABLE `tb_temp_barangbukti`
  MODIFY `id_barangbukti` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_temp_kasus`
--
ALTER TABLE `tb_temp_kasus`
  MODIFY `id_kasus` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_temp_tersangka`
--
ALTER TABLE `tb_temp_tersangka`
  MODIFY `id_tersangka` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_tersangka`
--
ALTER TABLE `tb_tersangka`
  MODIFY `id_tersangka` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD CONSTRAINT `tb_admin_ibfk_1` FOREIGN KEY (`kode_kesatuan`) REFERENCES `tb_kesatuan` (`kode_kesatuan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_barangbukti`
--
ALTER TABLE `tb_barangbukti`
  ADD CONSTRAINT `tb_barangbukti_ibfk_1` FOREIGN KEY (`id_kasus`) REFERENCES `tb_kasus` (`id_kasus`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_barangbukti_ibfk_2` FOREIGN KEY (`id_tersangka`) REFERENCES `tb_tersangka` (`id_tersangka`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_file`
--
ALTER TABLE `tb_file`
  ADD CONSTRAINT `tb_file_ibfk_1` FOREIGN KEY (`nrp`) REFERENCES `tb_admin` (`nrp`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_file_ibfk_2` FOREIGN KEY (`kode_kesatuan`) REFERENCES `tb_kesatuan` (`kode_kesatuan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_history_login`
--
ALTER TABLE `tb_history_login`
  ADD CONSTRAINT `tb_history_login_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `tb_admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_kasus`
--
ALTER TABLE `tb_kasus`
  ADD CONSTRAINT `tb_kasus_ibfk_2` FOREIGN KEY (`kode_kesatuan`) REFERENCES `tb_kesatuan` (`kode_kesatuan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_kasus_ibfk_3` FOREIGN KEY (`nrp_admin`) REFERENCES `tb_admin` (`nrp`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_pengumuman_tujuan`
--
ALTER TABLE `tb_pengumuman_tujuan`
  ADD CONSTRAINT `tb_pengumuman_tujuan_ibfk_2` FOREIGN KEY (`kode_kesatuan`) REFERENCES `tb_kesatuan` (`kode_kesatuan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_pengumuman_tujuan_ibfk_3` FOREIGN KEY (`id_pengumuman`) REFERENCES `tb_pengumuman` (`id_pengumuman`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_permohonan_edit`
--
ALTER TABLE `tb_permohonan_edit`
  ADD CONSTRAINT `tb_permohonan_edit_ibfk_1` FOREIGN KEY (`id_kasus`) REFERENCES `tb_kasus` (`id_kasus`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_temp_barangbukti`
--
ALTER TABLE `tb_temp_barangbukti`
  ADD CONSTRAINT `tb_temp_barangbukti_ibfk_1` FOREIGN KEY (`id_kasus`) REFERENCES `tb_temp_kasus` (`id_kasus`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_temp_barangbukti_ibfk_2` FOREIGN KEY (`id_tersangka`) REFERENCES `tb_temp_tersangka` (`id_tersangka`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_temp_kasus`
--
ALTER TABLE `tb_temp_kasus`
  ADD CONSTRAINT `tb_temp_kasus_ibfk_2` FOREIGN KEY (`kode_kesatuan`) REFERENCES `tb_kesatuan` (`kode_kesatuan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_temp_kasus_ibfk_3` FOREIGN KEY (`idkasus_pelimpahanDari`) REFERENCES `tb_kasus` (`id_kasus`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_temp_kasus_ibfk_4` FOREIGN KEY (`nrp_admin`) REFERENCES `tb_admin` (`nrp`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_temp_tersangka`
--
ALTER TABLE `tb_temp_tersangka`
  ADD CONSTRAINT `tb_temp_tersangka_ibfk_1` FOREIGN KEY (`id_kasus`) REFERENCES `tb_temp_kasus` (`id_kasus`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_tersangka`
--
ALTER TABLE `tb_tersangka`
  ADD CONSTRAINT `tb_tersangka_ibfk_1` FOREIGN KEY (`id_kasus`) REFERENCES `tb_kasus` (`id_kasus`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
