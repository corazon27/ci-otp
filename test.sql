-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2023 at 02:04 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `biodata`
--

CREATE TABLE `biodata` (
  `id_biodata` int(11) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `jk` enum('Laki-laki','Perempuan') NOT NULL,
  `no_telp` varchar(12) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `biodata`
--

INSERT INTO `biodata` (`id_biodata`, `alamat`, `jk`, `no_telp`, `id_user`) VALUES
(1, 'Bumi Nusantara 1 Jl.Mawar No.A11 RT 06/RW 06', 'Laki-laki', '082136405274', 5),
(14, 'Bumi Prayudan', 'Laki-laki', '082136405274', 6),
(15, 'Tes Alamat', 'Laki-laki', '087870446678', 14);

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id_kecamatan` int(11) NOT NULL,
  `id_kota` int(11) NOT NULL,
  `kecamatan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kecamatan`
--

INSERT INTO `kecamatan` (`id_kecamatan`, `id_kota`, `kecamatan`) VALUES
(1, 2, 'Kec Mertoyudan'),
(2, 2, 'Kec Muntilan'),
(3, 1, 'Tulung'),
(4, 1, 'Kebonpolo');

-- --------------------------------------------------------

--
-- Table structure for table `kota`
--

CREATE TABLE `kota` (
  `id_kota` int(11) NOT NULL,
  `id_provinsi` int(11) NOT NULL,
  `kota` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kota`
--

INSERT INTO `kota` (`id_kota`, `id_provinsi`, `kota`) VALUES
(1, 1, 'Kota Magelang'),
(2, 1, 'Kab Magelang');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(50,0) NOT NULL,
  `image` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `created_at`, `id_user`) VALUES
(1, 'bes', 'tes', '2123', 'a744833210a22a1f07c9648a4790a60b.jpg', 1693289997, 5),
(2, 'baru', 'tbau', '907', 'dcade9ca7569432c66352b994dc76063.jpg', 1690165597, 6),
(5, 'carti', 'carti', '43243', '1e60de8086a03bb90eb393f2267a3f20.jpg', 1690345083, 6),
(6, 'dsfd', '324234', '34242', '1400b766b7ad700a0ae8c3018d2fb0a5.jpg', 1690204331, 6),
(7, 'bre', 'gri', '2321', 'd1d5eee6abf90883a1156412c21a132d.jpg', 1693289960, 5),
(9, 'tes', 'tes', '32131', '01297433af7a28a0525ba7cc6568f452.jpg', 1690344993, 6),
(10, 'user', 'user baru', '41313', 'f4b483eaef38d009561a86bc9c271cb0.png', 1690514325, 5),
(12, 'justindo', 'bingung', '212', 'a9aed28d2e54c1cac5f056b76b4fbdfd.jpeg', 1693289956, 5);

-- --------------------------------------------------------

--
-- Table structure for table `provinsi`
--

CREATE TABLE `provinsi` (
  `id_provinsi` int(11) NOT NULL,
  `provinsi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `provinsi`
--

INSERT INTO `provinsi` (`id_provinsi`, `provinsi`) VALUES
(1, 'Jawa Tengah'),
(2, 'Jawa Barat'),
(3, 'Jawa Timur'),
(4, 'DIY');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `photo` varchar(128) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `is_active` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `date_created` int(11) NOT NULL,
  `id_provinsi` int(11) NOT NULL,
  `id_kota` int(11) NOT NULL,
  `id_kecamatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `name`, `email`, `photo`, `username`, `password`, `is_active`, `role_id`, `date_created`, `id_provinsi`, `id_kota`, `id_kecamatan`) VALUES
