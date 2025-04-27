-- -----------------------------------------------------
-- TAILOR2YOU DATABASE DATA POPULATION
-- -----------------------------------------------------

-- -----------------------------------------------------
-- 1. COLORS DATA
-- -----------------------------------------------------
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

INSERT INTO
    `colors` (`color_name`)
VALUES ('Navy Blue'),
    ('Burgundy'),
    ('Forest Green'),
    ('Teal'),
    ('Mint Green'),
    ('Olive'),
    ('Beige'),
    ('Cream'),
    ('Ivory'),
    ('Tan'),
    ('Brown'),
    ('Khaki'),
    ('Charcoal'),
    ('Silver'),
    ('Gold'),
    ('Turquoise'),
    ('Coral'),
    ('Peach'),
    ('Lavender'),
    ('Lilac'),
    ('Magenta'),
    ('Maroon'),
    ('Mustard'),
    ('Sage'),
    ('Sky Blue'),
    ('Royal Blue'),
    ('Baby Blue'),
    ('Hot Pink'),
    ('Salmon'),
    ('Rust'),
    ('Emerald'),
    ('Mauve'),
    ('Indigo'),
    ('Aqua'),
    ('Fuchsia'),
    ('Plum');

-- -----------------------------------------------------
-- 2. CLOTHING CATEGORIES DATA
-- -----------------------------------------------------
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
-- -----------------------------------------------------
-- Suit Category (ID: 3)
-- -----------------------------------------------------
INSERT INTO
    `category_measurements` (
        `category_id`,
        `measurement_id`,
        `is_required`,
        `display_order`
    )
SELECT
    3,
    `measurement_id`,
    CASE
        WHEN `name` IN (
            'chest',
            'shoulder_width',
            'sleeve_length',
            'waist',
            'pant_waist',
            'seat',
            'inseam'
        ) THEN TRUE
        ELSE FALSE
    END,
    CASE
    -- Jacket measurements
        WHEN `name` = 'chest' THEN 1
        WHEN `name` = 'shoulder_width' THEN 2
        WHEN `name` = 'sleeve_length' THEN 3
        WHEN `name` = 'waist' THEN 4
        WHEN `name` = 'bicep' THEN 5
        WHEN `name` = 'back_length' THEN 6
        -- Pant measurements
        WHEN `name` = 'pant_waist' THEN 7
        WHEN `name` = 'seat' THEN 8
        WHEN `name` = 'inseam' THEN 9
        WHEN `name` = 'outseam' THEN 10
        WHEN `name` = 'thigh' THEN 11
        ELSE 100
    END
FROM `measurements`
WHERE
    `name` IN (
        'chest',
        'shoulder_width',
        'sleeve_length',
        'waist',
        'bicep',
        'wrist',
        'back_length',
        'pant_waist',
        'seat',
        'thigh',
        'knee',
        'inseam',
        'outseam',
        'front_rise',
        'back_rise'
    );

-- -----------------------------------------------------
-- Dress Category (ID: 4)
-- -----------------------------------------------------
INSERT INTO
    `category_measurements` (
        `category_id`,
        `measurement_id`,
        `is_required`,
        `display_order`
    )
SELECT
    4,
    `measurement_id`,
    CASE
        WHEN `name` IN (
            'chest',
            'waist',
            'hip',
            'shoulder_width'
        ) THEN TRUE
        ELSE FALSE
    END,
    CASE
        WHEN `name` = 'chest' THEN 1
        WHEN `name` = 'waist' THEN 2
        WHEN `name` = 'hip' THEN 3
        WHEN `name` = 'shoulder_width' THEN 4
        WHEN `name` = 'front_length' THEN 5
        WHEN `name` = 'back_length' THEN 6
        WHEN `name` = 'sleeve_length' THEN 7
        WHEN `name` = 'armhole_depth' THEN 8
        ELSE 100
    END
