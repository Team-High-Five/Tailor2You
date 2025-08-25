-- -----------------------------------------------------
-- TAILOR2YOU DATABASE SCHEMA
-- -----------------------------------------------------

-- -----------------------------------------------------
-- 1. USER MANAGEMENT TABLES
-- -----------------------------------------------------

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

-- Create the `employees` table
CREATE TABLE `employees` (
    `employee_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `first_name` varchar(20) NOT NULL,
    `last_name` varchar(30) NOT NULL,
    `phone_number` varchar(10) NOT NULL,
    `home_town` varchar(20) NOT NULL,
    `district` varchar(50) DEFAULT NULL,
    `email` varchar(30) NOT NULL,
    `image` longblob DEFAULT NULL,
    PRIMARY KEY (`employee_id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 3 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- -----------------------------------------------------
-- 2. COMMUNICATION TABLES
-- -----------------------------------------------------

-- Create the `posts` table
CREATE TABLE `posts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `title` varchar(255) NOT NULL,
    `description` text NOT NULL,
    `gender` enum('men', 'women', 'unisex') DEFAULT 'unisex',
    `item_type` enum(
        'shirt',
        'pant',
        'frock',
        'skirt',
        'blouse'
    ) DEFAULT NULL,
    `image` longblob DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    KEY `user_id` (`user_id`),
    CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `likes` (
    `like_id` int(11) NOT NULL AUTO_INCREMENT,
    `customer_id` int(11) NOT NULL,
    `tailor_id` int(11) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `status` enum('active', 'removed') DEFAULT 'active',
    PRIMARY KEY (`like_id`),
    UNIQUE KEY `customer_id` (`customer_id`, `tailor_id`),
    KEY `tailor_id` (`tailor_id`),
    CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
    CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`tailor_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 5 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Create the `appointments` table
CREATE TABLE `appointments` (
    `appointment_id` INT(11) NOT NULL AUTO_INCREMENT,
    `customer_id` INT(11) NOT NULL,
    `tailor_shopkeeper_id` INT(11) NOT NULL,
    `appointment_date` DATE NOT NULL,
    `appointment_time` TIME NOT NULL,
    `status` ENUM(
        'accepted',
        'reschedule_pending',
        'rejected',
        'pending'
    ) NOT NULL DEFAULT 'pending',
    PRIMARY KEY (`appointment_id`),
    FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
    FOREIGN KEY (`tailor_shopkeeper_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- -----------------------------------------------------
-- 3. FABRIC AND COLOR TABLES
-- -----------------------------------------------------

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

-- -----------------------------------------------------
-- 4. CLOTHING CATEGORY AND DESIGN TABLES
-- -----------------------------------------------------

-- Create clothing categories table
CREATE TABLE `clothing_categories` (
    `category_id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `description` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `gender_specific` ENUM('gents', 'ladies', 'unisex') NOT NULL DEFAULT 'unisex',
    PRIMARY KEY (`category_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Create clothing subcategories table
CREATE TABLE `clothing_subcategories` (
    `subcategory_id` INT(11) NOT NULL AUTO_INCREMENT,
    `category_id` INT(11) NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `description` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`subcategory_id`),
    FOREIGN KEY (`category_id`) REFERENCES `clothing_categories` (`category_id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Create designs table
CREATE TABLE `designs` (
    `design_id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `gender` ENUM('gents', 'ladies', 'unisex') NOT NULL,
    `category_id` INT(11) NOT NULL,
    `subcategory_id` INT(11) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `main_image` VARCHAR(255) NULL COMMENT 'Path to image file',
    `base_price` DECIMAL(10, 2) NOT NULL,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`design_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
    FOREIGN KEY (`category_id`) REFERENCES `clothing_categories` (`category_id`),
    FOREIGN KEY (`subcategory_id`) REFERENCES `clothing_subcategories` (`subcategory_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Create customization types table
CREATE TABLE `customization_types` (
    `type_id` INT(11) NOT NULL AUTO_INCREMENT,
    `category_id` INT(11) NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `description` TEXT,
    PRIMARY KEY (`type_id`),
    FOREIGN KEY (`category_id`) REFERENCES `clothing_categories` (`category_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Create customization choices table
CREATE TABLE `customization_choices` (
    `choice_id` INT(11) NOT NULL AUTO_INCREMENT,
    `type_id` INT(11) NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `image` VARCHAR(255) NULL COMMENT 'Path to image file',
    `description` TEXT,
    `price_adjustment` DECIMAL(10, 2) DEFAULT 0.00,
    PRIMARY KEY (`choice_id`),
    FOREIGN KEY (`type_id`) REFERENCES `customization_types` (`type_id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Create design customizations linking table
CREATE TABLE `design_customizations` (
    `design_id` INT(11) NOT NULL,
    `choice_id` INT(11) NOT NULL,
    PRIMARY KEY (`design_id`, `choice_id`),
    FOREIGN KEY (`design_id`) REFERENCES `designs` (`design_id`) ON DELETE CASCADE,
    FOREIGN KEY (`choice_id`) REFERENCES `customization_choices` (`choice_id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Create design fabrics linking table
CREATE TABLE `design_fabrics` (
    `design_id` INT(11) NOT NULL,
    `fabric_id` INT(11) NOT NULL,
    `price_adjustment` DECIMAL(10, 2) DEFAULT 0.00,
    PRIMARY KEY (`design_id`, `fabric_id`),
    FOREIGN KEY (`design_id`) REFERENCES `designs` (`design_id`) ON DELETE CASCADE,
    FOREIGN KEY (`fabric_id`) REFERENCES `fabrics` (`fabric_id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- -----------------------------------------------------
-- 5. MEASUREMENT SYSTEM TABLES
-- -----------------------------------------------------

-- Master table of all possible clothing measurements
CREATE TABLE `measurements` (
    `measurement_id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `display_name` VARCHAR(100) NOT NULL,
    `description` TEXT NULL,
    `unit_type` ENUM(
        'length',
        'circumference',
        'angle',
        'other'
    ) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`measurement_id`),
    UNIQUE KEY (`name`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Link measurements to clothing categories
CREATE TABLE `category_measurements` (
    `category_id` INT(11) NOT NULL,
    `measurement_id` INT(11) NOT NULL,
    `is_required` BOOLEAN DEFAULT FALSE,
    `display_order` INT(11) DEFAULT 0,
    PRIMARY KEY (
        `category_id`,
        `measurement_id`
    ),
    FOREIGN KEY (`category_id`) REFERENCES `clothing_categories` (`category_id`) ON DELETE CASCADE,
    FOREIGN KEY (`measurement_id`) REFERENCES `measurements` (`measurement_id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Design-specific measurement requirements
CREATE TABLE `design_measurements` (
    `design_id` INT(11) NOT NULL,
    `measurement_id` INT(11) NOT NULL,
    `is_required` BOOLEAN DEFAULT TRUE,
    `description` TEXT NULL,
    `display_order` INT(11) DEFAULT 0,
    PRIMARY KEY (`design_id`, `measurement_id`),
    FOREIGN KEY (`design_id`) REFERENCES `designs` (`design_id`) ON DELETE CASCADE,
    FOREIGN KEY (`measurement_id`) REFERENCES `measurements` (`measurement_id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Custom measurements for designs (if standard measurements aren't enough)
CREATE TABLE `custom_design_measurements` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `design_id` INT(11) NOT NULL,
    `name` VARCHAR(50) NOT NULL,
    `display_name` VARCHAR(100) NOT NULL,
    `description` TEXT NULL,
    `is_required` BOOLEAN DEFAULT TRUE,
    `unit_type` ENUM(
        'length',
        'circumference',
        'angle',
        'other'
    ) NOT NULL,
    `display_order` INT(11) DEFAULT 999,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`design_id`) REFERENCES `designs` (`design_id`) ON DELETE CASCADE,
    UNIQUE KEY (`design_id`, `name`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Create new user_measurements table with both cm and inch values
CREATE TABLE `user_measurements` (
    `user_id` INT(11) NOT NULL,
    `measurement_id` INT(11) NOT NULL,
    `value_cm` DECIMAL(10, 2) NOT NULL,
    `value_inch` DECIMAL(10, 2) NOT NULL,
    `last_updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`user_id`, `measurement_id`),
    KEY `measurement_id` (`measurement_id`),
    CONSTRAINT `user_measurements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
    CONSTRAINT `user_measurements_ibfk_2` FOREIGN KEY (`measurement_id`) REFERENCES `measurements` (`measurement_id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- -----------------------------------------------------
-- 6. ORDER MANAGEMENT TABLES
-- -----------------------------------------------------

-- Orders main table
CREATE TABLE `orders` (
    `order_id` VARCHAR(20) NOT NULL,
    `customer_id` INT(11) NOT NULL,
    `tailor_id` INT(11) NOT NULL,
    `order_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `total_amount` DECIMAL(10, 2) NOT NULL,
    `tax_amount` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `final_amount` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `status` ENUM(
        'order_placed',
        'fabric_cutting',
        'stitching',
        'ready_for_delivery',
        'delivered',
        'cancelled'
    ) DEFAULT 'order_placed',
    `appointment_id` INT(11) NULL,
    `delivery_address` VARCHAR(255) NOT NULL,
    `expected_delivery_date` DATE NULL,
    `actual_delivery_date` DATE NULL,
    `notes` TEXT,
    PRIMARY KEY (`order_id`),
    FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
    FOREIGN KEY (`tailor_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
    FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`appointment_id`) ON DELETE SET NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Create a sequence table to track the next order number
CREATE TABLE `order_sequence` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `next_value` INT(11) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Order items table (one order can have multiple items)
CREATE TABLE `order_items` (
    `item_id` INT(11) NOT NULL AUTO_INCREMENT,
    `order_id` VARCHAR(20) NOT NULL,
    `design_id` INT(11) NOT NULL,
    `fabric_id` INT(11) NOT NULL,
    `color_id` INT(11) NOT NULL,
    `quantity` INT(2) DEFAULT 1,
    `base_price` DECIMAL(10, 2) NOT NULL,
    `customization_price` DECIMAL(10, 2) DEFAULT 0.00,
    `fabric_price` DECIMAL(10, 2) DEFAULT 0.00,
    `total_price` DECIMAL(10, 2) NOT NULL,
    `status` ENUM(
        'order_placed',
        'fabric_cutting',
        'stitching',
        'ready_for_delivery',
        'delivered',
        'cancelled'
    ) DEFAULT 'order_placed',
    PRIMARY KEY (`item_id`),
    FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
    FOREIGN KEY (`design_id`) REFERENCES `designs` (`design_id`) ON DELETE RESTRICT,
    FOREIGN KEY (`fabric_id`) REFERENCES `fabrics` (`fabric_id`) ON DELETE RESTRICT,
    FOREIGN KEY (`color_id`) REFERENCES `colors` (`color_id`) ON DELETE RESTRICT
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

CREATE TABLE `order_status_history` (
    `history_id` INT(11) NOT NULL AUTO_INCREMENT,
    `order_id` VARCHAR(20) NOT NULL,
    `status` ENUM(
        'order_placed',
        'fabric_cutting',
        'stitching',
        'ready_for_delivery',
        'delivered',
        'cancelled'
    ) NOT NULL,
    `status_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_by` INT(11) NOT NULL COMMENT 'User ID who updated the status',
    `notes` TEXT NULL,
    PRIMARY KEY (`history_id`),
    FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
    FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Order item customizations (which customization choices were selected for each item)
CREATE TABLE `order_item_customizations` (
    `item_customization_id` INT(11) NOT NULL AUTO_INCREMENT,
    `item_id` INT(11) NOT NULL,
    `type_id` INT(11) NOT NULL,
    `choice_id` INT(11) NOT NULL,
    `price_adjustment` DECIMAL(10, 2) DEFAULT 0.00,
    PRIMARY KEY (`item_customization_id`),
    FOREIGN KEY (`item_id`) REFERENCES `order_items` (`item_id`) ON DELETE CASCADE,
    FOREIGN KEY (`type_id`) REFERENCES `customization_types` (`type_id`) ON DELETE RESTRICT,
    FOREIGN KEY (`choice_id`) REFERENCES `customization_choices` (`choice_id`) ON DELETE RESTRICT
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Actual measurement values for order items
CREATE TABLE `order_item_measurements` (
    `item_measurement_id` INT(11) NOT NULL AUTO_INCREMENT,
    `item_id` INT(11) NOT NULL,
    `measurement_id` INT(11) NOT NULL,
    `value` DECIMAL(10, 2) NOT NULL,
    `measurement_source` ENUM('manual', 'profile') DEFAULT 'manual',
    PRIMARY KEY (`item_measurement_id`),
    UNIQUE KEY `unique_item_measurement` (`item_id`, `measurement_id`),
    FOREIGN KEY (`item_id`) REFERENCES `order_items` (`item_id`) ON DELETE CASCADE,
    FOREIGN KEY (`measurement_id`) REFERENCES `measurements` (`measurement_id`) ON DELETE RESTRICT
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Create measurement ranges table
CREATE TABLE `measurement_ranges` (
    `measurement_id` INT(11) NOT NULL,
    `min_value` DECIMAL(5, 2) NOT NULL DEFAULT 5.0,
    `max_value` DECIMAL(5, 2) NOT NULL DEFAULT 60.0,
    `increment` DECIMAL(3, 2) NOT NULL DEFAULT 0.5,
    PRIMARY KEY (`measurement_id`),
    FOREIGN KEY (`measurement_id`) REFERENCES `measurements` (`measurement_id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--------------------------------------------------------
-- 7. CART MANAGEMENT TABLES
-- -----------------------------------------------------
-- Create cart_items table
CREATE TABLE `cart_items` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `design_id` INT(11) NOT NULL,
    `fabric_id` INT(11) NOT NULL,
    `color_id` INT(11) NOT NULL,
    `quantity` INT(2) DEFAULT 1,
    `added_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
    FOREIGN KEY (`design_id`) REFERENCES `designs` (`design_id`) ON DELETE CASCADE,
    FOREIGN KEY (`fabric_id`) REFERENCES `fabrics` (`fabric_id`) ON DELETE CASCADE,
    FOREIGN KEY (`color_id`) REFERENCES `colors` (`color_id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- SQL script for creating the `messages` table

CREATE TABLE `messages` (
    `message_id` int(11) NOT NULL,
    `sender_id` int(11) NOT NULL,
    `receiver_id` int(11) NOT NULL,
    `text` text NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Add primary key and indexes
ALTER TABLE `messages`
ADD PRIMARY KEY (`message_id`),
ADD KEY `sender_id` (`sender_id`),
ADD KEY `receiver_id` (`receiver_id`);

-- Set AUTO_INCREMENT for the primary key
ALTER TABLE `messages`
MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 29;

-- Add foreign key constraints
ALTER TABLE `messages`
ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

COMMIT;

-- SQL script for creating the `reviews` table

CREATE TABLE `reviews` (
    `review_id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    `review_text` text NOT NULL,
    `rating` int(11) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `status` enum(
        'accepted',
        'pending',
        'rejected'
    ) DEFAULT 'pending',
    `action` varchar(255) DEFAULT NULL,
    `admin_notes` text DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Add primary key and indexes
ALTER TABLE `reviews`
ADD PRIMARY KEY (`review_id`),
ADD KEY `user_id` (`user_id`);

-- Set AUTO_INCREMENT for the primary key
ALTER TABLE `reviews`
MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 9;

-- Add foreign key constraint
ALTER TABLE `reviews`
ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

COMMIT;

CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_email (email)
);