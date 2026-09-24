-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 24, 2026 at 06:56 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pkl2026`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_akademik`
--

CREATE TABLE `tbl_akademik` (
  `kode_akd` varchar(10) NOT NULL,
  `semester` enum('GN','GL') NOT NULL,
  `tahun` char(4) NOT NULL,
  `is_active` enum('1','0') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_akademik`
--

INSERT INTO `tbl_akademik` (`kode_akd`, `semester`, `tahun`, `is_active`) VALUES
('4', 'GN', '2026', '0'),
('5', 'GL', '2026', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_kelas_matkul`
--

CREATE TABLE `tbl_detail_kelas_matkul` (
  `id_detail` int NOT NULL,
  `id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nim` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_detail_kelas_matkul`
--

INSERT INTO `tbl_detail_kelas_matkul` (`id_detail`, `id`, `nim`) VALUES
(15, '1', '42423042'),
(19, '1', '42423044'),
(21, '1', '42423045'),
(22, '1', '42423013'),
(23, '1', '42423043');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dosen`
--

CREATE TABLE `tbl_dosen` (
  `nik` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kontak` varchar(13) NOT NULL,
  `email` varchar(100) NOT NULL,
  `kelamin` char(1) NOT NULL,
  `img` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_dosen`
--

INSERT INTO `tbl_dosen` (`nik`, `nama`, `kontak`, `email`, `kelamin`, `img`) VALUES
('33402845', 'Khurotul Aeni, M.Kom', '038464874', 'aeni@gmail.com', 'P', NULL),
('33452467', 'Fathulloh, S.T., M.Kom', '093672343', 'fat@gmail.com', 'L', NULL),
('3345567', 'Achmad Syauqi, M.Kom', '038735', 'okyy@gmail.com', 'L', NULL),
('33456873', 'Sorikhi, M.kom', '0983645', 'sorikhi@gmail.com', 'L', NULL),
('33475868', 'Asep Saeful Millah, M.Kom', '9474656', 'millah@gmail.com', 'L', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jurusan`
--

CREATE TABLE `tbl_jurusan` (
  `kode_jurusan` varchar(50) NOT NULL,
  `nama_jurusan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_jurusan`
--

INSERT INTO `tbl_jurusan` (`kode_jurusan`, `nama_jurusan`) VALUES
('INF 1', 'Informatika'),
('INF 2', 'Informatika'),
('SI 1', 'Sistem Informasi'),
('SI 2', 'Sistem Informasi');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kelas_matkul`
--

CREATE TABLE `tbl_kelas_matkul` (
  `id` int NOT NULL,
  `kode_akd` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kode_matkul` varchar(10) NOT NULL,
  `kode_jurusan` varchar(50) NOT NULL,
  `nik` varchar(10) NOT NULL,
  `nama_kelas` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_kelas_matkul`
--

INSERT INTO `tbl_kelas_matkul` (`id`, `kode_akd`, `kode_matkul`, `kode_jurusan`, `nik`, `nama_kelas`) VALUES
(1, '4', 'PT001', 'INF 1', '33475868', 'INF 2'),
(3, '5', 'SPK002', 'INF 1', '33452467', 'INF 2'),
(6, '4', 'TKT003', 'INF 2', '33402845', 'INF 5'),
(7, '4', 'SPK002', 'SI 2', '33452467', 'SI 1'),
(8, '5', 'JK005', 'SI 2', '33452467', 'SI 2'),
(9, '5', 'PT001', 'INF 2', '33475868', 'INF 1'),
(10, '4', 'JK005', 'SI 1', '3345567', 'SI 1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_matkul`
--

CREATE TABLE `tbl_matkul` (
  `kode_matkul` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama_matkul` varchar(50) NOT NULL,
  `jml_sks` int NOT NULL,
  `jml_cpmk` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_matkul`
--

INSERT INTO `tbl_matkul` (`kode_matkul`, `nama_matkul`, `jml_sks`, `jml_cpmk`) VALUES
('CV004', 'Computer Vision', 3, 2),
('JK005', 'Jaringan Komputer', 3, 2),
('PT001', 'Pemrograman Terstruktur', 2, 2),
('SPK002', 'Sistem Pendukung Keputusan', 3, 2),
('TKT003', 'Tata Kelola TI', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mhs`
--

CREATE TABLE `tbl_mhs` (
  `nim` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kontak` varchar(13) NOT NULL,
  `email` varchar(100) NOT NULL,
  `kelamin` char(1) NOT NULL,
  `img` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_mhs`
--

INSERT INTO `tbl_mhs` (`nim`, `nama`, `kontak`, `email`, `kelamin`, `img`) VALUES
('42423013', 'Najwa Shabira', '096343784549', 'najwa@gmail.com', 'P', '../aset_web/img/foto-mhs1787552855.png'),
('42423042', 'Tena Erfiana', '084263814730', 'tena@gmail.com', 'P', ''),
('42423043', 'Alfi Resti Zelia', '086342814239', 'alfi@gmail.com', 'P', ''),
('42423044', 'Sasi Maelani', '082324650425', 'sasi@gmail.com', 'P', ''),
('42423045', 'Azam Putra', '098634362423', 'Aazam@gmail.com', 'L', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengguna`
--

CREATE TABLE `tbl_pengguna` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `sandi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `peran` char(1) NOT NULL,
  `pin` int NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_pengguna`
--

INSERT INTO `tbl_pengguna` (`id`, `username`, `sandi`, `peran`, `pin`, `nama`) VALUES
(8, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'A', 654321, 'Lestari'),
(12, '42423042', 'c7e92618fcec045a0261caf1d0cff75b16ba050e', 'M', 123456, 'Tena Erfiana'),
(14, '42423044', '0c572e05f45667de31ad87618662e26c1e7ac862', 'M', 123456, 'Sasi Maelani'),
(15, '42423013', '0688df815d1deebf8290987641a4eaceee6c865e', 'M', 123456, 'Najwa Shabira'),
(26, '424230', '025e7891a09bbce8b4977923ef05443a85896011', 'M', 123456, 'Fatah Fernandes'),
(35, '515392', '4b1cf56682a68ad29c9b8cb923ea40dd44035f3d', 'A', 696969, 'Aqila Calista'),
(66, '33475868', '93ca72a1ce3540582a0713658d4b429bebd168c4', 'D', 696969, 'Asep Saeful Millah, M.Kom'),
(67, '33456873', '64f8ecd16a8a16da5d2d31a52645ec345a74d459', 'D', 696969, 'Sorikhi, M.kom'),
(68, '33402845', '9fa8d7eb087c65b07e3f5b65371da72606401f28', 'D', 696969, 'Khurotul Aeni, M.Kom'),
(69, '33452467', '4aade77f310e130dacbad95aab1fa74357573bff', 'D', 696969, 'Fathulloh, S.T., M.Kom'),
(70, '3345567', 'faec26dbbdd0c759843909310d2e71896637f9e1', 'D', 696969, 'Achmad Syauqi, M.Kom'),
(71, '33475868', '93ca72a1ce3540582a0713658d4b429bebd168c4', 'D', 696969, 'Asep Saeful Millah, M.Kom');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pertemuan`
--

CREATE TABLE `tbl_pertemuan` (
  `id_pertemuan` int NOT NULL,
  `id` varchar(10) NOT NULL,
  `tanggal` date NOT NULL,
  `judul_pertemuan` varchar(255) NOT NULL,
  `status` char(1) NOT NULL,
  `pertemuan_ke` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_pertemuan`
--

INSERT INTO `tbl_pertemuan` (`id_pertemuan`, `id`, `tanggal`, `judul_pertemuan`, `status`, `pertemuan_ke`) VALUES
(12, '10', '2026-09-07', 'Jaringan Nirkabel', '1', 1),
(13, '10', '2026-09-07', 'DIgital Forensic', '1', 2),
(14, '10', '2026-09-07', 'Uji Forensic Objek Digital', '1', 3),
(16, '1', '2026-09-07', 'AI', '1', 1),
(17, '1', '2026-09-07', 'qr code', '1', 2),
(18, '6', '2026-09-07', 'Tata Kelola IT', '1', 1),
(19, '6', '2026-09-07', 'Tata Kelola IT', '1', 2),
(20, '1', '2026-09-08', 'Logika Matematika', '1', 3),
(21, '1', '2026-09-08', 'PHP', '1', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_presensi`
--

CREATE TABLE `tbl_presensi` (
  `id_presensi` int NOT NULL,
  `id_pertemuan` int NOT NULL,
  `nim` varchar(10) NOT NULL,
  `status_kehadiran` enum('hadir','alfa','izin','sakit') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_presensi`
--

INSERT INTO `tbl_presensi` (`id_presensi`, `id_pertemuan`, `nim`, `status_kehadiran`) VALUES
(1, 6, '42423042', 'izin'),
(2, 6, '42423044', 'hadir'),
(3, 6, '42423045', 'sakit'),
(4, 6, '42423013', 'hadir'),
(5, 6, '42423043', 'alfa'),
(6, 16, '42423042', 'alfa'),
(7, 16, '42423044', 'hadir'),
(8, 16, '42423045', 'izin'),
(9, 16, '42423013', 'sakit'),
(10, 16, '42423043', 'alfa'),
(11, 17, '42423042', 'hadir'),
(12, 17, '42423044', 'hadir'),
(13, 17, '42423045', 'hadir'),
(14, 17, '42423013', 'hadir'),
(15, 17, '42423043', 'hadir'),
(16, 20, '42423042', 'hadir'),
(17, 20, '42423044', 'hadir'),
(18, 20, '42423045', 'hadir'),
(19, 20, '42423013', 'hadir'),
(20, 20, '42423043', 'hadir'),
(21, 21, '42423042', 'hadir'),
(22, 21, '42423044', 'hadir'),
(23, 21, '42423045', 'hadir'),
(24, 21, '42423013', 'hadir'),
(25, 21, '42423043', 'izin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_akademik`
--
ALTER TABLE `tbl_akademik`
  ADD PRIMARY KEY (`kode_akd`);

--
-- Indexes for table `tbl_detail_kelas_matkul`
--
ALTER TABLE `tbl_detail_kelas_matkul`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `tbl_dosen`
--
ALTER TABLE `tbl_dosen`
  ADD PRIMARY KEY (`nik`);

--
-- Indexes for table `tbl_jurusan`
--
ALTER TABLE `tbl_jurusan`
  ADD PRIMARY KEY (`kode_jurusan`);

--
-- Indexes for table `tbl_kelas_matkul`
--
ALTER TABLE `tbl_kelas_matkul`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_matkul`
--
ALTER TABLE `tbl_matkul`
  ADD PRIMARY KEY (`kode_matkul`);

--
-- Indexes for table `tbl_mhs`
--
ALTER TABLE `tbl_mhs`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pertemuan`
--
ALTER TABLE `tbl_pertemuan`
  ADD PRIMARY KEY (`id_pertemuan`);

--
-- Indexes for table `tbl_presensi`
--
ALTER TABLE `tbl_presensi`
  ADD PRIMARY KEY (`id_presensi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_detail_kelas_matkul`
--
ALTER TABLE `tbl_detail_kelas_matkul`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_kelas_matkul`
--
ALTER TABLE `tbl_kelas_matkul`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `tbl_pertemuan`
--
ALTER TABLE `tbl_pertemuan`
  MODIFY `id_pertemuan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_presensi`
--
ALTER TABLE `tbl_presensi`
  MODIFY `id_presensi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
