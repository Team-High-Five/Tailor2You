<?php
class M_Designs
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getCategories()
    {
        $this->db->query('SELECT * FROM clothing_categories ORDER BY name');
        return $this->db->resultSet();
    }

    public function getAllSubcategories()
    {
        $this->db->query('SELECT * FROM clothing_subcategories ORDER BY name');
        return $this->db->resultSet();
    }

    public function getSubcategoriesByCategoryId($categoryId)
    {
        $this->db->query('SELECT * FROM clothing_subcategories WHERE category_id = :category_id ORDER BY name');
        $this->db->bind(':category_id', $categoryId);
        return $this->db->resultSet();
    }

    public function getCategoriesWithSubcategories()
    {
        $categories = $this->getCategories();

        // Attach subcategories to each category
        foreach ($categories as $category) {
            $this->db->query('SELECT * FROM clothing_subcategories WHERE category_id = :category_id ORDER BY name');
            $this->db->bind(':category_id', $category->category_id);
            $category->subcategories = $this->db->resultSet();
        }

        return $categories;
    }

    public function getCategoryById($categoryId)
    {
        $this->db->query('SELECT * FROM clothing_categories WHERE category_id = :category_id');
        $this->db->bind(':category_id', $categoryId);
        return $this->db->single();
    }

    public function getSubcategoryById($subcategoryId)
    {
        $this->db->query('SELECT * FROM clothing_subcategories WHERE subcategory_id = :subcategory_id');
        $this->db->bind(':subcategory_id', $subcategoryId);
        return $this->db->single();
    }

    public function getCustomizationTypes()
    {
        $this->db->query('SELECT * FROM customization_types');
        return $this->db->resultSet();
    }
    public function getCustomizationTypesByCategoryId($categoryId)
    {
        try {
            $this->db->query('
                SELECT *
                FROM customization_types 
                WHERE category_id = :category_id
                ORDER BY name
            ');
            $this->db->bind(':category_id', $categoryId);
            $results = $this->db->resultSet();
            error_log("Fetched " . count($results) . " customization types for category ID: " . $categoryId);
            return $results;
        } catch (Exception $e) {
            error_log("Error in getCustomizationTypesByCategoryId: " . $e->getMessage());
            return []; // Return empty array on error
        }
    }

    public function getFabrics()
    {
        $this->db->query('SELECT * FROM fabrics');
        return $this->db->resultSet();
    }

    public function getColors()
    {
        $this->db->query('SELECT * FROM colors');
        return $this->db->resultSet();
    }

    public function addDesign($data)
    {
        $this->db->query('INSERT INTO designs (user_id, gender, category_id, subcategory_id, name, description, main_image, base_price) 
                           VALUES (:user_id, :gender, :category_id, :subcategory_id, :name, :description, :main_image, :base_price)');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':subcategory_id', $data['subcategory_id']);
        $this->db->bind(':name', $data['design_name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':main_image', $data['main_image']);
        $this->db->bind(':base_price', $data['base_price']);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
    public function getFabricsByUserId($user_id)
    {
        try {
            // Debug logs
            error_log("Getting fabrics for user ID: $user_id");

            // First check if fabrics are directly associated with users
            $this->db->query('
            SELECT f.*, GROUP_CONCAT(fc.color_id) as color_ids, GROUP_CONCAT(c.color_name) as color_names, 
            GROUP_CONCAT(c.color_code) as color_codes
            FROM fabrics f
            LEFT JOIN fabric_colors fc ON f.fabric_id = fc.fabric_id
            LEFT JOIN colors c ON fc.color_id = c.color_id
            WHERE (f.user_id = :user_id OR f.user_id IS NULL)
            GROUP BY f.fabric_id
        ');
            $this->db->bind(':user_id', $user_id);
            $fabrics = $this->db->resultSet();

            error_log("Found " . count($fabrics) . " fabrics for user ID: $user_id");

            // If no fabrics found, get all available fabrics
            if (empty($fabrics)) {
                error_log("No user-specific fabrics found, getting all fabrics");
                $this->db->query('
                SELECT f.*, GROUP_CONCAT(fc.color_id) as color_ids, GROUP_CONCAT(c.color_name) as color_names, 
                GROUP_CONCAT(c.color_code) as color_codes
                FROM fabrics f
                LEFT JOIN fabric_colors fc ON f.fabric_id = fc.fabric_id
                LEFT JOIN colors c ON fc.color_id = c.color_id
                GROUP BY f.fabric_id
            ');
                $fabrics = $this->db->resultSet();
                error_log("Found " . count($fabrics) . " general fabrics");
            }

            // Process colors for each fabric
            foreach ($fabrics as $fabric) {
                $fabric->colors = [];

                if (!empty($fabric->color_ids)) {
                    $color_ids = explode(',', $fabric->color_ids);
                    $color_names = explode(',', $fabric->color_names);
                    $color_codes = explode(',', $fabric->color_codes);

                    for ($i = 0; $i < count($color_ids); $i++) {
                        if (isset($color_names[$i]) && isset($color_codes[$i])) {
                            $fabric->colors[] = (object)[
                                'color_id' => $color_ids[$i],
                                'color_name' => $color_names[$i],
                                'color_code' => $color_codes[$i]
                            ];
                        }
                    }
                }

                // Remove the concatenated properties
                unset($fabric->color_ids);
                unset($fabric->color_names);
                unset($fabric->color_codes);
            }

            return $fabrics;
        } catch (Exception $e) {
            error_log("Error in getFabricsByUserId: " . $e->getMessage());
            return [];
        }
    }
}
