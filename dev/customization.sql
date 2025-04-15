-- Add constraints to Category Table
ALTER TABLE categories
    MODIFY name VARCHAR(50) NOT NULL,
    ADD CONSTRAINT uk_category_name UNIQUE (name);

-- Add constraints to Subcategory Table
ALTER TABLE subcategories
    MODIFY category_id INT NOT NULL,
    MODIFY name VARCHAR(50) NOT NULL,
    ADD CONSTRAINT fk_subcategory_category FOREIGN KEY (category_id) 
        REFERENCES categories(category_id) ON DELETE CASCADE,
    ADD CONSTRAINT uk_subcategory_name_per_category UNIQUE (category_id, name);

-- Add constraints to Button Types Table
ALTER TABLE button_types
    MODIFY name VARCHAR(50) NOT NULL,
    ADD CONSTRAINT uk_button_type_name UNIQUE (name);

-- Add constraints to Collar Types Table
ALTER TABLE collar_types
    MODIFY name VARCHAR(50) NOT NULL,
    ADD CONSTRAINT uk_collar_type_name UNIQUE (name);

-- Add constraints to Pocket Types Table
ALTER TABLE pocket_types
    MODIFY name VARCHAR(50) NOT NULL,
    ADD CONSTRAINT uk_pocket_type_name UNIQUE (name);

-- Add constraints to Fabric Types Table
ALTER TABLE fabric_types
    MODIFY name VARCHAR(50) NOT NULL,
    ADD CONSTRAINT uk_fabric_type_name UNIQUE (name);

-- Add constraints to Colors Table
ALTER TABLE colors
    MODIFY color_name VARCHAR(30) NOT NULL,
    MODIFY hex_code VARCHAR(7) NOT NULL,
    ADD CONSTRAINT uk_color_name UNIQUE (color_name),
    ADD CONSTRAINT uk_color_hex_code UNIQUE (hex_code),
    ADD CONSTRAINT chk_hex_code CHECK (hex_code REGEXP '^#[0-9A-F]{6}$');

-- Add constraints to Fabric Colors Junction Table
ALTER TABLE fabric_colors
    MODIFY fabric_id INT NOT NULL,
    MODIFY color_id INT NOT NULL,
    ADD CONSTRAINT fk_fabric_color_fabric FOREIGN KEY (fabric_id) 
        REFERENCES fabric_types(fabric_id) ON DELETE CASCADE,
    ADD CONSTRAINT fk_fabric_color_color FOREIGN KEY (color_id) 
        REFERENCES colors(color_id) ON DELETE CASCADE,
    ADD CONSTRAINT uk_fabric_color UNIQUE (fabric_id, color_id);

-- Add constraints to Product Image Table
ALTER TABLE product_images
    MODIFY category_id INT NOT NULL,
    MODIFY subcategory_id INT NOT NULL,
    MODIFY image_path VARCHAR(255) NOT NULL,
    ADD CONSTRAINT fk_product_image_category FOREIGN KEY (category_id) 
        REFERENCES categories(category_id) ON DELETE CASCADE,
    ADD CONSTRAINT fk_product_image_subcategory FOREIGN KEY (subcategory_id) 
        REFERENCES subcategories(subcategory_id) ON DELETE CASCADE,
    ADD CONSTRAINT uk_product_image_category_subcategory UNIQUE (category_id, subcategory_id);

-- Add additional metadata columns for tracking and user management
ALTER TABLE categories 
    ADD updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    ADD created_by INT NULL,
    ADD updated_by INT NULL;

ALTER TABLE subcategories 
    ADD updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    ADD created_by INT NULL,
    ADD updated_by INT NULL;

ALTER TABLE button_types 
    ADD updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    ADD created_by INT NULL,
    ADD updated_by INT NULL;

ALTER TABLE collar_types 
    ADD updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    ADD created_by INT NULL,
    ADD updated_by INT NULL;

ALTER TABLE pocket_types 
    ADD updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    ADD created_by INT NULL,
    ADD updated_by INT NULL;

ALTER TABLE fabric_types 
    ADD updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    ADD created_by INT NULL,
    ADD updated_by INT NULL;

ALTER TABLE colors 
    ADD updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    ADD created_by INT NULL,
    ADD updated_by INT NULL;

-- Add status fields for soft deletion and inventory management
ALTER TABLE fabric_types
    ADD is_active BOOLEAN NOT NULL DEFAULT TRUE;

ALTER TABLE button_types
    ADD is_active BOOLEAN NOT NULL DEFAULT TRUE;

ALTER TABLE collar_types
    ADD is_active BOOLEAN NOT NULL DEFAULT TRUE;

ALTER TABLE pocket_types
    ADD is_active BOOLEAN NOT NULL DEFAULT TRUE;

-- Add price information to fabrics (since the form seems to manage inventory)
ALTER TABLE fabric_types
    ADD price_per_meter DECIMAL(10,2) NULL,
    ADD currency VARCHAR(3) DEFAULT 'USD';

-- Create a new table for customization presets
CREATE TABLE customization_presets (
    preset_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category_id INT NOT NULL,
    subcategory_id INT NOT NULL,
    button_type_id INT NULL,
    collar_type_id INT NULL,
    pocket_type_id INT NULL,
    fabric_id INT NULL,
    color_id INT NULL,
    image_path VARCHAR(255) NULL,
    is_popular BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    created_by INT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(category_id),
    FOREIGN KEY (subcategory_id) REFERENCES subcategories(subcategory_id),
    FOREIGN KEY (button_type_id) REFERENCES button_types(button_id),
    FOREIGN KEY (collar_type_id) REFERENCES collar_types(collar_id),
    FOREIGN KEY (pocket_type_id) REFERENCES pocket_types(pocket_id),
    FOREIGN KEY (fabric_id) REFERENCES fabric_types(fabric_id),
    FOREIGN KEY (color_id) REFERENCES colors(color_id)
);

-- Add sample presets
INSERT INTO customization_presets (name, category_id, subcategory_id, button_type_id, collar_type_id, pocket_type_id, fabric_id, color_id, is_popular)
VALUES
('Classic Business Shirt', 1, 1, 1, 1, 1, 3, 1, TRUE),
('Casual Summer Shirt', 1, 2, 2, 3, 2, 1, 3, TRUE),
('Formal Evening Shirt', 1, 3, 3, 2, 3, 2, 1, FALSE);
