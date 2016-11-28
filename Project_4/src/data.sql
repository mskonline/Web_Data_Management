ALTER TABLE `contains` DROP FOREIGN KEY `contains_book_isbn_cons`;
ALTER TABLE `contains` DROP FOREIGN KEY `contains_shoppingbasket_basketid_cons`;

ALTER TABLE contains DROP INDEX ISBN;
ALTER TABLE contains DROP INDEX basketID;

ALTER TABLE `shippingorder` DROP FOREIGN KEY `shippingorder_book_isbn_cons`;
ALTER TABLE `shippingorder` DROP FOREIGN KEY `shippingorder_customer_username_cons`;
ALTER TABLE `shippingorder` DROP FOREIGN KEY `shippingorder_warehouse_warehousecode_cons`;

ALTER TABLE shippingorder DROP INDEX ISBN;
ALTER TABLE shippingorder DROP INDEX warehouseCode;
ALTER TABLE shippingorder DROP INDEX username;

ALTER TABLE `shoppingbasket` DROP FOREIGN KEY `shoppingbasket_customer_username_cons`;

ALTER TABLE shoppingbasket DROP INDEX username;

ALTER TABLE `stocks` DROP FOREIGN KEY `stocks_book_isbn_cons`;
ALTER TABLE `stocks` DROP FOREIGN KEY `stocks_warehouse_warehousecode_cons`;

ALTER TABLE stocks DROP INDEX ISBN;
ALTER TABLE stocks DROP INDEX warehouseCode;

ALTER TABLE `writtenby` DROP FOREIGN KEY `writtenby_author_ssn_cons`;
ALTER TABLE `writtenby` DROP FOREIGN KEY `writtenby_book_isbn_cons`;


ALTER TABLE writtenby DROP INDEX ssn;
ALTER TABLE writtenby DROP INDEX ISBN;

ALTER TABLE author DROP PRIMARY KEY;
ALTER TABLE book DROP PRIMARY KEY;
ALTER TABLE customer DROP PRIMARY KEY;
ALTER TABLE shoppingbasket DROP PRIMARY KEY;
ALTER TABLE warehouse DROP PRIMARY KEY;


TRUNCATE TABLE writtenby;
TRUNCATE TABLE stocks;
TRUNCATE TABLE contains;
TRUNCATE TABLE shoppingbasket;
TRUNCATE TABLE shippingorder;

TRUNCATE TABLE book;
TRUNCATE TABLE author;
TRUNCATE TABLE warehouse;
TRUNCATE TABLE customer;


INSERT INTO `author` (`ssn`, `name`, `address`, `phone`) VALUES
('1000000001', 'Adam Smith', 'Kirkcaldy, Fife, Scotland', '7778889991'),
('1000000002', 'Ayan Rand', 'St. Petersburg, Russia', '7778889992'),
('1000000003', 'George Orwell', 'Bengal, India', '7778889993'),
('1000000004', 'Douglas Adams', 'Cambridge, England', '7778889994');

INSERT INTO `book` (`ISBN`, `title`, `year`, `price`, `publisher`) VALUES
('0345391802', 'Hitchhiker''s Guide to the Galaxy', 1995, 8.99, 'Del Rey'),
('0451191153', 'The Fountainhead', 1996, 19.99, 'Signet'),
('0451524934', '1984', 1961, 16.99, 'Signet Classic'),
('0553585975', 'The Wealth of Nations', 2003, 23.99, 'Bantam Classics'),
('0553585976', 'Brief history of Time', 2010, 25.99, 'Bantam Classics');

INSERT INTO `writtenby` (`ssn`, `ISBN`) VALUES
('1000000001', '0553585975'),
('1000000002', '0451191153'),
('1000000003', '0451524934'),
('1000000004', '0345391802'),
('1000000004', '0553585976');

