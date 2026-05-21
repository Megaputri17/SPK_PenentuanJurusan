-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2026 at 02:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: `spk_jurusan`

-- Table structure for table `alternatif`
CREATE TABLE `alternatif` (
  `id_alternatif` int(11) NOT NULL,
  `nama_alternatif` varchar(150) NOT NULL,
  `jenis` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Data for table `alternatif`
INSERT INTO `alternatif` (`id_alternatif`, `nama_alternatif`, `jenis`) VALUES
(1, 'Teknik Informatika', 'IT'),
(2, 'Teknologi Informasi', 'IT'),
(3, 'Teknik Jaringan Telekomunikasi Digital', 'IT'),
(4, 'Ilmu Komunikasi', 'Sosial'),
(5, 'Teknik Industri Pertanian', 'Teknik'),
(6, 'Pendidikan Teknologi Informasi', 'IT'),
(7, 'Teknologi Pendidikan', 'IT'),
(8, 'Manajemen Pemasaran', 'Bisnis'),
(9, 'Teknik Elektro', 'Teknik'),
(10, 'Teknik Komputer', 'IT'),
(11, 'Teknik Elektronika', 'Teknik'),
(12, 'Teknologi Rekayasa Sistem Elektronika', 'Teknik'),
(13, 'Pendidikan Jasmani Kesehatan dan Rekreasi', 'Pendidikan'),
(14, 'Pariwisata', 'Bisnis'),
(15, 'Manajemen ', 'Bisnis'),
(16, 'Ilmu Kesehatan Masyarakat', 'Kesehatan'),
(17, 'Teknik Industri', 'Teknik'),
(18, 'Teknik Pengairan', 'Teknik'),
(19, 'Administrasi Bisnis', 'Bisnis'),
(20, 'Pendidikan Guru Sekolah Dasar', 'Pendidikan');


-- Table structure for table `hasil`
CREATE TABLE `hasil` (
  `id_hasil` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `id_alternatif` int(11) DEFAULT NULL,
  `skor` float DEFAULT NULL,
  `ranking` int(11) DEFAULT NULL,
  `rekomendasi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Data for table `hasil`
INSERT INTO `hasil` (`id_hasil`, `id_siswa`, `id_alternatif`, `skor`, `ranking`, `rekomendasi`) VALUES
(42, 1, 1, 1.053, 1, NULL),
(43, 1, 2, 1.021, 2, NULL),
(44, 2, 3, 1.053, 1, NULL),
(45, 2, 1, 1.021, 2, NULL),
(46, 3, 4, 1.053, 1, NULL),
(47, 4, 5, 1.053, 1, NULL),
(48, 4, 6, 1.021, 2, NULL),
(49, 5, 7, 1.053, 1, NULL),
(50, 5, 8, 1.021, 2, NULL),
(51, 6, 1, 1.053, 1, NULL),
(52, 6, 9, 1.021, 2, NULL),
(53, 7, 10, 1.053, 1, NULL),
(54, 7, 9, 1.021, 2, NULL),
(55, 8, 3, 1.053, 1, NULL),
(56, 8, 1, 1.021, 2, NULL),
(57, 9, 11, 1.053, 1, NULL),
(58, 9, 12, 1.021, 2, NULL),
(59, 10, 9, 1.053, 1, NULL),
(60, 10, 11, 1.021, 2, NULL),
(61, 11, 1, 1.053, 1, NULL),
(62, 11, 3, 1.021, 2, NULL),
(63, 12, 11, 1.053, 1, NULL),
(64, 12, 9, 1.021, 2, NULL),
(65, 13, 1, 1.053, 1, NULL),
(66, 14, 13, 1.053, 1, NULL),
(67, 14, 14, 1.021, 2, NULL),
(68, 15, 1, 1.053, 1, NULL),
(69, 15, 9, 1.021, 2, NULL),
(70, 16, 15, 1.053, 1, NULL),
(71, 16, 16, 1.021, 2, NULL),
(72, 17, 1, 1.053, 1, NULL),
(73, 18, 15, 1.053, 1, NULL),
(74, 18, 9, 1.021, 2, NULL),
(75, 19, 17, 1.053, 1, NULL),
(76, 19, 18, 1.021, 2, NULL),
(77, 20, 4, 1.053, 1, NULL),
(78, 20, 3, 1.021, 2, NULL),
(79, 21, 9, 1.053, 1, NULL),
(80, 21, 1, 1.021, 2, NULL),
(81, 22, 19, 1.053, 1, NULL),
(82, 22, 20, 1.021, 2, NULL);


-- Table structure for table `kriteria`
CREATE TABLE `kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `nama_kriteria` varchar(100) DEFAULT NULL,
  `bobot` float DEFAULT NULL,
  `jenis` enum('benefit','cost') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Data for table `kriteria`
INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `bobot`, `jenis`) VALUES
(1, 'Kompetensi', 0.633, 'benefit'),
(2, 'Nilai Akademik', 0.26, 'benefit'),
(3, 'Minat', 0.16, 'benefit');


-- Table structure for table `nilai`
CREATE TABLE `nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `id_alternatif` int(11) DEFAULT NULL,
  `id_kriteria` int(11) DEFAULT NULL,
  `nilai` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Data for table `nilai`
INSERT INTO `nilai` (`id_nilai`, `id_siswa`, `id_alternatif`, `id_kriteria`, `nilai`) VALUES
(1, 1, 1, 1, 92),
(2, 1, 1, 2, 94.4),
(3, 1, 1, 3, 1),
(4, 1, 2, 1, 92),
(5, 1, 2, 2, 94.4),
(6, 1, 2, 3, 0.8),
(7, 2, 3, 1, 92),
(8, 2, 3, 2, 93.2),
(9, 2, 3, 3, 1),
(10, 2, 1, 1, 92),
(11, 2, 1, 2, 93.2),
(12, 2, 1, 3, 0.8),
(13, 3, 4, 1, 91),
(14, 3, 4, 2, 92.6),
(15, 3, 4, 3, 1),
(16, 4, 5, 1, 86),
(17, 4, 5, 2, 92.3),
(18, 4, 5, 3, 1),
(19, 4, 6, 1, 86),
(20, 4, 6, 2, 92.3),
(21, 4, 6, 3, 0.8),
(22, 5, 7, 1, 85),
(23, 5, 7, 2, 92),
(24, 5, 7, 3, 1),
(25, 5, 8, 1, 85),
(26, 5, 8, 2, 92),
(27, 5, 8, 3, 0.8),
(28, 6, 1, 1, 93),
(29, 6, 1, 2, 91.9),
(30, 6, 1, 3, 1),
(31, 6, 9, 1, 93),
(32, 6, 9, 2, 91.9),
(33, 6, 9, 3, 0.8),
(34, 7, 10, 1, 86),
(35, 7, 10, 2, 91.7),
(36, 7, 10, 3, 1),
(37, 7, 9, 1, 86),
(38, 7, 9, 2, 91.7),
(39, 7, 9, 3, 0.8),
(40, 8, 3, 1, 86),
(41, 8, 3, 2, 91.6),
(42, 8, 3, 3, 1),
(43, 8, 1, 1, 86),
(44, 8, 1, 2, 91.6),
(45, 8, 1, 3, 0.8),
(46, 9, 11, 1, 86),
(47, 9, 11, 2, 91.5),
(48, 9, 11, 3, 1),
(49, 9, 12, 1, 86),
(50, 9, 12, 2, 91.5),
(51, 9, 12, 3, 0.8),
(52, 10, 9, 1, 85),
(53, 10, 9, 2, 91.5),
(54, 10, 9, 3, 1),
(55, 10, 11, 1, 85),
(56, 10, 11, 2, 91.5),
(57, 10, 11, 3, 0.8),
(58, 11, 1, 1, 89),
(59, 11, 1, 2, 91.4),
(60, 11, 1, 3, 1),
(61, 11, 3, 1, 89),
(62, 11, 3, 2, 91.4),
(63, 11, 3, 3, 0.8),
(64, 12, 11, 1, 89),
(65, 12, 11, 2, 91.3),
(66, 12, 11, 3, 1),
(67, 12, 9, 1, 89),
(68, 12, 9, 2, 91.3),
(69, 12, 9, 3, 0.8),
(70, 13, 1, 1, 86),
(71, 13, 1, 2, 91),
(72, 13, 1, 3, 1),
(73, 14, 13, 1, 90),
(74, 14, 13, 2, 91),
(75, 14, 13, 3, 1),
(76, 14, 14, 1, 90),
(77, 14, 14, 2, 91),
(78, 14, 14, 3, 0.8),
(79, 15, 1, 1, 85),
(80, 15, 1, 2, 90.7),
(81, 15, 1, 3, 1),
(82, 15, 9, 1, 85),
(83, 15, 9, 2, 90.7),
(84, 15, 9, 3, 0.8),
(85, 16, 15, 1, 86),
(86, 16, 15, 2, 90.6),
(87, 16, 15, 3, 1),
(88, 16, 16, 1, 86),
(89, 16, 16, 2, 90.6),
(90, 16, 16, 3, 0.8),
(91, 17, 1, 1, 88),
(92, 17, 1, 2, 90.1),
(93, 17, 1, 3, 1),
(94, 18, 15, 1, 86),
(95, 18, 15, 2, 89.9),
(96, 18, 15, 3, 1),
(97, 18, 9, 1, 86),
(98, 18, 9, 2, 89.9),
(99, 18, 9, 3, 0.8),
(100, 19, 17, 1, 90),
(101, 19, 17, 2, 89.5),
(102, 19, 17, 3, 1),
(103, 19, 18, 1, 90),
(104, 19, 18, 2, 89.5),
(105, 19, 18, 3, 0.8),
(106, 20, 4, 1, 86),
(107, 20, 4, 2, 89.5),
(108, 20, 4, 3, 1),
(109, 20, 3, 1, 86),
(110, 20, 3, 2, 89.5),
(111, 20, 3, 3, 0.8),
(112, 21, 9, 1, 85),
(113, 21, 9, 2, 89.2),
(114, 21, 9, 3, 1),
(115, 21, 1, 1, 85),
(116, 21, 1, 2, 89.2),
(117, 21, 1, 3, 0.8),
(118, 22, 19, 1, 90),
(119, 22, 19, 2, 88.9),
(120, 22, 19, 3, 1),
(121, 22, 20, 1, 90),
(122, 22, 20, 2, 88.9),
(123, 22, 20, 3, 0.8);


-- Table structure for table `siswa`
CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `kelas` varchar(20) DEFAULT NULL,
  `jurusan_smk` varchar(50) DEFAULT NULL,
  `rata_tkj` float DEFAULT NULL,
  `rata_akhir` float DEFAULT NULL,
  `jurusan_1` varchar(255) DEFAULT NULL,
  `jurusan_2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Data for table `siswa`
INSERT INTO `siswa` (`id_siswa`, `nama`, `nisn`, `kelas`, `jurusan_smk`, `rata_tkj`, `rata_akhir`, `jurusan_1`, `jurusan_2`) VALUES
(1, 'IVANA GRACIA ARBILITA OMEGA', '75136357', 'XII TJKT 1', 'TJKT', 92, 944, 'Teknik Informatika', 'Teknologi Informasi'),
(2, 'AGIL FERDINAN', '78555800', 'XII TJKT 2', 'TJKT', 92, 932, 'Teknik Jaringan Telekomunikasi Digital', 'Teknik Informatika'),
(3, 'ALLEANDRO DEWO PASKALIS', '74474783', 'XII TJKT 2', 'TJKT', 91, 926, 'Ilmu Komunikasi', ''),
(4, 'VIVIT PUTRI NOVELA', '3070255285', 'XII TJKT 1', 'TJKT', 86, 923, 'Teknik Industri Pertanian', 'Pendidikan Teknologi Informasi'),
(5, 'ALDA SELSI FIRDAUS', '3087308370', 'XII TJKT 1', 'TJKT', 85, 920, 'Teknologi Pendidikan', 'Manajemen Pemasaran'),
(6, 'SURYA SETA AJI WIDIGDYA', '78137358', 'XII TJKT 1', 'TJKT', 93, 919, 'Teknik Informatika', 'Teknik Elektro'),
(7, 'NOVIA ANGELA ARIADI', '78943829', 'XII TJKT 1', 'TJKT', 86, 917, 'Teknik Komputer', 'Teknik Elektro'),
(8, 'HAMDAN NAUFAL BAHRUL ULUM', '74926475', 'XII TJKT 1', 'TJKT', 86, 916, 'Teknik Jaringan Telekomunikasi Digital', 'Teknik Informatika'),
(9, 'MUHAMMAD RIZKY NURFIRMANSYAH', '76489077', 'XII TJKT 1', 'TJKT', 86, 915, 'Teknik Elektronika', 'Teknologi Rekayasa Sistem Elektronika'),
(10, 'FANNY VIOLITA RAHMANIA', '74940090', 'XII TJKT 1', 'TJKT', 85, 915, 'Teknik Elektro', 'Teknik Elektronika'),
(11, 'MUHAMMAD SULTAN AZZAM ALHAFIZD', '79847660', 'XII TJKT 1', 'TJKT', 89, 914, 'Teknik Informatika', 'Teknik Jaringan Telekomunikasi Digital'),
(12, 'GENTA SATRIA NIRWANA', '85596095', 'XII TJKT 1', 'TJKT', 89, 913, 'Teknik Elektronika', 'Teknik Elektro'),
(13, 'DEVANA AURELYA AGUSTIN', '71096637', 'XII TJKT 1', 'TJKT', 86, 910, 'Teknik Informatika', 'Teknik Informatika'),
(14, 'SIONG FAH CIN', '3083914701', 'XII TJKT 1', 'TJKT', 90, 910, 'Pendidikan Jasmani Kesehatan dan Rekreasi', 'Pariwisata'),
(15, 'NANDA AGUSTIN PUTRI FAWZYAH', '77348941', 'XII TJKT 1', 'TJKT', 85, 907, 'Teknik Informatika', 'Teknik Elektro'),
(16, 'IVY IVANA YAKUB', '79965564', 'XII TJKT 1', 'TJKT', 86, 906, 'Manajemen', 'Ilmu Kesehatan Masyarakat'),
(17, 'NOVIA NABILA', '74195947', 'XII TJKT 3', 'TJKT', 88, 901, 'Teknik Informatika', 'Teknik Informatika'),
(18, 'PATRICIA', '85392222', 'XII TJKT 1', 'TJKT', 86, 899, 'Manajemen', 'Teknik Elektro'),
(19, 'SARIFUDIN DAROJATUN', '89487758', 'XII TJKT 2', 'TJKT', 90, 895, 'Teknik Industri', 'Teknik Pengairan'),
(20, 'RIFQI APRELINO JETZADA', '87448582', 'XII TJKT 1', 'TJKT', 86, 895, 'Ilmu Komunikasi', 'Teknik Jaringan Telekomunikasi Digital'),
(21, 'MOHAMAD RAZA KAYZAN KURNIAWAN', '83443962', 'XII TJKT 1', 'TJKT', 85, 892, 'Teknik Elektro', 'Teknik Informatika'),
(22, 'ANANTHA KURNIAWAN', '72576570', 'XII TJKT 2', 'TJKT', 90, 889, 'Administrasi Bisnis', 'Pendidikan Guru Sekolah Dasar');


-- Table structure for table `user`
CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Data for table `user`
INSERT INTO `user` (`id_user`, `username`, `password`) VALUES
(1, 'admin', 'admin123'),
(2, 'guru', 'guru123'),
(3, 'operator', 'operator123');



-- Indexes for dumped tables

-- Indexes for table `alternatif`
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);


-- Indexes for table `hasil`
ALTER TABLE `hasil`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_alternatif` (`id_alternatif`);


-- Indexes for table `kriteria`
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);


-- Indexes for table `nilai`
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_alternatif` (`id_alternatif`),
  ADD KEY `id_kriteria` (`id_kriteria`);


-- Indexes for table `siswa`
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);


-- Indexes for table `user`
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);



-- AUTO_INCREMENT for dumped tables

-- AUTO_INCREMENT for table `alternatif`
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;


-- AUTO_INCREMENT for table `hasil`
ALTER TABLE `hasil`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;


-- AUTO_INCREMENT for table `kriteria`
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


-- AUTO_INCREMENT for table `nilai`
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;


-- AUTO_INCREMENT for table `siswa`
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;


-- AUTO_INCREMENT for table `user`
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;



-- Constraints for dumped tables

-- Constraints for table `hasil`
ALTER TABLE `hasil`
  ADD CONSTRAINT `hasil_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `hasil_ibfk_2` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE;


-- Constraints for table `nilai`
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_2` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_ibfk_3` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE;
COMMIT;
