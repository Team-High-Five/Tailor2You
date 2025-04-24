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

-- Create the `posts` table
CREATE TABLE `posts` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `gender` ENUM('men', 'women', 'unisex') DEFAULT 'unisex',
    `item_type` ENUM(
        'shirt',
        'pant',
        'frock',
        'skirt',
        'blouse'
    ) NULL,
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
    `front_length` decimal(5, 2) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

ALTER TABLE `shirt_measurements` ADD KEY `user_id` (`user_id`);

ALTER TABLE `shirt_measurements`
ADD CONSTRAINT `shirt_measurements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

COMMIT;

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

--- Design Tables ---

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

-- Modify designs table to include gender
ALTER TABLE `designs`
ADD COLUMN `gender` ENUM('gents', 'ladies', 'unisex') NOT NULL AFTER `user_id`;

-- Modify clothing_categories to include gender applicability
ALTER TABLE `clothing_categories`
ADD COLUMN `gender_specific` ENUM('gents', 'ladies', 'unisex') NOT NULL DEFAULT 'unisex';

-- Update existing categories with gender specificity
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

-- Add more gender-specific categories
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

-- Add corresponding subcategories for new categories
INSERT INTO
    `clothing_subcategories` (
        `category_id`,
        `name`,
        `description`
    )
VALUES (
        (
            SELECT category_id
            FROM clothing_categories
            WHERE
                name = 'Blouse'
        ),
        'Quarter Sleeve',
        'Quarter length sleeve blouse'
    ),
    (
        (
            SELECT category_id
            FROM clothing_categories
            WHERE
                name = 'Blouse'
        ),
        'Sleeveless',
        'Sleeveless blouse'
    ),
    (
        (
            SELECT category_id
            FROM clothing_categories
            WHERE
                name = 'Saree Blouse'
        ),
        'Traditional',
        'Traditional style blouse'
    ),
    (
        (
            SELECT category_id
            FROM clothing_categories
            WHERE
                name = 'Saree Blouse'
        ),
        'Modern',
        'Modern style blouse'
    ),
    (
        (
            SELECT category_id
            FROM clothing_categories
            WHERE
                name = 'Kurta'
        ),
        'Regular',
        'Regular fit kurta'
    ),
    (
        (
            SELECT category_id
            FROM clothing_categories
            WHERE
                name = 'Kurta'
        ),
        'Slim',
        'Slim fit kurta'
    ),
    (
        (
            SELECT category_id
            FROM clothing_categories
            WHERE
                name = 'Waistcoat'
        ),
        'Single Breasted',
        'Single button row'
    ),
    (
        (
            SELECT category_id
            FROM clothing_categories
            WHERE
                name = 'Waistcoat'
        ),
        'Double Breasted',
        'Double button rows'
    ),
    (
        (
            SELECT category_id
            FROM clothing_categories
            WHERE
                name = 'Jacket'
        ),
        'Casual',
        'Casual style jacket'
    ),
    (
        (
            SELECT category_id
            FROM clothing_categories
            WHERE
                name = 'Jacket'
        ),
        'Formal',
        'Formal style jacket'
    );

-- Add customization types for new categories
INSERT INTO
    `customization_types` (
        `category_id`,
        `name`,
        `description`
    )
VALUES (
        (
            SELECT category_id
            FROM clothing_categories
            WHERE
                name = 'Blouse'
        ),
        'Neck Design',
        'Different types of neck designs'
    ),
    (
        (
            SELECT category_id
            FROM clothing_categories
            WHERE
                name = 'Blouse'
        ),
        'Back Design',
        'Different types of back designs'
    ),
    (
        (
            SELECT category_id
            FROM clothing_categories
            WHERE
                name = 'Saree Blouse'
        ),
        'Neck Pattern',
        'Different neck patterns'
    ),
    (
        (
            SELECT category_id
            FROM clothing_categories
            WHERE
                name = 'Kurta'
        ),
        'Collar Style',
        'Different collar styles'
    ),
    (
        (
            SELECT category_id
            FROM clothing_categories
            WHERE
                name = 'Waistcoat'
        ),
        'Lapel Style',
        'Different lapel styles'
    ),
    (
        (
            SELECT category_id
            FROM clothing_categories
            WHERE
                name = 'Jacket'
        ),
        'Closure Type',
        'Different closure types'
    );

<< << << < HEAD
-- Create the `feedback` table
CREATE TABLE `feedback` (
    `feedback_id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `rating` INT(1) NOT NULL CHECK (rating BETWEEN 1 AND 5),
    `feedback_text` TEXT NOT NULL,
    `status` ENUM(
        'published',
        'pending',
        'rejected'
    ) DEFAULT 'pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`feedback_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

= = = = = = =
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

-- Create the `feedback` table
CREATE TABLE `feedback` (
    `feedback_id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `rating` INT(1) NOT NULL CHECK (rating BETWEEN 1 AND 5),
    `feedback_text` TEXT NOT NULL,
    `status` ENUM(
        'published',
        'pending',
        'rejected'
    ) DEFAULT 'pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`feedback_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

>>>>>>> parent of 247152e (Merge pull request #74 from Team-High-Five/rangi-2)