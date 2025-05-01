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
            return [];
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
        $choiceId = $this->db->lastInsertId();
        $this->db->query('
            INSERT INTO design_customizations (design_id, choice_id)
            VALUES (:design_id, :choice_id)
        ');

        $this->db->bind(':design_id', $data['design_id']);
        $this->db->bind(':choice_id', $choiceId);

        return $this->db->execute();
    }
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
        $this->db->bind(':name', $data['name']);
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
            $this->db->query('DELETE FROM design_customizations WHERE design_id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();

            $this->db->query('DELETE FROM design_fabrics WHERE design_id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();

            $this->db->query('DELETE FROM design_measurements WHERE design_id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();

            $design = $this->getDesignById($id);

            $this->db->query('DELETE FROM designs WHERE design_id = :id');
            $this->db->bind(':id', $id);
            $result = $this->db->execute();

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

    public function removeAllCustomizationChoices($designId)
    {
        $this->db->query('
        DELETE FROM design_customizations 
        WHERE design_id = :design_id
    ');
        $this->db->bind(':design_id', $designId);
        return $this->db->execute();
    }

    public function removeAllDesignFabrics($designId)
    {
        $this->db->query('
        DELETE FROM design_fabrics
        WHERE design_id = :design_id
    ');
        $this->db->bind(':design_id', $designId);
        return $this->db->execute();
    }


    public function getCategoryMeasurements($categoryId)
    {
        $this->db->query('
        SELECT m.*, cm.is_required, cm.display_order
        FROM measurements m
        JOIN category_measurements cm ON m.measurement_id = cm.measurement_id
        WHERE cm.category_id = :category_id
        ORDER BY cm.display_order, m.display_name
    ');
        $this->db->bind(':category_id', $categoryId);
        return $this->db->resultSet();
    }

    public function addDesignMeasurements($designId, $measurementIds, $isRequired = array())
    {
        foreach ($measurementIds as $measurementId) {
            $required = isset($isRequired[$measurementId]) ? $isRequired[$measurementId] : 1;

            $this->db->query('
            INSERT INTO design_measurements (design_id, measurement_id, is_required)
            VALUES (:design_id, :measurement_id, :is_required)
        ');

            $this->db->bind(':design_id', $designId);
            $this->db->bind(':measurement_id', $measurementId);
            $this->db->bind(':is_required', $required);

            if (!$this->db->execute()) {
                return false;
            }
        }

        return true;
    }

  
    public function addCustomDesignMeasurement($data)
    {
        $this->db->query('
        INSERT INTO custom_design_measurements 
        (design_id, name, display_name, description, is_required, unit_type)
        VALUES (:design_id, :name, :display_name, :description, :is_required, :unit_type)
    ');

        $this->db->bind(':design_id', $data['design_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':display_name', $data['display_name']);
        $this->db->bind(':description', $data['description'] ?? null);
        $this->db->bind(':is_required', $data['is_required'] ?? 1);
        $this->db->bind(':unit_type', $data['unit_type']);

        return $this->db->execute();
    }
    public function getDesignMeasurements($designId)
    {
        $this->db->query('
        SELECT dm.*, m.name, m.display_name, m.description, m.unit_type
        FROM design_measurements dm
        JOIN measurements m ON dm.measurement_id = m.measurement_id
        WHERE dm.design_id = :design_id
        ORDER BY dm.display_order
    ');
        $this->db->bind(':design_id', $designId);
        return $this->db->resultSet();
    }

    public function getCustomDesignMeasurements($designId)
    {
        $this->db->query('
        SELECT *
        FROM custom_design_measurements
        WHERE design_id = :design_id
        ORDER BY display_order
    ');
        $this->db->bind(':design_id', $designId);
        return $this->db->resultSet();
    }

    public function removeAllDesignMeasurements($designId)
    {
        $this->db->query('
        DELETE FROM design_measurements
        WHERE design_id = :design_id
    ');
        $this->db->bind(':design_id', $designId);
        return $this->db->execute();
    }

    public function removeAllCustomDesignMeasurements($designId)
    {
        $this->db->query('
        DELETE FROM custom_design_measurements
        WHERE design_id = :design_id
    ');
        $this->db->bind(':design_id', $designId);
        return $this->db->execute();
    }
    public function updateCustomDesignMeasurement($data)
    {
        $this->db->query('
        UPDATE custom_design_measurements
        SET name = :name,
            display_name = :display_name,
            description = :description,
            is_required = :is_required,
            unit_type = :unit_type
        WHERE id = :id AND design_id = :design_id
    ');

        $this->db->bind(':id', $data['id']);
        $this->db->bind(':design_id', $data['design_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':display_name', $data['display_name']);
        $this->db->bind(':description', $data['description'] ?? null);
        $this->db->bind(':is_required', $data['is_required'] ?? 1);
        $this->db->bind(':unit_type', $data['unit_type']);

        return $this->db->execute();
    }

    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }

    public function commitTransaction()
    {
        return $this->db->commitTransaction();
    }

    public function rollbackTransaction()
    {
        return $this->db->rollbackTransaction();
    }
}
