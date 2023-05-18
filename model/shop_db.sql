-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2022 at 12:51 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: shop_db
--

-- --------------------------------------------------------

--
-- Table structure for table admins
--

CREATE TABLE admins (
  id number(30) NOT NULL,
  name varchar2(20) NOT NULL,
  password varchar2(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table admins
--

INSERT INTO admins (id, name, password) VALUES
(1, 'admin', 'munim');

-- --------------------------------------------------------

--
-- Table structure for table cart
--

CREATE TABLE cart (
  id number(30) NOT NULL,
  user_id number(30) NOT NULL,
  pid number(30) NOT NULL,
  name varchar2(100) NOT NULL,
  price number(10)) NOT NULL,
  quantity number(10)) NOT NULL,
  image varchar2(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table messages
--

CREATE TABLE messages (
  id number(30) NOT NULL,
  user_id number(30) NOT NULL,
  name varchar2(100) NOT NULL,
  email varchar2(100) NOT NULL,
  number varchar2(12) NOT NULL,
  message varchar2(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table orders
--

CREATE TABLE orders (
  id number(30) NOT NULL,
  user_id number(30) NOT NULL,
  name varchar2(20) NOT NULL,
  number varchar2(10) NOT NULL,
  email varchar2(50) NOT NULL,
  method varchar2(50) NOT NULL,
  address varchar2(500) NOT NULL,
  total_products varchar2(1000) NOT NULL,
  total_price number(30) NOT NULL,
  placed_on date NOT NULL DEFAULT current_timestamp(),
  payment_status varchar2(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table products
--

CREATE TABLE products (
  id number(30) NOT NULL,
  name varchar2(100) NOT NULL,
  details varchar2(500) NOT NULL,
  price number(10)) NOT NULL,
  image_01 varchar2(100) NOT NULL,
  image_02 varchar2(100) NOT NULL,
  image_03 varchar2(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table users
--

CREATE TABLE users (
  id number(30) NOT NULL,
  name varchar2(20) NOT NULL,
  email varchar2(50) NOT NULL,
  password varchar2(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table wishlist
--

CREATE TABLE wishlist (
  id number(30) NOT NULL,
  user_id number(30) NOT NULL,
  pid number(30) NOT NULL,
  name varchar2(100) NOT NULL,
  price number(30) NOT NULL,
  image varchar2(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table admins
--
ALTER TABLE admins
  ADD PRIMARY KEY (id);

--
-- Indexes for table cart
--
ALTER TABLE cart
  ADD PRIMARY KEY (id);

--
-- Indexes for table messages
--
ALTER TABLE messages
  ADD PRIMARY KEY (id);

--
-- Indexes for table orders
--
ALTER TABLE orders
  ADD PRIMARY KEY (id);

--
-- Indexes for table products
--
ALTER TABLE products
  ADD PRIMARY KEY (id);

--
-- Indexes for table users
--
ALTER TABLE users
  ADD PRIMARY KEY (id);

--
-- Indexes for table wishlist
--
ALTER TABLE wishlist
  ADD PRIMARY KEY (id);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table admins
--
ALTER TABLE admins
  MODIFY id number(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table cart
--
ALTER TABLE cart
  MODIFY id number(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table messages
--
ALTER TABLE messages
  MODIFY id number(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table orders
--
ALTER TABLE orders
  MODIFY id number(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table products
--
ALTER TABLE products
  MODIFY id number(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table users
--
ALTER TABLE users
  MODIFY id number(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table wishlist
--
ALTER TABLE wishlist
  MODIFY id number(30) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
