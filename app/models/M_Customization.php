<?php
class M_Customization {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Get all categories
    public function getCategories() {
        try {
            $this->db->query('SELECT * FROM categories WHERE 1 ORDER BY name');
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }

    // Get subcategories by category ID
    public function getSubcategories($categoryId) {
        try {
            $this->db->query('SELECT * FROM subcategories WHERE category_id = :category_id');
            $this->db->bind(':category_id', $categoryId);
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }

    // Get product image
    public function getProductImage($categoryId, $subcategoryId) {
        try {
            $this->db->query('SELECT image_path FROM product_images WHERE category_id = :category_id AND subcategory_id = :subcategory_id');
            $this->db->bind(':category_id', $categoryId);
            $this->db->bind(':subcategory_id', $subcategoryId);
            return $this->db->single();
        } catch (Exception $e) {
            return null;
        }
    }

    // Get button types
    public function getButtonTypes() {
        try {
            $this->db->query('SELECT * FROM button_types WHERE is_active = TRUE');
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }

    // Get collar types
    public function getCollarTypes() {
        try {
            $this->db->query('SELECT * FROM collar_types WHERE is_active = TRUE');
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }

    // Get pocket types
    public function getPocketTypes() {
        try {
            $this->db->query('SELECT * FROM pocket_types WHERE is_active = TRUE');
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }

    // Add button type
    public function addButtonType($name, $imagePath, $userId = null) {
        try {
            $this->db->query('INSERT INTO button_types (name, image_path, created_by) 
                              VALUES (:name, :image_path, :created_by)');
            $this->db->bind(':name', $name);
            $this->db->bind(':image_path', $imagePath);
            $this->db->bind(':created_by', $userId);
            
            if($this->db->execute()) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Add collar type
    public function addCollarType($name, $imagePath, $userId = null) {
        try {
            $this->db->query('INSERT INTO collar_types (name, image_path, created_by) 
                              VALUES (:name, :image_path, :created_by)');
            $this->db->bind(':name', $name);
            $this->db->bind(':image_path', $imagePath);
            $this->db->bind(':created_by', $userId);
            
            if($this->db->execute()) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Add pocket type
    public function addPocketType($name, $imagePath, $userId = null) {
        try {
            $this->db->query('INSERT INTO pocket_types (name, image_path, created_by) 
                              VALUES (:name, :image_path, :created_by)');
            $this->db->bind(':name', $name);
            $this->db->bind(':image_path', $imagePath);
            $this->db->bind(':created_by', $userId);
            
            if($this->db->execute()) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Soft delete (deactivate) button type
    public function deactivateButtonType($buttonId, $userId = null) {
        try {
            $this->db->query('UPDATE button_types SET is_active = FALSE, updated_by = :user_id, 
                              updated_at = CURRENT_TIMESTAMP WHERE button_id = :button_id');
            $this->db->bind(':button_id', $buttonId);
            $this->db->bind(':user_id', $userId);
            return $this->db->execute();
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Soft delete (deactivate) collar type
    public function deactivateCollarType($collarId, $userId = null) {
        try {
            $this->db->query('UPDATE collar_types SET is_active = FALSE, updated_by = :user_id, 
                              updated_at = CURRENT_TIMESTAMP WHERE collar_id = :collar_id');
            $this->db->bind(':collar_id', $collarId);
            $this->db->bind(':user_id', $userId);
            return $this->db->execute();
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Soft delete (deactivate) pocket type
    public function deactivatePocketType($pocketId, $userId = null) {
        try {
            $this->db->query('UPDATE pocket_types SET is_active = FALSE, updated_by = :user_id, 
                              updated_at = CURRENT_TIMESTAMP WHERE pocket_id = :pocket_id');
            $this->db->bind(':pocket_id', $pocketId);
            $this->db->bind(':user_id', $userId);
            return $this->db->execute();
        } catch (Exception $e) {
            return false;
        }
    }
    
    // Get customization presets
    public function getCustomizationPresets($categoryId = null) {
        try {
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
        } catch (Exception $e) {
            return [];
        }
    }
    
    // Save customization preset
    public function saveCustomizationPreset($data) {
        try {
            $this->db->query('INSERT INTO customization_presets (
                                name, category_id, subcategory_id, button_type_id, 
                                collar_type_id, pocket_type_id, color_id,
                                image_path, is_popular, created_by
                              ) VALUES (
                                :name, :category_id, :subcategory_id, :button_type_id,
                                :collar_type_id, :pocket_type_id, :color_id,
                                :image_path, :is_popular, :created_by
                              )');
                              
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':category_id', $data['category_id']);
            $this->db->bind(':subcategory_id', $data['subcategory_id']);
            $this->db->bind(':button_type_id', $data['button_type_id']);
            $this->db->bind(':collar_type_id', $data['collar_type_id']);
            $this->db->bind(':pocket_type_id', $data['pocket_type_id']);
            $this->db->bind(':color_id', $data['color_id']);
            $this->db->bind(':image_path', $data['image_path']);
            $this->db->bind(':is_popular', isset($data['is_popular']) ? $data['is_popular'] : false);
            $this->db->bind(':created_by', isset($data['user_id']) ? $data['user_id'] : null);
            
            if($this->db->execute()) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    // Category CRUD
    public function addCategory($name, $userId = null) {
        try {
            $this->db->query('INSERT INTO categories (name, created_by) VALUES (:name, :created_by)');
            $this->db->bind(':name', $name);
            $this->db->bind(':created_by', $userId);
            
            if($this->db->execute()) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateCategory($categoryId, $name, $userId = null) {
        try {
            $this->db->query('UPDATE categories SET name = :name, updated_by = :updated_by WHERE category_id = :category_id');
            $this->db->bind(':category_id', $categoryId);
            $this->db->bind(':name', $name);
            $this->db->bind(':updated_by', $userId);
            return $this->db->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteCategory($categoryId, $userId = null) {
        try {
            // Using CASCADE delete in database to handle subcategories
            $this->db->query('DELETE FROM categories WHERE category_id = :category_id');
            $this->db->bind(':category_id', $categoryId);
            return $this->db->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    // Subcategory CRUD
    public function addSubcategory($categoryId, $name, $userId = null) {
        try {
            $this->db->query('INSERT INTO subcategories (category_id, name, created_by) VALUES (:category_id, :name, :created_by)');
            $this->db->bind(':category_id', $categoryId);
            $this->db->bind(':name', $name);
            $this->db->bind(':created_by', $userId);
            
            if($this->db->execute()) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateSubcategory($subcategoryId, $categoryId, $name, $userId = null) {
        try {
            $this->db->query('UPDATE subcategories SET category_id = :category_id, name = :name, updated_by = :updated_by WHERE subcategory_id = :subcategory_id');
            $this->db->bind(':subcategory_id', $subcategoryId);
            $this->db->bind(':category_id', $categoryId);
            $this->db->bind(':name', $name);
            $this->db->bind(':updated_by', $userId);
            return $this->db->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteSubcategory($subcategoryId, $userId = null) {
        try {
            $this->db->query('DELETE FROM subcategories WHERE subcategory_id = :subcategory_id');
            $this->db->bind(':subcategory_id', $subcategoryId);
            return $this->db->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    // Get all subcategories with category names (for management view)
    public function getAllSubcategories() {
        try {
            $this->db->query('
                SELECT s.*, c.name AS category_name
                FROM subcategories s
                JOIN categories c ON s.category_id = c.category_id
                ORDER BY c.name, s.name
            ');
            return $this->db->resultSet();
        } catch (Exception $e) {
            return [];
        }
    }

    // Update button type
    public function updateButtonType($buttonId, $name, $imagePath = null, $userId = null) {
        try {
            if ($imagePath) {
                // If we have a new image
                $this->db->query('UPDATE button_types SET name = :name, image_path = :image_path, 
                                  updated_by = :user_id, updated_at = CURRENT_TIMESTAMP 
                                  WHERE button_id = :button_id');
                $this->db->bind(':image_path', $imagePath);
            } else {
                // Keep the existing image
                $this->db->query('UPDATE button_types SET name = :name, updated_by = :user_id, 
                                  updated_at = CURRENT_TIMESTAMP 
                                  WHERE button_id = :button_id');
            }
            
            $this->db->bind(':button_id', $buttonId);
            $this->db->bind(':name', $name);
            $this->db->bind(':user_id', $userId);
            
            return $this->db->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    // Update collar type
    public function updateCollarType($collarId, $name, $imagePath = null, $userId = null) {
        try {
            if ($imagePath) {
                // If we have a new image
                $this->db->query('UPDATE collar_types SET name = :name, image_path = :image_path, 
                                  updated_by = :user_id, updated_at = CURRENT_TIMESTAMP 
                                  WHERE collar_id = :collar_id');
                $this->db->bind(':image_path', $imagePath);
            } else {
                // Keep the existing image
                $this->db->query('UPDATE collar_types SET name = :name, updated_by = :user_id, 
                                  updated_at = CURRENT_TIMESTAMP 
                                  WHERE collar_id = :collar_id');
            }
            
            $this->db->bind(':collar_id', $collarId);
            $this->db->bind(':name', $name);
            $this->db->bind(':user_id', $userId);
            
            return $this->db->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    // Update pocket type
    public function updatePocketType($pocketId, $name, $imagePath = null, $userId = null) {
        try {
            if ($imagePath) {
                // If we have a new image
                $this->db->query('UPDATE pocket_types SET name = :name, image_path = :image_path, 
                                  updated_by = :user_id, updated_at = CURRENT_TIMESTAMP 
                                  WHERE pocket_id = :pocket_id');
                $this->db->bind(':image_path', $imagePath);
            } else {
                // Keep the existing image
                $this->db->query('UPDATE pocket_types SET name = :name, updated_by = :user_id, 
                                  updated_at = CURRENT_TIMESTAMP 
                                  WHERE pocket_id = :pocket_id');
            }
            
            $this->db->bind(':pocket_id', $pocketId);
            $this->db->bind(':name', $name);
            $this->db->bind(':user_id', $userId);
            
            return $this->db->execute();
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
