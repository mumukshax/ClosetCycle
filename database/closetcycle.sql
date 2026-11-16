-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2026 at 05:05 AM
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
-- Database: `closetcycle`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrow_requests`
--

CREATE TABLE `borrow_requests` (
  `requestID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `borrowerID` int(11) NOT NULL,
  `neededFrom` date NOT NULL,
  `neededUntil` date NOT NULL,
  `message` varchar(500) DEFAULT NULL,
  `status` enum('Pending','Approved','Declined','Borrowed','Returned','Cancelled') NOT NULL DEFAULT 'Pending',
  `requestDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `borrow_requests`
--

INSERT INTO `borrow_requests` (`requestID`, `itemID`, `borrowerID`, `neededFrom`, `neededUntil`, `message`, `status`, `requestDate`) VALUES
(1, 1, 3, '2026-10-18', '2026-10-20', 'I would like to borrow this for a wedding reception.', 'Borrowed', '2026-10-06 17:21:21'),
(2, 4, 4, '2026-10-05', '2026-10-08', 'I am borrowing this for an evening event.', 'Borrowed', '2026-10-06 17:21:21'),
(3, 7, 5, '2026-10-15', '2026-10-15', 'these are so beautiful! I am attending a wedding so i would love to pair these with my red dress.', 'Borrowed', '2026-10-06 17:31:42'),
(4, 1, 6, '2026-10-25', '2026-10-30', 'Could I borrow this for a graduation dinner?', 'Declined', '2026-10-06 18:29:31');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryID` int(11) NOT NULL,
  `categoryName` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryID`, `categoryName`) VALUES
(7, 'Accessories'),
(6, 'Bags'),
(1, 'Dresses'),
(3, 'Jackets & Blazers'),
(2, 'Sets'),
(5, 'Shoes'),
(4, 'Suits');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemID` int(11) NOT NULL,
  `ownerID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `occasionID` int(11) NOT NULL,
  `itemName` varchar(100) NOT NULL,
  `brand` varchar(80) DEFAULT NULL,
  `size` varchar(20) NOT NULL,
  `colour` varchar(50) DEFAULT NULL,
  `itemCondition` enum('New','Like New','Excellent','Good') NOT NULL,
  `description` text NOT NULL,
  `imageName` varchar(255) NOT NULL DEFAULT 'default-item.png',
  `status` enum('Available','Unavailable','On Loan') NOT NULL DEFAULT 'Available',
  `dateAdded` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemID`, `ownerID`, `categoryID`, `occasionID`, `itemName`, `brand`, `size`, `colour`, `itemCondition`, `description`, `imageName`, `status`, `dateAdded`) VALUES
(1, 2, 1, 1, 'Black Satin Midi Dress', 'Aritzia', 'M', 'Black', 'Excellent', 'A simple satin midi dress with a fitted shape. Great for weddings, dinners, and formal events.', 'item_cd859c9473a9d014.jpg', 'On Loan', '2026-09-18 10:00:00'),
(2, 2, 3, 5, 'Ivory Tailored Blazer', 'Mango', 'S', 'Ivory', 'Like New', 'Structured ivory blazer that works well for interviews, presentations, and formal work events.', 'item_c65a27bc0a4fd771.jpg', 'Available', '2026-09-20 11:00:00'),
(3, 3, 1, 2, 'Red Slip Dress', 'Reformation', 'M', 'Red', 'Excellent', 'Emerald green slip dress with a simple silhouette for formal dinners and special occasions.', 'item_9c90e424eb03b134.jpg', 'Available', '2026-09-23 12:00:00'),
(4, 3, 6, 4, 'Silver Mini Evening Bag', 'Zara', 'One Size', 'Silver', 'Excellent', 'Small silver evening bag with enough room for a phone, cards, and a few essentials.', 'item_db1c53e62f52a282.jpg', 'On Loan', '2026-09-25 13:00:00'),
(5, 4, 4, 3, 'Navy Tailored Suit', 'RW&CO', '6', 'Navy', 'Like New', 'Classic navy tailored suit suitable for graduation, presentations, and professional events.', 'item_edfa71b7d48f6bcc.jpg', 'Available', '2026-09-28 14:00:00'),
(6, 4, 5, 2, 'Black Slingback Heels', 'Aldo', '8', 'Black', 'Good', 'Black slingback heels with a medium heel. Comfortable enough for dinners and formal events.', 'item_79a5a4454e19bba8.jpg', 'Available', '2026-10-01 15:00:00'),
(7, 2, 7, 1, 'Gold Drop Earrings', 'Mejuri', 'One Size', 'Gold', 'Excellent', 'Simple gold drop earrings that work well with wedding guest and formal outfits.', 'item_94418794d03641ee.jpg', 'On Loan', '2026-10-03 16:00:00'),
(8, 3, 2, 6, 'Linen Two-Piece Set', 'H&M', 'M', 'Beige', 'Excellent', 'Lightweight linen-look two-piece set suitable for vacations and warm-weather events.', 'item_4630e560288190ad.jpg', 'Available', '2026-10-05 17:00:00'),
(9, 5, 1, 3, 'Formal  Dress', 'Zara', 'xs', 'Green', 'Like New', 'Only worn once, still has the tag.', 'item_091e6be9010f3a61.jpg', 'Available', '2026-10-06 17:29:50'),
(10, 6, 3, 2, 'pink mens shirt', 'xyz', 'M', 'RED', 'Good', 'NSJS', 'item_7f98464497f33f78.jpg', 'Available', '2026-10-06 18:30:44');

