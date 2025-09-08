-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 04:57 PM
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
-- Database: `sc_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartId` int(11) NOT NULL,
  `shopId` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `totalPrice` decimal(10,2) DEFAULT NULL,
  `addedTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartId`, `shopId`, `userId`, `productId`, `quantity`, `totalPrice`, `addedTime`) VALUES
(1, 0, NULL, 25, 1, 200000.00, '2024-12-17 04:07:05'),
(2, 0, NULL, 23, 1, 300000.00, '2024-12-17 04:07:05'),
(3, 0, NULL, 25, 1, 200000.00, '2024-12-17 04:07:05'),
(4, 0, NULL, 24, 1, 250000.00, '2024-12-17 04:07:05'),
(5, 0, NULL, 25, 1, 200000.00, '2024-12-17 04:07:05'),
(6, 0, NULL, 24, 1, 250000.00, '2024-12-17 04:07:05'),
(7, 0, NULL, 23, 1, 300000.00, '2024-12-17 04:07:05'),
(8, 0, NULL, 17, 1, 100000.00, '2024-12-17 04:07:05'),
(9, 0, NULL, 17, 1, 100000.00, '2024-12-17 04:07:05'),
(10, 0, NULL, 17, 1, 100000.00, '2024-12-17 04:07:05'),
(14, 0, NULL, 19, 1, 200000.00, '2024-12-17 04:07:05'),
(15, 0, NULL, 17, 1, 100000.00, '2024-12-17 04:07:05'),
(16, 0, NULL, 17, 1, 100000.00, '2024-12-17 04:07:05'),
(17, 0, NULL, 17, 1, 100000.00, '2024-12-17 04:07:05'),
(20, 0, 6, 23, 1, 300000.00, '2024-12-17 04:07:05'),
(21, 0, 3, 17, 1, 100000.00, '2024-12-17 04:07:05'),
(22, 0, 3, 25, 1, 200000.00, '2024-12-17 04:07:05'),
(23, 0, 4, 22, 1, 300000.00, '2024-12-17 04:07:05'),
(24, 0, 4, 24, 1, 250000.00, '2024-12-17 04:07:05'),
(25, 0, 3, 19, 1, 200000.00, '2024-12-17 04:07:05'),
(26, 0, 4, 17, 1, 100000.00, '2024-12-17 04:07:05'),
(27, 0, 2, 17, 1, 100000.00, '2024-12-17 04:07:05'),
(28, 0, 4, 28, 1, 200000.00, '2024-12-17 04:07:05'),
(30, 0, 7, 21, 1, 200000.00, '2024-12-17 04:07:05'),
(31, 0, 8, 17, 1, 100000.00, '2024-12-17 04:07:05'),
(32, 0, 4, 30, 1, 250000.00, '2024-12-17 04:07:05'),
(44, 9, 8, 32, 1, 200000.00, '2024-12-17 08:28:04'),
(51, 9, 9, 30, 1, 250000.00, '2024-12-17 14:03:14'),
(52, 6, 9, 27, 1, 1000000.00, '2024-12-17 14:03:22'),
(53, 9, 9, 32, 3, 600000.00, '2024-12-17 14:35:54'),
(54, 9, 9, 32, 1, 200000.00, '2024-12-17 15:52:44'),
(55, 2, 9, 17, 1, 100000.00, '2024-12-17 15:52:53');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productId` int(11) NOT NULL,
  `shopId` int(11) DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productDesc` varchar(200) DEFAULT NULL,
  `productCategory` enum('Shirts','Pants','Sweaters & Hoodies','Accessories','Footwear') DEFAULT NULL,
  `productPrice` decimal(10,2) DEFAULT NULL,
  `productQuantity` int(11) DEFAULT NULL,
  `productPhoto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productId`, `shopId`, `userId`, `productName`, `productDesc`, `productCategory`, `productPrice`, `productQuantity`, `productPhoto`, `created_at`) VALUES
