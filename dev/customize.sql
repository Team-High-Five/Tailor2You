-- First, select the mvc database
USE mvc;

-- Create base tables structure for customization

-- Categories and Subcategories
CREATE TABLE IF NOT EXISTS categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_by INT NULL
);

CREATE TABLE IF NOT EXISTS subcategories (
    subcategory_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_by INT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE
);

-- Customization Options Tables
CREATE TABLE IF NOT EXISTS button_types (
    button_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_by INT NULL
);

CREATE TABLE IF NOT EXISTS collar_types (
    collar_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_by INT NULL
);

CREATE TABLE IF NOT EXISTS pocket_types (
    pocket_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_by INT NULL
);

-- Removed Fabric Table

-- Product Images table for base imagery
CREATE TABLE IF NOT EXISTS product_images (
    product_image_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    subcategory_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE,
    FOREIGN KEY (subcategory_id) REFERENCES subcategories(subcategory_id) ON DELETE CASCADE
);

-- Customization Presets table
CREATE TABLE IF NOT EXISTS customization_presets (
    preset_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category_id INT NOT NULL,
    subcategory_id INT NOT NULL,
    button_type_id INT NULL,
    collar_type_id INT NULL,
    pocket_type_id INT NULL,
    -- Removed fabric_id
    image_path VARCHAR(255) NULL,
    is_popular BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    created_by INT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE,
    FOREIGN KEY (subcategory_id) REFERENCES subcategories(subcategory_id) ON DELETE CASCADE,
    FOREIGN KEY (button_type_id) REFERENCES button_types(button_id) ON DELETE SET NULL,
    FOREIGN KEY (collar_type_id) REFERENCES collar_types(collar_id) ON DELETE SET NULL,
    FOREIGN KEY (pocket_type_id) REFERENCES pocket_types(pocket_id) ON DELETE SET NULL
    -- Removed fabric foreign key
);

-- Ensure proper indexes for performance (only create if they don't exist)
-- Check if indexes exist before creating them
DROP PROCEDURE IF EXISTS create_index_if_not_exists;

DELIMITER $$
CREATE PROCEDURE create_index_if_not_exists()
BEGIN
    -- Removed fabric index check
    
    -- For button_types index
    IF NOT EXISTS (
        SELECT 1 FROM INFORMATION_SCHEMA.STATISTICS 
        WHERE table_schema = DATABASE() 
        AND table_name = 'button_types' 
        AND index_name = 'idx_button_active'
    ) THEN
        CREATE INDEX idx_button_active ON button_types(is_active);
    END IF;
    
    -- For collar_types index
    IF NOT EXISTS (
        SELECT 1 FROM INFORMATION_SCHEMA.STATISTICS 
        WHERE table_schema = DATABASE() 
        AND table_name = 'collar_types' 
        AND index_name = 'idx_collar_active'
    ) THEN
        CREATE INDEX idx_collar_active ON collar_types(is_active);
    END IF;
    
    -- For pocket_types index
    IF NOT EXISTS (
        SELECT 1 FROM INFORMATION_SCHEMA.STATISTICS 
        WHERE table_schema = DATABASE() 
        AND table_name = 'pocket_types' 
        AND index_name = 'idx_pocket_active'
    ) THEN
        CREATE INDEX idx_pocket_active ON pocket_types(is_active);
    END IF;
END$$
DELIMITER ;

CALL create_index_if_not_exists();
DROP PROCEDURE IF EXISTS create_index_if_not_exists;