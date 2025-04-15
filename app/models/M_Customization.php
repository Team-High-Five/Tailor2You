<?php
class M_Customization {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Get all categories
    public function getCategories() {
        $this->db->query('SELECT * FROM categories WHERE 1 ORDER BY name');
        return $this->db->resultSet();
    }

    // Get subcategories by category ID
    public function getSubcategories($categoryId) {
        $this->db->query('SELECT * FROM subcategories WHERE category_id = :category_id');
        $this->db->bind(':category_id', $categoryId);
        return $this->db->resultSet();
    }

    // Get product image
    public function getProductImage($categoryId, $subcategoryId) {
        $this->db->query('SELECT image_path FROM product_images WHERE category_id = :category_id AND subcategory_id = :subcategory_id');
        $this->db->bind(':category_id', $categoryId);
        $this->db->bind(':subcategory_id', $subcategoryId);
        return $this->db->single();
    }

    // Get button types
    public function getButtonTypes() {
        $this->db->query('SELECT * FROM button_types WHERE is_active = TRUE');
        return $this->db->resultSet();
    }

    // Get collar types
    public function getCollarTypes() {
        $this->db->query('SELECT * FROM collar_types WHERE is_active = TRUE');
        return $this->db->resultSet();
    }

    // Get pocket types
    public function getPocketTypes() {
        $this->db->query('SELECT * FROM pocket_types WHERE is_active = TRUE');
        return $this->db->resultSet();
    }

    // Get fabric types with colors
    public function getFabricTypesWithColors() {
        $this->db->query('
            SELECT 
                ft.fabric_id, 
                ft.name AS fabric_name, 
                ft.price_per_meter,
                ft.currency,
                c.color_id, 
                c.color_name, 
                c.hex_code
            FROM 
                fabric_types ft
            LEFT JOIN 
                fabric_colors fc ON ft.fabric_id = fc.fabric_id
            LEFT JOIN 
                colors c ON fc.color_id = c.color_id
            WHERE 
                ft.is_active = TRUE
            ORDER BY 
                ft.name, c.color_name
        ');
        
        return $this->db->resultSet();
    }

    // Add a new fabric
    public function addFabric($fabricName, $pricePerMeter = null, $currency = 'USD', $userId = null) {
        $this->db->query('INSERT INTO fabric_types (name, price_per_meter, currency, created_by) 
                          VALUES (:name, :price, :currency, :created_by)');
        $this->db->bind(':name', $fabricName);
        $this->db->bind(':price', $pricePerMeter);
        $this->db->bind(':currency', $currency);
        $this->db->bind(':created_by', $userId);
        
        if($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    // Add a new color to a fabric
    public function addFabricColor($fabricId, $colorId) {
        $this->db->query('INSERT INTO fabric_colors (fabric_id, color_id) 
                          VALUES (:fabric_id, :color_id)');
        $this->db->bind(':fabric_id', $fabricId);
        $this->db->bind(':color_id', $colorId);
        return $this->db->execute();
    }
    
    // Add a new color
    public function addColor($colorName, $hexCode, $userId = null) {
        $this->db->query('INSERT INTO colors (color_name, hex_code, created_by) 
                         VALUES (:color_name, :hex_code, :created_by)');
        $this->db->bind(':color_name', $colorName);
        $this->db->bind(':hex_code', $hexCode);
        $this->db->bind(':created_by', $userId);
        
        if($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    // Get all colors
    public function getColors() {
        $this->db->query('SELECT color_id, color_name, hex_code FROM colors ORDER BY color_name');
        return $this->db->resultSet();
    }
    
    // Add button type
    public function addButtonType($name, $imagePath, $userId = null) {
        $this->db->query('INSERT INTO button_types (name, image_path, created_by) 
                          VALUES (:name, :image_path, :created_by)');
        $this->db->bind(':name', $name);
        $this->db->bind(':image_path', $imagePath);
        $this->db->bind(':created_by', $userId);
        
        if($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    // Add collar type
    public function addCollarType($name, $imagePath, $userId = null) {
        $this->db->query('INSERT INTO collar_types (name, image_path, created_by) 
                          VALUES (:name, :image_path, :created_by)');
        $this->db->bind(':name', $name);
        $this->db->bind(':image_path', $imagePath);
        $this->db->bind(':created_by', $userId);
        
        if($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    // Add pocket type
    public function addPocketType($name, $imagePath, $userId = null) {
        $this->db->query('INSERT INTO pocket_types (name, image_path, created_by) 
                          VALUES (:name, :image_path, :created_by)');
        $this->db->bind(':name', $name);
        $this->db->bind(':image_path', $imagePath);
        $this->db->bind(':created_by', $userId);
        
        if($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    // Soft delete (deactivate) fabric
    public function deactivateFabric($fabricId, $userId = null) {
        $this->db->query('UPDATE fabric_types SET is_active = FALSE, updated_by = :user_id, 
                          updated_at = CURRENT_TIMESTAMP WHERE fabric_id = :fabric_id');
        $this->db->bind(':fabric_id', $fabricId);
        $this->db->bind(':user_id', $userId);
        return $this->db->execute();
    }
    
    // Get customization presets
    public function getCustomizationPresets($categoryId = null) {
        $sql = 'SELECT cp.*, c.name AS category_name, sc.name AS subcategory_name 
                FROM customization_presets cp
                JOIN categories c ON cp.category_id = c.category_id
                JOIN subcategories sc ON cp.subcategory_id = sc.subcategory_id';
                
        if ($categoryId) {
            $sql .= ' WHERE cp.category_id = :category_id';
            $this->db->query($sql);
            $this->db->bind(':category_id', $categoryId);
        } else {
            $this->db->query($sql);
        }
        
        return $this->db->resultSet();
    }
    
    // Save customization preset
    public function saveCustomizationPreset($data) {
        $this->db->query('INSERT INTO customization_presets (
                            name, category_id, subcategory_id, button_type_id, 
                            collar_type_id, pocket_type_id, fabric_id, color_id,
                            image_path, is_popular, created_by
                          ) VALUES (
                            :name, :category_id, :subcategory_id, :button_type_id,
                            :collar_type_id, :pocket_type_id, :fabric_id, :color_id,
                            :image_path, :is_popular, :created_by
                          )');
                          
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':subcategory_id', $data['subcategory_id']);
        $this->db->bind(':button_type_id', $data['button_type_id']);
        $this->db->bind(':collar_type_id', $data['collar_type_id']);
        $this->db->bind(':pocket_type_id', $data['pocket_type_id']);
        $this->db->bind(':fabric_id', $data['fabric_id']);
        $this->db->bind(':color_id', $data['color_id']);
        $this->db->bind(':image_path', $data['image_path']);
        $this->db->bind(':is_popular', isset($data['is_popular']) ? $data['is_popular'] : false);
        $this->db->bind(':created_by', isset($data['user_id']) ? $data['user_id'] : null);
        
        if($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
}
?>