(16, NULL, 3, 'White ', 'Good Quality', 'Shirts', 1234567.00, 1, '6755827252de3_WhatsApp Image 2024-12-04 at 10.32.18 PM (2).jpeg', '2024-12-08 05:26:42'),
(17, 2, 1, 'Green Sand Hoodie', 'Good Quality', '', 100000.00, 1, '6755844c48284_WhatsApp Image 2024-12-04 at 10.55.47 PM.jpeg', '2024-12-08 05:34:36'),
(18, 2, 1, 'White ', 'Good Quality', 'Shirts', 200000.00, 2, '675589d771e8a_WhatsApp Image 2024-12-04 at 10.32.18 PM (2).jpeg', '2024-12-08 05:58:15'),
(19, 2, 1, 'Short White Pants', 'Good Quality', 'Pants', 200000.00, 3, '67558a38e3bc0_WhatsApp Image 2024-12-04 at 10.44.04 PM.jpeg', '2024-12-08 05:59:52'),
(20, 2, 1, 'Fire Black Shirt', 'Good Quality', 'Shirts', 500000.00, 2, '67558a65a9b40_WhatsApp Image 2024-12-04 at 10.32.19 PM (2).jpeg', '2024-12-08 06:00:37'),
(21, 5, 5, 'White LOL', 'Good Quality', 'Shirts', 200000.00, 2, '6755922951e23_WhatsApp Image 2024-12-04 at 10.32.19 PM (3).jpeg', '2024-12-08 06:33:45'),
(22, 5, 5, 'AriZona Shirt Green', 'Ukuran XL (tersedia)', '', 300000.00, 2, '6755929db1a1f_WhatsApp Image 2024-12-04 at 10.55.46 PM (1).jpeg', '2024-12-08 06:35:41'),
(23, 5, 5, 'BlanCa Long Sleeve ', 'Ukuran XL L (tersedia)', 'Sweaters & Hoodies', 300000.00, 1, '6755933260153_WhatsApp Image 2024-12-04 at 10.55.46 PM.jpeg', '2024-12-08 06:38:10'),
(24, 5, 5, 'Baby Shirts Black', 'Good Quality ', 'Shirts', 250000.00, 2, '675593641928b_WhatsApp Image 2024-12-04 at 10.55.49 PM.jpeg', '2024-12-08 06:39:00'),
(25, 5, 5, 'Long Pants Black', 'ukuran 34', 'Pants', 200000.00, 2, '6755967c89d2a_WhatsApp Image 2024-12-04 at 10.44.02 PM.jpeg', '2024-12-08 06:52:12'),
(27, 6, 3, 'Jam Rolex ', 'Baguss', 'Accessories', 1000000.00, 1, '6758f258bbaab_WhatsApp Image 2024-12-04 at 11.06.15 PM.jpeg', '2024-12-10 20:00:56'),
(28, 7, 6, 'Green Hoodies', 'Baguus', '', 200000.00, 1, '6758f7de98d33_WhatsApp Image 2024-12-04 at 10.55.46 PM (1).jpeg', '2024-12-10 20:24:30'),
(29, 5, 5, 'Botol bekas ', 'Botol ajaib punya saa', 'Accessories', 100000.00, 1, '675a88c8da90b_123.jpeg', '2024-12-12 00:55:04'),
(30, 9, 8, 'Sweater Rajut Pink', 'Good Quality', '', 250000.00, 1, '676067696ebfe_woman-4792228_1280.jpg', '2024-12-16 11:46:17'),
(31, 2, 1, 'Colorful Sweaters', 'good ', '', 200000.00, 10, '67606bb64dc54_ai-generated-7974550_1280.jpg', '2024-12-16 12:04:38'),
(32, 9, 8, 'Yellow Jacket', 'Good', '', 200000.00, 10, '6761360d4377e_mockup-5206355_1280.jpg', '2024-12-17 02:27:57');

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `shopId` int(11) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `userId` int(11) NOT NULL,
  `shopName` varchar(255) NOT NULL,
  `phoneNumber` varchar(15) DEFAULT NULL,
  `shopDesc` text DEFAULT NULL,
  `bankAcc` varchar(255) NOT NULL,
  `linkPayment` varchar(255) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `operationalHours` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`shopId`, `userEmail`, `userId`, `shopName`, `phoneNumber`, `shopDesc`, `bankAcc`, `linkPayment`, `city`, `created_at`, `operationalHours`) VALUES
