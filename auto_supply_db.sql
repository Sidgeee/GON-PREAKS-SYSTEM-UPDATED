-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2026 at 03:00 AM
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
-- Database: `auto_supply_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `delivery_id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `delivery_address` text DEFAULT NULL,
  `delivery_status` enum('Pending','Preparing','Out for Delivery','Delivered') DEFAULT 'Pending',
  `driver_name` varchar(100) DEFAULT NULL,
  `pahinante_name` varchar(100) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `part_id` int(11) NOT NULL,
  `part_number` varchar(100) NOT NULL,
  `part_name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `supplier_name` varchar(255) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`part_id`, `part_number`, `part_name`, `category`, `supplier_name`, `brand`, `price`, `stock_quantity`, `created_at`) VALUES
(6, '26570-61J10', 'SUZUKI APV WITH GASKET', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 765.00, 5, '2026-03-15 16:05:04'),
(7, '26570-81A10', 'SUZUKI K6A DA52, DA62, JIMNY', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 885.00, 5, '2026-03-15 16:16:07'),
(8, '26445-77M10', 'SUZUKI K6A SA52, DA62, JIMNY', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 795.00, 5, '2026-03-15 16:16:53'),
(9, '26570-66H10', 'SUZUKI K6A DA64, DA62', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 685.00, 5, '2026-03-15 16:17:10'),
(10, '35330-30060', 'TOYOTA HIACE 06-18 1KD/2KD, HYUNDAI STAREX 03-07', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 725.00, 5, '2026-03-15 16:17:32'),
(11, '35303-B1020', 'TOYOTA WIGO 17-23', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 695.00, 5, '2026-03-20 05:58:25'),
(12, '35303-B1010', 'TOYOTA AVANZA 16-23 RUSH 18-23', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 795.00, 5, '2026-03-20 05:58:45'),
(13, '35303-97201', 'TOYOTA WIGO 14-16', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 685.00, 5, '2026-03-20 06:00:10'),
(14, '35330-12040', 'TOYOTA ALTIS 01-07', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 585.00, 5, '2026-03-20 06:00:23'),
(15, '35303-97501', 'TOYOTA AVANZA 06-15', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 615.00, 5, '2026-03-20 06:01:33'),
(16, '2804A032', 'MITSUBISHI MONTERO SPORT 4N15 16-22', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 885.00, 5, '2026-03-20 06:01:47'),
(17, '2804A057', 'MITSUBISHI XPANDER 18-23, NISSAN LIVINA 19-23', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 795.00, 5, '2026-03-20 06:02:58'),
(18, 'MR515064', 'MITSUBISHI LANCER 03-07 4G18/4G93', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 550.00, 5, '2026-03-20 06:03:23'),
(19, 'MD737840', 'MITSUBISHI LANCER 12V MIRAGE WIRA 1.3, 1.5', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 525.00, 5, '2026-03-20 06:07:04'),
(20, '8-97331-063-0', 'ISUZU ALTERRA, DMAX 08-13 4JJ1 4X4', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 835.00, 5, '2026-03-20 06:08:59'),
(21, '8-96041-088-0', 'ISUZU ALTERRA DMAX \'08-\'13 4JJ1 4X2', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 885.00, 5, '2026-03-20 06:09:14'),
(22, '8-97264-850-0', 'ISUZU CROSSWIND SPORTIVO 1996-2016 KIA SPORTAGE 1993 2006', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 885.00, 5, '2026-03-20 06:09:41'),
(23, '1L2P-7A098-AD', 'FORD EVEREST, RANGER \'06-\'12', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 735.00, 5, '2026-03-20 06:12:02'),
(24, 'BL3Z-7A098-B', 'FORD RANGER \'12-\'18 EVEREST \'15-\'18', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 735.00, 5, '2026-03-20 06:14:52'),
(25, 'BV56-19-815', 'BONGO MAZDA RF FORD RANGER 2001-2006', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 626.00, 5, '2026-03-20 06:15:59'),
(26, '31728-31X01', 'NISSAN ALMERA \'12-\'18', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 765.00, 5, '2026-03-20 06:16:12'),
(27, '31728-41X03', 'NISSAN NAVARA D40T, \'08–\'14 PATROL Y61', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 925.00, 5, '2026-03-20 06:16:31'),
(28, '31728-80X04', 'SENTRA GX \'03–\'12, XTRAIL, NAVARA, CEFIRO \'97–\'06', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 585.00, 5, '2026-03-20 06:20:37'),
(29, '25420-P4R-003', 'HONDA CIVIC 2001–2005', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 795.00, 5, '2026-03-20 06:21:35'),
(30, '25420-5T0-003', 'HONDA MOBILIO, CIVIC, CITY / JAZZ \'15–\'21', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 795.00, 5, '2026-03-20 06:21:57'),
(31, '25420-PWR-003', 'HONDA CITY 2003–2006', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 795.00, 5, '2026-03-20 06:22:09'),
(32, '25420-PRP-003', 'HONDA CRV 2002–2006', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 795.00, 5, '2026-03-20 06:24:18'),
(33, '25420-RXH-003', 'HONDA CRV 2007–2012', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 795.00, 5, '2026-03-20 06:34:01'),
(34, '46321-23001', 'HYUNDAI ACCENT \'12-\'18, I10 \'08-\'13, KIA PICANTO \'11-\'17, KIA RIO \'12-\'17', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 695.00, 5, '2026-03-20 06:34:10'),
(35, '46240-4C000', 'HYUNDAI GRAND STAREX 07-\'18 D4CB', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 895.00, 5, '2026-03-20 06:34:20'),
(36, '48148-02200', 'HYUNDAI ACCENT KAPPA ENGINE 14-\'15 A/T CVT (SHORT TUBE)', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 895.00, 5, '2026-03-20 06:37:47'),
(37, '48148-02230', 'HYUNDAI ACCENT KAPPA ENGINE 2016-\'18 A/T CVT (LONG TUBE)', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 895.00, 5, '2026-03-20 06:37:58'),
(38, '24236933', 'CHEVROLET COLORADO TRAILBLAZER', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 985.00, 5, '2026-03-20 06:38:04'),
(39, '35330-52010', 'TOYOTA VIOS \'08-\'12', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 450.00, 5, '2026-03-20 06:38:14'),
(40, '35330-53010', 'INNOVA/HI-ACE 1TR', 'TRANSMISSION FILTER', 'BJ AUTOSUPPLY', NULL, 600.00, 5, '2026-03-20 06:38:22');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_movements`
--