FROM `measurements`
WHERE
    `name` IN (
        'chest',
        'waist',
        'hip',
        'shoulder_width',
        'sleeve_length',
        'armhole_depth',
        'front_length',
        'back_length'
    );

-- -----------------------------------------------------
-- Skirt Category (ID: 5)
-- -----------------------------------------------------
INSERT INTO
    `category_measurements` (
        `category_id`,
        `measurement_id`,
        `is_required`,
        `display_order`
    )
SELECT
    5,
    `measurement_id`,
    CASE
        WHEN `name` IN ('waist', 'hip') THEN TRUE
        ELSE FALSE
    END,
    CASE
        WHEN `name` = 'waist' THEN 1
        WHEN `name` = 'hip' THEN 2
        WHEN `name` = 'front_length' THEN 3
        WHEN `name` = 'back_length' THEN 4
        ELSE 100
    END
FROM `measurements`
WHERE
    `name` IN (
        'waist',
        'hip',
        'front_length',
        'back_length'
    );

-- -----------------------------------------------------
-- Blouse Category (ID: 6)
-- -----------------------------------------------------
INSERT INTO
    `category_measurements` (
        `category_id`,
        `measurement_id`,
        `is_required`,
        `display_order`
    )
SELECT
    6,
    `measurement_id`,
    CASE
        WHEN `name` IN (
            'chest',
            'shoulder_width',
            'sleeve_length',
            'waist'
        ) THEN TRUE
        ELSE FALSE
    END,
    CASE
        WHEN `name` = 'chest' THEN 1
        WHEN `name` = 'waist' THEN 2
        WHEN `name` = 'shoulder_width' THEN 3
        WHEN `name` = 'sleeve_length' THEN 4
        WHEN `name` = 'armhole_depth' THEN 5
        WHEN `name` = 'back_length' THEN 6
        WHEN `name` = 'front_length' THEN 7
        ELSE 100
    END
FROM `measurements`
WHERE
    `name` IN (
        'chest',
        'waist',
        'shoulder_width',
        'sleeve_length',
        'armhole_depth',
        'back_length',
        'front_length'
    );

-- -----------------------------------------------------
-- Saree Blouse Category (ID: 7)
-- -----------------------------------------------------
INSERT INTO
    `category_measurements` (
        `category_id`,
        `measurement_id`,
        `is_required`,
        `display_order`
    )
SELECT
    7,
    `measurement_id`,
    CASE
        WHEN `name` IN (
            'chest',
            'waist',
            'shoulder_width',
            'sleeve_length'
        ) THEN TRUE
        ELSE FALSE
    END,
    CASE
        WHEN `name` = 'chest' THEN 1
        WHEN `name` = 'waist' THEN 2
        WHEN `name` = 'shoulder_width' THEN 3
        WHEN `name` = 'sleeve_length' THEN 4
        WHEN `name` = 'armhole_depth' THEN 5
        WHEN `name` = 'back_length' THEN 6
        WHEN `name` = 'front_length' THEN 7
        WHEN `name` = 'neck' THEN 8
        ELSE 100
    END
FROM `measurements`
WHERE
    `name` IN (
        'chest',
        'waist',
        'shoulder_width',
        'sleeve_length',
        'armhole_depth',
        'back_length',
        'front_length',
        'neck'
    );

-- -----------------------------------------------------
-- Kurta Category (ID: 8)
-- -----------------------------------------------------
INSERT INTO
    `category_measurements` (
        `category_id`,
        `measurement_id`,
        `is_required`,
        `display_order`
    )
SELECT
    8,
    `measurement_id`,
    CASE
        WHEN `name` IN (
            'chest',
            'shoulder_width',
            'sleeve_length',
            'shirt_length'
        ) THEN TRUE
        ELSE FALSE
    END,
    CASE
        WHEN `name` = 'chest' THEN 1
        WHEN `name` = 'shoulder_width' THEN 2
        WHEN `name` = 'sleeve_length' THEN 3
        WHEN `name` = 'shirt_length' THEN 4
        WHEN `name` = 'waist' THEN 5
        WHEN `name` = 'neck' THEN 6
        WHEN `name` = 'bicep' THEN 7
        WHEN `name` = 'wrist' THEN 8
        ELSE 100
    END
