SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";



CREATE TABLE admins (
  id number(30) NOT NULL,
  name varchar2(20) NOT NULL,
  password varchar2(50) NOT NULL
);

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
);

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
);



-- --------------------------------------------------------

--
-- Table structure for table orders
--

CREATE TABLE orders (
  id NUMBER(30) NOT NULL,
  user_id NUMBER(30) NOT NULL,
  name VARCHAR2(50) NOT NULL,
  phone_number VARCHAR2(20) NOT NULL,
  email VARCHAR2(100) NOT NULL,
  method VARCHAR2(50) NOT NULL,
  address VARCHAR2(1000) NOT NULL,
  total_products VARCHAR2(4000) NOT NULL,
  total_price NUMBER(30, 2) NOT NULL,
  placed_on DATE DEFAULT SYSDATE NOT NULL,
  payment_status VARCHAR2(20) DEFAULT 'pending' NOT NULL
);
-- --------------------------------------------------------

--
-- Table structure for table products
--

CREATE TABLE products (
  id number(30) NOT NULL,
  name varchar2(100) NOT NULL,
  details varchar2(500) NOT NULL,
  price number(10) NOT NULL,
  image_01 varchar2(100) NOT NULL,
  image_02 varchar2(100) NOT NULL,
  image_03 varchar2(100) NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table users
--

CREATE TABLE users (
  id number(30) NOT NULL,
  name varchar2(20) NOT NULL,
  email varchar2(50) NOT NULL,
  password varchar2(50) NOT NULL
);

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
);

--
-- AUTO_INCREMENT for table cart
--
CREATE SEQUENCE admins_seq START WITH 2 INCREMENT BY 1;


--
-- AUTO_INCREMENT for table orders
--
ALTER TABLE orders
  MODIFY id number(30) NOT NULL AUTO_INCREMENT;
CREATE SEQUENCE orders_seq START WITH 1 INCREMENT BY 1;
--
-- AUTO_INCREMENT for table products
--
CREATE SEQUENCE products_seq START WITH 1 INCREMENT BY 1;

--
-- AUTO_INCREMENT for table users
--
CREATE SEQUENCE users_seq START WITH 1 INCREMENT BY 1;

--
-- AUTO_INCREMENT for table wishlist
--
CREATE SEQUENCE wishlist_seq START WITH 1 INCREMENT BY 1;

-- AUTO_INCREMENT for table cart
--
CREATE SEQUENCE cart_seq START WITH 1 INCREMENT BY 1;

-- AUTO_INCREMENT for table message
--
CREATE SEQUENCE message_seq START WITH 1 INCREMENT BY 1;

-- Foreign key for table `cart`
ALTER TABLE cart ADD CONSTRAINT fk_cart_users FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE cart ADD CONSTRAINT fk_cart_products FOREIGN KEY (pid) REFERENCES products(id);

-- Foreign key for table `messages`
ALTER TABLE messages ADD CONSTRAINT fk_messages_users FOREIGN KEY (user_id) REFERENCES users(id);

-- Foreign key for table `orders`
ALTER TABLE orders ADD CONSTRAINT fk_orders_users FOREIGN KEY (user_id) REFERENCES users(id);

-- Foreign key for table `wishlist`
ALTER TABLE wishlist ADD CONSTRAINT fk_wishlist_users FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE wishlist ADD CONSTRAINT fk_wishlist_products FOREIGN KEY (pid) REFERENCES products(id);
