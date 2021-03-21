-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2021 at 04:55 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mini_projek`
--

-- --------------------------------------------------------

--
-- Table structure for table `alamat`
--

CREATE TABLE `alamat` (
  `id_alamat` int(11) NOT NULL,
  `id_customers` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `provinsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alamat`
--

INSERT INTO `alamat` (`id_alamat`, `id_customers`, `alamat`, `provinsi`) VALUES
(1, 'Cust-9a8a34e1', 'surabaya', NULL),
(2, 'Cust-0a90aea6', 'malang', NULL),
(3, 'Cust-79cb0b3a', 'sidoarjo', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_table_customer` int(11) NOT NULL,
  `uniqID_Customer` varchar(100) NOT NULL,
  `email_customer` varchar(50) NOT NULL,
  `nama_customer` varchar(50) NOT NULL,
  `bod_customer` date NOT NULL,
  `phone_customer` varchar(20) NOT NULL,
  `status_delete` int(11) DEFAULT 0,
  `date_create` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id_table_customer`, `uniqID_Customer`, `email_customer`, `nama_customer`, `bod_customer`, `phone_customer`, `status_delete`, `date_create`) VALUES
(1, 'Cust-9a8a34e1', 'babesugab@gmail.com', 'babesugab', '2021-03-16', '03189999999', 0, '2021-03-18 09:54:18'),
(2, 'Cust-0a90aea6', 'b46usf@gmail.com', 'b46usf', '2021-03-18', '123', 0, '2021-03-18 09:54:18'),
(3, 'Cust-79cb0b3a', 'recy@gmail.com', 'recy', '2021-03-18', '0318888888', 0, '2021-03-18 15:40:50');

-- --------------------------------------------------------

--
-- Table structure for table `customers_image`
--

CREATE TABLE `customers_image` (
  `idtab_image` int(11) NOT NULL,
  `id_customers` varchar(100) NOT NULL,
  `file_location` text NOT NULL,
  `file_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers_image`
--

INSERT INTO `customers_image` (`idtab_image`, `id_customers`, `file_location`, `file_image`) VALUES
(1, 'Cust-9a8a34e1', 'storage/img', 'Cust-9a8a34e1.jpg'),
(2, 'Cust-0a90aea6', 'storage/img', 'Cust-0a90aea6.jpg'),
(3, 'Cust-79cb0b3a', 'storage/img', 'Cust-79cb0b3a.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `rekening`
--

CREATE TABLE `rekening` (
  `id_rekening` int(11) NOT NULL,
  `id_customers` varchar(100) NOT NULL,
  `nomor_rekening` varchar(20) NOT NULL,
  `bank_rekening` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rekening`
--

INSERT INTO `rekening` (`id_rekening`, `id_customers`, `nomor_rekening`, `bank_rekening`) VALUES
(1, 'Cust-9a8a34e1', '123', 'qwe'),
(2, 'Cust-0a90aea6', '123', 'qwe'),
(3, 'Cust-79cb0b3a', '123', 'qwe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alamat`
--
ALTER TABLE `alamat`
  ADD PRIMARY KEY (`id_alamat`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_table_customer`);

--
-- Indexes for table `customers_image`
--
ALTER TABLE `customers_image`
  ADD PRIMARY KEY (`idtab_image`);

--
-- Indexes for table `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`id_rekening`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alamat`
--
ALTER TABLE `alamat`
  MODIFY `id_alamat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_table_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customers_image`
--
ALTER TABLE `customers_image`
  MODIFY `idtab_image` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rekening`
--
ALTER TABLE `rekening`
  MODIFY `id_rekening` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