FROM `measurements`
WHERE
    `name` IN (
        'chest',
        'shoulder_width',
        'sleeve_length',
        'shirt_length',
        'waist',
        'neck',
        'bicep',
        'wrist'
    );

-- -----------------------------------------------------
-- Waistcoat Category (ID: 9)
-- -----------------------------------------------------
INSERT INTO
    `category_measurements` (
        `category_id`,
        `measurement_id`,
        `is_required`,
        `display_order`
    )
SELECT
    9,
    `measurement_id`,
    CASE
        WHEN `name` IN (
            'chest',
            'waist',
            'shoulder_width'
        ) THEN TRUE
        ELSE FALSE
    END,
    CASE
        WHEN `name` = 'chest' THEN 1
        WHEN `name` = 'waist' THEN 2
        WHEN `name` = 'shoulder_width' THEN 3
        WHEN `name` = 'back_length' THEN 4
        WHEN `name` = 'front_length' THEN 5
        ELSE 100
    END
FROM `measurements`
WHERE
    `name` IN (
        'chest',
        'waist',
        'shoulder_width',
        'back_length',
        'front_length'
    );

-- -----------------------------------------------------
-- Jacket Category (ID: 10)
-- -----------------------------------------------------
INSERT INTO
    `category_measurements` (
        `category_id`,
        `measurement_id`,
        `is_required`,
        `display_order`
    )
SELECT
    10,
    `measurement_id`,
    CASE
        WHEN `name` IN (
            'chest',
            'shoulder_width',
            'sleeve_length'
        ) THEN TRUE
        ELSE FALSE
    END,
    CASE
        WHEN `name` = 'chest' THEN 1
        WHEN `name` = 'shoulder_width' THEN 2
        WHEN `name` = 'sleeve_length' THEN 3
        WHEN `name` = 'waist' THEN 4
        WHEN `name` = 'bicep' THEN 5
        WHEN `name` = 'wrist' THEN 6
        WHEN `name` = 'back_length' THEN 7
        WHEN `name` = 'front_length' THEN 8
        ELSE 100
    END
FROM `measurements`
WHERE
    `name` IN (
        'chest',
        'shoulder_width',
        'sleeve_length',
        'waist',
        'bicep',
        'wrist',
        'back_length',
        'front_length'
    );

-- -----------------------------------------------------
-- 3. CLOTHING SUBCATEGORIES DATA
-- -----------------------------------------------------
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

-- Add subcategories for Saree Blouse
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
            name = 'Saree Blouse'
    ), 'Embroidered', 'Blouses with intricate threadwork and embellishments'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Saree Blouse'
    ), 'Backless', 'Blouses with stylish backless designs'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Saree Blouse'
    ), 'High Neck', 'Blouses with elevated necklines for elegant look'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Saree Blouse'
    ), 'Halter Neck', 'Blouses with straps that wrap around the neck';

-- Add subcategories for Blouse
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
    ), 'Peplum', 'Blouses with a short flared ruffle attached at the waistline'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Blouse'
    ), 'Crop Top', 'Shorter blouses that expose midriff'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Blouse'
    ), 'Wrap', 'Blouses that wrap around and tie at the side'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Blouse'
    ), 'Off-Shoulder', 'Blouses with necklines that fall below the shoulders';

-- Add subcategories for Kurta
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
            name = 'Kurta'
    ), 'Anarkali', 'Long flared kurta inspired by Mughal court dancers'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Kurta'
    ), 'Straight Cut', 'Traditional straight kurta with side slits'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Kurta'
    ), 'A-Line', 'Fitted at the chest and flaring towards the bottom'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Kurta'
    ), 'Trail Cut', 'Kurta with asymmetrical hemline';

