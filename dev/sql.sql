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

-- -----------------------------------------------------
-- 2. COMMUNICATION TABLES
-- -----------------------------------------------------

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

-- Insert initial colors
INSERT INTO
    `colors` (`color_name`)
VALUES ('Black'),
    ('Red'),
    ('Blue'),
    ('Purple'),
    ('Orange'),
    ('Yellow'),
    ('Green'),
    ('White'),
    ('Gray'),
    ('Pink');

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
-- 4. MEASUREMENT TABLES
-- -----------------------------------------------------

-- Create shirt measurements table
CREATE TABLE `shirt_measurements` (
    `user_id` int(11) DEFAULT NULL,
    `measure` enum('cm', 'inch') DEFAULT NULL,
    `collar_size` decimal(5, 2) NOT NULL,
    `chest_width` decimal(5, 2) NOT NULL,
    `waist_width` decimal(5, 2) NOT NULL,
    `bottom_width` decimal(5, 2) NOT NULL,
    `shoulder_width` decimal(5, 2) NOT NULL,
    `sleeve_length` decimal(5, 2) NOT NULL,
    `armhole_depth` decimal(5, 2) NOT NULL,
    `bicep` decimal(5, 2) NOT NULL,
    `cuff_size` decimal(5, 2) NOT NULL,
    `front_length` decimal(5, 2) NOT NULL,
    KEY `user_id` (`user_id`),
    CONSTRAINT `shirt_measurements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Create pant measurements table
CREATE TABLE `pant_measurements` (
    `user_id` int(100) DEFAULT NULL,
    `measure` enum('cm', 'inch') DEFAULT NULL,
    `waist_width` decimal(5, 2) NOT NULL,
    `seat` decimal(5, 2) NOT NULL,
    `mid_thigh_width` decimal(5, 2) NOT NULL,
    `inseam` decimal(5, 2) NOT NULL,
    `bottom_width` decimal(5, 2) NOT NULL,
    `rise_height_front` decimal(5, 2) NOT NULL,
    `rise_height_back` decimal(5, 2) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- -----------------------------------------------------
-- 5. CLOTHING CATEGORY AND DESIGN TABLES
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

-- Insert initial categories
INSERT INTO
    `clothing_categories` (`name`, `description`)
VALUES (
        'Shirt',
        'All types of shirts'
    ),
    (
        'Pants',
        'All types of pants and trousers'
    ),
    ('Suit', 'Full formal suits'),
    (
        'Dress',
        'All types of dresses'
    ),
    (
        'Skirt',
        'All types of skirts'
    );

-- Update gender specificity for existing categories
UPDATE `clothing_categories`
SET
    `gender_specific` = 'gents'
WHERE
    `name` IN ('Shirt', 'Suit');

UPDATE `clothing_categories`
SET
    `gender_specific` = 'ladies'
WHERE
    `name` IN ('Dress', 'Skirt');

UPDATE `clothing_categories`
SET
    `gender_specific` = 'unisex'
WHERE
    `name` IN ('Pants');

-- Insert additional gender-specific categories
INSERT INTO
    `clothing_categories` (
        `name`,
        `description`,
        `gender_specific`
    )
VALUES (
        'Blouse',
        'Women\'s upper garment',
        'ladies'
    ),
    (
        'Saree Blouse',
        'Traditional blouse for sarees',
        'ladies'
    ),
    (
        'Kurta',
        'Traditional long shirt',
        'gents'
    ),
    (
        'Waistcoat',
        'Formal vest',
        'gents'
    ),
    (
        'Jacket',
        'All types of jackets',
        'unisex'
    );

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

-- Insert initial subcategories
INSERT INTO
    `clothing_subcategories` (
        `category_id`,
        `name`,
        `description`
    )
VALUES (
        1,
        'Long Sleeve',
        'Full sleeve shirts'
    ),
    (
        1,
        'Short Sleeve',
        'Half sleeve shirts'
    ),
    (
        2,
        'Regular Fit',
        'Standard fit pants'
    ),
    (
        2,
        'Slim Fit',
        'Slim fit pants'
    ),
    (
        3,
        'Two Piece',
        'Traditional two piece suit'
    ),
    (
        3,
        'Three Piece',
        'Three piece suit with vest'
    );

-- Insert subcategories for new categories
INSERT INTO
    `clothing_subcategories` (
        `category_id`,
        `name`,
        `description`
    )
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Blouse'
    ), 'Quarter Sleeve', 'Quarter length sleeve blouse'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Blouse'
    ), 'Sleeveless', 'Sleeveless blouse'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Saree Blouse'
    ), 'Traditional', 'Traditional style blouse'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Saree Blouse'
    ), 'Modern', 'Modern style blouse'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Kurta'
    ), 'Regular', 'Regular fit kurta'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Kurta'
    ), 'Slim', 'Slim fit kurta'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Waistcoat'
    ), 'Single Breasted', 'Single button row'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Waistcoat'
    ), 'Double Breasted', 'Double button rows'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Jacket'
    ), 'Casual', 'Casual style jacket'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Jacket'
    ), 'Formal', 'Formal style jacket';
-- Add subcategories for Dresses
INSERT INTO
    `clothing_subcategories` (
        `category_id`,
        `name`,
        `description`
    )
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Dress'
    ), 'Formal', 'Elegant dresses for special occasions'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Dress'
    ), 'Casual', 'Comfortable everyday dresses'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Dress'
    ), 'Maxi', 'Full-length dresses reaching the ankle'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Dress'
    ), 'Midi', 'Mid-length dresses falling below the knee'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Dress'
    ), 'Mini', 'Short dresses ending above the knee'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Dress'
    ), 'A-Line', 'Fitted at the top and flaring out at the bottom'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Dress'
    ), 'Shift', 'Straight cut dresses that hang from the shoulders'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Dress'
    ), 'Wrap', 'Dresses that wrap around and tie at the waist';

-- Add subcategories for Skirts
INSERT INTO
    `clothing_subcategories` (
        `category_id`,
        `name`,
        `description`
    )
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Skirt'
    ), 'Mini', 'Short skirts ending above the knee'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Skirt'
    ), 'Midi', 'Mid-length skirts falling below the knee'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Skirt'
    ), 'Maxi', 'Full-length skirts reaching the ankle'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Skirt'
    ), 'A-Line', 'Fitted at the waist and flaring out to hem'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Skirt'
    ), 'Pencil', 'Narrow, straight skirts hugging the hips'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Skirt'
    ), 'Pleated', 'Skirts with pressed folds'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Skirt'
    ), 'Circle', 'Full skirts cut in a complete circle';

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

-- Insert initial customization types for shirts
INSERT INTO
    `customization_types` (
        `category_id`,
        `name`,
        `description`
    )
VALUES (
        1,
        'Collar Type',
        'Different types of shirt collars'
    ),
    (
        1,
        'Cuff Style',
        'Different types of shirt cuffs'
    ),
    (
        1,
        'Pocket Style',
        'Different types of shirt pockets'
    ),
    (
        1,
        'Button Type',
        'Different types of buttons'
    );

-- Insert customization types for new categories
INSERT INTO
    `customization_types` (
        `category_id`,
        `name`,
        `description`
    )
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Blouse'
    ), 'Neck Design', 'Different types of neck designs'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Blouse'
    ), 'Back Design', 'Different types of back designs'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Saree Blouse'
    ), 'Neck Pattern', 'Different neck patterns'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Kurta'
    ), 'Collar Style', 'Different collar styles'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Waistcoat'
    ), 'Lapel Style', 'Different lapel styles'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Jacket'
    ), 'Closure Type', 'Different closure types';

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

-- Create design required measurements table
CREATE TABLE `design_required_measurements` (
    `design_id` INT(11) NOT NULL,
    `measurement_name` VARCHAR(50) NOT NULL,
    `measurement_description` TEXT,
    `is_required` BOOLEAN DEFAULT TRUE,
    `default_value` DECIMAL(5, 2) NULL,
    `measurement_type` ENUM('shirt', 'pant', 'other') NOT NULL,
    PRIMARY KEY (
        `design_id`,
        `measurement_name`
    ),
    FOREIGN KEY (`design_id`) REFERENCES `designs` (`design_id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- -----------------------------------------------------
-- 6. ORDER MANAGEMENT TABLES
-- -----------------------------------------------------

-- Orders main table
CREATE TABLE `orders` (
    `order_id` INT(11) NOT NULL AUTO_INCREMENT,
    `customer_id` INT(11) NOT NULL,
    `tailor_id` INT(11) NOT NULL,
    `order_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `total_amount` DECIMAL(10, 2) NOT NULL,
    `status` ENUM(
        'pending',
        'processing',
        'completed',
        'cancelled'
    ) DEFAULT 'pending',
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

-- Order items table (one order can have multiple items)
CREATE TABLE `order_items` (
    `item_id` INT(11) NOT NULL AUTO_INCREMENT,
    `order_id` INT(11) NOT NULL,
    `design_id` INT(11) NOT NULL,
    `fabric_id` INT(11) NOT NULL,
    `color_id` INT(11) NOT NULL,
    `quantity` INT(2) DEFAULT 1,
    `base_price` DECIMAL(10, 2) NOT NULL,
    `customization_price` DECIMAL(10, 2) DEFAULT 0.00,
    `fabric_price` DECIMAL(10, 2) DEFAULT 0.00,
    `total_price` DECIMAL(10, 2) NOT NULL,
    `status` ENUM(
        'pending',
        'in_progress',
        'ready',
        'delivered'
    ) DEFAULT 'pending',
    PRIMARY KEY (`item_id`),
    FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
    FOREIGN KEY (`design_id`) REFERENCES `designs` (`design_id`) ON DELETE RESTRICT,
    FOREIGN KEY (`fabric_id`) REFERENCES `fabrics` (`fabric_id`) ON DELETE RESTRICT,
    FOREIGN KEY (`color_id`) REFERENCES `colors` (`color_id`) ON DELETE RESTRICT
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Order item customizations (which customization choices were selected for each item)
CREATE TABLE `order_item_customizations` (
    `item_id` INT(11) NOT NULL,
    `customization_type_id` INT(11) NOT NULL,
    `choice_id` INT(11) NOT NULL,
    `price_adjustment` DECIMAL(10, 2) DEFAULT 0.00,
    PRIMARY KEY (
        `item_id`,
        `customization_type_id`
    ),
    FOREIGN KEY (`item_id`) REFERENCES `order_items` (`item_id`) ON DELETE CASCADE,
    FOREIGN KEY (`customization_type_id`) REFERENCES `customization_types` (`type_id`) ON DELETE CASCADE,
    FOREIGN KEY (`choice_id`) REFERENCES `customization_choices` (`choice_id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Order item measurements
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

-- Actual measurement values for order items
CREATE TABLE `order_item_measurements` (
    `item_id` INT(11) NOT NULL,
    `measurement_id` INT(11) NULL,
    `custom_measurement_id` INT(11) NULL,
    `value` DECIMAL(10, 2) NOT NULL,
    `measurement_source` ENUM(
        'profile',
        'manual',
        'adjusted'
    ) NOT NULL DEFAULT 'manual',
    `measured_by` INT(11) NULL,
    `measurement_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`item_id`, `measurement_id`),
    FOREIGN KEY (`item_id`) REFERENCES `order_items` (`item_id`) ON DELETE CASCADE,
    FOREIGN KEY (`measurement_id`) REFERENCES `measurements` (`measurement_id`) ON DELETE CASCADE,
    FOREIGN KEY (`custom_measurement_id`) REFERENCES `custom_design_measurements` (`id`) ON DELETE CASCADE,
    FOREIGN KEY (`measured_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
    CHECK (
        measurement_id IS NOT NULL
        OR custom_measurement_id IS NOT NULL
    )
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- User profile measurements
CREATE TABLE `user_measurements` (
    `user_id` INT(11) NOT NULL,
    `measurement_id` INT(11) NOT NULL,
    `value` DECIMAL(10, 2) NOT NULL,
    `last_updated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`user_id`, `measurement_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
    FOREIGN KEY (`measurement_id`) REFERENCES `measurements` (`measurement_id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Insert common shirt measurements
INSERT INTO
    `measurements` (
        `name`,
        `display_name`,
        `description`,
        `unit_type`
    )
VALUES (
        'neck',
        'Neck Circumference',
        'Measured around the base of neck',
        'circumference'
    ),
    (
        'chest',
        'Chest',
        'Measured at the fullest part of the chest',
        'circumference'
    ),
    (
        'waist',
        'Waist',
        'Measured at the narrowest part of the waist',
        'circumference'
    ),
    (
        'hip',
        'Hip',
        'Measured at the fullest part of the hip',
        'circumference'
    ),
    (
        'shoulder_width',
        'Shoulder Width',
        'Measured from shoulder point to shoulder point across back',
        'length'
    ),
    (
        'sleeve_length',
        'Sleeve Length',
        'Measured from shoulder point to wrist',
        'length'
    ),
    (
        'bicep',
        'Bicep',
        'Measured around the fullest part of the upper arm',
        'circumference'
    ),
    (
        'wrist',
        'Wrist',
        'Measured around the wrist bone',
        'circumference'
    ),
    (
        'shirt_length',
        'Shirt Length',
        'Measured from the highest point of the shoulder to the desired length',
        'length'
    ),
    (
        'armhole_depth',
        'Armhole Depth',
        'Measured from shoulder point to where arm joins the body',
        'length'
    ),
    (
        'cuff_circumference',
        'Cuff Circumference',
        'Measured around the cuff',
        'circumference'
    ),
    (
        'front_length',
        'Front Length',
        'Measured from shoulder to bottom hem at front',
        'length'
    ),
    (
        'back_length',
        'Back Length',
        'Measured from base of neck to bottom hem at back',
        'length'
    ),
    (
        'collar_height',
        'Collar Height',
        'Height of the collar',
        'length'
    ),
    (
        'collar_width',
        'Collar Width',
        'Width of the collar',
        'length'
    );

-- Insert common pant measurements
INSERT INTO
    `measurements` (
        `name`,
        `display_name`,
        `description`,
        `unit_type`
    )
VALUES (
        'pant_waist',
        'Pant Waist',
        'Measured around where pants would sit',
        'circumference'
    ),
    (
        'seat',
        'Seat/Hip',
        'Measured around the fullest part of seat',
        'circumference'
    ),
    (
        'thigh',
        'Thigh',
        'Measured around the fullest part of thigh',
        'circumference'
    ),
    (
        'knee',
        'Knee',
        'Measured around the knee',
        'circumference'
    ),
    (
        'calf',
        'Calf',
        'Measured around the widest part of calf',
        'circumference'
    ),
    (
        'ankle',
        'Ankle',
        'Measured around the ankle',
        'circumference'
    ),
    (
        'inseam',
        'Inseam',
        'Measured from crotch to desired pant length',
        'length'
    ),
    (
        'outseam',
        'Outseam',
        'Measured from waist to desired pant length on outside',
        'length'
    ),
    (
        'front_rise',
        'Front Rise',
        'Measured from center of crotch to top of waistband in front',
        'length'
    ),
    (
        'back_rise',
        'Back Rise',
        'Measured from center of crotch to top of waistband in back',
        'length'
    );

-- Associate measurements with categories
-- Shirt category (assuming ID 1)
INSERT INTO
    `category_measurements` (
        `category_id`,
        `measurement_id`,
        `is_required`,
        `display_order`
    )
SELECT
    1,
    `measurement_id`,
    CASE
        WHEN `name` IN (
            'neck',
            'chest',
            'shoulder_width',
            'sleeve_length'
        ) THEN TRUE
        ELSE FALSE
    END,
    CASE
        WHEN `name` = 'neck' THEN 1
        WHEN `name` = 'chest' THEN 2
        WHEN `name` = 'shoulder_width' THEN 3
        WHEN `name` = 'sleeve_length' THEN 4
        WHEN `name` = 'waist' THEN 5
        WHEN `name` = 'bicep' THEN 6
        WHEN `name` = 'wrist' THEN 7
        WHEN `name` = 'shirt_length' THEN 8
        ELSE 100
    END
FROM `measurements`
WHERE
    `name` IN (
        'neck',
        'chest',
        'waist',
        'shoulder_width',
        'sleeve_length',
        'bicep',
        'wrist',
        'shirt_length',
        'armhole_depth',
        'cuff_circumference',
        'front_length',
        'back_length',
        'collar_height',
        'collar_width'
    );

-- Pants category (assuming ID 2)
INSERT INTO
    `category_measurements` (
        `category_id`,
        `measurement_id`,
        `is_required`,
        `display_order`
    )
SELECT
    2,
    `measurement_id`,
    CASE
        WHEN `name` IN (
            'pant_waist',
            'seat',
            'inseam'
        ) THEN TRUE
        ELSE FALSE
    END,
    CASE
        WHEN `name` = 'pant_waist' THEN 1
        WHEN `name` = 'seat' THEN 2
        WHEN `name` = 'inseam' THEN 3
        WHEN `name` = 'outseam' THEN 4
        WHEN `name` = 'thigh' THEN 5
        ELSE 100
    END
FROM `measurements`
WHERE
    `name` IN (
        'pant_waist',
        'seat',
        'thigh',
        'knee',
        'calf',
        'ankle',
        'inseam',
        'outseam',
        'front_rise',
        'back_rise'
    );

-- new tables since 24/4/2025
CREATE TABLE `reschedule_requests` (
    `request_id` INT(11) NOT NULL AUTO_INCREMENT,
    `appointment_id` INT(11) NOT NULL,
    `requested_by` ENUM('tailor', 'customer') NOT NULL,
    `proposed_date` DATE NOT NULL,
    `proposed_time` TIME NOT NULL,
    `reason` TEXT NOT NULL,
    `status` ENUM(
        'pending',
        'accepted',
        'rejected'
    ) DEFAULT 'pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`request_id`),
    FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`appointment_id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

ALTER TABLE `appointments`
MODIFY COLUMN `status` ENUM(
    'accepted',
    'reschedule_pending',
    'rejected',
    'rescheduled',
    'pending'
) NOT NULL DEFAULT 'pending';