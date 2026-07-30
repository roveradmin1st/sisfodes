-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2026 at 05:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sidomulyo_db`
--
CREATE DATABASE IF NOT EXISTS `sidomulyo_db`;
USE `sidomulyo_db`;


-- --------------------------------------------------------

--
-- Table structure for table `informasi_desa`
--

CREATE TABLE `informasi_desa` (
  `id_informasi` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(200) NOT NULL,
  `kategori` enum('berita','pengumuman','agenda','galeri') NOT NULL,
  `isi` text NOT NULL,
  `waktu_pelaksanaan` datetime DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal_posting` date NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `status_publish` enum('publish','draft') NOT NULL DEFAULT 'publish',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `informasi_desa`
--

INSERT INTO `informasi_desa` (`id_informasi`, `judul`, `kategori`, `isi`, `waktu_pelaksanaan`, `gambar`, `tanggal_posting`, `penulis`, `status_publish`, `created_at`, `updated_at`) VALUES
(2, 'tes', 'berita', 'tes', NULL, NULL, '2026-06-22', 'Kaur Umum', 'publish', '2026-06-22 08:08:01', '2026-06-22 08:08:01'),
(3, 'tes', 'pengumuman', 'tes', NULL, NULL, '2026-06-22', 'Kaur Umum', 'publish', '2026-06-22 08:08:25', '2026-06-22 08:08:25'),
(4, 'tes', 'agenda', 'tes', NULL, NULL, '2026-06-22', 'Kaur Umum', 'publish', '2026-06-22 08:08:58', '2026-06-22 08:08:58'),
(5, 'tes', 'galeri', 'tes', NULL, 'informasi/9FtZVb0wptfJTEWYLqKUy25FuY3dBM5czdmNo3j3.png', '2026-06-22', 'Kaur Umum', 'publish', '2026-06-22 08:09:42', '2026-06-22 08:09:42');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_surat`
--

CREATE TABLE `jenis_surat` (
  `id_jenis_surat` bigint(20) UNSIGNED NOT NULL,
  `nama_surat` varchar(200) NOT NULL,
  `deskripsi` text NOT NULL,
  `syarat` text NOT NULL,
  `template_surat` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_surat`
--

INSERT INTO `jenis_surat` (`id_jenis_surat`, `nama_surat`, `deskripsi`, `syarat`, `template_surat`, `created_at`, `updated_at`) VALUES
(1, 'Surat Keterangan Domisili', 'Surat keterangan domisili digunakan untuk menyatakan bahwa seseorang bertempat tinggal di Desa Sidomulyo', '1. Fotokopi KTP\r\n2. Fotokopi Kartu Keluarga\r\n3. Surat Pengantar Kepala Dusun (jika diperlukan)', 'templates/surat/GEpp81Yi94nQqSj0QubBO6dTe2zqgcnQk5BVdmCW.pdf', '2026-06-22 00:27:28', '2026-06-22 08:49:38'),
(2, 'Surat Keterangan Tidak Mampu', 'Surat keterangan tidak mampu untuk keperluan bantuan sosial, pendidikan, atau kesehatan', '1. Fotokopi KTP\n2. Fotokopi Kartu Keluarga\n3. Dokumen Pendukung (foto rumah)', NULL, '2026-06-22 00:27:28', '2026-06-22 00:27:28'),
(3, 'Surat Keterangan Usaha', 'Surat keterangan usaha untuk pengajuan pinjaman atau bantuan usaha', '1. Fotokopi KTP\n2. Fotokopi Kartu Keluarga\n3. Dokumen Pendukung (foto bukti usaha)', NULL, '2026-06-22 00:27:28', '2026-06-22 00:27:28'),
(4, 'Surat Keterangan Belum Menikah', 'Surat keterangan belum menikah untuk pengajuan KPR atau keperluan administrasi lainnya', '1. Fotokopi KTP\n2. Fotokopi Kartu Keluarga\n3. Pas foto terbaru', NULL, '2026-06-22 00:27:28', '2026-06-22 00:27:28'),
(5, 'Surat Keterangan Kematian', 'Surat keterangan kematian untuk keperluan administrasi kependudukan dan keluarga', '1. Fotokopi KTP Almarhum\n2. Fotokopi Kartu Keluarga\n3. Surat keterangan dari rumah sakit', NULL, '2026-06-22 00:27:28', '2026-06-22 00:27:28');

