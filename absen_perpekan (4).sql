-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2024 at 07:17 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absen_perpekan`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('hadir','Alfa','Sakit','Izin') NOT NULL,
  `deskripsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `id_siswa`, `tanggal`, `status`, `deskripsi`) VALUES
(673, 1, '2024-06-10', 'hadir', ''),
(674, 2, '2024-06-10', 'hadir', ''),
(675, 3, '2024-06-10', 'hadir', ''),
(676, 4, '2024-06-10', 'hadir', ''),
(677, 5, '2024-06-10', 'hadir', ''),
(678, 6, '2024-06-10', 'hadir', ''),
(679, 7, '2024-06-10', 'hadir', ''),
(680, 8, '2024-06-10', 'hadir', ''),
(681, 9, '2024-06-10', 'hadir', ''),
(682, 10, '2024-06-10', 'hadir', ''),
(683, 11, '2024-06-10', 'hadir', ''),
(684, 12, '2024-06-10', 'hadir', ''),
(685, 13, '2024-06-10', 'hadir', ''),
(686, 14, '2024-06-10', 'hadir', ''),
(687, 15, '2024-06-10', 'hadir', ''),
(688, 16, '2024-06-10', 'hadir', ''),
(689, 17, '2024-06-10', 'hadir', ''),
(690, 18, '2024-06-10', 'hadir', ''),
(691, 19, '2024-06-10', 'hadir', ''),
(692, 20, '2024-06-10', 'hadir', ''),
(693, 21, '2024-06-10', 'hadir', ''),
(694, 22, '2024-06-10', 'hadir', ''),
(695, 23, '2024-06-10', 'hadir', ''),
(696, 24, '2024-06-10', 'hadir', ''),
(697, 25, '2024-06-10', 'Sakit', ''),
(698, 26, '2024-06-10', 'hadir', ''),
(699, 27, '2024-06-10', 'hadir', ''),
(700, 28, '2024-06-10', 'hadir', ''),
(701, 29, '2024-06-10', 'hadir', ''),
(702, 30, '2024-06-10', 'hadir', '');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `email`, `username`, `password`) VALUES
(0, 'Admin Name', 'admin@example.com', 'admin', '$2y$10$wZlNXXfS6tK8E6e9SxESmOfx3kyaK/VP/BOhcTbPfz9HOkTvkVc.e');

-- --------------------------------------------------------

--
-- Table structure for table `ketua_kelas`
--

