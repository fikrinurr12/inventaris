-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 06, 2025 at 01:33 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sukun`
--
CREATE DATABASE IF NOT EXISTS `db_sukun` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `db_sukun`;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_barangs`
--

CREATE TABLE `data_barangs` (
  `id` bigint UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_id` bigint UNSIGNED DEFAULT NULL,
  `spesifikasi` text COLLATE utf8mb4_unicode_ci,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `harga_terakhir` int NOT NULL DEFAULT '0',
  `stok_total_baik` int NOT NULL DEFAULT '0',
  `stok_total_rusak` int NOT NULL DEFAULT '0',
  `stok_tersedia` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_barangs`
--

INSERT INTO `data_barangs` (`id`, `kode`, `foto`, `nama`, `merk`, `kategori_id`, `spesifikasi`, `keterangan`, `harga_terakhir`, `stok_total_baik`, `stok_total_rusak`, `stok_tersedia`, `created_at`, `updated_at`) VALUES
(2, 'ALT9221', 'assets/img/upload/1737862618.png', 'Sapu', 'Wings', 2, 'Tidak Ada', 'Stok Gudang', 50000, 60, 0, 60, '2025-01-25 20:36:58', '2025-02-02 23:09:56'),
(3, 'ngj473', 'https://via.placeholder.com/640x480.png/0099cc?text=maiores', 'dolor', 'Kovacek-Fisher', 1, 'Dolore aut ratione harum omnis.', 'efjwerkvwe', 3223, 16, 22, 20, NULL, '2025-02-04 21:33:27'),
(4, 'kni367', 'https://via.placeholder.com/640x480.png/002244?text=debitis', 'error', 'Beahan-Rolfson', 2, 'Quia sit dolore iste sunt.', 'Quisquam est doloremque fugiat aut. Exercitationem aut id ipsum. Excepturi ratione molestiae porro itaque et. Aut voluptatum sint praesentium vero accusantium corrupti.', 318, 62, 7, 16, NULL, NULL),
(5, 'czs350', 'https://via.placeholder.com/640x480.png/0099aa?text=corporis', 'sequi', 'Mraz-Haley', 1, 'Totam et veniam animi.', 'Aut corporis alias eos sunt est esse. Quia et recusandae ut incidunt perspiciatis id. Quaerat nam dolorum iusto ratione ut quia. Quas id qui quidem sit praesentium.', 480, 11, 5, 48, NULL, NULL),
(7, 'glx115', 'https://via.placeholder.com/640x480.png/00bbbb?text=esse', 'voluptate', 'Kling-Blanda', 2, 'Autem temporibus pariatur odio in dolorem consequuntur ducimus.', 'Aut qui totam aliquam ut quasi. Dolore pariatur aliquid sed aliquid. Excepturi aperiam molestiae et consequuntur.', 470, 61, 9, 72, NULL, NULL),
(8, 'via388', 'https://via.placeholder.com/640x480.png/005588?text=non', 'aut', 'Wiegand-Schiller', 5, 'Ipsum impedit impedit optio facilis sit non laudantium.', 'Consequatur pariatur quam consequatur. Temporibus explicabo aperiam sunt impedit enim distinctio cupiditate. Error modi odit quia qui accusantium quas quas.', 351, 71, 2, 20, NULL, NULL),
(9, 'cqm019', 'https://via.placeholder.com/640x480.png/0077ff?text=possimus', 'architecto', 'Mante Ltd', 5, 'Maxime ipsum ipsum quod placeat pariatur.', 'Ea maiores rem occaecati ea in ipsum. Ea dolores in non omnis. Perspiciatis occaecati hic vel minima. Consequuntur consequatur provident quia repudiandae.', 939, 95, 2, 88, NULL, NULL),
(10, 'rjx257', 'https://via.placeholder.com/640x480.png/00ee11?text=impedit', 'rerum', 'Mosciski-Schoen', 2, 'Ut harum et ex aut rem omnis.', 'Sunt et expedita nihil eveniet odit illum. Est cum ut vitae qui a distinctio. Alias ad voluptatem voluptate.', 788, 70, 2, 3, NULL, NULL),
(11, 'xfy120', 'https://via.placeholder.com/640x480.png/00ccdd?text=recusandae', 'quasi', 'Marvin, Reichel and Murazik', 1, 'Dolorem ab ut et adipisci deserunt.', 'Assumenda et neque occaecati et occaecati hic. Non nam possimus rerum nostrum. Vero totam hic repellendus eius alias. Nesciunt iure labore eveniet nisi eligendi sed autem. Voluptatem sed eveniet labore saepe quos.', 729, 43, 6, 32, NULL, NULL),
(12, 'lpo711', 'https://via.placeholder.com/640x480.png/00cc88?text=voluptatem', 'ad', 'Sporer, Mertz and Brekke', 2, 'Eius non sapiente rem maiores dignissimos illo.', 'Repudiandae molestiae nobis rerum vitae. Occaecati voluptatum nesciunt laborum deserunt ut vero asperiores. Quidem consequatur animi molestiae et. Est enim voluptas totam et et debitis repudiandae.', 502, 91, 1, 84, NULL, NULL),
(13, 'rja658', 'https://via.placeholder.com/640x480.png/0088ee?text=ipsa', 'ex', 'Sauer, Hodkiewicz and King', 5, 'Omnis repudiandae et eum.', 'Esse quia ut consequuntur ab corrupti officia id. Iste consequatur sint aspernatur blanditiis laboriosam. Magni assumenda asperiores aperiam quod quasi omnis. Blanditiis autem hic et distinctio quia necessitatibus ut.', 574, 69, 10, 24, NULL, '2025-02-01 18:06:34'),
(14, 'cbq757', 'https://via.placeholder.com/640x480.png/000088?text=quo', 'molestias', 'Luettgen, Thompson and Collier', 3, 'Maxime labore rerum fugit dolores unde eveniet aut eveniet.', 'Et quis sint voluptate at qui omnis. Porro libero ut nihil a dolore vero. Ipsum nostrum rerum dolor. Aut sint molestias et nisi.', 184, 13, 1, 12, NULL, NULL),
(15, 'fpz193', 'https://via.placeholder.com/640x480.png/0055ff?text=dignissimos', 'nihil', 'Mohr, Grant and Berge', 2, 'Illo iusto voluptatem dignissimos incidunt recusandae.', 'Ipsa minima natus minus modi est. Magnam ea vero labore ipsam quia. Necessitatibus nesciunt eligendi necessitatibus et praesentium.', 228, 60, 7, 54, NULL, NULL),
(16, 'fiy608', 'https://via.placeholder.com/640x480.png/005555?text=reprehenderit', 'quia', 'Lind Group', 2, 'Et qui occaecati eveniet reprehenderit corporis neque vel debitis.', 'Iusto quo perspiciatis ex dolor. At soluta omnis velit perferendis consequuntur. Sint quisquam voluptatem enim velit quis nihil. Dolorum impedit eum ea quo et et.', 871, 89, 7, 5, NULL, NULL),
(17, 's', 'assets/img/upload/1738116100.png', '2', 'd', 2, '2', NULL, 0, 0, 0, 0, '2025-01-28 19:01:40', '2025-01-28 19:01:40'),
(18, 'ALT24442', 'assets/img/upload/1738136890.jpg', 'Vacum Cleaner', 'Samsung', 1, 'Super Sedot', 'Stok Gudang', 750000, 6, 2, 6, '2025-01-28 23:53:11', '2025-02-02 21:42:33'),
(19, 'TV98292', 'assets/img/upload/1738542927.png', 'TV SAMSUNG 50 Inch', 'Samsung', 1, 'Berkualitas', 'Stok Gudang', 4500000, 50, 0, 45, '2025-02-02 17:35:27', '2025-02-02 18:00:31');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategoris`
--

CREATE TABLE `kategoris` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoris`
--

INSERT INTO `kategoris` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Elektronik', '2025-01-25 18:17:14', '2025-01-25 18:17:14'),
(2, 'Alat', '2025-01-25 20:36:29', '2025-01-25 20:36:29'),
(3, 'Furniture', '2025-01-25 22:01:37', '2025-01-25 22:01:37'),
(4, 'Hardware', '2025-01-25 22:01:46', '2025-01-25 22:01:46'),
(5, 'Software', '2025-01-25 22:01:50', '2025-01-25 22:01:50'),
(7, 'Tools', '2025-01-28 18:38:33', '2025-01-28 18:38:33');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_26_003325_create_permission_tables', 1),
(5, '2025_01_21_041110_create_data_barangs_table', 2),
(7, '2025_01_21_062419_create_peminjamans_table', 2),
(8, '2025_01_21_064728_create_pengembalians_table', 2),
(9, '2025_01_22_075809_create_kategoris_table', 2),
(10, '2025_01_21_055113_create_pembelians_table', 3),
(11, '2025_02_03_013624_penyesuaian_stok', 4),
(12, '2025_02_03_013625_penyesuaian_stok', 5);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(3, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 5),
(1, 'App\\Models\\User', 8),
(1, 'App\\Models\\User', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembelians`
--

CREATE TABLE `pembelians` (
  `id` bigint UNSIGNED NOT NULL,
  `no_transaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_transaksi` date NOT NULL,
  `no_invoice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `harga` int NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembelians`
--

INSERT INTO `pembelians` (`id`, `no_transaksi`, `tgl_transaksi`, `no_invoice`, `kode_barang`, `jumlah`, `harga`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'TRX1737863228', '2025-01-26', 'INV1737863228', 'ALT9221', 90, 50000, 'Stok Gudang', '2025-01-25 20:47:08', '2025-01-25 20:47:08'),
(2, 'TRX1737863362', '2025-01-26', 'INV1737863362', 'ALT9221', 90, 50000, 'Stok Gudang', '2025-01-25 20:49:22', '2025-01-25 20:49:22'),
(3, 'TRX1738113499', '2001-10-23', 'INV1738113499', 'ALT9221', 5, 53000, 'Stok Gudang', '2025-01-28 18:18:20', '2025-01-28 18:18:20'),
(4, 'TRX1738118356', '0001-02-13', '1234345676', 'ngj473', 123213321, 3223, 'efjwerkvwe', '2025-01-28 19:39:16', '2025-01-28 19:39:16'),
(5, 'TRX1738133284', '2222-02-21', '553319888213332', 'ALT9221', 19, 20000, 'Cuci Gudang', '2025-01-28 23:48:04', '2025-01-28 23:48:04'),
(6, 'TRX1738133658', '2025-01-24', '8923789128', 'ALT24442', 10, 750000, 'Stok Gudang', '2025-01-28 23:54:18', '2025-01-28 23:54:18'),
(7, 'TRX1738197513', '0321-02-23', '90127289142198', 'ALT9221', 15, 50000, 'Stok Gudang', '2025-01-29 17:38:33', '2025-01-29 17:38:33'),
(8, 'TRX1738543074', '2025-02-03', '812937813213', 'TV98292', 50, 4500000, 'Stok Gudang', '2025-02-02 17:37:54', '2025-02-02 17:37:54');

-- --------------------------------------------------------

--
-- Table structure for table `peminjamans`
--

CREATE TABLE `peminjamans` (
  `id` bigint UNSIGNED NOT NULL,
  `id_peminjam` int NOT NULL,
  `no_transaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_peminjam` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_peminjaman` date NOT NULL,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `sisa_pinjam` int NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peminjamans`
--

INSERT INTO `peminjamans` (`id`, `id_peminjam`, `no_transaksi`, `nama_peminjam`, `tgl_peminjaman`, `kode_barang`, `nama_barang`, `jumlah`, `sisa_pinjam`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 3, 'TRX1738125515', 'User', '0002-02-02', 'ngj473', 'dolor', 21, 21, 'test', '2025-01-28 21:38:35', '2025-01-28 21:38:35'),
(2, 3, 'TRX1738125551', 'User', '0002-02-02', 'ngj473', 'dolor', 21, 21, 'test', '2025-01-28 21:39:11', '2025-01-28 21:39:11'),
(3, 3, 'TRX1738125575', 'User', '0002-02-02', 'ngj473', 'dolor', 21, 21, 'test', '2025-01-28 21:39:35', '2025-01-28 21:39:35'),
(4, 7, 'TRX1738125655', 'jono', '0002-02-22', 'ALT9221', 'Sapu', 50, 50, '2', '2025-01-28 21:40:55', '2025-01-28 21:40:55'),
(5, 5, 'TRX1738132574', 'fikri', '2025-01-29', 'ALT9221', 'Sapu', 20, 20, 'Stok Gudang', '2025-01-28 23:36:14', '2025-01-28 23:36:14'),
(6, 5, 'TRX1738133713', 'fikri', '2025-01-29', 'ALT24442', 'Vacum Cleaner', 5, 5, 'Peminjaman', '2025-01-28 23:55:13', '2025-01-28 23:55:13'),
(7, 7, 'TRX1738134068', 'jono', '2025-01-29', 'ALT24442', 'Vacum Cleaner', 3, 3, 'Peminjaman', '2025-01-29 00:01:08', '2025-01-29 00:01:08'),
(8, 5, 'TRX1738200106', 'fikri', '2025-01-30', 'ALT9221', 'Sapu', 10, 10, 'Ditolak', '2025-01-29 18:21:46', '2025-01-29 18:33:34'),
(9, 5, 'TRX1738200906', 'fikri', '0020-02-20', 'ALT9221', 'Sapu', 10, 0, 'Disetujui', '2025-01-29 18:35:06', '2025-01-31 23:42:14'),
(10, 5, 'TRX1738201010', 'fikri', '0099-09-09', 'ALT9221', 'Sapu', 9, -9, 'Disetujui', '2025-01-29 18:36:50', '2025-02-01 18:09:02'),
(11, 5, 'TRX1738201195', 'fikri', '0008-09-08', 'ALT9221', 'Sapu', 9, 9, 'Disetujui', '2025-01-29 18:39:55', '2025-01-29 18:40:35'),
(12, 5, 'TRX1738201394', 'fikri', '0023-07-21', 'ALT9221', 'Sapu', 10, 10, 'Dibatalkan', '2025-01-29 18:43:14', '2025-01-29 19:03:27'),
(13, 5, 'TRX1738203997', 'fikri', '2025-01-30', 'ALT24442', 'Vacum Cleaner', 1, 1, 'Dibatalkan', '2025-01-29 19:26:37', '2025-01-29 19:26:55'),
(14, 5, 'TRX1738204168', 'fikri', '2025-01-30', 'ALT9221', 'Sapu', 5, 5, 'Dibatalkan', '2025-01-29 19:29:28', '2025-01-29 19:29:54'),
(15, 5, 'TRX1738206653', 'fikri', '2025-01-30', 'ALT24442', 'Vacum Cleaner', 1, 0, 'Disetujui', '2025-01-29 20:10:53', '2025-02-01 19:03:59'),
(16, 5, 'TRX1738369660', 'fikri123', '0922-08-12', 'ALT9221', 'Sapu', 20, 20, 'Dibatalkan', '2025-01-31 17:27:40', '2025-01-31 17:29:35'),
(17, 5, 'TRX1738369790', 'fikri123', '0008-08-09', 'ALT9221', 'Sapu', 5, 5, 'Ditolak: Kurangi Jumlah Peminjamannya', '2025-01-31 17:29:50', '2025-01-31 17:35:25'),
(18, 3, 'TRX1738383332', 'User213', '2025-10-23', 'ngj473', 'dolor', 50, 0, 'Disetujui', '2025-01-31 21:15:32', '2025-02-01 17:55:32'),
(19, 3, 'TRX1738383355', 'User213', '2025-02-09', 'rja658', 'ex', 6, 0, 'Disetujui', '2025-01-31 21:15:55', '2025-02-01 18:06:34'),
(20, 5, 'TRX1738389909', 'fikri123', '2025-02-01', 'ALT9221', 'Sapu', 10, 10, 'Disetujui', '2025-01-31 23:05:09', '2025-01-31 23:37:14'),
(21, 5, 'TRX1738397644', 'fikri123', '2025-02-01', 'ALT9221', 'Sapu', 10, 10, 'Disetujui', '2025-02-01 01:14:04', '2025-02-01 01:14:42'),
(22, 3, 'TRX1738461953', 'User213', '2025-02-02', 'ALT24442', 'Vacum Cleaner', 4, -4, 'Disetujui', '2025-02-01 19:05:53', '2025-02-01 19:10:46'),
(23, 3, 'TRX1738462540', 'User213', '2025-02-02', 'ALT24442', 'Vacum Cleaner', 5, 0, 'Disetujui', '2025-02-01 19:15:40', '2025-02-01 19:16:53'),
(24, 8, 'TRX1738468889', 'cacamarica', '2025-02-02', 'ALT9221', 'Sapu', 13, 0, 'Disetujui', '2025-02-01 21:01:29', '2025-02-01 21:02:07'),
(25, 8, 'TRX1738482103', 'cacamarica', '2025-02-02', 'ALT24442', 'Vacum Cleaner', 5, 5, 'Menunggu', '2025-02-02 00:41:43', '2025-02-02 00:41:43'),
(26, 3, 'TRX1738544398', 'User213', '2025-02-03', 'TV98292', 'TV SAMSUNG 50 Inch', 10, 5, 'Disetujui', '2025-02-02 17:59:58', '2025-02-02 18:00:31'),
(27, 5, 'TRX1738730402', 'fikri123', '2025-02-05', 'TV98292', 'TV SAMSUNG 50 Inch', 2, 2, 'Menunggu', '2025-02-04 21:40:02', '2025-02-04 21:40:02');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalians`
--

CREATE TABLE `pengembalians` (
  `id` bigint UNSIGNED NOT NULL,
  `no_transaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaksi_keluar_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_peminjam` bigint UNSIGNED NOT NULL,
  `kondisi_baik` int NOT NULL DEFAULT '0',
  `kondisi_rusak` int NOT NULL DEFAULT '0',
  `jumlah` int NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_pengembalian` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengembalians`
--

INSERT INTO `pengembalians` (`id`, `no_transaksi`, `transaksi_keluar_id`, `kode_barang`, `id_peminjam`, `kondisi_baik`, `kondisi_rusak`, `jumlah`, `keterangan`, `tgl_pengembalian`, `created_at`, `updated_at`) VALUES
(1, 'TRX1738383332', 'TRX1738383332', '', 3, 30, 5, 35, 'Disetujui', NULL, '2025-01-31 21:48:13', '2025-01-31 21:48:13'),
(3, 'TRX1738200906', 'TRX1738200906', '', 5, 2, 1, 3, 'Disetujui', '2025-02-01', '2025-01-31 23:03:22', '2025-01-31 23:03:22'),
(4, 'TRX1738200906', 'TRX1738200906', '', 5, 2, 0, 2, 'Ditolak: Stok Gudang Penuh', '2025-02-28', '2025-01-31 23:11:30', '2025-01-31 23:33:43'),
(5, 'TRX1738206653', 'TRX1738206653', '', 5, 1, 0, 1, 'Dibatalkan', '2025-07-02', '2025-01-31 23:32:23', '2025-01-31 23:32:34'),
(6, 'TRX1738206653', 'TRX1738206653', '', 5, 1, 0, 1, 'Disetujui', '2025-02-20', '2025-01-31 23:34:44', '2025-01-31 23:35:25'),
(7, 'TRX1738200906', 'TRX1738200906', '', 5, 2, 5, 7, 'Disetujui', '2025-02-28', '2025-01-31 23:42:14', '2025-01-31 23:42:14'),
(8, 'TRX1738383332', 'TRX1738383332', '', 3, 10, 5, 15, 'Disetujui', '9211-02-02', '2025-02-01 17:44:51', '2025-02-01 17:45:23'),
(9, 'TRX1738383332', 'TRX1738383332', '', 3, 10, 5, 15, 'Disetujui', '2025-02-02', '2025-02-01 17:49:45', '2025-02-01 17:50:31'),
(10, 'TRX1738383332', 'TRX1738383332', '', 3, 10, 5, 15, 'Disetujui', '2025-02-02', '2025-02-01 17:55:32', '2025-02-01 17:55:32'),
(11, 'TRX1738383355', 'TRX1738383355', '', 3, 4, 2, 6, 'Disetujui', '2025-02-02', '2025-02-01 17:59:54', '2025-02-01 18:06:34'),
(12, 'TRX1738383355', 'TRX1738383355', '', 3, 6, 0, 6, 'Dibatalkan', '2025-02-02', '2025-02-01 18:02:57', '2025-02-01 18:06:12'),
(13, 'TRX1738201010', 'TRX1738201010', '', 5, 5, 4, 9, 'Disetujui', '2025-02-02', '2025-02-01 18:08:07', '2025-02-01 18:08:53'),
(14, 'TRX1738201010', 'TRX1738201010', '', 5, 5, 4, 9, 'Disetujui', '2025-02-02', '2025-02-01 18:08:28', '2025-02-01 18:09:02'),
(15, 'TRX1738201195', 'TRX1738201195', '', 5, 5, 4, 9, 'Ditolak: kakean sileh bosss', '2025-02-02', '2025-02-01 18:37:28', '2025-02-04 23:59:20'),
(16, 'TRX1738206653', 'TRX1738206653', '', 5, 0, 1, 1, 'Disetujui', '2025-02-02', '2025-02-01 19:03:27', '2025-02-01 19:03:59'),
(17, 'TRX1738461953', 'TRX1738461953', '', 3, 3, 1, 4, 'Disetujui', '2025-02-02', '2025-02-01 19:09:39', '2025-02-01 19:10:46'),
(18, 'TRX1738462540', 'TRX1738462540', '', 3, 3, 2, 5, 'Disetujui', '2025-02-02', '2025-02-01 19:16:30', '2025-02-01 19:16:53'),
(19, 'TRX1738468889', 'TRX1738468889', 'ALT9221', 8, 10, 3, 13, 'Disetujui', '2025-02-02', '2025-02-01 21:02:07', '2025-02-01 21:02:07'),
(20, 'TRX1738544398', 'TRX1738544398', 'TV98292', 3, 5, 0, 5, 'Disetujui', '2025-02-03', '2025-02-02 18:00:31', '2025-02-02 18:00:31');

-- --------------------------------------------------------

--
-- Table structure for table `penyesuaian_stok`
--

CREATE TABLE `penyesuaian_stok` (
  `id` bigint UNSIGNED NOT NULL,
  `no_transaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok_total_baik` int NOT NULL DEFAULT '0',
  `stok_total_rusak` int NOT NULL DEFAULT '0',
  `stok_tersedia` int NOT NULL DEFAULT '0',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penyesuaian_stok`
--

INSERT INTO `penyesuaian_stok` (`id`, `no_transaksi`, `kode_barang`, `stok_total_baik`, `stok_total_rusak`, `stok_tersedia`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'TRX1738557565', 'ALT24442', 10, 2, 8, 'Bonus Pembelian', '2025-02-02 21:39:25', '2025-02-02 21:39:25'),
(2, 'TRX1738557753', 'ALT24442', 6, 2, 6, 'Kesalahan input', '2025-02-02 21:42:33', '2025-02-02 21:42:33'),
(3, 'TRX1738562996', 'ALT9221', 60, 0, 60, 'Stok Rusak Dibuang', '2025-02-02 23:09:56', '2025-02-02 23:09:56'),
(4, 'TRX1738729960', 'ngj473', 23213316, 22, 23213320, 'Pengurangan jumlah berlebihan', '2025-02-04 21:32:40', '2025-02-04 21:32:40'),
(5, 'TRX1738730007', 'ngj473', 16, 22, 20, 'Pengurangan Lagi', '2025-02-04 21:33:27', '2025-02-04 21:33:27');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', NULL, NULL),
(2, 'user', 'web', NULL, NULL),
(3, 'superadmin', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('qd9yYOs0Ij763UXvsAz2RmOBsfwJnqXRqr0uW99O', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUml5OTducjhMRTAxTFFTZ05uQWVEbTFoVk9wUTJtalVCRmhGN25OayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly9pbnZlbnRhcmlzLnRlc3QvcGVtaW5qYW1hbi90YW1iYWhfcGVtaW5qYW1hbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1738805545);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Superadmin User', 'superadmin@example.com', NULL, '$2y$12$1j3/0u9Be/xrhtG6rQlSnOTEqs.N1e/uBmQ/SabrQrMqyMho0zNKC', 'lhDcMiJzbz63Re2iXosJlRFv3ThjdLEEDEwLFKYMT0JNja31nUq5trhs9ZFZ', '2025-01-25 17:59:25', '2025-01-25 17:59:25'),
(3, 'User213', 'user@example.com', NULL, '$2y$12$Cnn7Z5DTdc9tbLBPWWAKoeHi3baAUKtXGd7sAtVaFEp8L6VU71g7C', NULL, '2025-01-25 18:20:33', '2025-01-29 21:26:58'),
(5, 'fikri123', 'fikri030504@gmail.com', NULL, '$2y$12$1.fzwkRacwegty0IHb47Au0Wdd1oKhNRDGQmzm7je9rksHHqLTmA.', NULL, '2025-01-28 19:14:26', '2025-01-29 20:42:54'),
(8, 'cacamarica', 'caca@gmail.com', NULL, '$2y$12$hfxEG8bxyor.yP78CbDF4.D5HRuWXxXxH8EGm/gqmZewcs0JCZPEe', NULL, '2025-01-28 19:34:46', '2025-01-28 19:34:46'),
(9, 'testingadmin123', 'testing@gmail.com', NULL, '$2y$12$LhSXL/2gQbEdYzWCXR./ruLjQKTN6vWnP.IUGTzdafss.IHMHlZZW', NULL, '2025-01-29 21:19:37', '2025-01-29 21:19:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `data_barangs`
--
ALTER TABLE `data_barangs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `data_barangs_kode_unique` (`kode`),
  ADD KEY `data_barangs_kategori_id_foreign` (`kategori_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kategoris_nama_unique` (`nama`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pembelians`
--
ALTER TABLE `pembelians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pembelians_no_transaksi_unique` (`no_transaksi`);

--
-- Indexes for table `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `peminjamans_no_transaksi_unique` (`no_transaksi`),
  ADD KEY `peminjamans_kode_barang_foreign` (`kode_barang`);

--
-- Indexes for table `pengembalians`
--
ALTER TABLE `pengembalians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengembalians_peminjaman_id_foreign` (`id_peminjam`);

--
-- Indexes for table `penyesuaian_stok`
--
ALTER TABLE `penyesuaian_stok`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `penyesuaian_stok_no_transaksi_unique` (`no_transaksi`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_barangs`
--
ALTER TABLE `data_barangs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pembelians`
--
ALTER TABLE `pembelians`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `peminjamans`
--
ALTER TABLE `peminjamans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `pengembalians`
--
ALTER TABLE `pengembalians`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `penyesuaian_stok`
--
ALTER TABLE `penyesuaian_stok`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_barangs`
--
ALTER TABLE `data_barangs`
  ADD CONSTRAINT `data_barangs_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategoris` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengembalians`
--
ALTER TABLE `pengembalians`
  ADD CONSTRAINT `pengembalians_peminjaman_id_foreign` FOREIGN KEY (`id_peminjam`) REFERENCES `peminjamans` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
--
-- Database: `inventaris`
--
CREATE DATABASE IF NOT EXISTS `inventaris` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `inventaris`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
