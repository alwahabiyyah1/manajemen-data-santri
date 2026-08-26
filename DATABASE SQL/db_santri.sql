-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 18, 2026 at 03:54 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_santri`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id_admin` int NOT NULL,
  `nama_admin` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id_admin`, `nama_admin`, `username`, `password`, `email`, `created_at`, `remember_token`) VALUES
(1, 'Super Admin', 'admin', '$2y$12$RFxp/JKRcDkKBOSG95hMNe9VvkbHNBzZ4A/kxT0yNWHr9jjm4OLfi', 'admin@pesantren.ac.id', '2026-02-28 15:38:27', 'xh9UBjThnhnNcsjFQz8NX4cZCC77nKcZy7EKqRS7oJuMP648ahLvGuwgoEYN');

-- --------------------------------------------------------

--
-- Table structure for table `alamatayah`
--

CREATE TABLE `alamatayah` (
  `id_alamatayah` int NOT NULL,
  `id_ayah` int NOT NULL,
  `status_kepemilikan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provinsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kabupaten` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rw` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `kode_pos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alamatayah`
--

INSERT INTO `alamatayah` (`id_alamatayah`, `id_ayah`, `status_kepemilikan`, `provinsi`, `kabupaten`, `kecamatan`, `desa`, `rw`, `rt`, `alamat`, `kode_pos`, `created_at`, `updated_at`) VALUES
(17, 18, 'Milik Sendiri', 'JAWA TIMUR', 'KOTA SURABAYA', 'PAKAL', 'SUMBERREJO', '004', '003', 'Perum. Patra Raya Villina F 15/12 Ds.Sumber Rejo RT/RW 002/001 Kec. Pakal Kab. Kota Surabaya', '336345', '2026-06-24 08:44:54', '2026-08-16 04:48:30'),
(18, 19, 'Milik Sendiri', 'JAWA TIMUR', 'KABUPATEN PROBOLINGGO', 'SUMBERASIH', 'POHSANGIT LERES', '004', '010', 'Dsn. Kukun Ds.Pohsangitleres RT/RW 010/004 Kec. Sumberasih Kab. Probolinggo', '67251', '2026-06-24 09:11:37', '2026-06-24 09:11:37'),
(19, 20, 'Milik Sendiri', 'JAWA TIMUR', 'KABUPATEN SIDOARJO', 'PRAMBON', NULL, '002', '002', 'Ds.Temu RT/RW 002/002 Kec. Prambon Kab. Sidoarjo', '61264', '2026-06-24 09:28:35', '2026-06-24 09:28:35'),
(20, 21, 'Milik Sendiri', 'RIAU', 'KABUPATEN KUANTAN SINGINGI', 'SINGINGI HILIR', 'SUNGAI BULUH', NULL, NULL, 'SUNGAI BULUH', '29563', '2026-06-24 09:36:53', '2026-06-24 09:36:53'),
(21, 22, 'Milik Sendiri', 'JAWA TIMUR', 'KABUPATEN LAMONGAN', 'MANTUP', 'SUKOBENDU', NULL, NULL, 'Ds.Sukobendu RT/RW 002/002 Kec. Mantup Kab. Lamongan', NULL, '2026-06-24 09:55:43', '2026-06-24 09:55:43'),
(22, 23, 'Milik Sendiri', 'JAWA TIMUR', 'KABUPATEN PASURUAN', 'BEJI', 'CANGKRING MALANG', NULL, NULL, 'Ds.Cangkringmalang RT/RW 001/002 Kec. Beji Kab. Pasuruan', '67154', '2026-06-25 06:14:58', '2026-06-25 06:14:58'),
(23, 24, 'Milik Sendiri', 'JAWA TENGAH', 'KABUPATEN REMBANG', 'PAMOTAN', 'GAMBIRAN', NULL, NULL, 'Ds.Gambiran RT/RW 001/001 Kec. Pamotan Kab. Rembang', '59261', '2026-06-25 06:20:34', '2026-06-25 06:20:34'),
(24, 25, 'Milik Sendiri', 'JAWA TIMUR', 'KABUPATEN JOMBANG', 'KESAMBEN', 'POJOK KULON', NULL, NULL, 'Ds.Pojokkulon RT/RW 001/003 Kec. Kesamben Kab. Jombang', '61419', '2026-06-25 06:26:01', '2026-06-25 06:26:01'),
(25, 26, 'Milik Sendiri', 'JAWA TIMUR', 'KABUPATEN BLITAR', 'GARUM', 'POJOK', '2', '3', 'DSN. TALOK POJOK GARUM BLITAR', '66182', '2026-06-25 07:18:13', '2026-06-25 07:18:13'),
(26, 27, 'Milik Sendiri', 'BANTEN', 'KOTA TANGERANG', 'CIBODAS', 'CIBODASARI', '010', '002', 'Ds.Cibodasari RT/RW 002/010 Kec. Cibodas Kab. Kota Tangerang', '15138', '2026-06-25 07:26:27', '2026-06-25 07:26:27'),
(27, 28, 'Milik Sendiri', 'ACEH', 'KABUPATEN ACEH TENGAH', 'KEBAYAKAN', 'PINANGAN', '1', '11', 'Jalan Anggrek', '10101', '2026-07-04 18:33:25', '2026-07-04 18:33:25'),
(28, 17, 'Milik Sendiri', 'SUMATERA SELATAN', 'KABUPATEN OGAN KOMERING ULU TIMUR', 'BELITANG III', 'NUSA AGUNG', '01', '01', '-', '-', '2026-08-16 20:38:28', '2026-08-16 20:38:28');

-- --------------------------------------------------------

--
-- Table structure for table `alamatibu`
--

