-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 11, 2025 at 07:31 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webcompro`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$12$FPr3DJ9V0ZJ3BBCgBP4CweOqssXUXjALX3ltcxrCbzwYWkyOz7Zae', '2025-12-02 19:47:52', '2025-12-02 19:47:52');

-- --------------------------------------------------------

--
-- Table structure for table `admin_preferences`
--

CREATE TABLE `admin_preferences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `sidebar_state` enum('open','closed') NOT NULL DEFAULT 'open',
  `menu_order` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`menu_order`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_preferences`
--

INSERT INTO `admin_preferences` (`id`, `admin_id`, `sidebar_state`, `menu_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'open', '{\"admin-hero\":0,\"admin-vision-mission\":1,\"admin-contact\":2,\"admin-dashboard\":3,\"admin-client\":4,\"admin-testimonial\":5,\"admin-company-history\":6,\"admin-settings\":7,\"admin-product\":8}', '2025-12-02 19:54:54', '2025-12-09 08:30:52');

-- --------------------------------------------------------

--
-- Table structure for table `company_histories`
--

CREATE TABLE `company_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tahun` year(4) NOT NULL,
  `judul` varchar(191) NOT NULL,
  `deskripsi` text NOT NULL,
  `image_path` varchar(191) DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_histories`
--

INSERT INTO `company_histories` (`id`, `tahun`, `judul`, `deskripsi`, `image_path`, `images`, `order`, `created_at`, `updated_at`) VALUES
(1, '2005', 'Pendirian Perusahaan', 'Berdiri sebagai bengkel rekayasa di Yogyakarta. Fokus awal pada perbaikan dan modifikasi mesin industri ringan.', 'company-histories/e788ad13-f676-464f-b5cd-78c0af559e43.webp', '[\"company-histories/9bb78e33-d04a-4b9c-a384-932ca9b3c5e2.webp\"]', 4, '2025-11-13 12:42:46', '2025-12-10 22:26:48'),
(2, '2011', 'Ekspansi Layanan Custom mm', 'Berekspansi ke layanan custom fabrication. Memproduksi mesin semi-otomatis pertama kami untuk industri pengolahan makanan', 'company-histories/68da68bb-0cc8-4c6b-87ba-c16be3278855.webp', '[\"company-histories/2623406f-200d-4635-a3fa-e3284a3f76ab.webp\", \"company-histories/983e0604-407f-4869-922a-40c060bbc7a7.webp\"]', 3, '2025-11-13 12:44:16', '2025-12-10 22:26:48'),
(3, '2017', 'Fasilitas Lebih Besar', 'Pindah ke fasilitas yang lebih besar dan berinvestasi pada teknologi desain 3D (CAD/CAM) dan permesinan CNC untuk meningkatkan presisi.', 'company-histories/6f909fe7-7009-4c5d-a429-fcad86c0cf08.webp', '[\"company-histories/e4e899be-6139-4530-aa72-3e1bb433e752.webp\"]', 2, '2025-11-13 12:45:50', '2025-12-10 22:26:48'),
(4, '2025', 'testt', 'testt', 'company-histories/uny_20251211052647_8mx99410.webp', '[]', 0, '2025-12-10 22:26:48', '2025-12-10 22:26:48');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `map_url` text NOT NULL,
  `map_location_name` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `address`, `phone`, `email`, `map_url`, `map_location_name`, `created_at`, `updated_at`) VALUES
(1, 'Jl Mulyosari, Tumut, Sumbersari, Kec. Moyudan, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55563', '088902947368', 'suryakencanaa@gmail.com', 'https://maps.app.goo.gl/uwCvY1VCJAVK4mANA/', 'PT. Surya Kencana Gemilang Teknik', '2025-11-06 19:57:45', '2025-12-10 08:12:08');

-- --------------------------------------------------------

--
-- Table structure for table `heroes`
--

CREATE TABLE `heroes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `background` varchar(191) DEFAULT NULL,
  `backgrounds` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`backgrounds`)),
  `location` varchar(255) NOT NULL DEFAULT 'Jakarta, Indonesia',
  `title` varchar(500) NOT NULL DEFAULT 'MESIN TERBAIK UNTUK INDUSTRI ANDA',
  `machines` int(11) NOT NULL DEFAULT 500,
  `clients` int(11) NOT NULL DEFAULT 200,
  `customers` int(11) NOT NULL DEFAULT 5000,
  `experience_years` int(11) NOT NULL DEFAULT 15,
  `trust_years` int(11) NOT NULL DEFAULT 20,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `heroes`
--

