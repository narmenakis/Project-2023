-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 16, 2024 at 08:29 PM
-- Server version: 8.0.34
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webfinal`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announcement_id` int NOT NULL,
  `announcement_title` varchar(100) NOT NULL,
  `announcement_date` datetime DEFAULT NULL,
  `item_id` int DEFAULT NULL,
  `announcement_item_quantity` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcement_id`, `announcement_title`, `announcement_date`, `item_id`, `announcement_item_quantity`) VALUES
(2, 'Ανάγκη για νερό', '2024-09-05 20:06:09', 16, 2),
(3, 'Φαγητό και νερό', '2024-09-05 20:07:01', 16, 4),
(4, 'Φαγητό και νερό', '2024-09-05 20:07:01', 26, 5),
(5, 'Είδη πρώτης ανάγκης!!', '2024-09-05 20:35:21', 34, 5),
(6, 'Είδη πρώτης ανάγκης!!', '2024-09-05 20:35:21', 105, 10),
(7, 'Είδη πρώτης ανάγκης!!', '2024-09-05 20:35:21', 118, 3),
(17, 'announcement1', '2024-09-16 18:27:46', 16, 5);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int NOT NULL,
  `category_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(10, ''),
(13, '-----'),
(9, '2d hacker'),
(49, 'Animal Care'),
(66, 'Animal Flood'),
(29, 'Animal Food'),
(25, 'Baby Essentials'),
(6, 'Beverages'),
(59, 'Books'),
(22, 'Cleaning Supplies'),
(33, 'Cleaning Supplies.'),
(7, 'Clothing'),
(53, 'Clothing and cover'),
(28, 'Cold weather'),
(45, 'Communication items'),
(46, 'communications'),
(44, 'Disability and Assistance Items'),
(50, 'Earthquake Safety'),
(27, 'Electronic Devices'),
(43, 'Energy Drinks'),
(30, 'Financial support'),
(35, 'First Aid '),
(14, 'Flood'),
(5, 'Food'),
(60, 'Fuel and Energy'),
(8, 'Hacker of class'),
(34, 'Hot Weather'),
(57, 'Household Items'),
(47, 'Humanitarian Shelters'),
(26, 'Insect Repellents'),
(24, 'Kitchen Supplies'),
(16, 'Medical Supplies'),
(68, 'Mental Health Support'),
(52, 'Navigation Tools'),
(15, 'new cat'),
(65, 'ood'),
(21, 'Personal Hygiene '),
(41, 'pet supplies'),
(19, 'Shoes'),
(51, 'Sleep Essentilals'),
(67, 'Solar-Powered Devices'),
(56, 'Special items'),
(11, 'Test'),
(61, 'test category'),
(39, 'Test_0'),
(40, 'test1'),
(23, 'Tools'),
(54, 'Tools and Equipment'),
(48, 'Water Purification'),
(42, 'Μedicines');

-- --------------------------------------------------------

--
-- Table structure for table `coordinates`
--