CREATE TABLE `inventory_movements` (
  `movement_id` int(11) NOT NULL,
  `sup_prod_id` int(11) DEFAULT NULL,
  `movement_type` enum('SALE','PURCHASE','RETURN','ADJUSTMENT','INITIAL_STOCK') DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `part_number` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `category` enum('Engine Parts','Brake System','Electrical Parts','Suspension','Cooling System','Filters & Fluids','Accessories & Hardware') DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `vehicle_application` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`part_number`, `name`, `category`, `brand`, `barcode`, `vehicle_application`) VALUES
('TEST-001', 'Brake Pad Set', 'Brake System', 'Brembo', '12345', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `po_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `status` enum('Pending','Ordered','Received') DEFAULT 'Pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL,
  `cashier_name` varchar(100) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `payment_method` enum('Cash','GCash','Bank_Transfer') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Completed','Voided','Returned') DEFAULT 'Completed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `sale_item_id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `supplier_part_number` varchar(50) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `address_city` varchar(50) DEFAULT NULL,
  `address_province` varchar(50) DEFAULT NULL,
  `address_complete` text DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `viber` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `shop_name`, `address_city`, `address_province`, `address_complete`, `contact_number`, `email`, `viber`) VALUES
(1, 'Test Auto Hub', 'Manila', NULL, NULL, NULL, NULL, NULL),
(2, 'BJ AUTOSUPPLY ', '47, Isabelo Fernando Street, Manolo Compound, Vale', '', '', '(02) 3443 5263', '', ''),
(3, 'Cool spring', '', '', '', '', '', ''),
(4, 'Handy works', '', '', '', '', '', ''),
(5, 'Rings Marketing ', '', '', '', '', '', ''),
(6, 'NRCD', '', '', '', '', '', ''),
(8, 'Jomer ENT', '', '', '', '', '', ''),
(9, 'New DG Hdwe', '', '', '', '', '', ''),
(10, 'Bloomfield', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_categories`
--

CREATE TABLE `supplier_categories` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(100) DEFAULT NULL,
  `category_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier_categories`
--

INSERT INTO `supplier_categories` (`id`, `supplier_name`, `category_name`) VALUES
(5, 'BJ AUTOSUPPLY\r\n', 'TRANSMISSION FILTER'),
(6, 'BJ AUTOSUPPLY\r\n', 'NEW ARRIVALS: TRANSMISSION FILTER WITH GASKET'),
(7, 'BJ AUTOSUPPLY\r\n', 'WHEEL CYLINDER ASSY'),
(8, 'BJ AUTOSUPPLY\r\n', 'BREAK SHOE ASSY WITH REVITS \"OEM THAILAND\"'),
(9, 'BJ AUTOSUPPLY\r\n', 'SHOCK ABSORBER'),
(10, 'BJ AUTOSUPPLY\r\n', 'STABILIZER BLUSHING \"THAILAND\"'),
(11, 'BJ AUTOSUPPLY\r\n', 'COIL SPRING (HIGH PERFORMANCE)'),
(12, 'BJ AUTOSUPPLY\r\n', 'CYLINDER HEAD GASKET (AUTOLINE )'),
(13, 'BJ AUTOSUPPLY\r\n', 'OVERHAULING GASKET (AUTOLINE )'),
(14, 'BJ AUTOSUPPLY\r\n', 'CYLINDER HEAD GASKET (OEM THAILAND)	'),
(15, 'BJ AUTOSUPPLY\r\n', 'OVERHAULING GASKET (OEM THAILAND)	'),
(16, 'BJ AUTOSUPPLY\r\n', 'GLOW PLUG PRICELIST');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_products`
--

CREATE TABLE `supplier_products` (
  `sup_prod_id` int(11) NOT NULL,
  `supplier_part_number` varchar(50) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `product_part_number` varchar(50) DEFAULT NULL,
  `cost_price` decimal(10,2) DEFAULT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `reorder_level` int(11) DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier_products`
--

INSERT INTO `supplier_products` (`sup_prod_id`, `supplier_part_number`, `supplier_id`, `product_part_number`, `cost_price`, `selling_price`, `stock_quantity`, `reorder_level`) VALUES
(1, NULL, 1, 'TEST-001', 500.00, 750.00, 50, 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('Admin','Cashier','Driver','Restocker','Account Manager') DEFAULT 'Cashier',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `role`, `created_at`) VALUES
(4, 'System Admin', 'admin', 'admin123', 'Admin', '2026-03-13 12:30:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`delivery_id`),
  ADD KEY `sale_id` (`sale_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`part_id`),
  ADD UNIQUE KEY `part_number` (`part_number`);

--
-- Indexes for table `inventory_movements`
--
ALTER TABLE `inventory_movements`
  ADD PRIMARY KEY (`movement_id`),
  ADD KEY `sup_prod_id` (`sup_prod_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`part_number`),
  ADD UNIQUE KEY `barcode` (`barcode`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`po_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`sale_item_id`),
  ADD KEY `sale_id` (`sale_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `supplier_categories`
--
ALTER TABLE `supplier_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_products`
--
ALTER TABLE `supplier_products`
  ADD PRIMARY KEY (`sup_prod_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `product_part_number` (`product_part_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `part_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `inventory_movements`
--
ALTER TABLE `inventory_movements`
  MODIFY `movement_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `sale_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `supplier_categories`
--
ALTER TABLE `supplier_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `supplier_products`
--
ALTER TABLE `supplier_products`
  MODIFY `sup_prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `deliveries_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`sale_id`);

--
-- Constraints for table `inventory_movements`
--
ALTER TABLE `inventory_movements`
  ADD CONSTRAINT `inventory_movements_ibfk_1` FOREIGN KEY (`sup_prod_id`) REFERENCES `supplier_products` (`sup_prod_id`);

--
-- Constraints for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `purchase_orders_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`);

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`sale_id`);

--
-- Constraints for table `supplier_products`
--
ALTER TABLE `supplier_products`
  ADD CONSTRAINT `supplier_products_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`),
  ADD CONSTRAINT `supplier_products_ibfk_2` FOREIGN KEY (`product_part_number`) REFERENCES `products` (`part_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
