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

    public function getFabricsByUserId($user_id)
    {
        $this->db->query('SELECT * FROM fabrics WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    public function addDesignCustomizationChoice($data)
    {
        // First insert the customization choice
        $this->db->query('
            INSERT INTO customization_choices (type_id, name, image, price_adjustment)
            VALUES (:type_id, :name, :image, :price_adjustment)
        ');

        $this->db->bind(':type_id', $data['type_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':price_adjustment', $data['price_adjustment']);

        if (!$this->db->execute()) {
            return false;
        }

        // Get the last inserted choice ID
        $choiceId = $this->db->lastInsertId();

        // Now link this choice to the design
        $this->db->query('
            INSERT INTO design_customizations (design_id, choice_id)
            VALUES (:design_id, :choice_id)
        ');

        $this->db->bind(':design_id', $data['design_id']);
        $this->db->bind(':choice_id', $choiceId);

        return $this->db->execute();
    }

    /**
     * Associate a fabric with a design
     *
     * @param array $data Design fabric data
     * @return bool Success/failure
     */
    public function addDesignFabric($data)
    {
        $this->db->query('
            INSERT INTO design_fabrics (design_id, fabric_id, price_adjustment)
            VALUES (:design_id, :fabric_id, :price_adjustment)
        ');

        $this->db->bind(':design_id', $data['design_id']);
        $this->db->bind(':fabric_id', $data['fabric_id']);
        $this->db->bind(':price_adjustment', $data['price_adjustment']);

        return $this->db->execute();
    }

    /**
     * Update the addDesign method to correctly handle the design_name field
     */
    public function addDesign($data)
    {
        $this->db->query('
            INSERT INTO designs (user_id, gender, category_id, subcategory_id, name, description, main_image, base_price) 
            VALUES (:user_id, :gender, :category_id, :subcategory_id, :name, :description, :main_image, :base_price)
        ');

        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':subcategory_id', $data['subcategory_id']);
        $this->db->bind(':name', $data['name']); // This should be design_name in the data array
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':main_image', $data['main_image']);
        $this->db->bind(':base_price', $data['base_price']);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }

    /**
     * Commit a database transaction
     */
    public function commitTransaction()
    {
        return $this->db->commitTransaction();
    }

    /**
     * Roll back a database transaction
     */
    public function rollbackTransaction()
    {
        return $this->db->rollbackTransaction();
    }
}