-- Add subcategories for Shirts
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
            name = 'Shirt'
    ), 'Formal', 'Crisp business shirts for professional settings'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Shirt'
    ), 'Casual', 'Relaxed shirts for everyday wear'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Shirt'
    ), 'Slim Fit', 'Tailored shirts with a narrower cut'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Shirt'
    ), 'Regular Fit', 'Standard cut shirts with comfortable room';

-- Add subcategories for Pants
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
            name = 'Pants'
    ), 'Formal', 'Tailored trousers for business and formal occasions'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Pants'
    ), 'Casual', 'Comfortable pants for everyday wear'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Pants'
    ), 'Pleated', 'Pants with pleats at the waistline'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Pants'
    ), 'Flat Front', 'Pants without pleats for a sleek look';

-- Add subcategories for Waistcoat
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
            name = 'Waistcoat'
    ), 'Formal', 'Elegant waistcoats for formal occasions'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Waistcoat'
    ), 'Casual', 'Relaxed waistcoats for everyday wear'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Waistcoat'
    ), 'Nehru', 'Waistcoats with mandarin collar inspired by Indian style'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Waistcoat'
    ), 'Embroidered', 'Waistcoats with decorative embroidery patterns';

-- Add subcategories for Jacket
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
            name = 'Jacket'
    ), 'Blazer', 'Semi-formal jackets for versatile styling'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Jacket'
    ), 'Bandhgala', 'Traditional Indian high-neck jackets'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Jacket'
    ), 'Achkan', 'Knee-length jacket with front buttons'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Jacket'
    ), 'Sherwani', 'Long coat-like jacket for formal occasions';

-- Add subcategories for Suits
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
            name = 'Suit'
    ), 'Single Breasted', 'Suits with a single row of buttons'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Suit'
    ), 'Double Breasted', 'Suits with two parallel rows of buttons'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Suit'
    ), 'Slim Fit', 'Modern suits with a narrower silhouette'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Suit'
    ), 'Classic Fit', 'Traditional suits with a roomier cut';

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

-- -----------------------------------------------------
-- 4. CUSTOMIZATION TYPES DATA
-- -----------------------------------------------------
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

-- For Shirts (Category ID: 1)
INSERT INTO
    `customization_types` (
        `category_id`,
        `name`,
        `description`
    )
VALUES (
        1,
        'Front Placket Style',
        'Different styles for the front placket of shirts'
    ),
    (
        1,
        'Back Pleat Style',
        'Different types of back pleats for comfort and style'
    ),
    (
        1,
        'Monogram Options',
        'Personalized initials or text on shirts'
    ),
    (
        1,
        'Contrast Elements',
        'Contrasting fabric elements like collar inner, cuff inner'
    ),
    (
        1,
        'Hem Style',
        'Different hemline styles for shirts'
    );

--For Pants (Category ID: 2)
INSERT INTO
    `customization_types` (
        `category_id`,
        `name`,
        `description`
    )
VALUES (
        2,
        'Waistband Style',
        'Different waistband designs and closures'
    ),
    (
        2,
        'Pocket Style',
        'Various pocket designs and placements'
    ),
    (
        2,
        'Pleats Option',
        'Flat front or pleated front options'
    ),
    (
        2,
        'Cuff Style',
        'Different bottom hem styles including cuffed or plain'
    ),
    (
        2,
        'Belt Loop Style',
        'Various belt loop designs and placements'
    ),
    (
        2,
        'Fly Type',
        'Button fly or zipper fly options'
    );

--For Suits (Category ID: 3)
INSERT INTO
    `customization_types` (
        `category_id`,
        `name`,
        `description`
    )
VALUES (
        3,
        'Lapel Style',
        'Different lapel designs for suit jackets'
    ),
    (
        3,
        'Vent Style',
        'Back vent options for suit jackets'
    ),
    (
        3,
        'Button Configuration',
        'Number and arrangement of buttons'
    ),
    (
        3,
        'Lining Options',
        'Different lining fabrics and designs'
    ),
    (
        3,
        'Pocket Style',
        'Various pocket styles for suit jackets'
    ),
    (
        3,
        'Trouser Break',
        'How the trouser falls on the shoe'
    );

