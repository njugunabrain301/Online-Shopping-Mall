-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2020 at 09:26 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shoppingmall`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ADD_LISTING` (IN `wid` VARCHAR(40), IN `ptitle` VARCHAR(15), IN `description` TEXT, IN `pext` VARCHAR(6), OUT `newId` INT)  NO SQL
BEGIN
    SET @num = (Select count(*) from product_listing) + 1;
    INSERT INTO product_listing (`id`, `web_id`, `title`, `listing`, `ext`) VALUES (num, wid, ptitle, description, pext);
    SET newId = num;     
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `itemId` varchar(40) NOT NULL,
  `userId` int(11) NOT NULL,
  `day` date NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'PENDING',
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `locationId` int(11) NOT NULL,
  `reason` text DEFAULT NULL,
  `stars` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `itemId`, `userId`, `day`, `status`, `start`, `end`, `locationId`, `reason`, `stars`) VALUES
(16, '4822c49ac31020e6603a865ff6532846', 3, '2020-03-22', 'CANCELLED', 1000, 1200, 8, 'Hmmmmmm', 0),
(20, '4822c49ac31020e6603a865ff6532846', 3, '2020-05-25', 'COMPLETE', 1400, 1600, 7, NULL, 5),
(21, '4822c49ac31020e6603a865ff6532846', 3, '2020-05-23', 'CANCELLED', 1400, 1600, 7, 'Hmmmmmmmmmmm', 0),
(22, '4822c49ac31020e6603a865ff6532846', 3, '2020-05-24', 'CANCELLED', 800, 1000, 7, 'Hmmmmmmmmmmmx2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `itemId` varchar(40) NOT NULL,
  `userId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `status` varchar(15) DEFAULT 'PICK UP',
  `ordered` date DEFAULT NULL,
  `received` date DEFAULT NULL,
  `stars` int(11) DEFAULT 0,
  `reason` text DEFAULT NULL,
  `locationId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `itemId`, `userId`, `quantity`, `status`, `ordered`, `received`, `stars`, `reason`, `locationId`) VALUES
