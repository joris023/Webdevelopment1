-- phpMyAdmin SQL Dump
-- version 5.1.1
-- Host: mysql
-- Server version: 10.6.4-MariaDB-1:10.6.4+maria~focal
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------

CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'customer') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Example Users
-- INSERT INTO `users` (`id`, `firstname`, `email`, `password`, `role`) VALUES
-- (1, 'John Doe', 'john.doe@example.com', 'password123', 'customer'),
-- (2, 'Jane Smith', 'jane.smith@example.com', 'password456', 'customer'),
-- (3, 'Admin User', 'admin@example.com', 'adminpassword', 'admin');

-- --------------------------------------------------------
-- Table structure for table `foods`
-- --------------------------------------------------------

CREATE TABLE `foods` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `image` VARCHAR(255) NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `stock` INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Example Foods
INSERT INTO `foods` (`id`, `name`, `description`, `image`, `price`, `stock`) VALUES
(1, 'Pizza', 'Delicious cheese pizza with tomato sauce and a variety of toppings.', '/images/food/pizza.png', 8.99, 10),
(2, 'Burger', 'Juicy beef burger served with lettuce, tomato, and a side of fries.', '/images/food/burger.jpg', 7.49, 20),
(3, 'Pasta', 'Fresh pasta with a creamy Alfredo sauce and Parmesan cheese.', null , 6.99, 15);

-- --------------------------------------------------------
-- Table structure for table `drinks`
-- --------------------------------------------------------

CREATE TABLE `drinks` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `image` VARCHAR(255) NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `stock` INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Example Drinks
INSERT INTO `drinks` (`id`, `name`, `description`, `image`, `price`, `stock`) VALUES
(1, 'Coke', 'Refreshing cola drink served chilled.', '/images/drink/cola.jpg', 2.49, 50),
(2, 'Sprite', 'Lemon-lime flavored soft drink, ice cold.', '/images/drink/sprite.jpg', 2.49, 50),
(3, 'Water', 'Pure and refreshing bottled water.', '/images/drink/water.jpg', 1.49, 100);

-- --------------------------------------------------------
-- Table structure for table `orders`
-- --------------------------------------------------------

CREATE TABLE `orders` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `table_number` INT(11) NOT NULL,
  `total_amount` DECIMAL(10,2) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Example Orders
INSERT INTO `orders` (`id`, `user_id`, `table_number`, `total_amount`, `created_at`) VALUES
(1, 1, 5, 18.97, NOW()),
(2, 2, 3, 10.47, NOW());

-- --------------------------------------------------------
-- Table structure for table `order_foods`
-- --------------------------------------------------------

CREATE TABLE `order_foods` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `order_id` INT(11) NOT NULL,
  `food_id` INT(11) NOT NULL,
  `quantity` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`food_id`) REFERENCES `foods` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Example Order Foods
INSERT INTO `order_foods` (`order_id`, `food_id`, `quantity`) VALUES
(1, 1, 2), -- 2 Pizzas for Order 1
(1, 2, 1), -- 1 Burger for Order 1
(2, 3, 1); -- 1 Pasta for Order 2

-- --------------------------------------------------------
-- Table structure for table `order_drinks`
-- --------------------------------------------------------

CREATE TABLE `order_drinks` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `order_id` INT(11) NOT NULL,
  `drink_id` INT(11) NOT NULL,
  `quantity` INT(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`drink_id`) REFERENCES `drinks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Example Order Drinks
INSERT INTO `order_drinks` (`order_id`, `drink_id`, `quantity`) VALUES
(1, 1, 2), -- 2 Cokes for Order 1
(2, 2, 1), -- 1 Sprite for Order 2
(2, 3, 2); -- 2 Waters for Order 2

-- --------------------------------------------------------
-- Auto Increment Settings
-- --------------------------------------------------------

ALTER TABLE `users` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `foods` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `drinks` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `orders` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `order_foods` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `order_drinks` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT;

COMMIT;
