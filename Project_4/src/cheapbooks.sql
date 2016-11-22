-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2016 at 09:21 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cheapbooks`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `ssn` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(500) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='info about a book author';

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`ssn`, `name`, `address`, `phone`) VALUES
('1000000001', 'Adam Smith', 'Kirkcaldy, Fife, Scotland', '7778889991'),
('1000000002', 'Ayan Rand', 'St. Petersburg, Russia', '7778889992'),
('1000000003', 'George Orwell', 'Bengal, India', '7778889993'),
('1000000004', 'Douglas Adams', 'Cambridge, England', '7778889994');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `ISBN` varchar(15) NOT NULL,
  `title` varchar(200) NOT NULL,
  `year` year(4) NOT NULL,
  `price` float NOT NULL,
  `publisher` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='info about a book';

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`ISBN`, `title`, `year`, `price`, `publisher`) VALUES
('0345391802', 'Hitchhiker''s Guide to the Galaxy', 1995, 8.99, 'Del Rey'),
('0451191153', 'The Fountainhead', 1996, 19.99, 'Signet'),
('0451524934', '1984', 1961, 16.99, 'Signet Classic'),
('0553585975', 'The Wealth of Nations', 2003, 23.99, 'Bantam Classics');

-- --------------------------------------------------------

--
-- Table structure for table `contains`
--

CREATE TABLE `contains` (
  `ISBN` varchar(15) NOT NULL,
  `basketID` varchar(100) NOT NULL,
  `number` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='the content of a shopping basket';

--
-- Dumping data for table `contains`
--

INSERT INTO `contains` (`ISBN`, `basketID`, `number`) VALUES
('', '5833cfc22c618', 2),
('0345391802', '5834a8b66b0c6', 1),
('0451191153', '5834a8b66b0c6', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `username` varchar(100) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Info about a customer';

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`username`, `address`, `email`, `phone`, `password`) VALUES
('sai', '601 Summit Ave #285', 'saikumar.manakan@gmail.com', '6825519838', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `shippingorder`
--

CREATE TABLE `shippingorder` (
  `ISBN` varchar(15) NOT NULL,
  `warehouseCode` int(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `number` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shippingorder`
--

INSERT INTO `shippingorder` (`ISBN`, `warehouseCode`, `username`, `number`) VALUES
('0451191153', 1003, 'smith', 1),
('0451191153', 1004, 'smith', 1),
('0451191153', 1003, 'smith', 1),
('0451191153', 1004, 'smith', 1),
('0451191153', 1003, 'smith', 1),
('0451191153', 1004, 'smith', 1),
('0451191153', 1003, 'smith', 1),
('0451191153', 1004, 'smith', 1),
('0345391802', 1003, 'smith', 1),
('0451191153', 1003, 'smith', 1),
('0553585975', 1002, 'smith', 2),
('0345391802', 1004, 'smith', 1),
('0553585975', 1002, 'smith', 1),
('0345391802', 1001, 'smith', 1),
('0553585975', 1002, 'smith', 1);

-- --------------------------------------------------------

--
-- Table structure for table `shoppingbasket`
--

CREATE TABLE `shoppingbasket` (
  `basketID` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='relates customers with baskets';

--
-- Dumping data for table `shoppingbasket`
--

INSERT INTO `shoppingbasket` (`basketID`, `username`) VALUES
('5833cfc22c618', 'smith'),
('5834a8b66b0c6', 'sai');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `ISBN` varchar(15) NOT NULL,
  `warehouseCode` int(10) NOT NULL,
  `number` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`ISBN`, `warehouseCode`, `number`) VALUES
('0345391802', 1001, 3),
('0451191153', 1001, 25),
('0451524934', 1001, 10),
('0553585975', 1001, 15),
('0345391802', 1002, 4),
('0451191153', 1002, 25),
('0451524934', 1002, 15),
('0553585975', 1002, 65),
('0345391802', 1003, 4),
('0451191153', 1003, 44),
('0451524934', 1003, 100),
('0553585975', 1003, 45),
('0345391802', 1004, 4),
('0451191153', 1004, 45),
('0451524934', 1004, 45),
('0553585975', 1004, 30);

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE `warehouse` (
  `warehouseCode` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`warehouseCode`, `name`, `address`, `phone`) VALUES
(1001, 'Sunbelt', 'Dallas, TX', '9998887771'),
(1002, 'Bookcenter', 'Houston, TX', '9998887772'),
(1003, 'Bookware', 'Austin, TX', '9998887773'),
(1004, 'Zendware', 'San Antonio, TX', '9998887774');

-- --------------------------------------------------------

--
-- Table structure for table `writtenby`
--

CREATE TABLE `writtenby` (
  `ssn` varchar(10) NOT NULL,
  `ISBN` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `writtenby`
--

INSERT INTO `writtenby` (`ssn`, `ISBN`) VALUES
('1000000001', '0553585975'),
('1000000002', '0451191153'),
('1000000003', '0451524934'),
('1000000004', '0345391802');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`ssn`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`ISBN`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `shoppingbasket`
--
ALTER TABLE `shoppingbasket`
  ADD PRIMARY KEY (`basketID`);

--
-- Indexes for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`warehouseCode`);

--
-- Indexes for table `writtenby`
--
ALTER TABLE `writtenby`
  ADD PRIMARY KEY (`ssn`,`ISBN`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
