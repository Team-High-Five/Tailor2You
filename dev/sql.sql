CREATE TABLE users (
  user_id int(5) NOT NULL,
  user_type enum('tailor','customer','shopkeeper') NOT NULL,
  first_name varchar(20) NOT NULL,
  last_name varchar(30) NOT NULL,
  email varchar(30) NOT NULL,
  password varchar(255) NOT NULL,
  phone_number varchar(10) NOT NULL,
  nic varchar(12) DEFAULT NULL,
  birth_date date DEFAULT NULL,
  home_town varchar(20) NOT NULL,
  address varchar(100) NOT NULL,
  bio varchar(255) DEFAULT NULL,
  category varchar(10) DEFAULT NULL,
  profile_pic longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add the `status` column
ALTER TABLE `users`
ADD COLUMN `status` enum('active','inactive') NOT NULL DEFAULT 'active';

-- Modify the `user_type` column to include 'admin'
ALTER TABLE `users`
MODIFY COLUMN `user_type` enum('tailor','customer','shopkeeper','admin') NOT NULL;

CREATE TABLE `posts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `image` LONGBLOB,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `fabrics` (
  `fabric_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `fabric_name` varchar(50) NOT NULL,
  `image` longblob DEFAULT NULL,
  `price_per_meter` decimal(10,2) NOT NULL,
  `stock` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `colors` (
  `color_id` INT(5) NOT NULL AUTO_INCREMENT,
  `color_name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`color_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `fabric_colors` (
  `fabric_color_id` INT(5) NOT NULL AUTO_INCREMENT,
  `fabric_id` INT(5) NOT NULL,
  `color_id` INT(5) NOT NULL,
  PRIMARY KEY (`fabric_color_id`),
  FOREIGN KEY (`fabric_id`) REFERENCES `fabrics`(`fabric_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`color_id`) REFERENCES `colors`(`color_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert some initial data
INSERT INTO `colors` (`color_name`) VALUES ('Black');
INSERT INTO `colors` (`color_name`) VALUES ('Red');
INSERT INTO `colors` (`color_name`) VALUES ('Blue');
INSERT INTO `colors` (`color_name`) VALUES ('Purple');
INSERT INTO `colors` (`color_name`) VALUES ('Orange');
INSERT INTO `colors` (`color_name`) VALUES ('Yellow');
INSERT INTO `colors` (`color_name`) VALUES ('Green');
INSERT INTO `colors` (`color_name`) VALUES ('White');
INSERT INTO `colors` (`color_name`) VALUES ('Gray');
INSERT INTO `colors` (`color_name`) VALUES ('Pink');