CREATE TABLE `coordinates` (
  `id` int NOT NULL,
  `latitude` decimal(11,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `coordinates`
--

INSERT INTO `coordinates` (`id`, `latitude`, `longitude`) VALUES
(9, '38.25214590', '21.74344500'),
(10, '38.26073200', '21.73929800'),
(11, '38.26018456', '21.75007105'),
(12, '38.24815689', '21.76099777'),
(13, '38.23354180', '21.74032778'),
(15, '38.24626950', '21.73627854'),
(22, '38.24586505', '21.74400330'),
(23, '38.23791045', '21.75172805'),
(25, '38.24275672', '21.74240820'),
(26, '38.25925276', '21.74445391'),
(27, '38.23912392', '21.72889709');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int NOT NULL,
  `item_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `category_id` int NOT NULL,
  `date_added` datetime DEFAULT NULL,
  `amount` int UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `item_name`, `category_id`, `date_added`, `amount`) VALUES
(16, 'Water', 6, '2024-09-16 13:24:50', 0),
(17, 'Orange juice', 6, '2024-09-16 13:23:44', 22),
(18, 'Sardines', 5, '2024-09-11 00:21:23', 0),
(19, 'Canned corn', 5, '2024-09-09 01:22:17', 0),
(20, 'Bread', 5, '2024-09-16 13:47:49', 0),
(21, 'Chocolate', 5, '2024-09-11 23:02:59', 27),
(22, 'Men Sneakers', 7, '2024-09-16 13:22:58', 5),
(23, 'Test Product', 9, NULL, 0),
(24, 'Test Val', 14, NULL, 0),
(25, 'Spaghetti', 5, NULL, 0),
(26, 'Croissant', 5, '2024-09-11 21:27:08', 0),
(28, '', 10, NULL, 0),
(29, 'Biscuits', 5, '2024-09-09 01:06:30', 0),
(30, 'Bandages', 16, NULL, 0),
(31, 'Disposable gloves', 16, NULL, 0),
(32, 'Gauze', 16, '2024-09-09 00:54:26', 0),
(33, 'Antiseptic', 16, '2024-09-16 13:46:34', 10),
(34, 'First Aid Kit', 16, '2024-09-11 23:03:17', 3),
(35, 'Painkillers', 16, '2024-09-16 13:46:25', 0),
(36, 'Blanket', 7, '2024-09-11 23:03:11', 4),
(37, 'Fakes', 5, NULL, 0),
(38, 'Menstrual Pads', 21, NULL, 0),
(39, 'Tampon', 21, NULL, 0),
(40, 'Toilet Paper', 21, '2024-09-16 13:45:39', 0),
(41, 'Baby wipes', 21, '2024-09-11 23:04:56', 11),
(42, 'Toothbrush', 21, '2024-09-16 13:49:34', 3),
(43, 'Toothpaste', 21, NULL, 0),
(44, 'Vitamin C', 16, '2024-09-16 13:43:56', 5),
(45, 'Multivitamines', 16, NULL, 0),
(46, 'Paracetamol', 16, '2024-09-16 13:25:48', 9),
(47, 'Ibuprofen', 16, '2024-09-16 13:25:56', 5),
(48, '', 10, NULL, 0),
(49, '', 10, NULL, 0),
(50, '', 10, NULL, 0),
(51, 'Cleaning rag', 22, NULL, 0),
(52, 'Detergent', 22, NULL, 0),
(53, 'Disinfectant', 22, NULL, 0),
(54, 'Mop', 22, NULL, 0),
(55, 'Plastic bucket', 22, NULL, 0),
(56, 'Scrub brush', 22, NULL, 0),
(57, 'Dust mask', 22, NULL, 0),
(58, 'Broom', 22, NULL, 0),
(59, 'Hammer', 23, NULL, 0),
(60, 'Skillsaw', 23, NULL, 0),
(61, 'Prybar', 23, NULL, 0),
(62, 'Shovel', 23, NULL, 0),
(63, 'Flashlight', 23, '2024-09-11 23:04:39', 0),
(64, 'Duct tape', 23, NULL, 0),
(65, 'Underwear', 7, NULL, 0),
(66, 'Socks', 7, NULL, 0),
(67, 'Warm Jacket', 7, '2024-09-16 13:23:27', 10),
(68, 'Raincoat', 7, NULL, 0),
(69, 'Gloves', 7, NULL, 0),
(70, 'Pants', 7, '2024-09-16 13:44:34', 0),
(71, 'Boots', 7, NULL, 0),
(72, 'Dishes', 24, NULL, 0),
(73, 'Pots', 24, NULL, 0),
(74, 'Paring knives', 24, NULL, 0),
(75, 'Pan', 24, NULL, 0),
(76, 'Glass', 24, NULL, 0),
(77, '', 10, NULL, 0),
(78, '', 10, NULL, 0),
(79, '', 10, NULL, 0),
(80, '', 10, NULL, 0),
(81, '', 10, NULL, 0),
(82, '', 10, NULL, 0),
(83, 't22', 9, NULL, 0),
(84, 'water ', 6, NULL, 0),
(85, 'Coca Cola', 6, NULL, 0),
(86, 'spray', 26, NULL, 0),
(87, 'Outdoor spiral', 26, NULL, 0),
(88, 'Baby bottle', 25, NULL, 0),
(89, 'Pacifier', 25, NULL, 0),
(90, 'Condensed milk', 5, NULL, 0),
(91, 'Cereal bar', 5, NULL, 0),
(92, 'Pocket Knife', 23, NULL, 0),
(93, 'Water Disinfection Tablets', 16, '2024-09-09 01:41:04', 0),
(94, 'Radio', 27, NULL, 0),
(95, 'Kitchen appliances', 14, NULL, 0),
(96, 'Winter hat', 28, NULL, 0),
(97, 'Winter gloves', 28, NULL, 0),
(98, 'Scarf', 28, '2024-09-16 13:41:25', 0),
(99, 'Thermos', 28, NULL, 0),
(100, 'Tea', 6, NULL, 0),
(101, 'Dog Food ', 29, NULL, 0),
(102, 'Cat Food', 29, NULL, 0),
(103, 'Canned', 5, NULL, 0),
(104, 'Chlorine', 22, NULL, 0),
(105, 'Medical gloves', 22, NULL, 0),
(106, 'T-Shirt', 7, NULL, 0),
(107, 'Cooling Fan', 34, NULL, 0),
(108, 'Cool Scarf', 34, NULL, 0),
(109, 'Whistle', 23, NULL, 0),
(110, 'Blankets', 28, NULL, 0),
(111, 'Sleeping Bag', 28, NULL, 0),
(112, 'Toothbrush', 21, '2024-09-16 13:49:34', 3),
(113, 'Toothpaste', 21, NULL, 0),
(114, 'Thermometer', 16, NULL, 0),
(115, 'Rice', 5, NULL, 0),
(116, 'Bread', 5, '2024-09-16 13:47:49', 0),
(117, 'Towels', 22, NULL, 0),
(118, 'Wet Wipes', 22, NULL, 0),
(119, 'Fire Extinguisher', 23, NULL, 0),
(120, 'Fruits', 5, NULL, 0),
(121, 'Duct Tape', 23, NULL, 0),
(122, '', 10, NULL, 0),
(123, 'Αθλητικά', 19, NULL, 0),
(124, 'Πασατέμπος', 5, NULL, 0),
(125, 'Bandages', 35, NULL, 0),
(126, 'Betadine', 35, NULL, 0),
(127, 'cotton wool', 35, NULL, 0),
(128, 'Crackers', 5, NULL, 0),
(129, 'Sanitary Pads', 21, NULL, 0),
(130, 'Sanitary wipes', 21, NULL, 0),
(131, 'Electrolytes', 16, NULL, 0),
(132, 'Pain killers', 16, NULL, 0),
(133, 'Flashlight', 23, '2024-09-11 23:04:39', 0),
(134, 'Juice', 6, NULL, 0),
(135, 'Toilet Paper', 21, '2024-09-16 13:45:39', 0),
(136, 'Sterilized Saline', 16, NULL, 0),
(137, 'Biscuits', 5, '2024-09-09 01:06:30', 0),
(138, 'Antihistamines', 16, NULL, 0),
(139, 'Instant Pancake Mix', 5, NULL, 0),
(140, 'Lacta', 5, NULL, 0),
(141, 'Canned Tuna', 5, NULL, 0),
(142, 'Batteries', 23, NULL, 0),
(143, 'Dust Mask', 35, NULL, 0),
(144, 'Can Opener', 23, NULL, 0),
(145, '', 10, NULL, 0),
(146, 'Πατατάκια', 5, NULL, 0),
(147, 'Σερβιέτες', 21, NULL, 0),
(148, 'Dry Cranberries', 5, NULL, 0),
(149, 'Dry Apricots', 5, NULL, 0),
(150, 'Dry Figs', 5, NULL, 0),
(151, 'Παξιμάδια', 5, NULL, 0),
(152, '', 10, NULL, 0),
(153, 'Test Item', 11, NULL, 0),
(154, 'Painkillers', 35, '2024-09-16 13:46:25', 0),
(155, 'Tampons', 16, NULL, 0),
(156, 'plaster set', 41, NULL, 0),
(157, 'elastic bandages', 41, NULL, 0),
(158, 'traumaplast', 41, NULL, 0),
(159, 'thermal blanket', 41, NULL, 0),
(160, 'burn gel', 41, NULL, 0),
(161, 'pet carrier', 41, NULL, 0),
(162, 'pet dishes', 41, NULL, 0),
(163, 'plastic bags', 41, NULL, 0),
(164, 'toys', 41, NULL, 0),
(165, 'burn pads', 41, NULL, 0),
(166, 'cheese', 5, NULL, 0),
(167, 'lettuce', 5, NULL, 0),
(168, 'eggs', 5, NULL, 0),
(169, 'steaks', 5, NULL, 0),
(170, 'beef burgers', 5, NULL, 0),
(171, 'tomatoes', 5, NULL, 0),
(172, 'onions', 5, NULL, 0),
(173, 'flour', 5, NULL, 0),
(174, 'pastel', 5, NULL, 0),
(175, 'nuts', 5, NULL, 0),
(176, 'dramamines', 42, NULL, 0),
(177, 'nurofen', 42, NULL, 0),
(178, 'imodium', 42, NULL, 0),
(179, 'emetostop', 42, NULL, 0),
(180, 'xanax', 42, NULL, 0),
(181, 'saflutan', 42, NULL, 0),
(182, 'sadolin', 42, NULL, 0),
(183, 'depon', 42, NULL, 0),
(184, 'panadol', 42, NULL, 0),
(185, 'ponstan ', 42, NULL, 0),
(186, 'algofren', 42, NULL, 0),
(187, 'effervescent depon', 42, NULL, 0),
(188, 'cold coffee', 6, NULL, 0),
(189, 'Hell', 43, NULL, 0),
(190, 'Monster', 43, NULL, 0),
(191, 'Redbull', 43, NULL, 0),
(192, 'Powerade', 43, NULL, 0),
(193, 'PRIME', 43, NULL, 0),
(194, 'Lighter', 23, NULL, 0),
(195, 'isothermally shirts', 28, NULL, 0),
(196, '', 10, NULL, 0),
(197, 'Depon', 42, NULL, 0),
(198, 'Shorts', 34, NULL, 0),
(199, 'Chicken', 5, NULL, 0),
(200, 'Toilet Paper', 21, '2024-09-16 13:45:39', 0),
(201, 'toys', 41, NULL, 0),
(202, 'sanitary napkins', 21, NULL, 0),
(203, 'COVID-19 Tests', 16, NULL, 0),
(204, 'Club Soda', 6, NULL, 0),
(205, 'Wheelchairs', 44, NULL, 0),
(206, 'mobile phones', 45, NULL, 0),
(207, 'spoon', 24, NULL, 0),
(208, 'fork', 24, NULL, 0),
(209, 'MOTOTRBO R7', 45, NULL, 0),
(210, 'RM LA 250 (VHF Linear Ενισχυτής 140-150MHz)', 45, NULL, 0),
(211, 'Humanitarian General Purpose Tent System (HGPTS)', 47, NULL, 0),
(212, 'CELINA Dynamic Small Shelter ', 47, NULL, 0),
(213, 'Multi-purpose Area Shelter System, Type-I', 47, NULL, 0),
(214, 'Trousers', 7, NULL, 0),
(215, 'Shoes', 7, '2024-09-16 13:42:47', 0),
(216, 'Hoodie', 7, NULL, 0),
(217, '', 10, NULL, 0),
(218, 'dog food', 49, '2024-09-16 13:48:58', 0),
(219, 'cat food', 49, NULL, 0),
(220, 'macaroni', 5, NULL, 0),
(221, 'rice', 5, NULL, 0),
(222, 'scarf', 7, '2024-09-16 13:41:25', 0),
(223, 'gloves', 7, NULL, 0),
(224, 'underwear', 7, NULL, 0),
(225, 'Silver blanket', 50, NULL, 0),
(226, 'Helmet', 50, NULL, 0),
(227, 'Disposable toilet', 50, NULL, 0),
(228, 'Self-generated flashlight', 50, NULL, 0),
(229, 'Mattresses ', 51, NULL, 0),
(230, 'flashlight', 51, '2024-09-11 23:04:39', 0),
(231, 'matches', 51, NULL, 0),
(232, 'Heater', 51, NULL, 0),
(233, 'Earplugs', 51, NULL, 0),
(234, 'Compass', 52, NULL, 0),
(235, 'Map', 52, NULL, 0),
(236, 'GPS', 52, NULL, 0),
(237, 'First Aid', 16, NULL, 0),
(238, 'Bandage', 16, NULL, 0),
(239, 'Mask', 16, NULL, 0),
(240, 'Medicines', 16, NULL, 0),
(241, 'Water', 5, '2024-09-16 13:24:50', 0),
(242, 'Canned Goods', 5, NULL, 0),
(243, 'Snacks', 5, NULL, 0),
(244, 'Cereals', 5, NULL, 0),
(245, 'Blankets', 53, NULL, 0),
(246, 'Shirt', 53, NULL, 0),
(247, 'Pants', 53, '2024-09-16 13:44:34', 0),
(248, 'Shoes', 53, '2024-09-16 13:42:47', 0),
(249, 'Socks', 53, NULL, 0),
(250, 'Caps', 53, NULL, 0),
(251, 'Gloves', 53, NULL, 0),
(252, 'Flashlight', 54, '2024-09-11 23:04:39', 0),
(253, 'Batteries', 54, NULL, 0),
(254, 'Repair Tools', 54, NULL, 0),
(255, 'Soap and Shampoo', 21, NULL, 0),
(256, 'Toothpastes and Toothbrushes', 21, NULL, 0),
(257, 'Towels', 21, NULL, 0),
(258, 'Diapers', 56, NULL, 0),
(259, 'Animal food', 56, NULL, 0),
(260, 'Pots', 57, NULL, 0),
(261, 'Plates', 57, NULL, 0),
(262, 'Cups', 57, NULL, 0),
(263, 'Cutlery ', 57, NULL, 0),
(264, 'Cleaning Supplies', 57, NULL, 0),
(265, 'Kitchen Appliances', 57, NULL, 0),
(266, 'Home Repair Tools', 57, NULL, 0),
(267, '', 10, NULL, 0),
(268, 'Lord of the Rings', 59, NULL, 0),
(269, 'Dog Food', 29, '2024-09-16 13:48:58', 0),
(270, 'DEPON', 16, NULL, 0),
(271, 'Painkillers', 16, '2024-09-16 13:46:25', 0),
(272, 'Gasoline', 60, NULL, 0),
(273, 'Power Banks', 60, NULL, 0),
(274, '', 9, NULL, 0),
(275, 'test item', 29, NULL, 0),
(276, 'test item2', 61, NULL, 0),
(277, 'T4 Levothyroxine', 42, NULL, 0),
(278, '', 10, NULL, 0),
(279, 'Solar Charger', 67, NULL, 0),
(280, 'Solar-Powered Radio', 67, NULL, 0),
(281, 'Solar Torch', 67, NULL, 0),
(282, 'Stress Ball', 68, NULL, 0),
(283, 'Guided Meditation Audio', 68, NULL, 0),
(284, '', 10, NULL, 0),
(285, '', 10, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `itemdetails`
--

CREATE TABLE `itemdetails` (
  `item_id` int DEFAULT NULL,
  `detail_name` varchar(255) DEFAULT NULL,
  `detail_value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `itemdetails`
--

INSERT INTO `itemdetails` (`item_id`, `detail_name`, `detail_value`) VALUES
(16, 'volume', '1.5l'),
(16, 'pack size', '6'),
(17, 'volume', '250ml'),
(17, 'pack size', '12'),
(18, 'brand', 'Trata'),
(18, 'weight', '200g'),
(19, 'weight', '500g'),
(20, 'weight', '1kg'),
(20, 'type', 'white'),
(21, 'weight', '100g'),
(21, 'type', 'milk chocolate'),
(21, 'brand', 'ION'),
(22, 'size', '44'),
(23, 'weight', '500g'),
(23, 'pack size', '12'),
(23, 'expiry date', '13/12/1978'),
(24, 'Details', '600ml'),
(25, 'grams', '500'),
(26, 'calories', '200'),
(28, '', ''),
(29, '', ''),
(30, '', '25 pcs'),
(31, '', '100 pcs'),
(32, '', ''),
(33, '', '250ml'),
(34, '', ''),
(35, 'volume', '200mg'),
(36, 'size', '50\" x 60\"'),
(37, '', ''),
(38, 'stock', '500'),
(38, 'size', '3'),
(38, '', ''),
(39, 'stock', '500'),
(39, 'size', 'regular'),
(40, 'stock', '300'),
(40, 'ply', '3'),
(41, 'volume', '500gr'),
(41, 'stock ', '500'),
(41, 'scent', 'aloe'),
(42, 'stock', '500'),
(43, 'stock', '250'),
(44, 'stock', '200'),
(45, 'stock', '200'),
(46, 'stock', '2000'),
(46, 'dosage', '500mg'),
(47, 'stock ', '10'),
(47, 'dosage', '200mg'),
(48, '', ''),
(49, '', ''),
(49, '', ''),
(49, '', ''),
(50, '', ''),
(51, '', ''),
(52, '', ''),
(53, '', ''),
(54, '', ''),
(55, '', ''),
(56, '', ''),
(57, '', ''),
(58, '', ''),
(59, '', ''),
(60, '', ''),
(61, '', ''),
(62, '', ''),
(63, '', ''),
(64, '', ''),
(65, '', ''),
(66, '', ''),
(67, '', ''),
(68, '', ''),
(69, '', ''),
(70, '', ''),
(71, '', ''),
(72, '', ''),
(73, '', ''),
(74, '', ''),
(75, '', ''),
(76, '', ''),
(77, '', ''),
(77, '', ''),
(77, '', ''),
(78, '', ''),
(79, '', ''),
(80, '', ''),
(81, '', ''),
(82, '', ''),
(82, '', ''),
(82, '', ''),
(82, 'ghw56', 'twhwhrwh'),
(82, '', ''),
(83, 'wtwty', 'wytwty'),
(84, '', ''),
(85, 'Volume', '500ml'),
(86, 'volume', '75ml'),
(87, 'duration', '7 hours'),
(88, 'volume', '250ml'),
(89, 'material', 'silicone'),
(90, 'weight', '400gr'),
(91, 'weight', '23,5gr'),
(92, 'Number of different tools', '3'),
(92, 'Tool', 'Knife'),
(92, 'Tool', 'Screwdriver'),
(92, 'Tool', 'Spoon'),
(93, 'Basic Ingredients', 'Iodine'),
(93, 'Suggested for', 'Everyone expept pregnant women'),
(94, 'Power', 'Batteries'),
(94, 'Frequencies Range', '3 kHz - 3000 GHz'),
(95, '', '(scrubbers, rubber gloves, kitchen detergent, laundry soap)'),
(96, '', ''),
(97, '', ''),
(98, '', ''),
(99, '', ''),
(100, 'volume', '500ml'),
(101, 'volume', '500g'),
(102, 'volume', '500g'),
(103, '', ''),
(104, 'volume', '500ml'),
(105, 'volume', '20pieces'),
(106, 'size', 'XL'),
(107, '', ''),
(108, '', ''),
(109, '', ''),
(110, '', ''),
(111, '', ''),
(112, '', ''),
(113, '', ''),
(114, '', ''),
(115, '', ''),
(116, '', ''),
(117, '', ''),
(118, '', ''),
(119, '', ''),
(120, '', ''),
(120, '', ''),
(121, '', ''),
(122, '', ''),
(123, 'Νο 46', ''),
(124, '', ''),
(125, 'Adhesive', '2 meters'),
(126, 'Povidone iodine 10%', '240 ml'),
(127, '100% Hydrofile', '70gr'),
(128, 'Quantity per package', '10'),
(128, 'Packages', '2'),
(129, 'piece', '10 pieces'),
(129, '', ''),
(129, '', ''),
(130, 'pank', '10 packs'),
(131, 'packet of pills', '20 pills'),
(132, 'packet of pills', '20 pills'),
(133, 'pieces', '1'),
(133, '', ''),
(134, 'volume', '500ml'),
(135, 'rolls', '1 roll'),
(135, '', ''),
(136, 'volume', '100ml'),
(137, 'packet', '1 packet'),
(138, 'pills', '10 pills'),
(139, '', ''),
(140, 'weight', '105g'),
(141, '', ''),
(142, '6 pack', ''),
(143, '1', ''),
(144, '1', ''),
(145, '', ''),
(146, 'weight', '45g'),
(147, 'pcs', '18'),
(148, 'weight', '100'),
(149, 'weight', '100'),
(150, 'weight', '100'),
(151, 'weight', '200g'),
(152, '', ''),
(153, 'volume', '200g'),
(153, '', ''),
(154, 'Potency', 'High'),
(155, '', ''),
(156, '1', ''),
(156, '', ''),
(157, '', '12'),
(158, '', '20'),
(158, '', ''),
(159, '', '2'),
(160, 'ml', '500'),
(161, '', '2'),
(162, '', '10'),
(163, '', '20'),
(164, '', '5'),
(165, '', '5'),
(166, 'grams', '1000'),
(167, 'grams', '500'),
(168, 'pair', '10'),
(169, 'grams', '1000'),
(170, 'grams', '500'),
(171, 'grams', '1000'),
(172, 'grams', '500'),
(173, 'grams', '1000'),
(174, '', '7'),
(175, 'grams', '500'),
(176, '', '5'),
(177, '', '10'),
(178, '', '5'),
(179, '', '5'),
(180, '', '5'),
(181, '', '2'),
(182, '', '3'),
(183, '', '20'),
(184, '', '6'),
(185, '', '10'),
(186, '10', '600ml'),
(186, '', ''),
(187, '67', '1000mg'),
(188, '10', '330ml'),
(189, '22', '330'),
(190, '31', '500ml'),
(191, '40', '330ml'),
(192, '23', '500ml'),
(193, '15', '500ml'),
(194, '16', 'Mini'),
(195, '5', 'Medium'),
(195, '6', 'Large'),
(195, '10', 'Small'),
(195, '2', 'XL'),
(196, '', ''),
(197, '10', '500mg'),
(197, '', ''),
(198, '20', ''),
(198, '', ''),
(199, '5', '1.5kg'),
(200, '20', '200g'),
(200, '', ''),
(201, '30', ''),
(202, '30', '500g'),
(203, '20', ''),
(204, 'volume', '500ml'),
(205, 'quantity', '100'),
(206, 'iphone', '200'),
(207, '', ''),
(208, '', ''),
(209, 'band', 'UHF/VHF'),
(209, 'Wi-Fi', '2,4/5,0 GHz'),
(209, 'Bluetooth', '5.2'),
(209, 'Οθόνη', '2,4” 320 x 240 px. QVGA'),
(209, 'διάρκεια ζωής της μπαταρίας', '28 ώρες'),
(210, 'Frequency', '140-150Mhz'),
(210, 'Power Supply', '13VDC /- 1V 40A'),
(210, 'Output RF Power (Nominal)', '30 – 210W ; 230W max AM/FM/CW'),
(210, 'Modulation Types', 'SSB,CW,AM, FM, data etc (All narrowband modes)'),
(211, 'PART NUMBER', 'C14Y016X016-T'),
(211, 'CONTRACTOR NAME:', 'CELINA Tent, Inc'),
(211, 'COLOR', 'Tan'),
(211, 'SET-UP TIME/NUMBER OF PERSONS', '4 People/30 Minutes'),
(212, 'dimensions', ' 20’x32.5’'),
(212, 'TYPE', 'Frame Structure, Expandable, Air-Transportable'),
(212, 'WEIGHT', '1,200 lbs'),
(213, 'TYPE', 'Frame Structure, Expandable, Air- Transportable'),
(213, 'DIMENSIONS', 'E I-40’x80’'),
(213, 'WEIGHT', '24,000 lbs'),
(214, '', ''),
(215, '', ''),
(216, '', ''),
(217, '', ''),
(218, 'weight', '1k'),
(219, 'weight', '1k'),
(220, '', ''),
(221, '', ''),
(222, '', ''),
(223, '', ''),
(224, '', ''),
(225, '', ''),
(226, '', ''),
(227, '', ''),
(228, '', ''),
(229, 'size', '1.90X60'),
(230, 'light', 'blue'),
(231, 'pack', '60'),
(232, 'Volts', '208'),
(233, 'material', 'plastic'),
(234, 'Type', 'Digital'),
(235, 'Material', 'Paper'),
(236, 'Type', 'Waterproof'),
(237, '1', '1'),
(237, '', ''),
(238, '', '5'),
(239, '', '10'),
(240, '', ''),
(241, '6', '1500ml'),
(242, '2', '80g'),
(243, '3', '100g'),
(244, '1', '800g'),
(245, '1', ''),
(246, '', ''),
(247, '', ''),
(248, '', ''),
(249, '', ''),
(250, '', ''),
(251, '', ''),
(252, '', ''),
(253, 'AAA', '5'),
(254, '', ''),
(255, '1', '200ml'),
(256, '', ''),
(257, '', ''),
(258, '', ''),
(259, '', ''),
(260, '', ''),
(261, '', ''),
(262, '', ''),
(263, '', ''),
(264, '', ''),
(265, '', ''),
(266, '', ''),
(267, '', ''),
(268, 'pages', '230'),
(269, '', '1kg'),
(270, '', ''),
(271, '', ''),
(272, 'galons', '20'),
(273, 'quantity', '5'),
(274, '', ''),
(275, 'test item ', '1kg'),
(276, 'volume', '500ml'),
(276, '', ''),
(277, 'pills', '60 pills'),
(278, '', ''),
(278, '', ''),
(279, '', ''),
(279, '', ''),
(280, '', ''),
(281, '', ''),
(282, '', ''),
(283, '', ''),
(284, '', ''),
(285, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

CREATE TABLE `storage` (
  `storage_id` int NOT NULL,
  `storage_coordinates_id` int DEFAULT NULL,
  `item_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `storage`
--

INSERT INTO `storage` (`storage_id`, `storage_coordinates_id`, `item_id`) VALUES
(1542, 15, 17),
(1546, 15, 21),
(1547, 15, 22),
(1548, 15, 33),
(1549, 15, 34),
(1550, 15, 36),
(1551, 15, 41),
(1552, 15, 42),
(1553, 15, 44),
(1554, 15, 46),
(1555, 15, 47),
(1556, 15, 67),
(1557, 15, 112);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int NOT NULL,
  `type` enum('request','offer') NOT NULL,
  `status` enum('completed','pending','acquired') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `transaction_date` datetime DEFAULT NULL,
  `completion_date` datetime DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `item_id` int DEFAULT NULL,
  `requested_item_amount` int DEFAULT NULL,
  `starting_date` datetime DEFAULT NULL,
  `vehicle_id` int DEFAULT NULL,
  `number_of_citizens_involved` smallint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `type`, `status`, `transaction_date`, `completion_date`, `user_id`, `item_id`, `requested_item_amount`, `starting_date`, `vehicle_id`, `number_of_citizens_involved`) VALUES
(76, 'offer', 'pending', NULL, NULL, 106, 105, 8, '2024-09-16 14:56:54', NULL, 8),
(77, 'offer', 'pending', NULL, NULL, 106, 34, 5, '2024-09-16 14:57:01', NULL, 5),
(86, 'request', 'pending', NULL, NULL, 99, 69, 8, '2024-09-16 15:22:07', NULL, 8),
(87, 'request', 'acquired', '2024-09-16 16:31:51', NULL, 109, 17, 7, '2024-09-16 15:24:03', 108, 7),
(88, 'request', 'pending', NULL, NULL, 109, 118, 3, '2024-09-16 15:24:13', NULL, 3),
(89, 'offer', 'acquired', '2024-09-16 16:22:17', NULL, 107, 118, 3, '2024-09-16 15:40:56', 108, 3),
(90, 'request', 'acquired', '2024-09-16 16:52:11', NULL, 111, 34, 5, '2024-09-16 16:51:08', 108, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `authentication_token` enum('admin','rescuer','citizen') NOT NULL,
  `user_coordinates_id` int DEFAULT NULL,
  `creation_datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  `citizen_name` varchar(20) DEFAULT NULL,
  `citizen_surname` varchar(20) DEFAULT NULL,
  `citizen_phone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `authentication_token`, `user_coordinates_id`, `creation_datetime`, `citizen_name`, `citizen_surname`, `citizen_phone`) VALUES
(74, 'giorgos25', '$2y$10$p3cAI8Gp4LlLJ0mvTAzAA.eOWHIAOML9Jot9x5qFLE8VgKCZJjpae', 'admin', NULL, '2024-08-27 17:22:27', 'Giorgos', 'Apostolou', '6983618944'),
(75, 'giannis10', '$2y$10$1s4gH2pVaUHSiJKG6RlHMOD1XsatIUVE8xolruTcSAkkMVb1ePClm', 'rescuer', 26, '2024-08-27 17:23:32', 'Giannis', 'Papachristou', '6937793355'),
(76, 'katerina4', '$2y$10$7Y/BZ0hQEIVDZ0Ojl4P.KuEnRxknd5JlZ7UD4TasPpOkKQg5CQy/6', 'rescuer', 22, '2024-08-27 17:24:07', 'Katerina', 'Antoniou', '6944896015'),
(99, 'christos4', '$2y$10$ckIJJIwHOmj5OMudUjCM8OXH5ePM7c6yWPcdLHklIraFMDBoDuxle', 'citizen', 9, '2024-09-04 20:36:50', 'Christos', 'Togias', '6948252216'),
(101, 'aggelos13', '$2y$10$.nKBBEMeRxFWwz.dskLhnOYGxrjffwMb1FYLlTpW63q87k6nFoAqm', 'citizen', 10, '2024-09-04 20:44:25', 'Aggelos', 'Bolano', '6962539210'),
(102, 'giorgos7', '$2y$10$FmCgq8/EWH35SqNsLaiwbO9mRr8WD5dJY.N/dbLnYUzwCoynmidF6', 'citizen', 11, '2024-09-04 20:48:42', 'Giorgos', 'Michopoulos', '6976456129'),
(106, 'petros90', '$2y$10$aM1yfX3Yhu71dvvjQ4XJeuiW8iPN7AhFmVf8GgU5JPwXTUNSEBjbG', 'citizen', 12, '2024-09-04 20:57:31', 'Petros', 'Mouzakis', '6987908711'),
(107, 'georgia14', '$2y$10$byP.cyIottIXVr1w4DLoBOBm/OBUXIsUfH9zLQ6Y06T3Iuu9x4qMa', 'citizen', 13, '2024-09-04 20:58:32', 'Georgia', 'Tsavolaki', '6978989022'),
(108, 'limperis19', '$2y$10$QayTtc/b.q7ct0O0SyDgbuZseb/TunxXIMAID6SQwy1xGIS44vhD6', 'rescuer', 25, '2024-09-04 21:01:28', 'Limperis', 'Patistis', '6980733487'),
(109, 'giannis34', '$2y$10$AI5Vf4FHgalIS2QNC1CcX.TVRmLYO6okLzHEpMqtHqNqmyyJTIulO', 'citizen', 23, '2024-09-09 19:11:26', 'Giannis', 'Efstathiou', '6976563113'),
(111, 'nikos75', '$2y$10$pmK4NA7mjAkOdshiRzlND.I0ovK2PZJyfjV5226ercAOp.p5ybsgq', 'citizen', 27, '2024-09-12 00:53:19', 'Nikolaos', 'Armenakis', '6972344376');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `vehicle_id` int NOT NULL,
  `vehicle_coordinates_id` int NOT NULL,
  `status` enum('free','occupied') DEFAULT NULL,
  `number_of_tasks` smallint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`vehicle_id`, `vehicle_coordinates_id`, `status`, `number_of_tasks`) VALUES
(76, 22, 'free', 0),
(108, 25, 'free', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vehicleitems`
--

CREATE TABLE `vehicleitems` (
  `vehicle_item_id` int NOT NULL,
  `vehicle_id` int DEFAULT NULL,
  `item_id` int DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `vehicleitems`
--

INSERT INTO `vehicleitems` (`vehicle_item_id`, `vehicle_id`, `item_id`, `quantity`) VALUES
(12, 76, 21, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announcement_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `coordinates`
--
ALTER TABLE `coordinates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `itemdetails`
--
ALTER TABLE `itemdetails`
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`storage_id`),
  ADD UNIQUE KEY `item_id` (`item_id`),
  ADD KEY `storage_coordinates_id` (`storage_coordinates_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `user_coordinates_id` (`user_coordinates_id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD KEY `vehicle_coordinates_id` (`vehicle_coordinates_id`);

--
-- Indexes for table `vehicleitems`
--
ALTER TABLE `vehicleitems`
  ADD PRIMARY KEY (`vehicle_item_id`),
  ADD KEY `fk_vehicle` (`vehicle_id`),
  ADD KEY `fk_item` (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcement_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `coordinates`
--
ALTER TABLE `coordinates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=286;

--
-- AUTO_INCREMENT for table `storage`
--
ALTER TABLE `storage`
  MODIFY `storage_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1558;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `vehicleitems`
--
ALTER TABLE `vehicleitems`
  MODIFY `vehicle_item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `announcement_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`);

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `itemdetails`
--
ALTER TABLE `itemdetails`
  ADD CONSTRAINT `itemdetails_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`);

--
-- Constraints for table `storage`
--
ALTER TABLE `storage`
  ADD CONSTRAINT `storage_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`),
  ADD CONSTRAINT `storage_ibfk_2` FOREIGN KEY (`storage_coordinates_id`) REFERENCES `coordinates` (`id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`),
  ADD CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`vehicle_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`user_coordinates_id`) REFERENCES `coordinates` (`id`);

--
-- Constraints for table `vehicleitems`
--
ALTER TABLE `vehicleitems`
  ADD CONSTRAINT `fk_item` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`vehicle_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vehicleitems_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`vehicle_id`),
  ADD CONSTRAINT `vehicleitems_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `item` (`item_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