CREATE TABLE `alamatibu` (
  `id_alamatibu` int NOT NULL,
  `id_ibu` int NOT NULL,
  `status_kepemilikan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provinsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kabupaten` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rw` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `kode_pos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alamatibu`
--

INSERT INTO `alamatibu` (`id_alamatibu`, `id_ibu`, `status_kepemilikan`, `provinsi`, `kabupaten`, `kecamatan`, `desa`, `rw`, `rt`, `alamat`, `kode_pos`, `created_at`, `updated_at`) VALUES
(16, 17, 'Milik Sendiri', 'SUMATERA SELATAN', 'KABUPATEN OGAN KOMERING ULU TIMUR', 'BELITANG III', 'NUSA AGUNG', '01', '01', '-', '-', '2026-06-24 07:41:41', '2026-08-16 20:38:28'),
(17, 18, 'Milik Sendiri', 'JAWA TIMUR', 'KOTA SURABAYA', 'PAKAL', 'SUMBERREJO', '001', '003', 'Perum. Patra Raya Villina F 15/12 Ds.Sumber Rejo RT/RW 002/001 Kec. Pakal Kab. Kota Surabaya', '-', '2026-06-24 08:44:54', '2026-08-16 04:50:47'),
(18, 19, 'Milik Sendiri', 'JAWA TIMUR', 'KABUPATEN PROBOLINGGO', 'SUMBERASIH', 'POHSANGIT LERES', '004', '010', 'Dsn. Kukun Ds.Pohsangitleres RT/RW 010/004 Kec. Sumberasih Kab. Probolinggo', '67251', '2026-06-24 09:11:37', '2026-06-24 09:11:37'),
(19, 20, 'Milik Sendiri', 'JAWA TIMUR', 'KABUPATEN SIDOARJO', 'PRAMBON', NULL, '002', '002', 'Ds.Temu RT/RW 002/002 Kec. Prambon Kab. Sidoarjo', '61264', '2026-06-24 09:28:35', '2026-06-24 09:28:35'),
(20, 21, 'Milik Sendiri', 'RIAU', 'KABUPATEN KUANTAN SINGINGI', 'SINGINGI HILIR', 'SUNGAI BULUH', NULL, NULL, 'SUNGAI BULUH', '29563', '2026-06-24 09:36:53', '2026-06-24 09:36:53'),
(21, 22, 'Milik Sendiri', 'JAWA TIMUR', 'KABUPATEN LAMONGAN', 'MANTUP', 'SUKOBENDU', NULL, NULL, 'Ds.Sukobendu RT/RW 002/002 Kec. Mantup Kab. Lamongan', NULL, '2026-06-24 09:55:43', '2026-06-24 09:55:43'),
(22, 23, 'Milik Sendiri', 'JAWA TIMUR', 'KABUPATEN PASURUAN', 'BEJI', 'CANGKRING MALANG', NULL, NULL, 'Ds.Cangkringmalang RT/RW 001/002 Kec. Beji Kab. Pasuruan', '67154', '2026-06-25 06:14:58', '2026-06-25 06:14:58'),
(23, 24, 'Milik Sendiri', 'JAWA TENGAH', 'KABUPATEN REMBANG', 'PAMOTAN', 'GAMBIRAN', NULL, NULL, 'Ds.Gambiran RT/RW 001/001 Kec. Pamotan Kab. Rembang', '59261', '2026-06-25 06:20:34', '2026-06-25 06:20:34'),
(24, 25, 'Milik Sendiri', 'JAWA TIMUR', 'KABUPATEN JOMBANG', 'KESAMBEN', 'POJOK KULON', NULL, NULL, 'Ds.Pojokkulon RT/RW 001/003 Kec. Kesamben Kab. Jombang', '61419', '2026-06-25 06:26:01', '2026-06-25 06:26:01'),
(25, 26, 'Milik Sendiri', 'JAWA TIMUR', 'KABUPATEN BLITAR', 'GARUM', 'POJOK', '2', '3', 'DSN. TALOK POJOK GARUM BLITAR', '66182', '2026-06-25 07:18:13', '2026-06-25 07:18:13'),
(26, 27, 'Milik Sendiri', 'BANTEN', 'KOTA TANGERANG', 'CIBODAS', 'CIBODASARI', '010', '002', 'Ds.Cibodasari RT/RW 002/010 Kec. Cibodas Kab. Kota Tangerang', '15138', '2026-06-25 07:26:27', '2026-06-25 07:26:27'),
(27, 28, 'Milik Sendiri', 'ACEH', 'KABUPATEN ACEH TENGAH', 'KEBAYAKAN', 'PINANGAN', '1', '11', 'Jalan Anggrek', '10101', '2026-07-04 18:33:25', '2026-07-04 18:33:25');

-- --------------------------------------------------------

--
-- Table structure for table `alamatsantri`
--

CREATE TABLE `alamatsantri` (
  `id_alamatsantri` int NOT NULL,
  `id_santri` int NOT NULL,
  `status_mukim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_tempat_tinggal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provinsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kabupaten` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rw` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `kode_pos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jarak_ke_lembaga` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transportasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu_tempuh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `koordinat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alamatsantri`
--

INSERT INTO `alamatsantri` (`id_alamatsantri`, `id_santri`, `status_mukim`, `status_tempat_tinggal`, `provinsi`, `kabupaten`, `kecamatan`, `desa`, `rw`, `rt`, `alamat`, `kode_pos`, `jarak_ke_lembaga`, `transportasi`, `waktu_tempuh`, `koordinat`, `created_at`, `updated_at`) VALUES
(14, 20, 'Mukim', 'Asrama Pesantren', 'JAWA TIMUR', 'KABUPATEN JOMBANG', 'JOMBANG', 'TAMBAK REJO', '001', '001', 'JL. KH. ABD. WAHAB CHASBULLAH TAMBAKBERAS', '61419', '2', 'Jalan Kaki', '10', NULL, '2026-06-24 07:41:41', '2026-08-16 09:23:13'),
(15, 21, 'Mukim', 'Asrama Pesantren', 'JAWA TIMUR', 'KABUPATEN JOMBANG', 'JOMBANG', 'TAMBAK REJO', '-', '-', 'JL. KH. ABD. WAHAB CHASBULLAH TAMBAKBERAS', '-', '1', 'Jalan Kaki', '5', NULL, '2026-06-24 08:44:54', '2026-08-16 05:18:01'),
(16, 22, 'Mukim', 'Asrama Pesantren', 'JAWA TIMUR', 'KABUPATEN JOMBANG', 'JOMBANG', 'TAMBAK REJO', '3', '3', 'JL. KH. ABD. WAHAB HASBULLOH DS. TAMBAKREJO KEC. JOMBANG KAB. JOMBANG Kec. JOMBANG, Kel. TAMBAKREJO', '61419', '1', 'Jalan Kaki', '5', NULL, '2026-06-24 09:11:37', '2026-06-24 09:11:37'),
(17, 23, 'Mukim', 'Asrama Pesantren', 'JAWA TIMUR', 'KABUPATEN JOMBANG', 'JOMBANG', 'TAMBAK REJO', '3', '3', 'JL. KH. ABD. WAHAB HASBULLOH DS. TAMBAKREJO KEC. JOMBANG KAB. JOMBANG Kec. JOMBANG, Kel. TAMBAKREJO', '61419', '1', 'Jalan Kaki', '4', NULL, '2026-06-24 09:28:35', '2026-06-24 09:28:35'),
(18, 24, 'Mukim', 'Asrama Pesantren', 'JAWA TIMUR', 'KABUPATEN JOMBANG', 'JOMBANG', 'TAMBAK REJO', '3', '3', 'JL. KH. ABD. WAHAB HASBULLOH DS. TAMBAKREJO KEC. JOMBANG KAB. JOMBANG', '29563', '1', 'Jalan Kaki', '5', NULL, '2026-06-24 09:36:53', '2026-06-24 09:36:53'),
(19, 25, 'Mukim', 'Asrama Pesantren', 'JAWA TIMUR', 'KABUPATEN JOMBANG', 'JOMBANG', 'TAMBAK REJO', NULL, NULL, 'JL. KH. ABD. WAHAB CHASBULLAH TAMBAKBERAS', '61419', '1', 'Jalan Kaki', '5', NULL, '2026-06-24 09:55:43', '2026-06-24 09:55:43'),
(20, 26, 'Mukim', 'Asrama Pesantren', 'JAWA TIMUR', 'KABUPATEN JOMBANG', 'JOMBANG', 'TAMBAK REJO', NULL, NULL, 'JL. KH. ABD. WAHAB CHASBULLAH TAMBAKBERAS', NULL, '1', 'Jalan Kaki', '5', NULL, '2026-06-25 06:14:58', '2026-06-25 06:14:58'),
(21, 27, 'Mukim', 'Asrama Pesantren', 'JAWA TIMUR', 'KABUPATEN JOMBANG', 'JOMBANG', 'TAMBAK REJO', NULL, NULL, 'JL. KH. ABD. WAHAB CHASBULLAH TAMBAKBERAS', '61419', '1', 'Jalan Kaki', '5', NULL, '2026-06-25 06:20:34', '2026-06-25 06:20:34'),
(22, 28, 'Mukim', 'Asrama Pesantren', 'JAWA TIMUR', 'KABUPATEN JOMBANG', 'JOMBANG', 'TAMBAK REJO', NULL, NULL, 'JL. KH. ABD. WAHAB CHASBULLAH TAMBAKBERAS', '61419', '1', 'Jalan Kaki', '5', NULL, '2026-06-25 06:26:01', '2026-06-25 06:26:01'),
(23, 29, 'Mukim', 'Asrama Pesantren', 'JAWA TIMUR', 'KABUPATEN JOMBANG', 'JOMBANG', 'TAMBAK REJO', NULL, NULL, 'JL. KH. ABD. WAHAB CHASBULLAH TAMBAKBERAS', NULL, '1', 'Jalan Kaki', '5', NULL, '2026-06-25 07:18:13', '2026-06-25 07:18:13'),
(24, 30, 'Mukim', 'Asrama Pesantren', 'JAWA TIMUR', 'KABUPATEN JOMBANG', 'JOMBANG', 'TAMBAK REJO', '-', '-', 'JL. KH. ABD. WAHAB CHASBULLAH TAMBAKBERAS', '-', '1', 'Jalan Kaki', '5', NULL, '2026-06-25 07:26:27', '2026-08-16 05:39:33'),
(25, 31, 'Mukim', 'Asrama Pesantren', 'JAWA TIMUR', 'KABUPATEN JOMBANG', 'JOMBANG', 'TAMBAK REJO', '004', '003', 'Gang Pondok', '61419', '1', 'Jalan Kaki', '10', NULL, '2026-07-04 18:33:25', '2026-07-17 01:33:05');

-- --------------------------------------------------------

--
-- Table structure for table `alamat_wali`
--

CREATE TABLE `alamat_wali` (
  `id_alamat` int NOT NULL,
  `id_wali` int NOT NULL,
  `status_kepemilikan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provinsi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kabupaten` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kecamatan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desa` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rw` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rt` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `kode_pos` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alamat_wali`
--

INSERT INTO `alamat_wali` (`id_alamat`, `id_wali`, `status_kepemilikan`, `provinsi`, `kabupaten`, `kecamatan`, `desa`, `rw`, `rt`, `alamat`, `kode_pos`, `created_at`, `updated_at`) VALUES
(9, 10, 'Milik Sendiri', 'JAWA TIMUR', 'KOTA SURABAYA', 'PAKAL', 'SUMBERREJO', '-', '-', 'Perum. Patra Raya Villina F 15/12 Ds.Sumber Rejo RT/RW 002/001 Kec. Pakal Kab. Kota Surabaya', '-', '2026-06-24 08:44:54', '2026-08-16 04:50:47'),
(10, 11, 'Milik Sendiri', 'JAWA TIMUR', 'KABUPATEN PROBOLINGGO', 'SUMBERASIH', 'POHSANGIT LERES', '004', '010', 'Dsn. Kukun Ds.Pohsangitleres RT/RW 010/004 Kec. Sumberasih Kab. Probolinggo', '67251', '2026-06-24 09:11:37', '2026-06-24 09:11:37'),
(11, 12, 'Milik Sendiri', 'JAWA TIMUR', 'KABUPATEN SIDOARJO', 'PRAMBON', NULL, '002', '002', 'Ds.Temu RT/RW 002/002 Kec. Prambon Kab. Sidoarjo', '61264', '2026-06-24 09:28:35', '2026-06-24 09:28:35'),
(12, 13, 'Milik Sendiri', 'RIAU', 'KABUPATEN KUANTAN SINGINGI', 'SINGINGI HILIR', 'SUNGAI BULUH', NULL, NULL, 'SUNGAI BULUH', '29563', '2026-06-24 09:36:53', '2026-06-24 09:36:53'),
(13, 14, 'Milik Sendiri', 'JAWA TIMUR', 'KABUPATEN LAMONGAN', 'MANTUP', 'SUKOBENDU', NULL, NULL, 'Ds.Sukobendu RT/RW 002/002 Kec. Mantup Kab. Lamongan', NULL, '2026-06-24 09:55:43', '2026-06-24 09:55:43'),
(14, 15, 'Milik Sendiri', 'JAWA TIMUR', 'KABUPATEN PASURUAN', 'BEJI', 'CANGKRING MALANG', NULL, NULL, 'Ds.Cangkringmalang RT/RW 001/002 Kec. Beji Kab. Pasuruan', '67154', '2026-06-25 06:14:58', '2026-06-25 06:14:58'),
(15, 16, 'Milik Sendiri', 'JAWA TENGAH', 'KABUPATEN REMBANG', 'PAMOTAN', 'GAMBIRAN', NULL, NULL, 'Ds.Gambiran RT/RW 001/001 Kec. Pamotan Kab. Rembang', '59261', '2026-06-25 06:20:34', '2026-06-25 06:20:34'),
(16, 17, 'Milik Sendiri', 'JAWA TIMUR', 'KABUPATEN JOMBANG', 'KESAMBEN', 'POJOK KULON', NULL, NULL, 'Ds.Pojokkulon RT/RW 001/003 Kec. Kesamben Kab. Jombang', '61419', '2026-06-25 06:26:01', '2026-06-25 06:26:01'),
(17, 18, 'Milik Sendiri', 'JAWA TIMUR', 'KABUPATEN BLITAR', 'GARUM', 'POJOK', '2', '3', 'DSN. TALOK POJOK GARUM BLITAR', '66182', '2026-06-25 07:18:13', '2026-06-25 07:18:13'),
(18, 19, 'Milik Sendiri', 'BANTEN', 'KOTA TANGERANG', 'CIBODAS', 'CIBODASARI', '010', '002', 'Ds.Cibodasari RT/RW 002/010 Kec. Cibodas Kab. Kota Tangerang', '15138', '2026-06-25 07:26:27', '2026-06-25 07:26:27'),
(19, 20, 'Milik Sendiri', 'ACEH', 'KABUPATEN ACEH TENGAH', 'KEBAYAKAN', 'PINANGAN', '1', '11', 'Jalan Anggrek', '10101', '2026-07-04 18:33:25', '2026-07-04 18:33:25'),
(20, 9, 'Milik Sendiri', 'SUMATERA SELATAN', 'KABUPATEN OGAN KOMERING ULU TIMUR', 'BELITANG III', 'NUSA AGUNG', '01', '01', '-', '-', '2026-08-16 20:38:28', '2026-08-16 20:38:28');

-- --------------------------------------------------------

--
-- Table structure for table `dataayah`
--

CREATE TABLE `dataayah` (
  `id_ayah` int NOT NULL,
  `id_santri` int NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kewarganegaraan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `pendidikan_terakhir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan_utama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penghasilan_perbulan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dataayah`
--

INSERT INTO `dataayah` (`id_ayah`, `id_santri`, `nama_lengkap`, `status`, `kewarganegaraan`, `nik`, `tempat_lahir`, `tanggal_lahir`, `pendidikan_terakhir`, `pekerjaan_utama`, `penghasilan_perbulan`, `no_hp`, `created_at`, `updated_at`) VALUES
(17, 20, 'Nurhuda', 'Ayah Kandung (Masih Hidup)', 'WNI', '111111111111111', 'jombang', '1999-11-11', 'D4/S1', 'Politikus', '1.800.001 - 2.500.000', '111111111', '2026-06-24 07:44:01', '2026-08-16 20:38:28'),
(18, 21, 'MUHAMMAD ERWIN ANWAR', 'Ayah Kandung (Masih Hidup)', 'WNI', '3578301511810002', 'Surabaya', '1981-11-15', 'D4/S1', 'Guru/Dosen', '1.800.001 - 2.500.000', '0822222222', '2026-06-24 08:44:54', '2026-08-16 04:48:30'),
(19, 22, 'Shidiqin Hasiyanto', 'Ayah Kandung (Masih Hidup)', 'WNI', '333333333', 'Banyuwangi', '1999-11-11', 'D4/S1', 'Petani/Peternak', '1.800.001 - 2.500.000', '0822222', '2026-06-24 09:11:37', '2026-08-16 20:46:54'),
(20, 23, 'Rakhmad Hidayanto', 'Ayah Kandung (Masih Hidup)', 'WNI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-24 09:28:35', '2026-06-24 09:28:35'),
(21, 24, 'SUHERI', 'Ayah Kandung (Masih Hidup)', 'WNI', '1409080702720001', 'Blora', '1972-02-05', 'SMP/Sederajat', 'Petani/Peternak', NULL, '020202', '2026-06-24 09:36:53', '2026-07-04 17:05:35'),
(22, 25, 'Maulana Samsudin', 'Ayah Kandung (Masih Hidup)', 'WNI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-24 09:55:43', '2026-06-24 09:55:43'),
(23, 26, 'Mohammad Taufiq', 'Ayah Kandung (Masih Hidup)', 'WNI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 06:14:58', '2026-06-25 06:14:58'),
(24, 27, 'Ircham Rosyidi', 'Ayah Kandung (Masih Hidup)', 'WNI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 06:20:34', '2026-06-25 06:20:34'),
(25, 28, 'Imam Wachyudi', 'Ayah Kandung (Masih Hidup)', 'WNI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 06:26:01', '2026-06-25 06:26:01'),
(26, 29, 'HASYIM ASY\'ARI', 'Ayah Kandung (Masih Hidup)', 'WNI', '3505172011820001', 'BLITAR', '1982-11-09', 'SMA/Sederajat', 'Pedagang', NULL, NULL, '2026-06-25 07:18:13', '2026-06-25 07:18:13'),
(27, 30, 'Bambang Susilo', 'Ayah Kandung (Masih Hidup)', 'WNI', '121212121', 'jomnag', '2006-11-11', 'S2', 'Petani/Peternak', '800.001 - 1.200.000', '09090909099', '2026-06-25 07:26:27', '2026-08-16 05:38:18'),
(28, 31, 'Heri', 'Ayah Kandung (Masih Hidup)', 'WNI', '090909090', 'jombang', '1999-11-11', 'S3', 'Politikus', '4.800.001 - 6.500.000', '0987654', '2026-07-04 18:33:25', '2026-07-17 01:13:17');

-- --------------------------------------------------------

--
-- Table structure for table `dataibu`
--

CREATE TABLE `dataibu` (
  `id_ibu` int NOT NULL,
  `id_santri` int NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kewarganegaraan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `pendidikan_terakhir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan_utama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penghasilan_perbulan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dataibu`
--

INSERT INTO `dataibu` (`id_ibu`, `id_santri`, `nama_lengkap`, `status`, `kewarganegaraan`, `nik`, `tempat_lahir`, `tanggal_lahir`, `pendidikan_terakhir`, `pekerjaan_utama`, `penghasilan_perbulan`, `no_hp`, `created_at`, `updated_at`) VALUES
(17, 20, 'Nur Amanah', 'Ibu Kandung (Masih Hidup)', 'WNI', '-', 'jombang', '1999-11-11', 'D4/S1', 'PNS', '1.800.001 - 2.500.000', '-', '2026-06-24 07:41:40', '2026-08-16 20:38:28'),
(18, 21, 'HANIATIN MUTOHAROHA.MA.', 'Ibu Kandung (Masih Hidup)', 'WNI', '3578305103860002', 'Bojonegoro', '1986-04-11', 'D3', 'Guru/Dosen', '800.001 - 1.200.000', '089999999', '2026-06-24 08:44:54', '2026-08-16 04:48:30'),
(19, 22, 'YAYUK ANDIRA', 'Ibu Kandung (Masih Hidup)', 'WNI', '1111111111', 'banyuwangi', '1999-12-12', 'D4/S1', 'Pedagang', '800.001 - 1.200.000', '0899999', '2026-06-24 09:11:37', '2026-08-16 20:46:54'),
(20, 23, 'VERAWATI WIJAYA', 'Ibu Kandung (Masih Hidup)', 'WNI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-24 09:28:35', '2026-06-24 09:28:35'),
(21, 24, 'PANISIH', 'Ibu Kandung (Masih Hidup)', 'WNI', '1409085508780001', 'Bojonegoro', '1978-08-15', 'SMA/Sederajat', 'Petani/Peternak', NULL, NULL, '2026-06-24 09:36:53', '2026-07-04 17:04:37'),
(22, 25, 'Heni Hidayati', 'Ibu Kandung (Masih Hidup)', 'WNI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-24 09:55:43', '2026-06-24 09:55:43'),
(23, 26, 'Lutfiyatul Azizah', 'Ibu Kandung (Masih Hidup)', 'WNI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 06:14:58', '2026-06-25 06:14:58'),
(24, 27, 'Siti Mis Yuliatin', 'Ibu Kandung (Masih Hidup)', 'WNI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 06:20:34', '2026-06-25 06:20:34'),
(25, 28, 'SRI KANAH', 'Ibu Kandung (Masih Hidup)', 'WNI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 06:26:01', '2026-06-25 06:26:01'),
(26, 29, 'SITI MUKAROMAH', 'Ibu Kandung (Masih Hidup)', 'WNI', '3505115610840001', 'BLITAR', '1984-10-16', 'SMA/Sederajat', 'Pedagang', NULL, NULL, '2026-06-25 07:18:13', '2026-07-04 07:01:57'),
(27, 30, 'Khoiriyah', 'Ibu Kandung (Masih Hidup)', 'WNI', '111111', 'jombang', '2006-11-11', 'D4/S1', 'Nelayan', '800.001 - 1.200.000', '121212121', '2026-06-25 07:26:27', '2026-08-16 05:38:18'),
(28, 31, 'Aminah', 'Ibu Kandung (Masih Hidup)', 'WNI', '12121212', 'tuban', '1999-11-11', 'D3', 'Politikus', '3.500.001 - 4.800.000', '234568765', '2026-07-04 18:33:25', '2026-07-17 02:14:57');

-- --------------------------------------------------------

--
-- Table structure for table `datasantri`
--

CREATE TABLE `datasantri` (
  `id_santri` int NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_kk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kewarganegaraan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_saudara` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anak_ke` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cita_cita` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hobi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pembiaya_sekolah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kebutuhan_khusus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kebutuhan_disabilitas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_3x4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_kk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_kapala_keluarga` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_masuk` year DEFAULT NULL,
  `tahun_keluar` year DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `datasantri`
--

INSERT INTO `datasantri` (`id_santri`, `nama_lengkap`, `no_kk`, `nik`, `kewarganegaraan`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `jumlah_saudara`, `anak_ke`, `cita_cita`, `agama`, `no_hp`, `email`, `hobi`, `pembiaya_sekolah`, `kebutuhan_khusus`, `kebutuhan_disabilitas`, `foto_3x4`, `foto_kk`, `nama_kapala_keluarga`, `tahun_masuk`, `tahun_keluar`, `created_at`, `updated_at`) VALUES
(20, 'Ahmad Faiz Rayan Afri Cesa MD', '1811071004100003', '1811071004100003', 'WNI', 'Riau', '2010-04-10', 'Laki-laki', '3', '2', '-', 'Islam', '082282896566', NULL, NULL, 'Orang Tua', '-', '-', 'foto3x4_20_1784281002_H706xdvk.jpg', 'fotokk_20_1784281003_6907BiO9.jpg', 'Nurhuda', 2025, NULL, '2026-06-24 07:41:40', '2026-08-16 20:38:28'),
(21, 'AHMAD MUTHOHAR SANUSI', '111111111111', '3578300302090001', 'WNI', 'Gresik', '2009-02-03', 'Laki-laki', '2', '1', 'TNI/Polri', 'Islam', '081554387205', NULL, 'Olahraga', 'Orang Tua', '-', '-', 'foto3x4_21_foto3x4_1782315873_BU7yS9fD.png', 'fotokk_21_fotokk_1782315873_tpj9iKjC.jpg', 'MUHAMMAD ERWIN ANWAR', 2025, NULL, '2026-06-24 08:44:54', '2026-08-16 04:50:47'),
(22, 'AHMAD ZAYNI', '3510010101050001', '3513211010090003', NULL, 'Probolinggo', '2009-10-10', 'Laki-laki', '3', '2', 'PNS', 'Islam', '081111', NULL, 'Olahraga', 'Orang Tua', NULL, NULL, 'foto3x4_22_foto3x4_1782317473_nWLjo5Xa.png', 'fotokk_22_fotokk_1782317473_mJC7Ks43.png', 'Shidiqin Hasiyanto', 2022, NULL, '2026-06-24 09:11:37', '2026-08-16 21:24:00'),
(23, 'GHOZI ADLAN AR-RIZQI', NULL, '3515022906100004', 'WNI', 'Sidoarjo', '2010-06-29', 'Laki-laki', '1', '1', 'PNS', 'Islam', NULL, NULL, 'Olahraga', 'Orang Tua', NULL, NULL, 'foto3x4_23_foto3x4_1782318504_JdZzMoLl.png', 'fotokk_23_fotokk_1782318504_9XPLOMsT.png', NULL, 2022, NULL, '2026-06-24 09:28:35', '2026-06-24 09:28:35'),
(24, 'M. FAQIH ASYHARI', NULL, '1409082809090001', 'WNI', 'KUANTAN SINGINGI', '2009-09-28', 'Laki-laki', '2', '1', NULL, 'Islam', NULL, NULL, NULL, 'Orang Tua', NULL, NULL, 'foto3x4_24_foto3x4_1782319005_PiLyEFYg.png', 'fotokk_24_fotokk_1782319005_nG6fn0lx.png', NULL, 2025, NULL, '2026-06-24 09:36:53', '2026-06-24 09:36:53'),
(25, 'M. Taufiq Hidayat Maulana', NULL, '3524160107090003', 'WNI', 'Lamongan', '2009-06-01', 'Laki-laki', NULL, NULL, NULL, 'Islam', '085646325964', NULL, NULL, 'Orang Tua', NULL, NULL, 'foto3x4_25_foto3x4_1782320126_vkxkTdhv.png', 'fotokk_25_fotokk_1782320126_StUlBjcY.png', NULL, 2025, NULL, '2026-06-24 09:55:43', '2026-06-24 09:55:43'),
(26, 'MOHAMMAD AKMAL ABDURRAHMAN', NULL, '3514131602100001', 'WNI', 'SIDOARJO', '2010-02-16', 'Laki-laki', NULL, NULL, NULL, 'Islam', '081357776639', NULL, NULL, 'Orang Tua', NULL, NULL, 'foto3x4_26_foto3x4_1782393275_ebRNCLME.png', 'fotokk_26_fotokk_1782393277_RVjNgJ7j.png', NULL, 2025, NULL, '2026-06-25 06:14:58', '2026-06-25 06:14:58'),
(27, 'MUHAMMAD AQIL FAHMI IRCHAM', NULL, '3317071207100002', 'WNI', 'REMBANG', '2010-07-12', 'Laki-laki', NULL, NULL, NULL, 'Islam', '081325557610', NULL, NULL, 'Orang Tua', NULL, NULL, 'foto3x4_27_foto3x4_1782393628_xAQ264zp.png', 'fotokk_27_fotokk_1782393629_kfmXLQwj.png', NULL, 2025, NULL, '2026-06-25 06:20:34', '2026-06-25 06:20:34'),
(28, 'MUHAMMAD ZIYAD AFKARUL HIKAM', NULL, '3517122011090002', 'WNI', 'JOMBANG', '2009-11-20', 'Laki-laki', NULL, NULL, NULL, 'Islam', NULL, NULL, NULL, 'Orang Tua', NULL, NULL, 'foto3x4_28_foto3x4_1782393955_GT4BiOvn.png', 'fotokk_28_fotokk_1782393955_DP0W0n5F.png', NULL, 2025, NULL, '2026-06-25 06:26:01', '2026-06-25 06:26:01'),
(29, 'NEHRU MANDALA HAMKA', NULL, '3505111002100003', 'WNI', 'BLITAR', '2010-02-11', 'Laki-laki', NULL, NULL, 'Wiraswasta', 'Islam', '081217125335', NULL, 'Olahraga', 'Orang Tua', NULL, NULL, 'foto3x4_29_foto3x4_1782397086_aGnFacde.png', 'fotokk_29_fotokk_1782397086_SbrTO4zU.png', NULL, 2025, NULL, '2026-06-25 07:18:13', '2026-06-25 07:18:13'),
(30, 'Nizar Raissa Susilo', '111111111111', '3671091808100005', 'WNI', 'Grobogan', '2010-08-18', 'Laki-laki', '1', '1', '-', 'Islam', '090990909', NULL, '-', 'Orang Tua', '-', '-', 'foto3x4_30_foto3x4_1782397574_M8O8rEkN.png', 'fotokk_30_fotokk_1782397574_2HzsLSn7.png', 'Bambang Susilo', 2025, NULL, '2026-06-25 07:26:27', '2026-08-16 05:38:18'),
(31, 'rosyid fahmi', '111111', '1409082809090001', 'WNI', 'Jombang', '2000-01-11', 'Laki-laki', '1', '1', '-', 'Islam', '11111111', NULL, 'berenang', 'Orang Tua', '-', '-', 'foto3x4_31_1783215323_UEDbHz5r.png', 'fotokk_31_fotokk_1783215184_VMFrLiPl.png', 'heri', 2020, 2025, '2026-07-04 18:33:25', '2026-08-15 21:25:39');

-- --------------------------------------------------------

--
-- Table structure for table `data_wali`
--

CREATE TABLE `data_wali` (
  `id_wali` int NOT NULL,
  `id_santri` int NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kewarganegaraan` enum('WNI','WNA') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `pendidikan_terakhir` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan_utama` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penghasilan_perbulan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_wali`
--

INSERT INTO `data_wali` (`id_wali`, `id_santri`, `nama_lengkap`, `status`, `kewarganegaraan`, `nik`, `tempat_lahir`, `tanggal_lahir`, `pendidikan_terakhir`, `pekerjaan_utama`, `penghasilan_perbulan`, `no_hp`, `created_at`, `updated_at`) VALUES
(9, 20, 'Nurhuda', 'Ayah/Ibu', 'WNI', '111111111111111', 'jombang', '1999-11-11', 'D4/S1', 'PNS', '1.800.001 - 2.500.000', '111111111', '2026-06-24 07:46:12', '2026-08-16 20:38:28'),
(10, 21, 'MUHAMMAD ERWIN ANWAR', 'Lainnya', 'WNI', '3578301511810002', 'Surabaya', '1981-11-15', 'D4/S1', 'Guru/Dosen', '1.800.001 - 2.500.000', '0822222222', '2026-06-24 08:44:54', '2026-08-16 04:48:30'),
(11, 22, 'Shidiqin Hasiyanto', 'Ayah/Ibu', 'WNI', '333333333', 'Banyuwangi', '1999-11-11', 'D4/S1', 'Petani/Peternak', '1.800.001 - 2.500.000', '0822222', '2026-06-24 09:11:37', '2026-08-16 20:46:54'),
(12, 23, 'Rakhmad Hidayanto', 'Ayah/Ibu', 'WNI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-24 09:28:35', '2026-06-24 09:28:35'),
(13, 24, 'SUHERI', NULL, 'WNI', '1409080702720001', 'Blora', '1972-02-05', 'SMP/Sederajat', 'Petani/Peternak', NULL, '01010101', '2026-06-24 09:36:53', '2026-07-04 17:04:37'),
(14, 25, 'Maulana Samsudin', 'Ayah/Ibu', 'WNI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-24 09:55:43', '2026-06-24 09:55:43'),
(15, 26, 'Mohammad Taufiq', 'Ayah/Ibu', 'WNI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 06:14:58', '2026-06-25 06:14:58'),
(16, 27, 'Ircham Rosyidi', 'Ayah/Ibu', 'WNI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-06-25 06:20:34', '2026-06-25 06:20:34'),
(17, 28, 'Imam Wachyudi', NULL, 'WNI', NULL, NULL, NULL, NULL, NULL, NULL, '09876543', '2026-06-25 06:26:01', '2026-07-04 06:59:12'),
(18, 29, 'HASYIM ASY\'ARI', NULL, 'WNI', '3505172011820001', 'BLITAR', '1982-11-09', 'SMA/Sederajat', 'Pedagang', NULL, '202020', '2026-06-25 07:18:13', '2026-07-04 07:01:57'),
(19, 30, 'Bambang Susilo', 'Ayah/Ibu', 'WNI', '121212121', 'jomnag', '2006-11-11', 'S2', 'Petani/Peternak', '800.001 - 1.200.000', '09090909099', '2026-06-25 07:26:27', '2026-08-16 05:38:18'),
(20, 31, 'Heri', 'Ayah/Ibu', 'WNI', '090909090', 'jombang', '1999-11-11', 'S3', 'Politikus', '4.800.001 - 6.500.000', '0987654', '2026-07-04 18:33:25', '2026-07-17 03:23:30');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_01_01_000001_create_admins_table', 1),
(2, '2024_01_01_000002_create_wali_santri_table', 1),
(3, '2024_01_01_000003_create_santri_table', 1),
(4, '2024_01_01_000004_create_datasantri_table', 1),
(5, '2024_01_01_000005_create_dataayah_table', 1),
(6, '2024_01_01_000006_create_dataibu_table', 1),
(7, '2024_01_01_000007_create_alamatayah_table', 1),
(8, '2024_01_01_000008_create_alamatibu_table', 1),
(9, '2024_01_01_000009_create_alamatsantri_table', 1),
(10, '2026_03_05_105528_create_datawali_table', 2),
(11, '2026_03_05_105529_add_berkas_to_datasantri_table', 3),
(12, '2026_03_05_105529_create_alamatwali_table', 3),
(13, '2026_04_14_083512_add_remember_token_to_wali_santri_table', 4),
(14, '2026_05_06_102308_alter_penghasilan_to_string_on_ayah_ibu', 5),
(15, '2026_05_06_103045_alter_datawali_status_nullable', 6),
(16, '2026_05_06_103906_add_plain_password_to_wali_santri', 7),
(17, '2026_06_25_130345_add_remember_token_to_admins_table', 8),
(18, '2026_08_01_000000_add_foreign_keys_to_all_tables', 9),
(19, '2026_08_16_160333_add_is_verified_to_santri_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `santri`
--

CREATE TABLE `santri` (
  `id` int NOT NULL,
  `id_wali` int DEFAULT NULL,
  `status_data` enum('aktif','tidak aktif','lulus','keluar') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `tanggal_input` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `santri`
--

INSERT INTO `santri` (`id`, `id_wali`, `status_data`, `is_verified`, `tanggal_input`, `tanggal_update`) VALUES
(20, 20, 'aktif', 0, '2026-06-24 14:41:40', '2026-08-17 04:23:25'),
(21, 21, 'aktif', 0, '2026-06-24 15:44:54', '2026-08-17 04:41:50'),
(22, 22, 'aktif', 0, '2026-06-24 16:11:36', '2026-08-17 04:17:22'),
(23, 23, 'keluar', 0, '2026-06-24 16:28:35', '2026-07-18 10:11:10'),
(24, 24, 'aktif', 0, '2026-06-24 16:36:53', '2026-06-24 16:36:53'),
(25, 25, 'aktif', 0, '2026-06-24 16:55:43', '2026-07-25 06:28:52'),
(26, 26, 'aktif', 0, '2026-06-25 13:14:58', '2026-06-25 13:14:58'),
(27, 27, 'aktif', 0, '2026-06-25 13:20:34', '2026-06-25 13:20:34'),
(28, 28, 'aktif', 0, '2026-06-25 13:26:01', '2026-06-25 13:26:01'),
(29, 29, 'aktif', 0, '2026-06-25 14:18:13', '2026-06-25 14:18:13'),
(30, 32, 'aktif', 0, '2026-06-25 14:26:27', '2026-08-17 04:29:52'),
(31, 32, 'aktif', 1, '2026-07-05 01:33:25', '2026-08-17 05:46:23');

-- --------------------------------------------------------

--
-- Table structure for table `wali_santri`
--

CREATE TABLE `wali_santri` (
  `id_wali` int NOT NULL,
  `nama_wali` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plain_password` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wali_santri`
--

INSERT INTO `wali_santri` (`id_wali`, `nama_wali`, `no_hp`, `alamat`, `email`, `username`, `password`, `plain_password`, `created_at`, `updated_at`, `remember_token`) VALUES
(20, 'Nurhuda', '111111111', NULL, NULL, 'Nurhuda', '$2y$12$3lVh0YPvtgaWOD90U4jopOCiGvJf0gSBRQ/D/nitSHmCYwuPpJavK', '111111111', '2026-06-24 07:59:45', '2026-08-16 20:38:29', 'kllH4STuaDHWY5SD5beQfCMHhc6VWe9wOiX7vRELWwUyjWvSEF9NvImyZdUk'),
(21, 'MUHAMMAD ERWIN ANWAR', '0822222222', 'Perum. Patra Raya Villina F 15/12 Ds.Sumber Rejo RT/RW 002/001 Kec. Pakal Kab. Kota Surabaya', NULL, 'erwinanwar', '$2y$12$se1rwnUJHzvhjso8g46kc.Aquldsp9sBMQWY5U5zZW/qOBDBOg8ei', '111111', '2026-06-24 08:44:54', '2026-08-16 04:58:36', NULL),
(22, 'Shidiqin Hasiyanto', '0822222', 'Dsn. Kukun Ds.Pohsangitleres RT/RW 010/004 Kec. Sumberasih Kab. Probolinggo', NULL, 'hasiyanto', '$2y$12$Dc20Lpejcowl76o7MnKLieaG6ldpgXVvHcBzBLuQ6gPjZbhTjR.Ty', '0822222', '2026-06-24 09:11:36', '2026-08-16 20:46:55', NULL),
(23, 'Rakhmad Hidayanto', '223344', 'Ds.Temu RT/RW 002/002 Kec. Prambon Kab. Sidoarjo', NULL, 'rakhmad12', '$2y$12$j6Rpo5/XCZyRt.zyQMDgPeNOV2OeQ7WWI5DO2SeomlohJsfpLa77i', '223344', '2026-06-24 09:28:35', '2026-08-16 20:41:35', NULL),
(24, 'SUHERI', '020202', 'SUNGAI BULUH', NULL, 'suheri1644', '$2y$12$3sQQVeBeDzl/vgXwUSJ.5.r1F4YBJ19WyTyxqZIfU.oUpFMyleTgu', '020202', '2026-06-24 09:36:53', '2026-07-04 17:05:36', NULL),
(25, 'Maulana Samsudin', '', 'Ds.Sukobendu RT/RW 002/002 Kec. Mantup Kab. Lamongan', NULL, 'maulanasamsudin3967', '$2y$12$xxxOg/bvhCI6lntk4tKgVedYGBJvaqROAf4cQKF53PQpKx5ZSSZR6', 'oJZU7azJoj', '2026-06-24 09:55:43', '2026-06-24 09:55:43', NULL),
(26, 'Mohammad Taufiq', '', 'Ds.Cangkringmalang RT/RW 001/002 Kec. Beji Kab. Pasuruan', NULL, 'mohammadtaufiq8974', '$2y$12$gSImL7evF0xaSO1CuuSY1elCCEWqfKm6O0JoWtco2B5ISC0o3eNl.', 'ZaXdkmQmyi', '2026-06-25 06:14:58', '2026-06-25 06:14:58', NULL),
(27, 'Ircham Rosyidi', '', 'Ds.Gambiran RT/RW 001/001 Kec. Pamotan Kab. Rembang', NULL, 'irchamrosyidi1442', '$2y$12$X4zYkykwtGKxndBXuawfoe03GbKnTrOPmvflaB82gP3ieyglFPHwS', 'yHNmzMyZqZ', '2026-06-25 06:20:34', '2026-06-25 06:20:34', NULL),
(28, 'Imam Wachyudi', '', 'Ds.Pojokkulon RT/RW 001/003 Kec. Kesamben Kab. Jombang', NULL, 'imamwachyudi4112', '$2y$12$RmqXBSG1JQ.Fh3fFDqe1bediqmu/zOw5MN9BD4jJBsA0VSiu7ADB.', 'ueeNmrUTp7', '2026-06-25 06:26:01', '2026-06-25 06:26:01', NULL),
(29, 'HASYIM ASY\'ARI', '', 'DSN. TALOK POJOK GARUM BLITAR', NULL, 'hasyimasyari2761', '$2y$12$uxzBANOjp.I2eLJ3lwtrv.DtCJ60rqBJ9PnobuGEZD.II37SB0xRa', 'zYQssL4RnX', '2026-06-25 07:18:13', '2026-06-25 07:18:13', NULL),
(30, 'Bambang Susilo', '08123456', 'Ds.Cibodasari RT/RW 002/010 Kec. Cibodas Kab. Kota Tangerang', NULL, 'bambangsusilo7020', '$2y$12$IFdOcxAoVXt2MNz/yUqCqedS5p7SiFPiVtVCzgIJsr51zRuKhRgam', '123456', '2026-06-25 07:26:27', '2026-07-04 06:49:03', NULL),
(32, 'Heri', '0987654', 'Jalan Anggrek', NULL, 'heri6935', '$2y$12$.c4cnsV/wt7.HnmEqvjydOjp5f2dXoPu9SMYe4af04m7DXmzS7dcS', '0987654', '2026-07-04 18:33:25', '2026-07-17 01:13:18', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `admins_username_unique` (`username`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `alamatayah`
--
ALTER TABLE `alamatayah`
  ADD PRIMARY KEY (`id_alamatayah`),
  ADD KEY `alamatayah_id_ayah_index` (`id_ayah`);

--
-- Indexes for table `alamatibu`
--
ALTER TABLE `alamatibu`
  ADD PRIMARY KEY (`id_alamatibu`),
  ADD KEY `alamatibu_id_ibu_index` (`id_ibu`);

--
-- Indexes for table `alamatsantri`
--
ALTER TABLE `alamatsantri`
  ADD PRIMARY KEY (`id_alamatsantri`),
  ADD KEY `alamatsantri_id_santri_index` (`id_santri`);

--
-- Indexes for table `alamat_wali`
--
ALTER TABLE `alamat_wali`
  ADD PRIMARY KEY (`id_alamat`),
  ADD KEY `alamat_wali_id_wali_foreign` (`id_wali`);

--
-- Indexes for table `dataayah`
--
ALTER TABLE `dataayah`
  ADD PRIMARY KEY (`id_ayah`),
  ADD KEY `dataayah_id_santri_index` (`id_santri`);

--
-- Indexes for table `dataibu`
--
ALTER TABLE `dataibu`
  ADD PRIMARY KEY (`id_ibu`),
  ADD KEY `dataibu_id_santri_index` (`id_santri`);

--
-- Indexes for table `datasantri`
--
ALTER TABLE `datasantri`
  ADD PRIMARY KEY (`id_santri`);

--
-- Indexes for table `data_wali`
--
ALTER TABLE `data_wali`
  ADD PRIMARY KEY (`id_wali`),
  ADD KEY `data_wali_id_santri_foreign` (`id_santri`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `santri`
--
ALTER TABLE `santri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `santri_id_wali_index` (`id_wali`);

--
-- Indexes for table `wali_santri`
--
ALTER TABLE `wali_santri`
  ADD PRIMARY KEY (`id_wali`),
  ADD UNIQUE KEY `wali_santri_username_unique` (`username`),
  ADD UNIQUE KEY `wali_santri_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `alamatayah`
--
ALTER TABLE `alamatayah`
  MODIFY `id_alamatayah` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `alamatibu`
--
ALTER TABLE `alamatibu`
  MODIFY `id_alamatibu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `alamatsantri`
--
ALTER TABLE `alamatsantri`
  MODIFY `id_alamatsantri` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `alamat_wali`
--
ALTER TABLE `alamat_wali`
  MODIFY `id_alamat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `dataayah`
--
ALTER TABLE `dataayah`
  MODIFY `id_ayah` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `dataibu`
--
ALTER TABLE `dataibu`
  MODIFY `id_ibu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `data_wali`
--
ALTER TABLE `data_wali`
  MODIFY `id_wali` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `santri`
--
ALTER TABLE `santri`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `wali_santri`
--
ALTER TABLE `wali_santri`
  MODIFY `id_wali` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alamatayah`
--
ALTER TABLE `alamatayah`
  ADD CONSTRAINT `alamatayah_id_ayah_foreign` FOREIGN KEY (`id_ayah`) REFERENCES `dataayah` (`id_ayah`) ON DELETE CASCADE;

--
-- Constraints for table `alamatibu`
--
ALTER TABLE `alamatibu`
  ADD CONSTRAINT `alamatibu_id_ibu_foreign` FOREIGN KEY (`id_ibu`) REFERENCES `dataibu` (`id_ibu`) ON DELETE CASCADE;

--
-- Constraints for table `alamatsantri`
--
ALTER TABLE `alamatsantri`
  ADD CONSTRAINT `alamatsantri_id_santri_foreign` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `alamat_wali`
--
ALTER TABLE `alamat_wali`
  ADD CONSTRAINT `alamat_wali_id_wali_foreign` FOREIGN KEY (`id_wali`) REFERENCES `data_wali` (`id_wali`) ON DELETE CASCADE;

--
-- Constraints for table `dataayah`
--
ALTER TABLE `dataayah`
  ADD CONSTRAINT `dataayah_id_santri_foreign` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dataibu`
--
ALTER TABLE `dataibu`
  ADD CONSTRAINT `dataibu_id_santri_foreign` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `datasantri`
--
ALTER TABLE `datasantri`
  ADD CONSTRAINT `datasantri_id_santri_foreign` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `data_wali`
--
ALTER TABLE `data_wali`
  ADD CONSTRAINT `data_wali_id_santri_foreign` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `santri`
--
ALTER TABLE `santri`
  ADD CONSTRAINT `santri_id_wali_foreign` FOREIGN KEY (`id_wali`) REFERENCES `wali_santri` (`id_wali`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