-- --------------------------------------------------------

--
-- Table structure for table `kritik_saran`
--

CREATE TABLE `kritik_saran` (
  `id_pesan` bigint(20) UNSIGNED NOT NULL,
  `nama_pengirim` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `isi_pesan` text NOT NULL,
  `status` enum('dibaca','dibalas') NOT NULL DEFAULT 'dibaca',
  `balasan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_06_22_070339_create_users_table', 1),
(2, '2026_06_22_070340_create_penduduk_table', 1),
(3, '2026_06_22_070341_create_profil_desa_table', 1),
(4, '2026_06_22_070342_create_perangkat_desa_table', 1),
(5, '2026_06_22_070343_create_informasi_desa_table', 1),
(6, '2026_06_22_070344_create_jenis_surat_table', 1),
(7, '2026_06_22_070345_create_permohonan_surat_table', 1),
(8, '2026_06_22_070347_create_penerima_bantuan_table', 1),
(9, '2026_06_22_070349_create_kritik_saran_table', 1),
(10, '2026_06_22_070417_create_reset_password_table', 1),
(11, '2026_06_22_120733_add_is_kepala_keluarga_to_penduduk_table', 2),
(12, '2026_06_22_125459_add_luas_wilayah_and_map_to_profil_desa_table', 3),
(13, '2026_06_29_101030_add_email_to_users_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `penduduk`
--

CREATE TABLE `penduduk` (
  `id_penduduk` bigint(20) UNSIGNED NOT NULL,
  `nik` varchar(16) NOT NULL,
  `no_kk` varchar(16) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `agama` varchar(20) NOT NULL,
  `pendidikan` varchar(50) DEFAULT NULL,
  `pekerjaan` varchar(50) DEFAULT NULL,
  `status_perkawinan` varchar(20) DEFAULT NULL,
  `kewarganegaraan` varchar(20) NOT NULL DEFAULT 'WNI',
  `alamat` text NOT NULL,
  `dusun` varchar(20) DEFAULT NULL,
  `rt` varchar(5) DEFAULT NULL,
  `rw` varchar(5) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `status_penduduk` enum('tetap','sementara') NOT NULL DEFAULT 'tetap',
  `is_kepala_keluarga` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penerima_bantuan`
--

CREATE TABLE `penerima_bantuan` (
  `id_penerima` bigint(20) UNSIGNED NOT NULL,
  `id_penduduk` bigint(20) UNSIGNED NOT NULL,
  `program_bantuan` varchar(100) NOT NULL,
  `tanggal_terima` date NOT NULL,
  `status` enum('diterima','dialihkan') NOT NULL DEFAULT 'diterima',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perangkat_desa`
--

CREATE TABLE `perangkat_desa` (
  `id_perangkat` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `perangkat_desa`
--

INSERT INTO `perangkat_desa` (`id_perangkat`, `nama`, `jabatan`, `foto`, `created_at`, `updated_at`) VALUES
(1, 'Satriawan', 'Kepala Desa', 'perangkat/k1N3ETSiJCvfBiStAQqKVWWJa5QCIEzfHw21E7Bj.jpg', '2026-06-22 00:27:26', '2026-06-22 06:35:51'),
(2, 'Samsidar, A.Md', 'Sekretaris Desa', NULL, '2026-06-22 00:27:26', '2026-06-22 00:27:26'),
(3, 'M. Muchlisin', 'Kepala Seksi Pemerintahan', NULL, '2026-06-22 00:27:26', '2026-06-22 00:27:26'),
(4, 'Nuraisah', 'Kepala Seksi Kesejahteraan', NULL, '2026-06-22 00:27:27', '2026-06-22 00:27:27'),
(5, 'Tatang Priyatna', 'Kepala Seksi Pelayanan', NULL, '2026-06-22 00:27:27', '2026-06-22 00:27:27'),
(6, 'Tuti Amidah', 'Kepala Urusan Umum', NULL, '2026-06-22 00:27:27', '2026-06-22 00:27:27'),
(7, 'Syahfitri', 'Kepala Urusan Keuangan', NULL, '2026-06-22 00:27:27', '2026-06-22 00:27:27'),
(8, 'Ratna Dewi Br Sembiring, S.Kom', 'Kepala Urusan Perencanaan', NULL, '2026-06-22 00:27:27', '2026-06-22 00:27:27'),
(9, 'Chairul Anwar', 'Kepala Dusun I', NULL, '2026-06-22 00:27:27', '2026-06-22 00:27:27'),
(10, 'Sumanto', 'Kepala Dusun II', NULL, '2026-06-22 00:27:27', '2026-06-22 00:27:27'),
(11, 'Terkelin Sitepu', 'Kepala Dusun III', NULL, '2026-06-22 00:27:27', '2026-06-22 00:27:27'),
(12, 'M. Aliges Ginting', 'Kepala Dusun IV', NULL, '2026-06-22 00:27:27', '2026-06-22 00:27:27'),
(13, 'Prianto', 'Kepala Dusun V', NULL, '2026-06-22 00:27:28', '2026-06-22 00:27:28'),
(14, 'Gusti Juanda', 'Kepala Dusun VI', NULL, '2026-06-22 00:27:28', '2026-06-22 00:27:28');

-- --------------------------------------------------------

--
-- Table structure for table `permohonan_surat`
--

CREATE TABLE `permohonan_surat` (
  `id_permohonan` bigint(20) UNSIGNED NOT NULL,
  `id_penduduk` bigint(20) UNSIGNED NOT NULL,
  `id_jenis_surat` bigint(20) UNSIGNED NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `keperluan` text NOT NULL,
  `file_persyaratan` varchar(255) DEFAULT NULL,
  `file_surat_scan` varchar(255) DEFAULT NULL,
  `status_permohonan` enum('menunggu','diproses','selesai','ditolak') NOT NULL DEFAULT 'menunggu',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profil_desa`
--

CREATE TABLE `profil_desa` (
  `id_profil` bigint(20) UNSIGNED NOT NULL,
  `nama_desa` varchar(100) NOT NULL DEFAULT 'Desa Sidomulyo',
  `kecamatan` varchar(100) NOT NULL DEFAULT 'Biru-Biru',
  `kabupaten` varchar(100) NOT NULL DEFAULT 'Deli Serdang',
  `provinsi` varchar(100) NOT NULL DEFAULT 'Sumatera Utara',
  `alamat` text NOT NULL,
  `luas_wilayah` varchar(255) DEFAULT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `visi` text NOT NULL,
  `misi` text NOT NULL,
  `sejarah` text NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `map` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profil_desa`
--

INSERT INTO `profil_desa` (`id_profil`, `nama_desa`, `kecamatan`, `kabupaten`, `provinsi`, `alamat`, `luas_wilayah`, `kode_pos`, `telepon`, `email`, `visi`, `misi`, `sejarah`, `logo`, `map`, `created_at`, `updated_at`) VALUES
(2, 'Desa Sidomulyo', 'Biru-Biru', 'Deli Serdang', 'Sumatera Utara', 'Jl. Desa Sidomulyo, Kecamatan Biru-Biru, Kabupaten Deli Serdang, Provinsi Sumatera Utara', NULL, '20376', '061-1234567', 'desa.sidomulyo@gmail.com', 'Terwujudnya kemandirian desa yang maju, aman, sejahtera dan berkeadilan dengan menempatkan masyarakat sebagai pelaku utama dalam seluruh proses pengelolaan pembangunan desa.', '1. Meningkatkan pembangunan desa dalam berbagai bidang.\n2. Mengembangkan kemampuan masyarakat untuk berperan aktif dalam proses pembangunan sehingga secara bertahap masyarakat mampu membangun diri dan lingkungan sehingga tercipta kondisi desa yang aman tertib dan rukun.\n3. Mengentaskan kemiskinan dengan kegiatan keterampilan serta memfasilitasi berbagai masyarakat dalam pengembangan usaha ekonomi desa.\n4. Mengoptimalkan fungsi perangkat desa sehingga menghasilkan data yang akurat khususnya administrasi desa dan profil desa.\n5. Meningkatkan peran serta generasi muda dalam kegiatan olahraga, seni budaya, karang taruna desa dan mengaktifkan peran serta masyarakat dalam bergotong royong.\n6. Menuntaskan pendidikan dasar 12 (dua belas) tahun agar timbul generasi-generasi muda yang lebih baik dan pintar.\n7. Membentuk forum komunikasi antar tokoh agama dan tokoh masyarakat di dusun-dusun yang ada di desa.', 'Desa Sidomulyo dahulu wilayahnya merupakan areal perkebunan Belanda (Tahun 1950), setelah melalui perjuangan masyarakat desa maka pada tahun 1952 memperoleh pengakuan dan izin dari Asisten Wedana Pancur Batu terbentuk menjadi kampung Sidomulyo yang dipimpin oleh Lurah Kelurahan Sidomulyo yaitu Alm. Parno, yang membawahi beberapa Kepala Kampung yang ada di Kecamatan Biru-Biru. Sidomulyo berasal dari kata Sido artinya jadi, dan mulyo artinya mulia, sehingga dapat diartikan sebagai desa yang akan menjadi mulia.\r\n\r\nDesa Sidomulyo adalah desa pertama pintu masuk gerbang Kecamatan Biru-Biru dan merupakan satu dari 17 (tujuh belas) Desa yang ada di Kecamatan Biru-Biru terdiri dari 6 (enam) Dusun serta hasil penggabungan Kecamatan Biru-Biru, terdiri dari Dusun Tahun 90-an sampai dengan saat ini. Desa Sidomulyo adalah desa yang padat penduduknya, sehingga sebagian besarnya wilayahnya merupakan daerah pengembangan sarana pemukiman penduduk.', 'profil/logo_1782188932.jpg', NULL, '2026-06-22 08:44:42', '2026-06-22 21:28:55');

-- --------------------------------------------------------

--
-- Table structure for table `reset_password`
--

CREATE TABLE `reset_password` (
  `id_reset` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(225) NOT NULL,
  `expired_at` datetime NOT NULL,
  `status` enum('pending','used') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('kaur_umum','kepala_desa','penduduk') NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nik`, `nama`, `username`, `email`, `password`, `role`, `foto`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '1212345678901234', 'Kaur Umum', 'kaur_umum', 'kaur_umum@gmail.com', '$2y$12$fP9/Nuh.dxBTDuTtTbEHfOtp1A1lXEVaeephhWxgfV.FXwXICrznG', 'kaur_umum', NULL, 'aktif', NULL, '2026-06-22 00:27:25', '2026-06-29 03:13:06'),
(2, '1212345678905678', 'Kepala Desa Sidomulyo', 'kepala_desa', 'kepala_desa@gmail.com', '$2y$12$Cv8MMMrJSItPdeAyn//l8eG0ev2z3nljU1qRpx18oVYXo1HrH6HPW', 'kepala_desa', NULL, 'aktif', NULL, '2026-06-22 00:27:25', '2026-06-29 03:13:06'),
(3, '1212345678909999', 'Penduduk Contoh', 'penduduk', 'penduduk@gmail.com', '$2y$12$aKHXm1alk1cGDZdIS628xO51riS3J/OFTTwZZ86cR5ROcpKpsouEG', 'penduduk', NULL, 'aktif', NULL, '2026-06-22 00:27:26', '2026-06-29 03:13:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `informasi_desa`
--
ALTER TABLE `informasi_desa`
  ADD PRIMARY KEY (`id_informasi`);

--
-- Indexes for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
  ADD PRIMARY KEY (`id_jenis_surat`);

--
-- Indexes for table `kritik_saran`
--
ALTER TABLE `kritik_saran`
  ADD PRIMARY KEY (`id_pesan`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penduduk`
--
ALTER TABLE `penduduk`
  ADD PRIMARY KEY (`id_penduduk`),
  ADD UNIQUE KEY `penduduk_nik_unique` (`nik`);

--
-- Indexes for table `penerima_bantuan`
--
ALTER TABLE `penerima_bantuan`
  ADD PRIMARY KEY (`id_penerima`),
  ADD KEY `penerima_bantuan_id_penduduk_foreign` (`id_penduduk`);

--
-- Indexes for table `perangkat_desa`
--
ALTER TABLE `perangkat_desa`
  ADD PRIMARY KEY (`id_perangkat`);

--
-- Indexes for table `permohonan_surat`
--
ALTER TABLE `permohonan_surat`
  ADD PRIMARY KEY (`id_permohonan`),
  ADD KEY `permohonan_surat_id_penduduk_foreign` (`id_penduduk`),
  ADD KEY `permohonan_surat_id_jenis_surat_foreign` (`id_jenis_surat`);

--
-- Indexes for table `profil_desa`
--
ALTER TABLE `profil_desa`
  ADD PRIMARY KEY (`id_profil`);

--
-- Indexes for table `reset_password`
--
ALTER TABLE `reset_password`
  ADD PRIMARY KEY (`id_reset`),
  ADD KEY `reset_password_id_user_foreign` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `users_nik_unique` (`nik`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `informasi_desa`
--
ALTER TABLE `informasi_desa`
  MODIFY `id_informasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jenis_surat`
--
ALTER TABLE `jenis_surat`
  MODIFY `id_jenis_surat` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kritik_saran`
--
ALTER TABLE `kritik_saran`
  MODIFY `id_pesan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `penduduk`
--
ALTER TABLE `penduduk`
  MODIFY `id_penduduk` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `penerima_bantuan`
--
ALTER TABLE `penerima_bantuan`
  MODIFY `id_penerima` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `perangkat_desa`
--
ALTER TABLE `perangkat_desa`
  MODIFY `id_perangkat` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `permohonan_surat`
--
ALTER TABLE `permohonan_surat`
  MODIFY `id_permohonan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profil_desa`
--
ALTER TABLE `profil_desa`
  MODIFY `id_profil` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reset_password`
--
ALTER TABLE `reset_password`
  MODIFY `id_reset` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `penerima_bantuan`
--
ALTER TABLE `penerima_bantuan`
  ADD CONSTRAINT `penerima_bantuan_id_penduduk_foreign` FOREIGN KEY (`id_penduduk`) REFERENCES `penduduk` (`id_penduduk`) ON DELETE CASCADE;

--
-- Constraints for table `permohonan_surat`
--
ALTER TABLE `permohonan_surat`
  ADD CONSTRAINT `permohonan_surat_id_jenis_surat_foreign` FOREIGN KEY (`id_jenis_surat`) REFERENCES `jenis_surat` (`id_jenis_surat`) ON DELETE CASCADE,
  ADD CONSTRAINT `permohonan_surat_id_penduduk_foreign` FOREIGN KEY (`id_penduduk`) REFERENCES `penduduk` (`id_penduduk`) ON DELETE CASCADE;

--
-- Constraints for table `reset_password`
--
ALTER TABLE `reset_password`
  ADD CONSTRAINT `reset_password_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