INSERT INTO `heroes` (`id`, `background`, `backgrounds`, `location`, `title`, `machines`, `clients`, `customers`, `experience_years`, `trust_years`, `created_at`, `updated_at`) VALUES
(1, NULL, '[\"heroes/72cf5923-626d-4197-a7bb-c2872132f4df.webp\", \"heroes/Food Truck_20251205045508_szx6lglw.webp\"]', 'Yogyakarta, Indonesia', 'Mesin Custom untuk Kebutuhan Industri Anda', 80, 100, 10, 6, 11, '2025-11-06 23:07:13', '2025-12-05 00:20:49');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_09_18_062255_create_our_clients_table', 1),
(2, '2025_09_19_032612_create_products_table', 1),
(3, '2025_09_19_033916_create_testimonials_table', 1),
(4, '2025_09_19_034250_create_contacts_table', 1),
(5, '2025_09_19_034549_create_admins_table', 1),
(6, '2025_09_19_034550_create_admin_preferences_table', 1),
(7, '2025_09_19_034709_create_super_admins_table', 1),
(8, '2025_09_19_034846_create_vision_missions_table', 1),
(9, '2025_09_19_044120_create_sessions_table', 1),
(10, '2025_10_03_033647_create_personal_access_tokens_table', 1),
(11, '2025_10_30_132122_create_heroes_table', 1),
(12, '2025_10_30_132127_create_company_histories_table', 1),
(13, '2025_10_30_150425_create_site_settings_table', 1),
(14, '2025_10_30_152335_add_image_to_company_histories_table', 1),
(15, '2025_10_30_163221_add_role_to_users_table', 1),
(16, '2025_10_31_012734_add_backgrounds_to_heroes_table', 1),
(17, '2025_10_31_021834_add_images_to_company_histories_table', 1),
(18, '2025_10_31_022931_add_images_to_products_table', 1),
(19, '2025_11_13_192514_make_client_id_nullable_in_products_table', 1),
(20, '2025_11_27_175815_add_indexes_to_tables', 1),
(21, '2025_11_28_000000_add_performance_indexes', 1),
(22, '2025_12_01_220000_add_order_to_products_table', 1),
(23, '2025_12_01_220100_add_order_to_our_clients_table', 1),
(24, '2025_12_01_220200_add_order_to_testimonials_table', 1),
(25, '2025_12_01_220300_add_order_to_company_histories_table', 1),
(26, '2025_12_02_040726_add_hide_price_to_products_table', 1),
(27, '2025_12_02_162456_add_map_location_name_to_contacts_table', 1),
(28, '2025_12_02_163000_make_map_url_nullable_in_contacts_table', 1),
(29, '2025_12_04_072142_make_institution_nullable_in_our_clients_table', 1),
(30, '2025_12_18_000000_increase_map_url_column', 1);

-- --------------------------------------------------------

--
-- Table structure for table `our_clients`
--

CREATE TABLE `our_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_name` varchar(191) NOT NULL,
  `institution` varchar(191) DEFAULT NULL,
  `logo_path` varchar(191) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `our_clients`
--

INSERT INTO `our_clients` (`id`, `client_name`, `institution`, `logo_path`, `order`, `created_at`, `updated_at`) VALUES
(7, 'ANTAM m', 'test', 'ourClients/8804a941-474b-49c2-9ee9-3081ea0e87e2.webp', 2, '2025-11-13 13:13:15', '2025-12-10 22:23:22'),
(8, 'UNIVERSITAS GADJAH MADA', 'Tets', 'ourClients/5000dfe3-a5e1-43dd-aac6-26dd380af876.webp', 4, '2025-11-13 17:47:31', '2025-12-10 22:23:22'),
(9, 'UNIVERSITAS NEGERI YOGYAKARTA', 'Tets', 'ourClients/efa1560c-cfa5-4a7d-84f9-f6f31c212fba.webp', 5, '2025-11-13 17:48:50', '2025-12-10 22:23:22'),
(30009, 'UI', NULL, 'ourClients/PEMDA 1_20251204072712_x28kuclr.webp', 3, '2025-12-04 00:27:13', '2025-12-10 22:23:22'),
(30010, 'juggggg', NULL, 'ourClients/pngwing.com_20251211052320_ipsjjp7l.webp', 0, '2025-12-10 22:23:22', '2025-12-10 22:23:22');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(32, 'App\\Models\\Admin', 1, 'auth_token', 'a53ee858fddd59316df2473534ac2265eb0b90649cdc6300801bb09b575a4a3b', '[\"*\"]', '2025-12-10 21:20:07', NULL, '2025-12-10 21:20:06', '2025-12-10 21:20:07'),
(33, 'App\\Models\\SuperAdmin', 1, 'auth_token', '9232b162abaa17277f817427e355af8eccc23b0a345a00ebfee4b1986a1d147e', '[\"*\"]', '2025-12-10 21:20:23', NULL, '2025-12-10 21:20:23', '2025-12-10 21:20:23'),
(36, 'App\\Models\\SuperAdmin', 1, 'web_token', 'bbaad9f7f3c72d1b2699e43e0a9b00634fd919dedb3778d9f062c184f7727349', '[\"*\"]', '2025-12-10 22:38:52', NULL, '2025-12-10 21:25:52', '2025-12-10 22:38:52'),
(38, 'App\\Models\\SuperAdmin', 1, 'mobile_token', '43d7f36962bfef790342dc09e2710168195704b42a10e9e50c9d274d0df46b2e', '[\"*\"]', '2025-12-10 22:50:12', NULL, '2025-12-10 22:33:31', '2025-12-10 22:50:12');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(191) NOT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `price` decimal(12,2) NOT NULL,
  `hide_price` tinyint(1) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `client_id`, `name`, `description`, `image_path`, `images`, `price`, `hide_price`, `order`, `created_at`, `updated_at`) VALUES