(5, 'Sandhika Galih', 'sandhikagalih@unpas.ac.id', 'a0c29d38ba1aacbbcd5c32486a976039.jpg', 'admin', '$2y$10$MlR2biWoMcKP6JVp5/5Fbu3Nai4NL9CW5XTTvI/1J6rlFk5rT0XV6', 1, 1, 1552120289, 1, 2, 1),
(6, 'Doddy Ferdiansyah', 'doddy@gmail.com', '383009bc784f2e3c8ba4981755a0f240.jpg', 'doddy', '$2y$10$MlR2biWoMcKP6JVp5/5Fbu3Nai4NL9CW5XTTvI/1J6rlFk5rT0XV6', 1, 1, 1552285263, 0, 0, 0),
(13, 'tes', 'tes321@gmail.com', 'user.png', 'tes321', '$2y$10$MlR2biWoMcKP6JVp5/5Fbu3Nai4NL9CW5XTTvI/1J6rlFk5rT0XV6', 1, 2, 1690862917, 0, 0, 0),
(14, 'adminn', 'adminn@gmail.com', '3fe4f0ea4e3dbae6b5965ee977acb0a0.jpg', 'admivn', '$2y$10$MlR2biWoMcKP6JVp5/5Fbu3Nai4NL9CW5XTTvI/1J6rlFk5rT0XV6', 1, 1, 1690862957, 0, 0, 0),
(17, 'random', 'random@gmail.com', 'default.png', 'random', '$2y$10$Cqkucr/hOXCrfgXQhtTZg.dvXIZAoF.o7y2lx68ieCkk9YVn0PUfW', 1, 2, 1690863735, 0, 0, 0),
(18, 'random1', 'random1@gmail.com', 'user.png', 'random1', '$2y$10$5JPmv4K5a/UCCGoAub96rOfYDWbySmB9sNU4iYodt/GNkGwUfBM7m', 1, 2, 1690863774, 0, 0, 0),
(27, 'tes email', 'alfiandotid@gmail.com', 'default.png', 'tess', '$2y$10$VyITbMe6WLb90j7KYogGTOh20cJv88l3HB3T1UX0n72EUnZHu.Zwq', 0, 2, 1693455407, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Administrator'),
(2, 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `email`, `token`, `date_created`) VALUES
(9, 'alfiandotid@gmail.com', '9GG0s0hRCHXswgr64QuOgAg9zFpWPg9msWJ2vD/SXY0=', 1693452261),
(10, 'alfiandotid@gmail.com', 'V81N6PXsCVx5mjZwrQGPajwv+811ZqvDE9GZLlwIYh0=', 1693452591),
(11, 'alfiandotid@gmail.com', 'KmUvLBdFbHMN2KXZBHPJrxF/Ma9SX9dw1i2kznNwt8c=', 1693452757),
(12, 'alfiandotid@gmail.com', 'ZlT5pJQgGTpgQyndV81xAMyM09f9FTnbWfGfXF+MLu0=', 1693453183),
(13, 'alfiandotid@gmail.com', '0h9rF2VNxGSWpoQYRUTMsumoSZGzuSjL2lZl5DoX/Vg=', 1693453369),
(14, 'alfiandotid@gmail.com', '/oguEw1qCmhU1Kjh9wIaRc4mH1fL0EbB+2/GiyPGjzM=', 1693453656),
(15, 'alfiandotid@gmail.com', '+ZaRBRFMF46bnm5ky4xpE0mPiBemhP0QhkQIT+TyLNk=', 1693453733),
(16, 'alfiandotid@gmail.com', 'lLd0jGQLR6eIl5Jh0p6QovjC6CeIr4ox0vhItEx5xhg=', 1693454169),
(17, 'alfiandotid@gmail.com', 'mzWtJ12XJk5v1nOjXDqxzNKC4JhvmGnZX6mnfJMfKPc=', 1693455407);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `biodata`
--
ALTER TABLE `biodata`
  ADD PRIMARY KEY (`id_biodata`);

--
-- Indexes for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id_kecamatan`);

--
-- Indexes for table `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`id_kota`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`id_provinsi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `biodata`
--
ALTER TABLE `biodata`
  MODIFY `id_biodata` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id_kecamatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kota`
--
ALTER TABLE `kota`
  MODIFY `id_kota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `provinsi`
--
ALTER TABLE `provinsi`
  MODIFY `id_provinsi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