INSERT INTO `warehouse` (`warehouseCode`, `name`, `address`, `phone`) VALUES
(1001, 'Sunbelt', 'Dallas, TX', '9998887771'),
(1002, 'Bookcenter', 'Houston, TX', '9998887772'),
(1003, 'Bookware', 'Austin, TX', '9998887773'),
(1004, 'Zendware', 'San Antonio, TX', '9998887774');

INSERT INTO `stocks` (`ISBN`, `warehouseCode`, `number`) VALUES
('0345391802', 1001, 3),
('0451191153', 1001, 25),
('0451524934', 1001, 10),
('0553585975', 1001, 15),
('0553585976', 1001, 20),
('0345391802', 1002, 3),
('0451191153', 1002, 25),
('0451524934', 1002, 15),
('0553585975', 1002, 65),
('0553585976', 1002, 25),
('0345391802', 1003, 4),
('0451191153', 1003, 43),
('0451524934', 1003, 100),
('0553585975', 1003, 45),
('0553585976', 1003, 15),
('0345391802', 1004, 4),
('0451191153', 1004, 45),
('0451524934', 1004, 45),
('0553585975', 1004, 30),
('0553585976', 1004, 10);

ALTER TABLE `author`
  ADD PRIMARY KEY (`ssn`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`ISBN`);

--
-- Indexes for table `contains`
--
ALTER TABLE `contains`
  ADD KEY `ISBN` (`ISBN`),
  ADD KEY `basketID` (`basketID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `shippingorder`
--
ALTER TABLE `shippingorder`
  ADD KEY `ISBN` (`ISBN`),
  ADD KEY `warehouseCode` (`warehouseCode`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `shoppingbasket`
--
ALTER TABLE `shoppingbasket`
  ADD PRIMARY KEY (`basketID`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD KEY `ISBN` (`ISBN`),
  ADD KEY `warehouseCode` (`warehouseCode`);

--
-- Indexes for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`warehouseCode`);

--
-- Indexes for table `writtenby`
--
ALTER TABLE `writtenby`
  ADD KEY `ssn` (`ssn`),
  ADD KEY `ISBN` (`ISBN`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contains`
--
ALTER TABLE `contains`
  ADD CONSTRAINT `contains_book_isbn_cons` FOREIGN KEY (`ISBN`) REFERENCES `book` (`ISBN`),
  ADD CONSTRAINT `contains_shoppingbasket_basketid_cons` FOREIGN KEY (`basketID`) REFERENCES `shoppingbasket` (`basketID`);

--
-- Constraints for table `shippingorder`
--
ALTER TABLE `shippingorder`
  ADD CONSTRAINT `shippingorder_book_isbn_cons` FOREIGN KEY (`ISBN`) REFERENCES `book` (`ISBN`),
  ADD CONSTRAINT `shippingorder_customer_username_cons` FOREIGN KEY (`username`) REFERENCES `customer` (`username`),
  ADD CONSTRAINT `shippingorder_warehouse_warehousecode_cons` FOREIGN KEY (`warehouseCode`) REFERENCES `warehouse` (`warehouseCode`);

--
-- Constraints for table `shoppingbasket`
--
ALTER TABLE `shoppingbasket`
  ADD CONSTRAINT `shoppingbasket_customer_username_cons` FOREIGN KEY (`username`) REFERENCES `customer` (`username`);

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_book_isbn_cons` FOREIGN KEY (`ISBN`) REFERENCES `book` (`ISBN`),
  ADD CONSTRAINT `stocks_warehouse_warehousecode_cons` FOREIGN KEY (`warehouseCode`) REFERENCES `warehouse` (`warehouseCode`);

--
-- Constraints for table `writtenby`
--
ALTER TABLE `writtenby`
  ADD CONSTRAINT `writtenby_author_ssn_cons` FOREIGN KEY (`ssn`) REFERENCES `author` (`ssn`),
  ADD CONSTRAINT `writtenby_book_isbn_cons` FOREIGN KEY (`ISBN`) REFERENCES `book` (`ISBN`);

