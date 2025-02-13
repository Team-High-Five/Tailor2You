-- Create the `users` table
CREATE TABLE `users` (
    `user_id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_type` ENUM(
        'tailor',
        'customer',
        'shopkeeper',
        'admin'
    ) NOT NULL,
    `first_name` VARCHAR(20) NOT NULL,
    `last_name` VARCHAR(30) NOT NULL,
    `email` VARCHAR(30) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `phone_number` VARCHAR(10) NOT NULL,
    `nic` VARCHAR(12) DEFAULT NULL,
    `birth_date` DATE DEFAULT NULL,
    `home_town` VARCHAR(20) NOT NULL,
    `address` VARCHAR(100) NOT NULL,
    `bio` VARCHAR(255) DEFAULT NULL,
    `category` VARCHAR(10) DEFAULT NULL,
    `profile_pic` LONGBLOB DEFAULT NULL,
    `status` ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    PRIMARY KEY (`user_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Create the `appointments` table
CREATE TABLE `appointments` (
    `appointment_id` INT(11) NOT NULL AUTO_INCREMENT,
    `customer_id` INT(11) NOT NULL,
    `tailor_shopkeeper_id` INT(11) NOT NULL,
    `appointment_date` DATE NOT NULL,
    `appointment_time` TIME NOT NULL,
    `status` ENUM(
        'accepted',
        'processing',
        'rejected',
        'pending'
    ) NOT NULL DEFAULT 'pending',
    PRIMARY KEY (`appointment_id`),
    FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
    FOREIGN KEY (`tailor_shopkeeper_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Create the `posts` table
CREATE TABLE `posts` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `image` LONGBLOB,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Create the `fabrics` table
CREATE TABLE `fabrics` (
    `fabric_id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `fabric_name` VARCHAR(50) NOT NULL,
    `image` LONGBLOB DEFAULT NULL,
    `price_per_meter` DECIMAL(10, 2) NOT NULL,
    `stock` DECIMAL(10, 2) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`fabric_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Create the `colors` table
CREATE TABLE `colors` (
    `color_id` INT(11) NOT NULL AUTO_INCREMENT,
    `color_name` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`color_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Create the `fabric_colors` table
CREATE TABLE `fabric_colors` (
    `fabric_color_id` INT(11) NOT NULL AUTO_INCREMENT,
    `fabric_id` INT(11) NOT NULL,
    `color_id` INT(11) NOT NULL,
    PRIMARY KEY (`fabric_color_id`),
    FOREIGN KEY (`fabric_id`) REFERENCES `fabrics` (`fabric_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`color_id`) REFERENCES `colors` (`color_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Insert some initial data into the `colors` table
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

-- Create the `employees` table
CREATE TABLE `employees` (
    `employee_id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `first_name` VARCHAR(20) NOT NULL,
    `last_name` VARCHAR(30) NOT NULL,
    `phone_number` VARCHAR(10) NOT NULL,
    `home_town` VARCHAR(20) NOT NULL,
    `email` VARCHAR(30) NOT NULL,
    `image` LONGBLOB DEFAULT NULL,
    PRIMARY KEY (`employee_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `shirt_measurements` (
    `user_id` varchar(100) NOT NULL,
    `measure` int(11) NOT NULL,
    `collar_size` int(11) NOT NULL,
    `chest_width` int(11) NOT NULL,
    `waist_width` int(11) NOT NULL,
    `bottom_width` int(11) NOT NULL,
    `shoulder_width` int(11) NOT NULL,
    `sleeve_length` int(11) NOT NULL,
    `armhole_depth` int(11) NOT NULL,
    `bicep` int(11) NOT NULL,
    `cuff_size` int(11) NOT NULL,
    `front_length` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;