(7, NULL, 'Mesin Assembling Otomatis', 'Mesin ini dirancang untuk menggantikan proses perakitan manual yang repetitif dan rentan kesalahan. Dengan sistem robotik dan PLC terintegrasi, mesin ini memastikan konsistensi dan kecepatan perakitan produk Anda.', 'products/7dbc3dfe-51c4-48d8-84e8-67f7c21c0137.webp', '[\"products/75d3c2ca-7290-485f-821d-acde846ddd82.webp\", \"products/7e3b0a81-f912-4e9d-a992-8f1042000398.webp\"]', 20000000.00, 1, 5, '2025-11-13 12:28:41', '2025-12-10 22:31:23'),
(8, NULL, 'Mesin Pengisian', 'Deskripsi:\r\nDirancang khusus untuk produk dengan viskositas (kekentalan) unik atau bentuk kemasan non-standar. Solusi kami mencakup pengisian (filler), penutupan (capper), pelabelan (labeller), dan pengepakan (case packer) dalam satu alur terintegrasi.', 'products/9a87b535-9838-4822-b26b-8a2d514b2f37.webp', '[]', 5000000.00, 1, 3, '2025-11-13 12:37:16', '2025-12-10 22:31:23'),
(60008, NULL, 'Sutra', 'Larang', 'products/uny_20251205070724_xjvubvtp.webp', '[\"products/uny_20251205070725_hnynehlu.webp\"]', 0.00, 1, 4, '2025-12-05 00:07:25', '2025-12-10 22:31:23'),
(90008, NULL, 'tes kon', 'jhjkhjhj', 'products/uny_20251205071850_zac8n64t.webp', '[]', 70000.00, 0, 2, '2025-12-05 00:18:51', '2025-12-10 22:31:23'),
(90009, NULL, 'SOBA ABU', 'YUHU\r\nYAHA\r\nYIHI\r\nYEHE', 'products/pngwing.com_20251211053121_ohodyxeh.webp', '[]', 0.00, 1, 0, '2025-12-10 22:31:23', '2025-12-10 22:31:23');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(191) NOT NULL DEFAULT 'SURYA KENCANA',
  `company_logo` varchar(191) DEFAULT NULL,
  `hero_title` varchar(500) NOT NULL DEFAULT 'MESIN TERBAIK UNTUK INDUSTRI ANDA',
  `hero_subtitle` varchar(191) NOT NULL DEFAULT 'Jakarta, Indonesia',
  `visi_misi_label` varchar(191) NOT NULL DEFAULT 'TENTANG KAMI',
  `visi_misi_title` varchar(500) NOT NULL DEFAULT 'CREATE YOUR STORY IN A PLACE WHERE DREAMS AND REALITY MERGE.',
  `produk_label` varchar(191) NOT NULL DEFAULT 'PRODUK KAMI',
  `produk_title` varchar(500) NOT NULL DEFAULT 'OUR MACHINE PRODUCTS SPECIFICATIONS.',
  `clients_label` varchar(191) NOT NULL DEFAULT 'Our Partners',
  `clients_title` varchar(500) NOT NULL DEFAULT 'Trusted Clients',
  `riwayat_label` varchar(191) NOT NULL DEFAULT 'RIWAYAT PERUSAHAAN',
  `riwayat_title` varchar(500) NOT NULL DEFAULT 'PERJALANAN KAMI SELAMA INI.',
  `testimoni_label` varchar(191) NOT NULL DEFAULT 'TESTIMONIAL',
  `testimoni_title` varchar(500) NOT NULL DEFAULT 'PENGALAMAN PELANGGAN KAMI.',
  `kontak_label` varchar(191) NOT NULL DEFAULT 'HUBUNGI KAMI',
  `kontak_title` varchar(500) NOT NULL DEFAULT 'JANGAN RAGU MENGHUBUNGI KAMI.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `company_name`, `company_logo`, `hero_title`, `hero_subtitle`, `visi_misi_label`, `visi_misi_title`, `produk_label`, `produk_title`, `clients_label`, `clients_title`, `riwayat_label`, `riwayat_title`, `testimoni_label`, `testimoni_title`, `kontak_label`, `kontak_title`, `created_at`, `updated_at`) VALUES
