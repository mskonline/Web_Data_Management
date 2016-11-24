TRUNCATE TANLE author;
TRUNCATE TANLE book;
TRUNCATE TANLE writtenby;
TRUNCATE TANLE warehouse;
TRUNCATE TANLE stocks;


INSERT INTO `author` (`ssn`, `name`, `address`, `phone`) VALUES
('1000000001', 'Adam Smith', 'Kirkcaldy, Fife, Scotland', '7778889991'),
('1000000002', 'Ayan Rand', 'St. Petersburg, Russia', '7778889992'),
('1000000003', 'George Orwell', 'Bengal, India', '7778889993'),
('1000000004', 'Douglas Adams', 'Cambridge, England', '7778889994');

INSERT INTO `book` (`ISBN`, `title`, `year`, `price`, `publisher`) VALUES
('0345391802', 'Hitchhiker''s Guide to the Galaxy', 1995, 8.99, 'Del Rey'),
('0451191153', 'The Fountainhead', 1996, 19.99, 'Signet'),
('0451524934', '1984', 1961, 16.99, 'Signet Classic'),
('0553585975', 'The Wealth of Nations', 2003, 23.99, 'Bantam Classics');

INSERT INTO `writtenby` (`ssn`, `ISBN`) VALUES
('1000000001', '0553585975'),
('1000000002', '0451191153'),
('1000000003', '0451524934'),
('1000000004', '0345391802');

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
('0345391802', 1002, 3),
('0451191153', 1002, 25),
('0451524934', 1002, 15),
('0553585975', 1002, 65),
('0345391802', 1003, 4),
('0451191153', 1003, 43),
('0451524934', 1003, 100),
('0553585975', 1003, 45),
('0345391802', 1004, 4),
('0451191153', 1004, 45),
('0451524934', 1004, 45),
('0553585975', 1004, 30);