(6, '3469bf07bf96a97b3c7023be24d42213', 3, 100, 'COMPLETE', '2020-04-29', NULL, 5, NULL, 8),
(7, '3469bf07bf96a97b3c7023be24d42213', 3, 1, 'CANCELLED', NULL, NULL, 0, 'Just felt like it', NULL),
(8, '3469bf07bf96a97b3c7023be24d42213', 3, 1, 'CANCELLED', NULL, NULL, 0, 'Just felt like it too', NULL),
(9, '3469bf07bf96a97b3c7023be24d42213', 3, 1, 'CANCELLED', NULL, NULL, 0, 'Just felt like it too too', NULL),
(10, '3469bf07bf96a97b3c7023be24d42213', 3, 1, 'CANCELLED', NULL, NULL, 0, 'Just felt like it too too too', NULL),
(11, '3469bf07bf96a97b3c7023be24d42213', 3, 1, 'CANCELLED', NULL, NULL, 0, 'Just felt like it too too too', NULL),
(12, '3469bf07bf96a97b3c7023be24d42213', 3, 1, 'CANCELLED', NULL, NULL, 0, 'Just felt like it too too too', 9),
(13, '3469bf07bf96a97b3c7023be24d42213', 3, 1, 'CANCELLED', NULL, NULL, 0, 'awsdfghjk', 9),
(25, 'ce19fa6598e5abaac267c0c68040adf7', 3, 1, 'COMPLETE', '0000-00-00', '2020-05-17', 5, NULL, 11),
(26, 'ce19fa6598e5abaac267c0c68040adf7', 3, 1, 'COMPLETE', '0000-00-00', '2020-05-17', 5, NULL, 11),
(27, 'ce19fa6598e5abaac267c0c68040adf7', 3, 1, 'COMPLETE', '0000-00-00', '2020-05-18', 5, NULL, 11),
(28, 'ce19fa6598e5abaac267c0c68040adf7', 3, 1, 'COMPLETE', '0000-00-00', '2020-05-23', 3, NULL, 11),
(29, 'ce19fa6598e5abaac267c0c68040adf7', 3, 1, 'PICK UP', '0000-00-00', NULL, 0, NULL, 11),
(30, 'ce19fa6598e5abaac267c0c68040adf7', 3, 1, 'PENDING', NULL, NULL, 0, NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `clothes`
--

CREATE TABLE `clothes` (
  `id` int(11) NOT NULL,
  `pid` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `size` text DEFAULT NULL,
  `color` text DEFAULT NULL,
  `brand` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `item_id` varchar(40) CHARACTER SET latin1 NOT NULL,
  `comment` text CHARACTER SET latin1 DEFAULT NULL,
  `stars` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `item_id`, `comment`, `stars`, `user_id`) VALUES
(1, 'ce19fa6598e5abaac267c0c68040adf7', 'Mbogi ni kimonyoski', 5, 3),
(2, 'ce19fa6598e5abaac267c0c68040adf7', 'Mseee wazi', 5, 3),
(3, 'ce19fa6598e5abaac267c0c68040adf7', 'Ustake jua', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `computers`
--

CREATE TABLE `computers` (
  `id` int(11) NOT NULL,
  `pid` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `screensize` float DEFAULT NULL,
  `ram` varchar(10) DEFAULT NULL,
  `storage` varchar(10) DEFAULT NULL,
  `make` varchar(30) DEFAULT NULL,
  `model` varchar(80) DEFAULT NULL,
  `processorType` varchar(40) DEFAULT NULL,
  `processorSpeed` varchar(15) DEFAULT NULL,
  `colors` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `userId` int(11) NOT NULL,
  `storeId` varchar(40) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`userId`, `storeId`) VALUES
(3, '586d1fb171563dc84d1f6f0a77e057bf');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int(11) NOT NULL,
  `holiday` varchar(50) NOT NULL,
  `day` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `type` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `holiday`, `day`, `month`, `type`) VALUES
(1, 'myHols', 11, 4, 'RELIGIOUS'),
(2, 'myHols2', 12, 4, 'NATIONAL');

-- --------------------------------------------------------

--
-- Table structure for table `hours`
--

CREATE TABLE `hours` (
  `id` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hours`
--

INSERT INTO `hours` (`id`, `start`, `end`, `userId`) VALUES
(1, 800, 1700, NULL),
(2, 800, 2000, NULL),
(4, 0, 0, NULL),
(5, 1300, 1400, 2);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `web_id` varchar(40) NOT NULL,
  `street` varchar(40) NOT NULL,
  `building` varchar(40) NOT NULL,
  `stall` varchar(10) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `web_id`, `street`, `building`, `stall`, `description`) VALUES
(6, '2fe6831b1c50e98b0b5fbd77614cfa90', 'latestt', 'latestt', 'latestt', 'A great place'),
(7, '7a96ab4106fa78ea81b879d09cd178c4', 'service', 'service', 'service', ''),
(8, '494939aee71f55d281867c24784d7385', 'Biashara', 'Biashara Center', '25', ''),
(9, '2fe6831b1c50e98b0b5fbd77614cfa90', 'street', 'building', 'stall', ''),
(10, '586d1fb171563dc84d1f6f0a77e057bf', 'Street', 'Building', 'stalll', 'jdfsklfjhskdjfncklsdnkshfdsjbcksdncdsklfksjdkslfjkdslfjsdlkfjsdk'),
(11, '586d1fb171563dc84d1f6f0a77e057bf', 'Steet', 'buid', 'tall', 'sedfghjkl;kjhgfdsxfcvgbhjuikolpkoijhuygtfrdxfcgvhbjkjhugtfrdxcgvhbjkiol');

-- --------------------------------------------------------

--
-- Table structure for table `lunchhours`
--

CREATE TABLE `lunchhours` (
  `id` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `userId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lunchhours`
--

INSERT INTO `lunchhours` (`id`, `start`, `end`, `userId`) VALUES
(1, 1300, 1400, NULL),
(6, 30, 103, 2),
(7, 0, 0, NULL),
(8, 1101, 1400, 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product_id` varchar(40) DEFAULT NULL,
  `amount` double NOT NULL,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `account_number` varchar(30) DEFAULT 'undefined',
  `receiver` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `mode` varchar(10) NOT NULL,
  `amount` double NOT NULL,
  `purpose` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `phones`
--

CREATE TABLE `phones` (
  `id` int(11) NOT NULL,
  `pid` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `ram` varchar(10) DEFAULT NULL,
  `storage` varchar(10) DEFAULT NULL,
  `screensize` float DEFAULT NULL,
  `make` varchar(30) DEFAULT NULL,
  `model` varchar(80) DEFAULT NULL,
  `frontCamera` float DEFAULT NULL,
  `backCamera` float DEFAULT NULL,
  `batteryCapacity` float DEFAULT NULL,
  `refurbished` varchar(3) DEFAULT NULL,
  `colors` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `name` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `duration` double DEFAULT 0,
  `amount` int(11) DEFAULT 0,
  `web_id` varchar(40) DEFAULT NULL,
  `id` varchar(40) NOT NULL,
  `category` varchar(50) NOT NULL,
  `search` text DEFAULT NULL,
  `procurement` varchar(12) NOT NULL DEFAULT 'PICK UP',
  `classification` varchar(20) NOT NULL DEFAULT 'PRODUCT',
  `status` varchar(15) NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`name`, `type`, `description`, `price`, `duration`, `amount`, `web_id`, `id`, `category`, `search`, `procurement`, `classification`, `status`) VALUES
('Dope stuff', 'Of the Dope Type', 'Pretty dope stuff', 2000, 2, 0, '87106ae7c573a9eb13d832ecda47907b', '1ff0755a4684f888324ef650a6a60f3b', 'Televisions', 'Televisions', 'PICK UP', 'SERVICE', 'DELETED'),
('Prod', 'Prod', 'Prod getProduct getProduct getProduct getProduct getProduct getProduct getProduct getProduct getProduct getProduct', 1, 0, 10, '2fe6831b1c50e98b0b5fbd77614cfa90', '3469bf07bf96a97b3c7023be24d42213', 'Computers & Accessories', 'Computers & Accessoriesprod', 'PICKUP', 'PRODUCT', 'ACTIVE'),
('service', 'cervice', 'asdfghbjkl;kljhufygtdrgvhbjnmk', 500, 2, 0, '7a96ab4106fa78ea81b879d09cd178c4', '4822c49ac31020e6603a865ff6532846', 'Electronics & Appliances', 'Electronics & Appliances service', 'PICKUP', 'SERVICE', 'ACTIVE'),
('Fab', 'Fab type', 'I know, RIght!', 500, 2, 0, '87106ae7c573a9eb13d832ecda47907b', 'a3d13ad9f44ddd0ff4a62e9b8e95cec4', 'Phones & Accessories', 'phones', 'PICK UP', 'SERVICE', 'DELETED'),
('Prod', 'Prada', 'Pretty amazing if you ask me', 2000, 0, 20, '586d1fb171563dc84d1f6f0a77e057bf', 'c84b5aa8a523d044901c5a628063c7d8', 'Shoes', 'Shoes', 'PICK UP', 'PRODUCT', 'DELETED'),
('Another Prod', 'Prada Too', 'Another pretty awsome stuff here. don\'t miss out', 2500, 0, 20, '586d1fb171563dc84d1f6f0a77e057bf', 'ce19fa6598e5abaac267c0c68040adf7', 'Shoes', 'SHoes', 'PICK UP', 'PRODUCT', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` varchar(80) NOT NULL,
  `ext` varchar(5) NOT NULL,
  `num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `ext`, `num`) VALUES
(8, '3469bf07bf96a97b3c7023be24d42213', 'jpeg', 2),
(9, '3469bf07bf96a97b3c7023be24d42213', 'jpeg', 3),
(10, '3469bf07bf96a97b3c7023be24d42213', 'jpeg', 4),
(12, '4822c49ac31020e6603a865ff6532846', 'jpeg', 1),
(13, 'c84b5aa8a523d044901c5a628063c7d8', 'jpg', 0),
(14, 'c84b5aa8a523d044901c5a628063c7d8', 'jpg', 1),
(15, 'c84b5aa8a523d044901c5a628063c7d8', 'jpg', 2),
(16, 'c84b5aa8a523d044901c5a628063c7d8', 'jpeg', 3),
(17, 'ce19fa6598e5abaac267c0c68040adf7', 'jpg', 0),
(18, 'ce19fa6598e5abaac267c0c68040adf7', 'jpg', 1),
(19, 'ce19fa6598e5abaac267c0c68040adf7', 'jpg', 2),
(20, 'ce19fa6598e5abaac267c0c68040adf7', 'jpg', 3),
(21, '1ff0755a4684f888324ef650a6a60f3b', 'jpg', 0),
(22, '1ff0755a4684f888324ef650a6a60f3b', 'jpg', 1),
(23, '1ff0755a4684f888324ef650a6a60f3b', 'jpg', 2),
(24, '1ff0755a4684f888324ef650a6a60f3b', 'jpg', 3),
(25, 'a3d13ad9f44ddd0ff4a62e9b8e95cec4', 'jpg', 0),
(26, 'a3d13ad9f44ddd0ff4a62e9b8e95cec4', 'jpg', 1),
(27, 'a3d13ad9f44ddd0ff4a62e9b8e95cec4', 'jpg', 2),
(28, 'a3d13ad9f44ddd0ff4a62e9b8e95cec4', 'jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_listing`
--

CREATE TABLE `product_listing` (
  `id` int(11) NOT NULL,
  `listing` text NOT NULL,
  `web_id` varchar(40) NOT NULL,
  `title` varchar(15) NOT NULL DEFAULT '',
  `ext` varchar(6) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_listing`
--

INSERT INTO `product_listing` (`id`, `listing`, `web_id`, `title`, `ext`) VALUES
(1, 'Clothes Repair Clothes Repair Clothes Repair Clothes Repair Clothes Repair Clothes Repair Clothes Repair Clothes Repair Clothes Repair', '494939aee71f55d281867c24784d7385', '', ''),
(3, 'fdxcgvhbjnkmlkjhgfvhbjnkm', '2fe6831b1c50e98b0b5fbd77614cfa90', '', ''),
(4, 'azsdxfcgvbhjnkljhgfcgvbhnjmk', '2fe6831b1c50e98b0b5fbd77614cfa90', '', ''),
(5, 'sdxfcgvhbjklkjhgvcfdxcgvbhj', '2fe6831b1c50e98b0b5fbd77614cfa90', '', ''),
(6, 'ajsgfdsjkfgsdjfs auidhakjdhajdhakj jkdagdhkj agdajhdasj d gadgakd asdg askdgakjd askjdg adgask daksjgd askjdga das daskdgaskj das dagsd akdga kd ask das dasdgkas das dgaskd asdgkas dasdgas das dkasd askdak dask dsa d asd as da', '2fe6831b1c50e98b0b5fbd77614cfa90', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `id` varchar(40) NOT NULL,
  `name` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(15) NOT NULL,
  `number_of_stars` int(11) DEFAULT 0,
  `number_of_reviewers` int(11) DEFAULT 0,
  `ext` varchar(5) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'PENDING',
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `search` text DEFAULT NULL,
  `stars` int(11) DEFAULT 0,
  `sales` int(11) DEFAULT 0,
  `lunchbreak` int(11) NOT NULL,
  `hours` int(11) NOT NULL,
  `weekends` varchar(10) NOT NULL,
  `holidays` varchar(12) NOT NULL,
  `dateCreated` date NOT NULL,
  `capacity` int(11) NOT NULL,
  `website` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`id`, `name`, `user_id`, `description`, `type`, `number_of_stars`, `number_of_reviewers`, `ext`, `status`, `email`, `phone`, `search`, `stars`, `sales`, `lunchbreak`, `hours`, `weekends`, `holidays`, `dateCreated`, `capacity`, `website`) VALUES
('2fe6831b1c50e98b0b5fbd77614cfa90', 'latestt', 2, 'latestt', 'silver', 5, 2, 'jpeg', 'SUSPENDED', 'admin@gmail.com', '0717563148', NULL, 5, 2, 1, 1, 'both', 'all', '2020-01-01', 0, 'www.website.com'),
('494939aee71f55d281867c24784d7385', 'Shawn Cooper', 2, 'The best shoes store in history', 'silver', 0, 0, 'jpeg', 'DELETED', 'jb@gmail.com', '0717563148', NULL, 0, 0, 1, 1, 'both', 'all', '2020-01-01', 0, ''),
('586d1fb171563dc84d1f6f0a77e057bf', 'Store name', 2, 'The other store of all stores', 'silver', 18, 4, 'jpg', 'APPROVED', 'otherStore@gmail.com', '0793456789', NULL, 0, 0, 1, 1, 'both', 'all', '2020-01-01', 0, ''),
('7a96ab4106fa78ea81b879d09cd178c4', 'service', 2, 'service', 'gold', 0, 0, 'jpg', 'APPROVED', '', '', NULL, 5, 1, 1, 1, 'both', 'all', '2020-01-01', 0, ''),
('87106ae7c573a9eb13d832ecda47907b', 'Store name', 2, 'Yes. This is the store of all stores', 'gold', 0, 0, 'jpg', 'DELETED', 'store@gmail.com', '0717563148', NULL, 0, 0, 1, 1, 'none', 'none', '2020-01-01', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `shoes`
--

CREATE TABLE `shoes` (
  `id` int(11) NOT NULL,
  `pid` varchar(40) CHARACTER SET latin1 DEFAULT NULL,
  `colors` text DEFAULT NULL,
  `brand` varchar(30) DEFAULT NULL,
  `number` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `televisions`
--

CREATE TABLE `televisions` (
  `id` int(11) NOT NULL,
  `inches` float DEFAULT NULL,
  `make` varchar(30) DEFAULT NULL,
  `model` varchar(80) DEFAULT NULL,
  `display` varchar(10) DEFAULT NULL,
  `pid` varchar(40) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `id_number` varchar(12) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(100) NOT NULL,
  `verification_key` varchar(100) DEFAULT NULL,
  `verified` int(11) DEFAULT 0,
  `type` varchar(10) NOT NULL DEFAULT 'CUSTOMER',
  `ext` varchar(7) DEFAULT NULL,
  `recorded_last` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `id_number`, `email`, `phone`, `password`, `verification_key`, `verified`, `type`, `ext`, `recorded_last`) VALUES
(2, 'Johnny', 'hellwo', '123456789', 'admin@gmail.com', '0717563148', '$2y$10$IT.BlTejvRuTMiU7lFmEN.rY/Y/bBHRLzTRQkNJiFPTyDKTlrdfl2', 'not sent', 0, 'CUSTOMER', NULL, '2020-06-04'),
(3, 'First Name', 'Johnte', '435678998', 'bjmbugua7@gmail.com', '0717563148', '$2y$10$ON3w2vbhaWFqeSJlHv0pSuU88TsmAJLWueELMy9nsQ6Le/nuuSX/6', 'not sent', 0, 'CUSTOMER', 'jpg', '2020-05-28'),
(4, 'Admin', 'Admin', '3456789876', 'user1@gmail.com', '0717563148', '$2y$10$9/6.SHW9XmrbmjHqKSsNte4ZurKfK6lszqmmR7e2cHLUo1FS0LI26', 'not sent', 0, 'ADMIN', NULL, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `day` date NOT NULL,
  `product_id` varchar(40) CHARACTER SET latin1 NOT NULL,
  `number_of_views` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`day`, `product_id`, `number_of_views`) VALUES
('2020-04-29', '4822c49ac31020e6603a865ff6532846', 4),
('2020-05-13', '3469bf07bf96a97b3c7023be24d42213', 1),
('2020-05-15', '3469bf07bf96a97b3c7023be24d42213', 1),
('2020-05-16', 'ce19fa6598e5abaac267c0c68040adf7', 1),
('2020-05-17', 'ce19fa6598e5abaac267c0c68040adf7', 1),
('2020-05-19', 'ce19fa6598e5abaac267c0c68040adf7', 1),
('2020-05-20', '4822c49ac31020e6603a865ff6532846', 1),
('2020-05-21', '4822c49ac31020e6603a865ff6532846', 1),
('2020-05-23', 'a3d13ad9f44ddd0ff4a62e9b8e95cec4', 1),
('2020-05-28', '4822c49ac31020e6603a865ff6532846', 1),
('2020-05-28', 'ce19fa6598e5abaac267c0c68040adf7', 1),
('2020-05-29', 'ce19fa6598e5abaac267c0c68040adf7', 1),
('2020-05-30', 'ce19fa6598e5abaac267c0c68040adf7', 1),
('2020-06-01', 'ce19fa6598e5abaac267c0c68040adf7', 1),
('2020-06-02', '4822c49ac31020e6603a865ff6532846', 1),
('2020-06-03', 'ce19fa6598e5abaac267c0c68040adf7', 1),
('2020-06-04', 'ce19fa6598e5abaac267c0c68040adf7', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `itemId` (`itemId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `locationId` (`locationId`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `itemId` (`itemId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `locationId` (`locationId`);

--
-- Indexes for table `clothes`
--
ALTER TABLE `clothes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `computers`
--
ALTER TABLE `computers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`userId`,`storeId`),
  ADD KEY `storeId` (`storeId`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hours`
--
ALTER TABLE `hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `web_id` (`web_id`);

--
-- Indexes for table `lunchhours`
--
ALTER TABLE `lunchhours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver` (`receiver`),
  ADD KEY `sender` (`sender`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver` (`receiver`),
  ADD KEY `sender` (`sender`);

--
-- Indexes for table `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `web_id` (`web_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_listing`
--
ALTER TABLE `product_listing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `web_id` (`web_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hours` (`hours`),
  ADD KEY `lunchbreak` (`lunchbreak`);

--
-- Indexes for table `shoes`
--
ALTER TABLE `shoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `televisions`
--
ALTER TABLE `televisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`day`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `clothes`
--
ALTER TABLE `clothes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `computers`
--
ALTER TABLE `computers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hours`
--
ALTER TABLE `hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `lunchhours`
--
ALTER TABLE `lunchhours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phones`
--
ALTER TABLE `phones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `product_listing`
--
ALTER TABLE `product_listing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `shoes`
--
ALTER TABLE `shoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `televisions`
--
ALTER TABLE `televisions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`itemId`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`locationId`) REFERENCES `locations` (`id`);

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`itemId`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `carts_ibfk_3` FOREIGN KEY (`locationId`) REFERENCES `locations` (`id`);

--
-- Constraints for table `clothes`
--
ALTER TABLE `clothes`
  ADD CONSTRAINT `clothes_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `product` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `computers`
--
ALTER TABLE `computers`
  ADD CONSTRAINT `computers_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `product` (`id`);

--
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`storeId`) REFERENCES `section` (`id`);

--
-- Constraints for table `hours`
--
ALTER TABLE `hours`
  ADD CONSTRAINT `hours_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`web_id`) REFERENCES `section` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lunchhours`
--
ALTER TABLE `lunchhours`
  ADD CONSTRAINT `lunchhours_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`receiver`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`sender`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`receiver`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`sender`) REFERENCES `user` (`id`);

--
-- Constraints for table `phones`
--
ALTER TABLE `phones`
  ADD CONSTRAINT `phones_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `product` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`web_id`) REFERENCES `section` (`id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`web_id`) REFERENCES `section` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product_listing`
--
ALTER TABLE `product_listing`
  ADD CONSTRAINT `product_listing_ibfk_1` FOREIGN KEY (`web_id`) REFERENCES `section` (`id`);

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `section_ibfk_2` FOREIGN KEY (`hours`) REFERENCES `hours` (`id`),
  ADD CONSTRAINT `section_ibfk_3` FOREIGN KEY (`lunchbreak`) REFERENCES `lunchhours` (`id`);

--
-- Constraints for table `shoes`
--
ALTER TABLE `shoes`
  ADD CONSTRAINT `shoes_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `product` (`id`);

--
-- Constraints for table `televisions`
--
ALTER TABLE `televisions`
  ADD CONSTRAINT `televisions_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `product` (`id`);

--
-- Constraints for table `views`
--
ALTER TABLE `views`
  ADD CONSTRAINT `views_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