(2, '', 1, 'Funnie\'s Store', '08123345622', 'Good Quality', '', '', 'Jakarta Utara', '2024-12-07 14:13:54', ''),
(3, '', 1, 'Ennjeh store', '089223478', 'Nice Quality ', '', '', 'Jakarta Barat', '2024-12-07 14:25:56', ''),
(4, '', 1, 'Maieh store', '089223478', 'Nice Quality ', '', '', 'Jakarta Barat', '2024-12-07 14:29:27', ''),
(5, '', 5, 'Super Choice ', '08123345800', 'Menjual Fashion Second Kece ', '', '', 'Bekasi', '2024-12-08 12:06:14', '10:00 - 21:30'),
(6, '', 3, 'Sarah Rose', '081288925673', 'Toko Second, barang bagus', '', '', 'Jakarta Barat', '2024-12-11 01:58:41', ''),
(7, '', 6, 'Lala Store', '0872889000', 'Toko Second', '', '', 'Jakarta Timur', '2024-12-11 02:23:32', ''),
(9, 'kevin@gmail.com', 8, 'Kevin', '08129872922', 'Good', '9989127388', '', 'Kota Bekasi', '2024-12-16 16:22:55', '');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transactionId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `totalAmount` decimal(10,2) NOT NULL,
  `transactionDate` datetime NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transactionId`, `userId`, `totalAmount`, `transactionDate`, `status`) VALUES
(1, 9, 455000.00, '2024-12-17 00:58:53', 'Pending'),
(2, 9, 450000.00, '2024-12-17 15:29:41', 'Pending'),
(3, 9, 200000.00, '2024-12-17 20:19:22', 'Pending'),
(4, 9, 200000.00, '2024-12-17 20:28:18', 'Pending'),
(5, 9, 200000.00, '2024-12-17 20:32:27', 'Pending'),
(6, 9, 200000.00, '2024-12-17 20:43:22', 'Pending'),
(7, 9, 1000000.00, '2024-12-17 22:53:12', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE `transaction_details` (
  `detailId` int(11) NOT NULL,
  `transactionId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_payment`
--

CREATE TABLE `transaction_payment` (
  `paymentId` int(11) NOT NULL,
  `transactionId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `filePath` varchar(255) NOT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_payment`
--

INSERT INTO `transaction_payment` (`paymentId`, `transactionId`, `userId`, `filePath`, `uploadDate`) VALUES
(1, 2, 9, 'uploads/payment_proofs/bukti-transfer.jpeg', '2024-12-17 08:29:41'),
(2, 3, 9, 'uploads/payment_proofs/bukti-transfer.jpeg', '2024-12-17 13:19:22'),
(3, 4, 9, 'uploads/payment_proofs/bukti-transfer.jpeg', '2024-12-17 13:28:18'),
(4, 5, 9, 'uploads/payment_proofs/bukti-transfer.jpeg', '2024-12-17 13:32:27'),
(5, 6, 9, 'uploads/payment_proofs/bukti-transfer.jpeg', '2024-12-17 13:43:22'),
(6, 7, 9, 'uploads/payment_proofs/bukti-transfer.jpeg', '2024-12-17 15:53:12');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `userId` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `gender` enum('Laki-laki','Perempuan','Lainnya') NOT NULL,
  `birth_date` date DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Seller','Customer') NOT NULL DEFAULT 'Customer',
  `is_seller` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`userId`, `first_name`, `last_name`, `email`, `phone`, `address`, `gender`, `birth_date`, `password`, `role`, `is_seller`, `created_at`) VALUES
(1, 'Anggi', 'Magdalena', 'anggimagdalena0@gmail.com', '081234552678', 'Tangerang', 'Perempuan', '2000-06-02', '$2y$10$Me8wtUjrBWkzO3DM8Mj4Iu1VRsNpLIENjGRVxSyC9PNA3oLtpbIke', 'Customer', 1, '2024-12-03 14:41:17'),
(2, 'Vira', 'Ayu', 'vira@gmail.com', NULL, NULL, 'Perempuan', NULL, '$2y$10$Pzdi9S5e2/IKOcTvACaBi.3qr0zwtFSKBAKy0lGoTTK43D5XlLqn.', 'Admin', 0, '2024-12-04 01:57:11'),
(3, 'Sarah', 'Lein', 'sarah23@gmail.com', NULL, NULL, 'Perempuan', NULL, '$2y$10$yGzO/bEBaUdSdTutlduiK.l25uCgFMCjGB/RvDiK1cTFgGyzhqesG', 'Customer', 1, '2024-12-04 01:57:46'),
(4, 'Stefani', 'Asep', 'stefanikiw@gmail.com', NULL, NULL, 'Perempuan', NULL, '$2y$10$ve7MLh5GrU1cO97qAtoJEO7Mhh/ZJbS3./kX0MdTrS9dGKGIH1qd6', 'Customer', 0, '2024-12-04 01:58:22'),
(5, 'Darren', 'Axel', 'darenaxel@gmail.com', NULL, NULL, 'Laki-laki', NULL, '$2y$10$0SbBSpuufP72Fh5IqsFPLOC3MswWHCXGAqhawXdzwuDh9qmXYFETC', 'Customer', 1, '2024-12-08 12:05:11'),
(6, 'Jonah', 'Sean', 'sean23@gmail.com', NULL, NULL, 'Laki-laki', NULL, '$2y$10$vUyvvalwELQ8UX8BBWC7SOReSoefEcYzIUHNIkX.pFwZgZiw.3Gqm', 'Customer', 1, '2024-12-09 15:24:21'),
(7, 'Anggi', 'Keren', 'anggie@gmail.com', NULL, NULL, 'Laki-laki', NULL, '$2y$10$ZOpGqInqiwL694zHHQrWhuCYEsbMsFFMjZBsxKHe3VZQR4K/N7UH.', 'Customer', 0, '2024-12-12 06:45:26'),
(8, 'Kevin', 'Jordan', 'kevin@gmail.com', NULL, NULL, 'Laki-laki', NULL, '$2y$10$6RZMIncvo3EI6Mg.T45qjOeJp2WLx4Oxqv60jllXU2ded1movtLke', 'Customer', 1, '2024-12-16 15:10:25'),
(9, 'Selly', 'Camile', 'selly@gmail.com', NULL, NULL, 'Perempuan', NULL, '$2y$10$BueO2Uv7MO3dn9X7dABJWefAtlVuT0EiZdAMGtF9.Y7Ws0GDdqX3y', 'Customer', 0, '2024-12-16 17:49:25');

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `userId` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`userId`, `email`, `login_time`) VALUES
(1, 'anggimagdalena0@gmail.com', '2024-12-03 08:44:49'),
(1, 'anggimagdalena0@gmail.com', '2024-12-03 08:58:00'),
(1, 'anggimagdalena0@gmail.com', '2024-12-03 08:58:53'),
(1, 'anggimagdalena0@gmail.com', '2024-12-03 09:08:04'),
(1, 'anggimagdalena0@gmail.com', '2024-12-03 09:10:26'),
(1, 'anggimagdalena0@gmail.com', '2024-12-03 09:20:06'),
(1, 'anggimagdalena0@gmail.com', '2024-12-03 10:04:53'),
(1, 'anggimagdalena0@gmail.com', '2024-12-04 00:46:18'),
(1, 'anggimagdalena0@gmail.com', '2024-12-04 01:33:32'),
(1, 'anggimagdalena0@gmail.com', '2024-12-04 01:35:12'),
(1, 'anggimagdalena0@gmail.com', '2024-12-04 02:09:09'),
(1, 'anggimagdalena0@gmail.com', '2024-12-04 07:48:11'),
(1, 'anggimagdalena0@gmail.com', '2024-12-04 07:54:57'),
(1, 'anggimagdalena0@gmail.com', '2024-12-04 07:59:49'),
(1, 'anggimagdalena0@gmail.com', '2024-12-04 08:00:20'),
(1, 'anggimagdalena0@gmail.com', '2024-12-04 08:35:49'),
(1, 'anggimagdalena0@gmail.com', '2024-12-07 07:56:30'),
(1, 'anggimagdalena0@gmail.com', '2024-12-07 08:32:26'),
(1, 'anggimagdalena0@gmail.com', '2024-12-07 09:33:37'),
(1, 'anggimagdalena0@gmail.com', '2024-12-08 04:52:05'),
(1, 'anggimagdalena0@gmail.com', '2024-12-08 04:57:48'),
(1, 'anggimagdalena0@gmail.com', '2024-12-08 05:31:37'),
(1, 'anggimagdalena0@gmail.com', '2024-12-08 05:32:54'),
(1, 'anggimagdalena0@gmail.com', '2024-12-08 05:33:56'),
(1, 'anggimagdalena0@gmail.com', '2024-12-09 09:52:27'),
(1, 'anggimagdalena0@gmail.com', '2024-12-10 07:31:35'),
(1, 'anggimagdalena0@gmail.com', '2024-12-10 07:49:11'),
(1, 'anggimagdalena0@gmail.com', '2024-12-10 10:28:42'),
(1, 'anggimagdalena0@gmail.com', '2024-12-10 10:30:03'),
(1, 'anggimagdalena0@gmail.com', '2024-12-16 09:58:04'),
(1, 'anggimagdalena0@gmail.com', '2024-12-16 12:03:58'),
(2, 'vira@gmail.com', '2024-12-03 20:31:59'),
(2, 'vira@gmail.com', '2024-12-03 20:35:01'),
(2, 'vira@gmail.com', '2024-12-03 21:49:02'),
(2, 'vira@gmail.com', '2024-12-03 21:50:25'),
(2, 'vira@gmail.com', '2024-12-03 23:56:37'),
(2, 'vira@gmail.com', '2024-12-04 00:48:31'),
(2, 'vira@gmail.com', '2024-12-10 06:54:42'),
(2, 'vira@gmail.com', '2024-12-10 06:56:03'),
(2, 'vira@gmail.com', '2024-12-10 06:56:37'),
(2, 'vira@gmail.com', '2024-12-10 06:58:12'),
(2, 'vira@gmail.com', '2024-12-10 07:14:05'),
(3, 'sarah23@gmail.com', '2024-12-08 04:35:03'),
(3, 'sarah23@gmail.com', '2024-12-08 05:03:38'),
(3, 'sarah23@gmail.com', '2024-12-08 05:11:55'),
(3, 'sarah23@gmail.com', '2024-12-08 09:14:59'),
(3, 'sarah23@gmail.com', '2024-12-08 09:53:13'),
(3, 'sarah23@gmail.com', '2024-12-08 10:18:28'),
(3, 'sarah23@gmail.com', '2024-12-09 05:44:50'),
(3, 'sarah23@gmail.com', '2024-12-09 05:46:15'),
(3, 'sarah23@gmail.com', '2024-12-09 05:46:35'),
(3, 'sarah23@gmail.com', '2024-12-09 05:48:37'),
(3, 'sarah23@gmail.com', '2024-12-09 06:13:12'),
(3, 'sarah23@gmail.com', '2024-12-09 21:41:50'),
(3, 'sarah23@gmail.com', '2024-12-10 07:49:22'),
(3, 'sarah23@gmail.com', '2024-12-10 08:13:13'),
(3, 'sarah23@gmail.com', '2024-12-10 11:23:44'),
(3, 'sarah23@gmail.com', '2024-12-10 19:54:52'),
(3, 'sarah23@gmail.com', '2024-12-10 19:58:51'),
(4, 'stefanikiw@gmail.com', '2024-12-10 08:18:13'),
(4, 'stefanikiw@gmail.com', '2024-12-10 20:25:23'),
(4, 'stefanikiw@gmail.com', '2024-12-10 20:31:58'),
(4, 'stefanikiw@gmail.com', '2024-12-16 11:46:45'),
(5, 'darenaxel@gmail.com', '2024-12-08 06:05:25'),
(5, 'darenaxel@gmail.com', '2024-12-08 06:06:31'),
(5, 'darenaxel@gmail.com', '2024-12-08 07:13:23'),
(5, 'darenaxel@gmail.com', '2024-12-10 01:18:02'),
(5, 'darenaxel@gmail.com', '2024-12-12 00:54:15'),
(6, 'sean23@gmail.com', '2024-12-09 09:24:32'),
(6, 'sean23@gmail.com', '2024-12-09 09:27:24'),
(6, 'sean23@gmail.com', '2024-12-10 20:01:45'),
(6, 'sean23@gmail.com', '2024-12-10 20:01:46'),
(6, 'sean23@gmail.com', '2024-12-10 20:08:41'),
(6, 'sean23@gmail.com', '2024-12-10 20:20:47'),
(6, 'sean23@gmail.com', '2024-12-10 20:22:28'),
(6, 'sean23@gmail.com', '2024-12-10 20:23:54'),
(7, 'anggie@gmail.com', '2024-12-12 00:45:54'),
(7, 'anggie@gmail.com', '2024-12-12 00:48:53'),
(8, 'kevin@gmail.com', '2024-12-16 09:10:36'),
(8, 'kevin@gmail.com', '2024-12-16 09:56:09'),
(8, 'kevin@gmail.com', '2024-12-16 09:59:44'),
(8, 'kevin@gmail.com', '2024-12-16 11:44:54'),
(8, 'kevin@gmail.com', '2024-12-16 12:05:04'),
(8, 'kevin@gmail.com', '2024-12-17 02:27:00'),
(9, 'selly@gmail.com', '2024-12-16 11:49:35'),
(9, 'selly@gmail.com', '2024-12-16 12:05:20'),
(9, 'selly@gmail.com', '2024-12-17 02:28:36'),
(9, 'selly@gmail.com', '2024-12-17 03:34:33'),
(9, 'selly@gmail.com', '2024-12-17 09:52:35'),
(9, 'selly@gmail.com', '2024-12-17 09:53:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productId`),
  ADD KEY `fk_userId` (`userId`),
  ADD KEY `fk_shop` (`shopId`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`shopId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transactionId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`detailId`),
  ADD KEY `transactionId` (`transactionId`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `transaction_payment`
--
ALTER TABLE `transaction_payment`
  ADD PRIMARY KEY (`paymentId`),
  ADD KEY `transactionId` (`transactionId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`userId`,`login_time`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `shopId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transactionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `detailId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_payment`
--
ALTER TABLE `transaction_payment`
  MODIFY `paymentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user_data` (`userId`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_shop` FOREIGN KEY (`shopId`) REFERENCES `shop` (`shopId`),
  ADD CONSTRAINT `fk_userId` FOREIGN KEY (`userId`) REFERENCES `user_data` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `shop`
--
ALTER TABLE `shop`
  ADD CONSTRAINT `shop_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user_data` (`userId`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user_data` (`userId`);

--
-- Constraints for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD CONSTRAINT `transaction_details_ibfk_1` FOREIGN KEY (`transactionId`) REFERENCES `transactions` (`transactionId`),
  ADD CONSTRAINT `transaction_details_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`);

--
-- Constraints for table `transaction_payment`
--
ALTER TABLE `transaction_payment`
  ADD CONSTRAINT `transaction_payment_ibfk_1` FOREIGN KEY (`transactionId`) REFERENCES `transactions` (`transactionId`),
  ADD CONSTRAINT `transaction_payment_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user_data` (`userId`);

--
-- Constraints for table `user_login`
--
ALTER TABLE `user_login`
  ADD CONSTRAINT `user_login_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user_data` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