--For Dresses (Category ID: 4)
INSERT INTO
    `customization_types` (
        `category_id`,
        `name`,
        `description`
    )
VALUES (
        4,
        'Neckline Style',
        'Various neckline designs for dresses'
    ),
    (
        4,
        'Sleeve Type',
        'Different sleeve styles and lengths'
    ),
    (
        4,
        'Waistline Style',
        'Various waistline placements and designs'
    ),
    (
        4,
        'Back Design',
        'Different back styles including closures'
    ),
    (
        4,
        'Hem Style',
        'Various hemline designs and lengths'
    ),
    (
        4,
        'Embellishment Options',
        'Additional decorative elements'
    );

--For Skirts (Category ID: 5)
INSERT INTO
    `customization_types` (
        `category_id`,
        `name`,
        `description`
    )
VALUES (
        5,
        'Waistband Style',
        'Different waistband designs'
    ),
    (
        5,
        'Closure Type',
        'Various closure methods for skirts'
    ),
    (
        5,
        'Hem Style',
        'Different hemline designs'
    ),
    (
        5,
        'Pleat Options',
        'Various pleating styles and placements'
    ),
    (
        5,
        'Slit Options',
        'Different slit placements and lengths'
    );

--For Blouse (Category ID: 6)
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
    ), 'Sleeve Style', 'Different sleeve designs and lengths'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Blouse'
    ), 'Armhole Design', 'Various armhole shapes and styles'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Blouse'
    ), 'Closure Type', 'Different methods for fastening the blouse'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Blouse'
    ), 'Hem Style', 'Various hemline designs for blouses';

--For Saree Blouse (Category ID: 7)
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
            name = 'Saree Blouse'
    ), 'Sleeve Length', 'Different sleeve lengths for saree blouses'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Saree Blouse'
    ), 'Back Hook Style', 'Various hook designs and placements'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Saree Blouse'
    ), 'Border Design', 'Different border styles for saree blouses'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Saree Blouse'
    ), 'Embroidery Options', 'Various embroidery patterns and placements';

--For Kurta (Category ID: 8)
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
            name = 'Kurta'
    ), 'Neckline Design', 'Various neckline patterns for kurtas'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Kurta'
    ), 'Sleeve Style', 'Different sleeve designs and lengths'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Kurta'
    ), 'Side Slit Style', 'Various side slit designs and lengths'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Kurta'
    ), 'Embroidery Options', 'Different embroidery patterns and placements';

-- For Waistcoat (Category ID: 9)
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
            name = 'Waistcoat'
    ), 'Back Style', 'Different back designs for waistcoats'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Waistcoat'
    ), 'Button Style', 'Various button types and arrangements'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Waistcoat'
    ), 'Pocket Style', 'Different pocket designs and placements'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Waistcoat'
    ), 'Bottom Cut', 'Various bottom hem designs for waistcoats';

--  For Jacket (Category ID: 10)
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
            name = 'Jacket'
    ), 'Collar Style', 'Different collar designs for jackets'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Jacket'
    ), 'Sleeve Style', 'Various sleeve designs and cuff options'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Jacket'
    ), 'Pocket Design', 'Different pocket styles and placements'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Jacket'
    ), 'Lining Options', 'Various lining fabrics and designs'
UNION ALL
SELECT (
        SELECT category_id
        FROM clothing_categories
        WHERE
            name = 'Jacket'
    ), 'Vent Style', 'Different back vent options for jackets';

-- -----------------------------------------------------
-- 5. MEASUREMENT DATA
-- -----------------------------------------------------
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

-- -----------------------------------------------------
-- 6. CATEGORY MEASUREMENTS MAPPING
-- -----------------------------------------------------
-- Associate measurements with categories - Shirt category
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

-- Associate measurements with categories - Pants category
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