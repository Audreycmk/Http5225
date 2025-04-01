-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 28, 2025 at 01:56 PM
-- Server version: 10.11.10-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u522900848_lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `mobile` int(10) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `mobile`, `role`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin@1234', 2147483647, 'admin'),
(3, 'admin', 'admin@gmail.com', 'simran@1234', 2147483647, 'admin'),
(4, 'admin', 'admin@gmail.com', 'Prab@1234', 2147483647, 'admin'),
(5, 'admin', 'admin@gmail.com', 'Noor@1234', 2147483647, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `author_id` int(11) NOT NULL,
  `author_name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`author_id`, `author_name`) VALUES
(102, 'Kyle Simpson\r\n'),
(103, 'David Flanagan'),
(104, 'Munshi Prem Chand'),
(106, 'Eric Meyer'),
(107, 'Marijn Haverbeke'),
(108, 'David Flanagan'),
(109, 'Nicholas C. Zakas'),
(110, 'Robin Nixon'),
(111, 'Mark Pilgrim'),
(112, 'Eric Freeman'),
(113, 'Jennifer Robbins'),
(114, 'Rachel Andrew'),
(120, 'Marijn Haverbeke'),
(129, 'New'),
(130, 'check'),
(131, 'check'),
(132, 'check'),
(133, 'check'),
(134, 'check'),
(135, 'check'),
(136, 'check'),
(137, 'check'),
(138, 'check3'),
(139, 'check'),
(140, 'sdcsdc'),
(141, 'csdc'),
(142, 'New'),
(143, 'New'),
(144, 'check'),
(145, 'check'),
(146, 'check'),
(147, 'check'),
(148, 'check'),
(149, 'David Flanagan'),
(150, 'Tae Kim'),
(151, 'Jeffree Nguyen'),
(152, 'Steve Krug'),
(153, 'Donna Jones Alward'),
(154, 'Hannah Kristin'),
(155, 'ROALD DAHL'),
(156, 'Stephenie Meyer'),
(157, 'Vaclav Smil'),
(158, 'G. Ng'),
(159, 'John Perkins'),
(160, 'Ezra Klein');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `book_name` varchar(250) NOT NULL,
  `author_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `book_no` int(11) NOT NULL,
  `book_price` int(11) NOT NULL,
  `book_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `book_name`, `author_id`, `cat_id`, `book_no`, `book_price`, `book_image`) VALUES
(1, 'Software engineering', 103, 1, 4518, 270, ''),
(2, 'Data structure', 102, 2, 6541, 299, ''),
(4, 'Data Analytics', 104, 4, 4544, 277, ''),
(32, 'check3', 142, 33, 0, 275, 'uploads/books/Screenshot 2024-11-12 171212.png'),
(33, 'check2', 143, 34, 0, 275, 'uploads/books/Screenshot 2024-11-15 161432.png'),
(35, 'check', 146, 37, 1234, 277, 'uploads/books/Screenshot 2024-10-03 190959.png'),
(36, 'check', 147, 38, 12345, 276, 'uploads/books/Screenshot 2024-11-12 162410.png'),
(37, 'check_img', 148, 39, 12345678, 277, 'uploads/books/Lab10.png'),
(38, 'Software engineering', 149, 41, 512132, 128, 'uploads/books/Frame 2.png'),
(39, 'The Nvidia Way', 150, 41, 12434, 37, 'uploads/books/Frame 3.png'),
(40, 'The AI Engineer Interview Bible', 151, 42, 36364, 14, 'uploads/books/Frame 4.png'),
(41, 'Don\'t Make Me Think, Revisited', 152, 43, 56462, 57, 'uploads/books/Frame 5.png'),
(42, 'When the World Fell Silent', 153, 44, 34252, 20, 'uploads/books/Frame 9.png'),
(43, 'The Women', 154, 45, 63636, 23, 'uploads/books/Frame 10.png'),
(44, 'SACRÉES SORCIÈRES', 155, 46, 45352, 16, 'uploads/books/Frame 11.png'),
(45, 'Breaking Dawn', 156, 47, 22552, 22, 'uploads/books/Frame 12.png'),
(46, 'How to Feed the World', 157, 48, 41414, 40, 'uploads/books/Frame 1 (1).png'),
(47, 'The 38 Letters from J.D. Rockefeller to his son', 158, 49, 25253, 35, 'uploads/books/Frame 6.png'),
(48, 'Confessions of an Economic Hit Man, 3rd Edition', 159, 50, 44411, 29, 'uploads/books/Frame 7.png'),
(49, 'Abundance', 160, 51, 42567, 27, 'uploads/books/Frame 8.png');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`) VALUES
(1, 'Computer Science Engineering '),
(2, 'Novel'),
(4, 'Motivational'),
(5, 'Story'),
(10, 'tryguhljk;'),
(19, 'New'),
(20, 'check'),
(21, 'check1'),
(22, 'check2edwd'),
(23, 'check'),
(24, 'check'),
(25, 'check'),
(26, 'check'),
(27, 'check2'),
(28, 'check3'),
(29, 'check'),
(30, 'check'),
(31, 'sdc'),
(32, 'sdcsdcsd'),
(33, 'check'),
(34, 'New'),
(35, 'check'),
(36, 'check'),
(37, 'check'),
(38, 'check'),
(39, 'check'),
(40, 'Computer Science Engineering'),
(41, 'Computer'),
(42, 'Computer'),
(43, 'Computer'),
(44, 'Fiction'),
(45, 'Fiction'),
(46, 'Fiction'),
(47, 'Fiction'),
(48, 'Finance'),
(49, 'Fiction'),
(50, 'Finance'),
(51, 'Finance');