(1, 'SURYA KENCANA', 'logos/Asset 5@3x_20251202172150_c6gv1b14.webp', 'MESIN TERBAIK UNTUK INDUSTRI ANDA', 'Jakarta, Indonesia', 'TENTANG KAMI', 'Inovasi Teknik, Presisi Tanpa Kompromi', 'PRODUK KAMI', 'Rekayasa Spesifik untuk Hasil Optimal', 'CLIENT KAMI', 'Dipercaya oleh Industri', 'RIWAYAT PERUSAHAAN', 'Jejak Langkah PT. Surya Kencana', 'TESTIMONIAL', 'Apa Kata Mereka Tentang Kami', 'INFORMASI KONTAK KAMIi', 'JANGAN RAGU MENGHUBUNGI KAMI.', '2025-11-06 19:57:57', '2025-12-10 20:22:55');

-- --------------------------------------------------------

--
-- Table structure for table `super_admins`
--

CREATE TABLE `super_admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `super_admins`
--

INSERT INTO `super_admins` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', '$2y$12$NTzo8yrU6eQPmqzFcU7ZQOmOcy9UlB7o3ecbkNBlgzwQO0TP/C/y6', '2025-11-06 19:57:45', '2025-12-02 19:34:51');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_name` varchar(191) NOT NULL,
  `institution` varchar(191) NOT NULL,
  `feedback` text NOT NULL,
  `date` date NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `client_name`, `institution`, `feedback`, `date`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Whitney Durgan', 'Monahan Group', 'Ratione qui non amet quaerat vel et laborum cumque. Eos et ea et blanditiis vel deserunt est. Dignissimos culpa ipsam minus.', '2001-07-27', 2, '2025-11-06 19:57:45', '2025-12-10 22:19:34'),
(2, 'Luella McLaughlin', 'Friesen-Luettgen', 'Vel recusandae aut culpa fugit et et ut. Molestias excepturi dolorem minus enim labore ut est.', '1987-12-09', 4, '2025-11-06 19:57:45', '2025-12-10 22:19:34'),
(3, 'Jody Buckridge V', 'Ankunding-Barrows', 'Cumque est earum et. Modi est et dolor consequuntur doloremque quam ducimus quae. Aut molestiae perferendis molestias accusamus vitae nisi. Voluptatem possimus quidem accusantium est quia eum voluptatem. Repellendus iusto ut error dolores ullam quia modi praesentium.', '2024-05-01', 5, '2025-11-06 19:57:45', '2025-12-10 22:19:34'),
(4, 'Mr. Jocelyn Renner IV', 'Larson-Windler', 'Totam voluptates itaque aperiam magnam. Ea laborum voluptas assumenda error. Eum error doloribus minus repudiandae. Maiores rerum accusantium sunt eaque.', '2006-06-03', 6, '2025-11-06 19:57:45', '2025-12-10 22:19:34'),
(5, 'Lonnie Kuvalis', 'Swaniawski-Wuckert', 'Est quam qui nihil et nihil. Incidunt perspiciatis dicta odio et facilis similique. Reprehenderit quo ipsam quia accusamus cumque earum. Numquam voluptas laudantium sit nesciunt.', '2018-03-15', 7, '2025-11-06 19:57:45', '2025-12-10 22:19:34'),
(60002, 'Bagus BAngett', 'Test', 'PPPP', '2025-12-04', 3, '2025-12-04 00:13:50', '2025-12-10 22:19:34'),
(60003, 'Halo', 'UI', 'Halo bagus sekali! hh', '2025-12-04', 1, '2025-12-04 00:27:32', '2025-12-10 22:19:34'),
(90002, 'Budi Santoso', 'PT. Maju Jaya', 'Layanan luar biasa! Sangat puas dengan hasilnya.', '2025-12-04', 9, '2025-12-04 11:27:05', '2025-12-10 22:19:34'),
(90003, 'Testt', 'Yuhuuu', 'oke oke', '2025-12-11', 0, '2025-12-10 22:19:34', '2025-12-10 22:19:34');