-- --------------------------------------------------------

--
-- Table structure for table `occasions`
--

CREATE TABLE `occasions` (
  `occasionID` int(11) NOT NULL,
  `occasionName` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `occasions`
--

INSERT INTO `occasions` (`occasionID`, `occasionName`) VALUES
(2, 'Formal'),
(3, 'Graduation'),
(4, 'Night Out'),
(6, 'Vacation'),
(1, 'Wedding Guest'),
(5, 'Work');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `role` enum('member','admin') NOT NULL DEFAULT 'member',
  `dateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `firstName`, `lastName`, `email`, `passwordHash`, `role`, `dateCreated`, `isActive`) VALUES
(1, 'ClosetCycle', 'Admin', 'admin@closetcycle.local', '$2y$12$Z/uMZVw3YMuO8K14/X7L7OlV.46zl8UdaEXYHE1m0lGjtMQacPKDq', 'admin', '2026-10-06 17:21:20', 1),
(2, 'Emma', 'Chen', 'emma@example.com', '$2y$12$ENa9DEBTpusI/uCFXtQDb.JqdU1wpNOzq745zNplcfCVKHkYql/2m', 'member', '2026-10-06 17:21:20', 1),
(3, 'Noor', 'Patel', 'noor@example.com', '$2y$12$ENa9DEBTpusI/uCFXtQDb.JqdU1wpNOzq745zNplcfCVKHkYql/2m', 'member', '2026-10-06 17:21:20', 1),
(4, 'Maya', 'Thompson', 'maya@example.com', '$2y$12$ENa9DEBTpusI/uCFXtQDb.JqdU1wpNOzq745zNplcfCVKHkYql/2m', 'member', '2026-10-06 17:21:20', 1),
(5, 'mumuksha', '.', 'mumuksha@example.com', '$2y$12$ENa9DEBTpusI/uCFXtQDb.JqdU1wpNOzq745zNplcfCVKHkYql/2m', 'member', '2026-10-06 17:25:26', 1),
(6, 'john', 'doe', 'john@example.com', '$2y$12$ENa9DEBTpusI/uCFXtQDb.JqdU1wpNOzq745zNplcfCVKHkYql/2m', 'member', '2026-10-06 18:28:15', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  ADD PRIMARY KEY (`requestID`),
  ADD KEY `fk_request_item` (`itemID`),
  ADD KEY `fk_request_borrower` (`borrowerID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryID`),
  ADD UNIQUE KEY `categoryName` (`categoryName`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `fk_item_owner` (`ownerID`),
  ADD KEY `fk_item_category` (`categoryID`),
  ADD KEY `fk_item_occasion` (`occasionID`);

--
-- Indexes for table `occasions`
--
ALTER TABLE `occasions`
  ADD PRIMARY KEY (`occasionID`),
  ADD UNIQUE KEY `occasionName` (`occasionName`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  MODIFY `requestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `occasions`
--
ALTER TABLE `occasions`
  MODIFY `occasionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  ADD CONSTRAINT `fk_request_borrower` FOREIGN KEY (`borrowerID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `fk_request_item` FOREIGN KEY (`itemID`) REFERENCES `items` (`itemID`) ON DELETE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `fk_item_category` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`categoryID`),
  ADD CONSTRAINT `fk_item_occasion` FOREIGN KEY (`occasionID`) REFERENCES `occasions` (`occasionID`),
  ADD CONSTRAINT `fk_item_owner` FOREIGN KEY (`ownerID`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
