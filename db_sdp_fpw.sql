-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 22, 2022 at 06:06 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sdp_fpw`
--
CREATE DATABASE IF NOT EXISTS `db_sdp_fpw` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_sdp_fpw`;

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE `Customer` (
  `customer_id` int(11) NOT NULL,
  `customer_username` varchar(256) NOT NULL,
  `customer_password` varchar(256) NOT NULL,
  `customer_name` varchar(256) NOT NULL,
  `customer_address` varchar(256) NOT NULL,
  `customer_phonenumber` varchar(256) NOT NULL,
  `customer_gender` varchar(10) NOT NULL,
  `customer_accountnumber` varchar(256) NOT NULL,
  `customer_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 -> active,\\\\n0 -> nonactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Customer`
--

INSERT INTO `Customer` (`customer_id`, `customer_username`, `customer_password`, `customer_name`, `customer_address`, `customer_phonenumber`, `customer_gender`, `customer_accountnumber`, `customer_status`, `created_at`, `updated_at`) VALUES
(1, 'wnicolas', 'dummyCust', 'Maiya Padberg', '64213 Ima Trafficway\nCarterton, AZ 90318', '+1-507-564-3868', 'female', '2237708636798036', 1, '2022-11-01 19:26:21', '2022-11-21 21:36:26'),
(2, 'ianderson', 'dummyCust', 'Stanley Erdman', '64344 Adrianna Plain Suite 658\nNorth Elissa, MD 54590', '+15024379113', 'male', '6058468784429131', 1, '2022-11-01 19:26:21', '2022-11-01 19:26:21'),
(3, 'prosacco.raina', 'dummyCust', 'Dr. Jennifer Kozey DVM', '4816 Gustave Stravenue Apt. 375\nPort Carmenchester, DC 94805-3883', '+19808585519', 'female', '3578457685388996', 1, '2022-11-01 19:26:21', '2022-11-01 19:26:21'),
(4, 'dudley05', 'dummyCust', 'Dr. Alize Beatty', '601 Prosacco Overpass Apt. 439\nLake Annie, FL 05431', '1-859-460-9259', 'female', '8156777351695508', 1, '2022-11-01 19:26:21', '2022-11-01 19:26:21'),
(5, 'yasmine.jacobson', 'dummyCust', 'Reese Rippin', '9385 Christ Orchard Suite 610\nKieratown, MN 52882', '(863) 383-1818', 'male', '5113058782529333', 1, '2022-11-01 19:26:21', '2022-11-01 19:26:21'),
(6, 'praba62', 'dummyCust', 'Harsana Garda Nashiruddin S.I.Kom', 'Psr. Basuki No. 632, Tidore Kepulauan 84182, Jatim', '0406 5131 658', 'male', '5719992630808434', 1, '2022-11-01 19:31:35', '2022-11-01 19:31:35'),
(7, 'yuni.puspita', 'dummyCust', 'Icha Susanti', 'Ds. Gajah No. 478, Tomohon 28165, DKI', '0472 1113 1660', 'female', '7320195470266282', 1, '2022-11-01 19:31:35', '2022-11-01 19:31:35'),
(14, 'TheShoppingLad', 'abc654321', 'Lorem Ipsum', 'Jalan Mawar no 21, Surabaya', '081211444555', 'male', '5154676777223344', 1, '2022-11-08 22:36:29', '2022-11-08 22:36:29');

-- --------------------------------------------------------

--
-- Table structure for table `D_Trans`
--

CREATE TABLE `D_Trans` (
  `dtrans_id` int(11) NOT NULL,
  `invoice_number` varchar(256) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `H_Trans`
--

CREATE TABLE `H_Trans` (
  `invoice_number` varchar(256) NOT NULL,
  `trans_date` date NOT NULL,
  `trans_total` int(11) NOT NULL,
  `trans_customer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Product`
--

CREATE TABLE `Product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(256) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_desc` varchar(500) NOT NULL,
  `product_stock` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Product`
--

INSERT INTO `Product` (`product_id`, `product_name`, `product_price`, `product_desc`, `product_stock`, `type_id`, `shop_id`, `deleted_at`) VALUES
(1, 'Kue Cheesecake porsi medium', 50000, 'Cheesecake dengan ukuran medium. Cukup untuk pesta dengan jumlah undangan medium.', 50, 1, 1, NULL),
(2, 'Kue Red Velvet porsi kecil', 35000, 'Kue dengan warna merah.', 0, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Product_Type`
--

CREATE TABLE `Product_Type` (
  `Type_ID` int(11) NOT NULL,
  `Type_Name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Product_Type`
--

INSERT INTO `Product_Type` (`Type_ID`, `Type_Name`) VALUES
(1, 'Cake'),
(2, 'Bread'),
(3, 'Snacks'),
(4, 'Drinks'),
(5, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `Promo`
--

CREATE TABLE `Promo` (
  `promo_id` int(11) NOT NULL,
  `promo_name` varchar(256) NOT NULL,
  `promo_amount` int(11) NOT NULL,
  `promo_type` int(11) NOT NULL,
  `promo_sourceshop` int(11) DEFAULT NULL,
  `promo_expiredate` date NOT NULL,
  `promo_status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Promo`
--

INSERT INTO `Promo` (`promo_id`, `promo_name`, `promo_amount`, `promo_type`, `promo_sourceshop`, `promo_expiredate`, `promo_status`) VALUES
(1, 'Potongan Pertama', 15000, 1, NULL, '2023-01-05', 1),
(2, 'Promo Kedua', 15, 2, NULL, '2023-02-17', 1),
(3, 'Promo Toko Pertama', 1500, 1, 1, '2023-03-18', 1),
(4, 'Promo Toko Kedua', 2, 2, 1, '2023-09-10', 1),
(5, 'Promo Toko Ketiga', 1, 2, 1, '2022-12-09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Promo_Type`
--

CREATE TABLE `Promo_Type` (
  `promo_type_id` int(11) NOT NULL,
  `promo_type_name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Promo_Type`
--

INSERT INTO `Promo_Type` (`promo_type_id`, `promo_type_name`) VALUES
(1, 'Potongan'),
(2, 'Diskon');

-- --------------------------------------------------------

--
-- Table structure for table `Shop`
--

CREATE TABLE `Shop` (
  `shop_id` int(11) NOT NULL,
  `shop_username` varchar(256) NOT NULL,
  `shop_password` varchar(256) NOT NULL,
  `shop_name` varchar(256) NOT NULL,
  `shop_emailaddress` varchar(256) NOT NULL,
  `shop_phonenumber` varchar(256) NOT NULL,
  `shop_accountnumber` varchar(256) NOT NULL,
  `shop_status` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1 -> active,\\n0 -> nonactive, \\n2 -> waiting_list'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Shop`
--

INSERT INTO `Shop` (`shop_id`, `shop_username`, `shop_password`, `shop_name`, `shop_emailaddress`, `shop_phonenumber`, `shop_accountnumber`, `shop_status`) VALUES
(1, 'TheFlyingLad', 'abc123', 'Toko Mahalima', 'bud1@mail.com', '081211444555', '5154676777', 1),
(2, 'bud123', 'qwerty', 'Toko Trial Register', 'marc@mail.com', '081777222999', '5554446677', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Transaction_Promo`
--

CREATE TABLE `Transaction_Promo` (
  `tp_id` int(11) NOT NULL,
  `invoice_number` varchar(256) NOT NULL,
  `promo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Voucher`
--

CREATE TABLE `Voucher` (
  `voucher_id` int(11) NOT NULL,
  `voucher_name` varchar(256) NOT NULL,
  `voucher_type` int(11) NOT NULL,
  `voucher_amount` int(11) NOT NULL,
  `voucher_expiredate` date NOT NULL,
  `voucher_status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Voucher`
--

INSERT INTO `Voucher` (`voucher_id`, `voucher_name`, `voucher_type`, `voucher_amount`, `voucher_expiredate`, `voucher_status`) VALUES
(1, 'Voucher Pertama', 1, 5000, '2023-03-18', 1),
(2, 'Voucher Kedua', 2, 5, '2023-03-09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Voucher_Customer`
--

CREATE TABLE `Voucher_Customer` (
  `voucher_customer_id` int(11) NOT NULL,
  `voucher_customer_customer` int(11) NOT NULL,
  `voucher_customer_voucher` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Customer`
--
ALTER TABLE `Customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `D_Trans`
--
ALTER TABLE `D_Trans`
  ADD PRIMARY KEY (`dtrans_id`),
  ADD KEY `fk_trans_product` (`product_id`),
  ADD KEY `fk_dtrans` (`invoice_number`);

--
-- Indexes for table `H_Trans`
--
ALTER TABLE `H_Trans`
  ADD PRIMARY KEY (`invoice_number`),
  ADD KEY `fk_transaction_customer` (`trans_customer`);

--
-- Indexes for table `Product`
--
ALTER TABLE `Product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_product_type` (`type_id`),
  ADD KEY `fk_product_shop` (`shop_id`);

--
-- Indexes for table `Product_Type`
--
ALTER TABLE `Product_Type`
  ADD PRIMARY KEY (`Type_ID`);

--
-- Indexes for table `Promo`
--
ALTER TABLE `Promo`
  ADD PRIMARY KEY (`promo_id`),
  ADD KEY `fk_promo_type` (`promo_type`),
  ADD KEY `fk_promo_shop` (`promo_sourceshop`);

--
-- Indexes for table `Promo_Type`
--
ALTER TABLE `Promo_Type`
  ADD PRIMARY KEY (`promo_type_id`);

--
-- Indexes for table `Shop`
--
ALTER TABLE `Shop`
  ADD PRIMARY KEY (`shop_id`);

--
-- Indexes for table `Transaction_Promo`
--
ALTER TABLE `Transaction_Promo`
  ADD PRIMARY KEY (`tp_id`),
  ADD KEY `fk_trnas_promo` (`promo_id`),
  ADD KEY `fk_invoice_promo` (`invoice_number`);

--
-- Indexes for table `Voucher`
--
ALTER TABLE `Voucher`
  ADD PRIMARY KEY (`voucher_id`),
  ADD KEY `fk_voucher_type` (`voucher_type`);

--
-- Indexes for table `Voucher_Customer`
--
ALTER TABLE `Voucher_Customer`
  ADD PRIMARY KEY (`voucher_customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Customer`
--
ALTER TABLE `Customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `D_Trans`
--
ALTER TABLE `D_Trans`
  MODIFY `dtrans_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Product`
--
ALTER TABLE `Product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Product_Type`
--
ALTER TABLE `Product_Type`
  MODIFY `Type_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Promo`
--
ALTER TABLE `Promo`
  MODIFY `promo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Promo_Type`
--
ALTER TABLE `Promo_Type`
  MODIFY `promo_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Shop`
--
ALTER TABLE `Shop`
  MODIFY `shop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Transaction_Promo`
--
ALTER TABLE `Transaction_Promo`
  MODIFY `tp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Voucher`
--
ALTER TABLE `Voucher`
  MODIFY `voucher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Voucher_Customer`
--
ALTER TABLE `Voucher_Customer`
  MODIFY `voucher_customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `D_Trans`
--
ALTER TABLE `D_Trans`
  ADD CONSTRAINT `fk_dtrans` FOREIGN KEY (`invoice_number`) REFERENCES `H_Trans` (`invoice_number`),
  ADD CONSTRAINT `fk_trans_product` FOREIGN KEY (`product_id`) REFERENCES `Product` (`product_id`);

--
-- Constraints for table `H_Trans`
--
ALTER TABLE `H_Trans`
  ADD CONSTRAINT `fk_transaction_customer` FOREIGN KEY (`trans_customer`) REFERENCES `Customer` (`customer_id`);

--
-- Constraints for table `Product`
--
ALTER TABLE `Product`
  ADD CONSTRAINT `fk_product_shop` FOREIGN KEY (`shop_id`) REFERENCES `Shop` (`shop_id`),
  ADD CONSTRAINT `fk_product_type` FOREIGN KEY (`type_id`) REFERENCES `Product_Type` (`Type_ID`);

--
-- Constraints for table `Promo`
--
ALTER TABLE `Promo`
  ADD CONSTRAINT `fk_promo_shop` FOREIGN KEY (`promo_sourceshop`) REFERENCES `Shop` (`shop_id`),
  ADD CONSTRAINT `fk_promo_type` FOREIGN KEY (`promo_type`) REFERENCES `Promo_Type` (`promo_type_id`);

--
-- Constraints for table `Transaction_Promo`
--
ALTER TABLE `Transaction_Promo`
  ADD CONSTRAINT `fk_invoice_promo` FOREIGN KEY (`invoice_number`) REFERENCES `H_Trans` (`invoice_number`),
  ADD CONSTRAINT `fk_trnas_promo` FOREIGN KEY (`promo_id`) REFERENCES `Promo` (`promo_id`);

--
-- Constraints for table `Voucher`
--
ALTER TABLE `Voucher`
  ADD CONSTRAINT `fk_voucher_type` FOREIGN KEY (`voucher_type`) REFERENCES `Promo_Type` (`promo_type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