-- --------------------------------------------------------

--
-- Table structure for table `issued_books`
--

CREATE TABLE `issued_books` (
  `s_no` int(11) NOT NULL,
  `book_no` int(11) NOT NULL,
  `book_name` varchar(200) NOT NULL,
  `book_author` varchar(200) NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `issue_date` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issued_books`
--

INSERT INTO `issued_books` (`s_no`, `book_no`, `book_name`, `book_author`, `student_id`, `status`, `issue_date`) VALUES
(1, 6541, 'Data structure', 'D S Gupta', 4, 1, '0000-00-00 00:00:00'),
(3, 6533, 'Data Analystics', 'Mark Pilgrim', 3, 3, '2020-04-25'),
(4, 6544, 'Basic of HTML &CSS', 'Eric Meyer', 4, 4, '2020-05-04'),
(5, 6555, 'Web development', 'Eric Meyer', 5, 5, '2018-05-04'),
(6, 6566, 'Basic of PHP', 'Rachel Andrew', 6, 6, '2019-06-06'),
(18, 7845, 'Software engineering', 'Jennifer Robbins', 2, 1, '2020-04-22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `mobile` int(10) NOT NULL,
  `address` varchar(250) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `mobile`, `address`, `role`) VALUES
(4, 'user', 'user@gmail.com', 'user@1234', 2147483644, 'szdfxcghbjkl;cdsdcsdc', 'user'),
(5, 'user', 'user@gmail.com', 'Noor@123', 2147483644, 'szdfxcghbjkl;cdsdcsdc', 'user'),
(7, 'user', 'user@gmail.com', 'hemant@123', 2147483644, 'szdfxcghbjkl;cdsdcsdc', 'user'),
(8, 'user', 'user@gmail.com', 'suman@1234', 2147483644, 'szdfxcghbjkl;cdsdcsdc', 'user'),
(9, 'user', 'user@gmail.com', 'sdfghjk', 2147483644, 'szdfxcghbjkl;cdsdcsdc', 'user'),
(10, 'Srivignesh Kavle', 'ramnathkavle@gmail.com', 'Check', 2147483647, 'Muthu mohammed St, Madipakkam\r\n11C/28', 'user'),
(11, 'check', 'check@gmail.com', 'check@123', 2147483647, 'check', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`author_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `issued_books`
--
ALTER TABLE `issued_books`
  ADD PRIMARY KEY (`s_no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `issued_books`
--
ALTER TABLE `issued_books`
  MODIFY `s_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