-- --------------------------------------------------------

--
-- Table structure for table `vision_missions`
--

CREATE TABLE `vision_missions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vision` text DEFAULT NULL,
  `mission` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vision_missions`
--

INSERT INTO `vision_missions` (`id`, `vision`, `mission`, `created_at`, `updated_at`) VALUES
(1, 'Menjadi perusahaan rekayasa dan manufaktur mesin custom terdepan di Indonesia, yang dikenal atas inovasi, kualitas, dan keandalan solusi untuk setiap tantangan industri. yyy', '[\"Menyediakan solusi mesin custom yang spesifik, efisien, dan bernilai tambah tinggi bagi klien. yyyy\",\"Mengutamakan presisi dan standar kualitas tertinggi dalam setiap proses desain dan produksi.\",\"Membangun kemitraan jangka panjang dengan klien melalui layanan purna jual yang responsif dan proaktif.\",\"Terus berinovasi dengan mengadopsi teknologi terbaru dalam rekayasa dan otomasi industri.\"]', '2025-11-06 19:57:45', '2025-12-10 07:18:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admins_username_index` (`username`),
  ADD KEY `admins_created_at_index` (`created_at`);

--
-- Indexes for table `admin_preferences`
--
ALTER TABLE `admin_preferences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_preferences_admin_id_unique` (`admin_id`),
  ADD KEY `admin_preferences_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `company_histories`
--
ALTER TABLE `company_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_company_histories_year` (`tahun`),
  ADD KEY `idx_company_histories_created_at` (`created_at`),
  ADD KEY `company_histories_tahun_index` (`tahun`),
  ADD KEY `company_histories_created_at_index` (`created_at`),
  ADD KEY `company_histories_updated_at_index` (`updated_at`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_contacts_updated_at` (`updated_at`),
  ADD KEY `contacts_updated_at_index` (`updated_at`);

--
-- Indexes for table `heroes`
--
ALTER TABLE `heroes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_heroes_created_at` (`created_at`),
  ADD KEY `idx_heroes_updated_at` (`updated_at`),
  ADD KEY `heroes_updated_at_index` (`updated_at`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `our_clients`
--
ALTER TABLE `our_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_clients_name` (`client_name`),
  ADD KEY `idx_clients_institution` (`institution`),
  ADD KEY `idx_clients_created_at` (`created_at`),
  ADD KEY `our_clients_client_name_index` (`client_name`),
  ADD KEY `our_clients_created_at_index` (`created_at`),
  ADD KEY `our_clients_updated_at_index` (`updated_at`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_client_id_index` (`client_id`),
  ADD KEY `products_created_at_index` (`created_at`),
  ADD KEY `products_updated_at_index` (`updated_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_site_settings_updated_at` (`updated_at`),
  ADD KEY `site_settings_updated_at_index` (`updated_at`);

--
-- Indexes for table `super_admins`
--
ALTER TABLE `super_admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_testimonials_date` (`date`),
  ADD KEY `idx_testimonials_client_name` (`client_name`),
  ADD KEY `idx_testimonials_institution` (`institution`),
  ADD KEY `idx_testimonials_created_at` (`created_at`),
  ADD KEY `testimonials_date_index` (`date`),
  ADD KEY `testimonials_created_at_index` (`created_at`),
  ADD KEY `testimonials_updated_at_index` (`updated_at`);

--
-- Indexes for table `vision_missions`
--
ALTER TABLE `vision_missions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_vision_missions_updated_at` (`updated_at`),
  ADD KEY `vision_missions_updated_at_index` (`updated_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_preferences`
--
ALTER TABLE `admin_preferences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30001;

--
-- AUTO_INCREMENT for table `company_histories`
--
ALTER TABLE `company_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `heroes`
--
ALTER TABLE `heroes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `our_clients`
--
ALTER TABLE `our_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30011;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90010;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `super_admins`
--
ALTER TABLE `super_admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90004;

--
-- AUTO_INCREMENT for table `vision_missions`
--
ALTER TABLE `vision_missions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_preferences`
--
ALTER TABLE `admin_preferences`
  ADD CONSTRAINT `admin_preferences_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `our_clients` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
