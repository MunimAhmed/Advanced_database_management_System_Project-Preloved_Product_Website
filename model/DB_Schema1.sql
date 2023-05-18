--Granting all the previleges to the main user.

GRANT ALL PRIVILEGES TO web;

--Creating users for different roles
CREATE USER user1 IDENTIFIED BY password1;
CREATE USER user2 IDENTIFIED BY password2;
CREATE USER user3 IDENTIFIED BY password3;

--Grant the necessary privileges to the users:
GRANT CREATE SESSION, CREATE TABLE, CREATE VIEW TO user1;
GRANT CREATE SESSION, CREATE PROCEDURE, CREATE TRIGGER, CREATE SEQUENCE TO user2;
GRANT CREATE SESSION, CREATE TABLE, CREATE VIEW, CREATE SEQUENCE, CREATE ANY INDEX TO user3;

--Create roles for each user and grant the necessary privileges to the roles:
CREATE ROLE role1;
GRANT CREATE SESSION, CREATE TABLE, CREATE VIEW TO role1;
GRANT role1 TO user1;

CREATE ROLE role2;
GRANT CREATE SESSION, CREATE PROCEDURE, CREATE TRIGGER, CREATE SEQUENCE TO role2;
GRANT role2 TO user2;

CREATE ROLE role3;
GRANT CREATE SESSION, CREATE TABLE, CREATE VIEW, CREATE INDEX, CREATE SEQUENCE TO role3;
GRANT role3 TO user3;

--
-- Table structure for table admins
--

CREATE TABLE admins (
  id number(30) PRIMARY KEY,,
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
  id number(30) PRIMARY KEY,
  user_id number(30) NOT NULL,
  pid number(30) NOT NULL,
  name varchar2(100) NOT NULL,
  price number(10) NOT NULL,
  image varchar2(100) NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table messages
--

CREATE TABLE messages (
  id number(30) PRIMARY KEY,,
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
  id NUMBER(30) PRIMARY KEY,,
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
  id number(30) PRIMARY KEY,,
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
  id number(30) PRIMARY KEY,,
  name varchar2(20) NOT NULL,
  email varchar2(50) NOT NULL,
  password varchar2(50) NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table wishlist
--

CREATE TABLE wishlist (
  id number(30) PRIMARY KEY,,
  user_id number(30) NOT NULL,
  pid number(30) NOT NULL,
  name varchar2(100) NOT NULL,
  price number(30) NOT NULL,
  image varchar2(100) NOT NULL
);

-- --------------------------------------------------------
--
--Table Category Structure
--

CREATE TABLE category (
  category_id NUMBER PRIMARY KEY,
  category_name VARCHAR2(50) NOT NULL
);

-- --------------------------------------------------------
--
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

-- --------------------------------------------------------
--
--Foreign key for table `product`
ALTER TABLE Products
ADD (c_id NUMBER, 
     CONSTRAINT fk_c_id 
     FOREIGN KEY (c_id) REFERENCES Category(Category_id));
--
--Trigger to set foreign key c_id into products table automatically whenever an insertion is done
--
CREATE OR REPLACE TRIGGER trg_set_c_id
BEFORE INSERT ON products
FOR EACH ROW
DECLARE
  v_category_id category.category_id%TYPE;
BEGIN
  SELECT category_id INTO v_category_id FROM category WHERE UPPER(category_name) = UPPER(:NEW.category);
  :NEW.c_id := v_category_id;
END;
/
-- Procedure to create sequence
--
CREATE OR REPLACE PROCEDURE create_sequence(
    p_sequence_name IN VARCHAR2,
    p_start_with IN NUMBER,
    p_increment_by IN NUMBER
) AS
BEGIN
  EXECUTE IMMEDIATE 'CREATE SEQUENCE ' || p_sequence_name ||
    ' START WITH ' || p_start_with || ' INCREMENT BY ' || p_increment_by;
END;
--
--Calling the procedure to create all the sequences
--
BEGIN
  create_sequence('admins_seq', 2, 1);
  create_sequence('orders_seq', 1, 1);
  create_sequence('products_seq', 1, 1);
  create_sequence('users_seq', 1, 1);
  create_sequence('wishlist_seq', 1, 1);
  create_sequence('cart_seq', 1, 1);
  create_sequence('message_seq', 1, 1);
  create_sequence('category_seq', 1, 1);
END;

--
--Creating Trigger to insert the category_id automatically using sequence whenever a category name is added to the category table
--
CREATE OR REPLACE TRIGGER category_trigger
BEFORE INSERT ON category
FOR EACH ROW
BEGIN
  :NEW.category_id := category_seq.NEXTVAL;
END;
--
--
--Inserting Values to Category Table
--
INSERT INTO category (category_name) VALUES ('Smartphone');
INSERT INTO category (category_name) VALUES ('Laptop');
INSERT INTO category (category_name) VALUES ('TV');
INSERT INTO category (category_name) VALUES ('Computer Accessories');
INSERT INTO category (category_name) VALUES ('Refrigerator');
INSERT INTO category (category_name) VALUES ('Washing Machine');
INSERT INTO category (category_name) VALUES ('Watch');
INSERT INTO category (category_name) VALUES ('Household');
INSERT INTO category (category_name) VALUES ('Camera');
INSERT INTO category (category_name) VALUES ('Clothings');
INSERT INTO category (category_name) VALUES ('Furniture');

--
--Procedure to create index for each table
--
CREATE OR REPLACE PROCEDURE create_index(
    p_table_name IN VARCHAR2,
    p_index_name IN VARCHAR2,
    p_column_name IN VARCHAR2
) AS
BEGIN
    EXECUTE IMMEDIATE 'CREATE INDEX ' || p_index_name || ' ON ' || p_table_name || '(' || p_column_name || ')';
END;
--
--Calling the procedure 
--
BEGIN
-- create indexes
  create_index('admins', 'admins_name_idx', 'name');
  create_index('cart', 'cart_name_idx', 'name');
  create_index('messages', 'messages_name_idx', 'name');
  create_index('orders', 'orders_name_idx', 'name');
  create_index('products', 'products_name_idx', 'name');
  create_index('users', 'users_name_idx', 'name');
  create_index('wishlist', 'wishlist_name_idx', 'name');
  create_index('category', 'category_name_idx', 'category_name');
END;