CREATE TABLE `ketua_kelas` (
  `id` int(20) NOT NULL,
  `Name` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ketua_kelas`
--

INSERT INTO `ketua_kelas` (`id`, `Name`, `username`, `password`) VALUES
(13, 'Rayhan Juli', 'rey', '$2y$10$7sqDjxGJl1umhWy5dLVnLesY6Pdh94NOvL2K7tNhteV6K2CXpkb7e');

-- --------------------------------------------------------

--
-- Table structure for table `rentang_pekanan`
--

CREATE TABLE `rentang_pekanan` (
  `id` int(20) NOT NULL,
  `tgl_awal` date NOT NULL,
  `tgl_akhir` date NOT NULL,
  `pekan_ke` varchar(20) NOT NULL,
  `bulan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rentang_pekanan`
--

INSERT INTO `rentang_pekanan` (`id`, `tgl_awal`, `tgl_akhir`, `pekan_ke`, `bulan`) VALUES
(24, '2024-06-10', '2024-06-14', '2', '6');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nis` varchar(255) NOT NULL,
  `nisn` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `id_kelas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `nis`, `nisn`, `alamat`, `tgl_lahir`, `id_kelas`) VALUES
(1, 'ABD.RAHMAN.N', '22351', '0061352650', 'jl Sungai pareman', '2007-06-09', 1),
(2, 'AHMAD ANUGRAH SATYA', '22352', '0071448087', 'jl traktor 4', '2007-01-19', 1),
(3, 'AHSAN PUTRA AHYAR', '22353', '0074444833', 'jl Kijang', '2007-08-03', 1),
(4, 'ANDI ASHADELAH MAHARANI A', '22354', '0074631157', 'Minasa Upa', '2007-06-20', 1),
(5, 'ANDI MUH.RAIHAN ALKAWSAR', '22355', '0077865020', 'Jl bulusaraung', '2007-08-08', 1),
(6, 'CHAIRIL ABIZALI HALIM', '22356', '0074298055', 'jl pongtiku', '2007-05-10', 1),
(7, 'FACHRI RAMADHAN.A', '22357', '0077458672', 'Jl Rusa', '2007-12-07', 1),
(8, 'FATSA AKHWANI', '22358', '3062547750', 'Antang', '2007-01-04', 1),
(9, 'HANSAR', '22360', '0061866130', 'Jl Maccini', '2007-12-01', 1),
(10, 'JORDAN', '22361', '0061994618', 'Jl Pampang 1', '2007-06-01', 1),
(11, 'M.NAFAN NABIL N', '22362', '0071452297', 'Barukang', '2007-05-07', 1),
(12, 'MUH ALFAHREZI RAIHAN', '22363', '0076826642', 'Jl Rappojawa', '2007-08-10', 1),
(13, 'MUH.ARDIANSYA', '22364', '0075342172', 'Jl Maccini', '2007-08-19', 1),
(14, 'MUH DAUD RESKI JAYADI', '22365', '0076370223', 'Jl Pongtiku\r\n', '2007-08-17', 1),
(15, 'MUH.NUR REZKI AL \'FATIR', '22367', '0073298902', 'Jl pongtiku', '2007-06-22', 1),
(16, 'MUH.TAUFIK', '22368', '0068886036', 'Jl Pampang 5', '2007-06-16', 1),
(17, 'MUH. TAUFIQ ADIGUNA', '22369', '0078521536', 'Jl Adipura', '2007-06-12', 1),
(18, 'MUHAMMAD AGIS', '22370', '0078335217', 'Galangan kapal', '2007-05-18', 1),
(19, 'MUHAMMAD FADHIL AMIR', '22372', '0064595636', 'Jl Maccini kidul', '2007-09-11', 1),
(20, 'MUHAMMAD FARHAN MAULANA', '22373', '0072837619', 'Jl lompobattang', '2007-05-18', 1),
(21, 'MUHAMMAD FATHURRAHMAN PRATAMA', '22374\r\n', '0061914974', 'Jl Pampang 2 lr 5', '2007-06-02', 1),
(22, 'MUHAMMAD ZHAFRAN RIZKY SYAH ALAM', '22376', '0077625945', 'Jl Racing', '2007-05-02', 1),
(23, 'NABIL SHIDDIQ Z', '22377', '0074755907\r\n', 'Jl pongtiku', '2007-06-21', 1),
(24, 'NUR AFNI RAMADANI', '22379', '0069025149\r\n', 'jl Maccini', '2007-06-05', 1),
(25, 'NUR INAYAH ATHAILLAH ABADI', '22380', '0077101133', 'jl cendrawasih', '2007-05-11', 1),
(26, 'NUR RAHMAT RAMADAN', '22381', '0064560534', 'jl Rappokalling raya', '2007-12-07', 1),
(27, 'RAYHAN JULI SAPUTRA', '22382', '0078990294', 'JL Pongtiku', '2007-06-11', 1),
(28, 'REZKY AWALYA', '22383', '0076417451', 'jl Naja Dg.Nai', '2007-06-02', 1),
(29, 'SITI NUR HAZISA.A', '22384', '0069211408', 'jl abu bakar lambogo', '2007-05-19', 1),
(30, 'MUH RAYHAN AL FAZHARI', '22385', '0067531902', 'JL Cendrawasih 2', '2007-12-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id` int(20) NOT NULL,
  `nama` varchar(25) NOT NULL,
  `id_ketua_kelas` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_kelas`
--

INSERT INTO `tb_kelas` (`id`, `nama`, `id_ketua_kelas`) VALUES
(1, '11 RPL 1', 13);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sw` (`id_siswa`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `ketua_kelas`
--
ALTER TABLE `ketua_kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `rentang_pekanan`
--
ALTER TABLE `rentang_pekanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_siswa_kelas` (`id_kelas`);

--
-- Indexes for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_ketua_kelas` (`id_ketua_kelas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=703;

--
-- AUTO_INCREMENT for table `ketua_kelas`
--
ALTER TABLE `ketua_kelas`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `rentang_pekanan`
--
ALTER TABLE `rentang_pekanan`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `fk_sw` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `fk_siswa_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id`);

--
-- Constraints for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD CONSTRAINT `id_ketua_kelas` FOREIGN KEY (`id_ketua_kelas`) REFERENCES `ketua_kelas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
