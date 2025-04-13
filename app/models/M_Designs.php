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

    public function getDesignsByUserId($user_id)
    {
        $this->db->query('
        SELECT d.*, 
               c.name as category_name, 
               s.name as subcategory_name,
               d.created_at,
               d.status
        FROM designs d
        LEFT JOIN clothing_categories c ON d.category_id = c.category_id
        LEFT JOIN clothing_subcategories s ON d.subcategory_id = s.subcategory_id
        WHERE d.user_id = :user_id
        ORDER BY d.created_at DESC
    ');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }
    public function getDesignById($id)
    {
        $this->db->query('SELECT * FROM designs WHERE design_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }


    public function deleteDesign($id)
    {
        $this->db->beginTransaction();

        try {
            // Delete design customizations
            $this->db->query('DELETE FROM design_customizations WHERE design_id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();

            // Delete design fabrics
            $this->db->query('DELETE FROM design_fabrics WHERE design_id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();

            // Get the design to find the image filename
            $design = $this->getDesignById($id);

            // Delete the design from the database
            $this->db->query('DELETE FROM designs WHERE design_id = :id');
            $this->db->bind(':id', $id);
            $result = $this->db->execute();

            // Delete the image file if it exists
            if ($result && $design && !empty($design->main_image)) {
                $imagePath = ROOTPATH . '/public/img/uploads/designs/' . $design->main_image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $this->db->commitTransaction();
            return $result;
        } catch (Exception $e) {
            $this->db->rollbackTransaction();
            error_log("Error deleting design: " . $e->getMessage());
            return false;
        }
    }


    public function updateDesign($data)
    {
        $this->db->query('
        UPDATE designs 
        SET gender = :gender,
            category_id = :category_id,
            subcategory_id = :subcategory_id,
            name = :name,
            description = :description,
            main_image = :main_image,
            base_price = :base_price,
            status = :status
        WHERE design_id = :design_id AND user_id = :user_id
    ');

        $this->db->bind(':design_id', $data['design_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':subcategory_id', $data['subcategory_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':main_image', $data['main_image']);
        $this->db->bind(':base_price', $data['base_price']);
        $this->db->bind(':status', $data['status']);

        return $this->db->execute();
    }
    /**
     * Get all customization choices for a design
     */
    public function getDesignCustomizationChoices($designId)
    {
        $this->db->query('
        SELECT c.*, t.name as type_name, t.type_id
        FROM customization_choices c
        JOIN design_customizations dc ON c.choice_id = dc.choice_id
        JOIN customization_types t ON c.type_id = t.type_id
        WHERE dc.design_id = :design_id
    ');
        $this->db->bind(':design_id', $designId);
        return $this->db->resultSet();
    }

    /**
     * Get all fabrics associated with a design
     */
    public function getDesignFabrics($designId)
    {
        $this->db->query('
        SELECT df.*, f.fabric_name, f.price_per_meter, f.image
        FROM design_fabrics df
        JOIN fabrics f ON df.fabric_id = f.fabric_id
        WHERE df.design_id = :design_id
    ');
        $this->db->bind(':design_id', $designId);
        return $this->db->resultSet();
    }

    /**
     * Remove customization choices that were not selected during edit
     */
    public function removeUnselectedCustomizationChoices($designId, $choiceIds)
    {
        // Convert to a comma-separated string of IDs for the query
        $choiceIdsStr = implode(',', array_map('intval', $choiceIds));

        $this->db->query('
        DELETE FROM design_customizations 
        WHERE design_id = :design_id 
        AND choice_id NOT IN (' . $choiceIdsStr . ')
    ');
        $this->db->bind(':design_id', $designId);
        return $this->db->execute();
    }

    /**
     * Remove all customization choices for a design
     */
    public function removeAllCustomizationChoices($designId)
    {
        $this->db->query('
        DELETE FROM design_customizations 
        WHERE design_id = :design_id
    ');
        $this->db->bind(':design_id', $designId);
        return $this->db->execute();
    }

    /**
     * Remove all fabric associations for a design
     */
    public function removeAllDesignFabrics($designId)
    {
        $this->db->query('
        DELETE FROM design_fabrics
        WHERE design_id = :design_id
    ');
        $this->db->bind(':design_id', $designId);
        return $this->db->execute();
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
