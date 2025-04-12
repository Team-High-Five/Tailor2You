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

-- Mesurements Tables--

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

CREATE TABLE `pant_measurements` (
    `user_id` varchar(100) NOT NULL,
    `measure` int(11) NOT NULL,
    `waist_width` int(11) NOT NULL,
    `seat` int(11) NOT NULL,
    `mid_thigh_width` int(11) NOT NULL,
    `inseam` int(11) NOT NULL,
    `bottom_width` int(11) NOT NULL,
    `rise_height_front` int(11) NOT NULL,
    `rise_height_back` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;


--- Design Tables ---

-- Create clothing categories table
CREATE TABLE `clothing_categories` (
    `category_id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `description` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
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