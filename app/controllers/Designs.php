<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
require_once APPROOT . '/controllers/Users.php';
require_once APPROOT . '/helpers/FileUploader.php';

class Designs extends Controller
{
    private $designModel;
    private $fabricModel;
    private $orderModel;

    public function __construct()
    {
        $this->designModel = $this->model('M_Designs');
        $this->fabricModel = $this->model('M_Fabrics');
        $this->orderModel = $this->model('M_Orders');
    }

    public function index() {}


    public function displayCustomizeItemDetails()
    {
        $data = [
            'title' => 'Customize Item Details'
        ];
        $this->view('users/Tailor/v_t_customize_item_details', $data);
    }
    public function addCustomizeItem()
    {
        $categories = $this->designModel->getCategories();

        $data = [
            'categories' => $categories,
        ];

        $this->view('users/Tailor/v_t_customize_add_new', $data);
    }
    public function getSubcategories($categoryId)
    {
        if (!$categoryId || !is_numeric($categoryId)) {
            error_log('Invalid category ID: ' . $categoryId);
            echo "<option value=''>Invalid category ID</option>";
            return;
        }

        try {
            $subcategories = $this->designModel->getSubcategoriesByCategoryId($categoryId);
            error_log('Found ' . count($subcategories) . ' subcategories for category ' . $categoryId);

            foreach ($subcategories as $subcategory) {
                echo "<option value='" . $subcategory->subcategory_id . "'>" .
                    htmlspecialchars($subcategory->name) . "</option>";
            }
        } catch (Exception $e) {
            error_log('Error in getSubcategories: ' . $e->getMessage());
            echo "<option value=''>Error loading subcategories</option>";
        }
    }
    public function addNewCustomizeItem()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_id' => $_SESSION['user_id'],
                'gender' => trim($_POST['gender']),
                'category_id' => trim($_POST['category_id']),
                'subcategory_id' => trim($_POST['subcategory_id']),
                'design_name' => trim($_POST['design_name']),
                'base_price' => trim($_POST['base_price']),
                'errors' => []
            ];

            // Validate inputs
            if (empty($data['gender'])) {
                $data['errors']['gender'] = 'Please select gender';
            }
            if (empty($data['category_id'])) {
                $data['errors']['category'] = 'Please select category';
            }
            if (empty($data['subcategory_id'])) {
                $data['errors']['subcategory'] = 'Please select subcategory';
            }
            if (empty($data['design_name'])) {
                $data['errors']['design_name'] = 'Please enter design name';
            }
            if (empty($data['base_price'])) {
                $data['errors']['base_price'] = 'Please enter base price';
            }

            // If no errors, proceed to next step
            if (empty($data['errors'])) {
                $_SESSION['design_data'] = $data;
                redirect('designs/customizeDesign');
            } else {
                // Load view with errors
                $data['categories'] = $this->designModel->getCategories();
                $this->view('users/Tailor/v_t_customize_add_new', $data);
            }
        } else {
            redirect('designs/addCustomizeItem');
        }
    }
    public function customizeDesign()
    {
        // Check if the user is logged in
        if (!isLoggedIn()) {
            $_SESSION['redirect_url'] = 'designs/customizeDesign';
            redirect('users/login');
            exit();
        }

        // Check if design data is set in session
        if (!isset($_SESSION['design_data'])) {
            // Redirect back or show an error
            flash('design_error', 'Design details not found. Please start again.', 'alert alert-danger');
            redirect('designs/addCustomizeItem'); 
            return; 
        }

        $design_data = $_SESSION['design_data'];

        // Validate category ID exists in design_data
        if (!isset($design_data['category_id']) || !is_numeric($design_data['category_id'])) {
            flash('design_error', 'Invalid category selection. Please start again.', 'alert alert-danger');
            redirect('designs/addCustomizeItem');
            return;
        }
        $categoryId = $design_data['category_id'];
        $category = $this->designModel->getCategoryById($categoryId);
        $subcategory = $this->designModel->getSubcategoryById($design_data['subcategory_id']);
        $customization_types = $this->designModel->getCustomizationTypesByCategoryId($categoryId);

        $category_measurements = $this->designModel->getCategoryMeasurements($categoryId);

        // Log if no customization types are found for the category
        if (empty($customization_types)) {
            error_log("No specific customization types found for category ID: " . $categoryId . ". Consider adding associations or a fallback.");
        }

        // Try to get user-specific fabrics (or general)
        $fabrics = $this->designModel->getFabricsByUserId($_SESSION['user_id']);
        if (empty($fabrics)) {
            error_log("No user-specific fabrics found for user ID: " . $_SESSION['user_id'] . ", using general fabrics");
            $fabrics = $this->designModel->getFabrics();
        }

        $data = [
            'title' => 'Customize Design',
            'design_data' => $design_data,
            'category' => $category,
            'subcategory' => $subcategory,
            'customization_types' => $customization_types,
            'fabrics' => $fabrics,
            'category_measurements' => $category_measurements 
        ];

        $this->view('users/Tailor/v_t_customize_add_new_continue', $data);
    }
    public function saveDesign()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Check if user is logged in
            if (!isLoggedIn()) {
                redirect('users/login');
                return;
            }

            // Load FileUploader helper
            require_once APPROOT . '/helpers/FileUploader.php';

            // Retrieve design data from session
            if (!isset($_SESSION['design_data'])) {
                redirect('designs/addCustomizeItem');
                return;
            }
            $design_data = $_SESSION['design_data'];

            // Handle main design image upload
            $main_image = FileUploader::uploadImage(
                $_FILES['main_image'],
                'designs',
                'design_' . $_SESSION['user_id'] . '_'
            );

            if (!$main_image) {
                $data = [
                    'design_data' => $design_data,
                    'category' => $this->designModel->getCategoryById($design_data['category_id']),
                    'subcategory' => $this->designModel->getSubcategoryById($design_data['subcategory_id']),
                    'customization_types' => $this->designModel->getCustomizationTypesByCategoryId($design_data['category_id']),
                    'fabrics' => $this->designModel->getFabricsByUserId($_SESSION['user_id']),
                    'image_error' => 'Failed to upload design image. Please try again.'
                ];
                $this->view('users/Tailor/v_t_customize_add_new_continue', $data);
                return;
            }

            // Begin database transaction
            $this->designModel->beginTransaction();

            try {
                // Create design data array
                $designData = [
                    'user_id' => $_SESSION['user_id'],
                    'gender' => $design_data['gender'],
                    'category_id' => $design_data['category_id'],
                    'subcategory_id' => $design_data['subcategory_id'],
                    'name' => $design_data['design_name'],
                    'description' => trim($_POST['description'] ?? ''),
                    'main_image' => $main_image, 
                    'base_price' => $design_data['base_price']
                ];

                // Add design to database
                $designId = $this->designModel->addDesign($designData);

                if (!$designId) {
                    throw new Exception("Failed to add design to database");
                }

                // Process customization choices
                if (isset($_POST['choice_name'])) {
                    foreach ($_POST['choice_name'] as $type_id => $names) {
                        foreach ($names as $index => $name) {
                            if (empty($name)) continue;

                            // Check if image exists for this choice
                            if (
                                !isset($_FILES['choice_image']['name'][$type_id][$index]) ||
                                empty($_FILES['choice_image']['name'][$type_id][$index])
                            ) {
                                continue;
                            }
                            // Setup file data for this choice
                            $fileData = [
                                'name' => $_FILES['choice_image']['name'][$type_id][$index],
                                'type' => $_FILES['choice_image']['type'][$type_id][$index],
                                'tmp_name' => $_FILES['choice_image']['tmp_name'][$type_id][$index],
                                'error' => $_FILES['choice_image']['error'][$type_id][$index],
                                'size' => $_FILES['choice_image']['size'][$type_id][$index]
                            ];
                            // Upload choice image
                            $choiceImage = FileUploader::uploadImage(
                                $fileData,
                                'customizations',
                                'custom_' . $type_id . '_'
                            );
                            if (!$choiceImage) {
                                throw new Exception("Failed to upload image for customization option");
                            }
                            // Get additional price
                            $price = !empty($_POST['choice_price'][$type_id][$index])
                                ? floatval($_POST['choice_price'][$type_id][$index])
                                : 0;
                            // Add the customization choice
                            $choiceData = [
                                'design_id' => $designId,
                                'type_id' => $type_id,
                                'name' => $name,
                                'image' => $choiceImage,
                                'price_adjustment' => $price
                            ];

                            if (!$this->designModel->addDesignCustomizationChoice($choiceData)) {
                                throw new Exception("Failed to add customization choice");
                            }
                        }
                    }
                }
                // Process selected fabrics
                if (isset($_POST['fabrics']) && is_array($_POST['fabrics'])) {
                    foreach ($_POST['fabrics'] as $fabricId) {
                        $priceAdjustment = !empty($_POST['fabric_price'][$fabricId])
                            ? floatval($_POST['fabric_price'][$fabricId])
                            : 0;

                        $fabricData = [
                            'design_id' => $designId,
                            'fabric_id' => $fabricId,
                            'price_adjustment' => $priceAdjustment
                        ];

                        if (!$this->designModel->addDesignFabric($fabricData)) {
                            throw new Exception("Failed to add design fabric");
                        }
                    }
                }
                // Process measurements
                if (isset($_POST['measurements']) && is_array($_POST['measurements'])) {
                    $measurementRequired = $_POST['measurement_required'] ?? [];
                    if (!$this->designModel->addDesignMeasurements($designId, $_POST['measurements'], $measurementRequired)) {
                        throw new Exception("Failed to save design measurements");
                    }
                }

                // Process custom measurements
                if (isset($_POST['custom_name']) && is_array($_POST['custom_name'])) {
                    foreach ($_POST['custom_name'] as $index => $name) {
                        if (empty($name)) continue;

                        $customMeasurementData = [
                            'design_id' => $designId,
                            'name' => $name,
                            'display_name' => $_POST['custom_display_name'][$index] ?? $name,
                            'description' => $_POST['custom_description'][$index] ?? null,
                            'is_required' => $_POST['custom_required'][$index] ?? 1,
                            'unit_type' => $_POST['custom_unit_type'][$index] ?? 'length'
                        ];

                        if (!$this->designModel->addCustomDesignMeasurement($customMeasurementData)) {
                            throw new Exception("Failed to add custom measurement");
                        }
                    }
                }

                // Commit transaction
                $this->designModel->commitTransaction();

                unset($_SESSION['design_data']);
                flash('design_success', 'Design has been successfully saved!', 'alert alert-success');
                redirect('Tailors/displayCustomizeItems');
            } catch (Exception $e) {
                // Rollback transaction on error
                $this->designModel->rollbackTransaction();
                error_log('Error in saveDesign: ' . $e->getMessage());
                // Show error to user
                $data = [
                    'design_data' => $design_data,
                    'category' => $this->designModel->getCategoryById($design_data['category_id']),
                    'subcategory' => $this->designModel->getSubcategoryById($design_data['subcategory_id']),
                    'customization_types' => $this->designModel->getCustomizationTypesByCategoryId($design_data['category_id']),
                    'fabrics' => $this->designModel->getFabricsByUserId($_SESSION['user_id']),
                    'error' => 'Failed to save design: ' . $e->getMessage()
                ];
                $this->view('users/Tailor/v_t_customize_add_new_continue', $data);
            }
        } else {
            redirect('designs/addCustomizeItem');
        }
    }
    public function deleteDesign($id = null)
    {
        if (!isLoggedIn()) {
            redirect('users/login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($id)) {
            // Check if the design belongs to the current user
            $design = $this->designModel->getDesignById($id);

            if ($design && $design->user_id == $_SESSION['user_id']) {
                // Delete the design
                if ($this->designModel->deleteDesign($id)) {
                    flash('design_message', 'Design removed successfully');
                } else {
                    flash('design_message', 'Failed to remove design', 'alert alert-danger');
                }
            } else {
                flash('design_message', 'Unauthorized action', 'alert alert-danger');
            }
        }

        redirect('tailors/displayCustomizeItems');
    }
    public function editDesign($id = null)
    {
        if (!isLoggedIn()) {
            redirect('users/login');
            return;
        }

        if (!$id) {
            flash('design_error', 'No design specified', 'alert alert-danger');
            redirect('tailors/displayCustomizeItems');
            return;
        }

        $design = $this->designModel->getDesignById($id);

        if (!$design || $design->user_id != $_SESSION['user_id']) {
            flash('design_error', 'Design not found or you don\'t have permission to edit it', 'alert alert-danger');
            redirect('tailors/displayCustomizeItems');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'design_id' => $id,
                'user_id' => $_SESSION['user_id'],
                'gender' => trim($_POST['gender']),
                'category_id' => trim($_POST['category_id']),
                'subcategory_id' => trim($_POST['subcategory_id']),
                'name' => trim($_POST['design_name']),
                'description' => trim($_POST['description'] ?? ''),
                'base_price' => trim($_POST['base_price']),
                'main_image' => $this->designModel->getDesignById($id)->main_image,
                'status' => trim($_POST['status']),
                'errors' => []
            ];

            if (empty($data['gender'])) {
                $data['errors']['gender'] = 'Please select gender';
            }
            if (empty($data['category_id'])) {
                $data['errors']['category'] = 'Please select category';
            }
            if (empty($data['subcategory_id'])) {
                $data['errors']['subcategory'] = 'Please select subcategory';
            }
            if (empty($data['name'])) {
                $data['errors']['design_name'] = 'Please enter design name';
            }
            if (empty($data['base_price'])) {
                $data['errors']['base_price'] = 'Please enter base price';
            }

            // Check if a new image was uploaded
            if (!empty($_FILES['main_image']['name'])) {
                // Upload new image
                $newImage = FileUploader::uploadImage(
                    $_FILES['main_image'],
                    'designs',
                    'design_' . $_SESSION['user_id'] . '_'
                );

                if (!$newImage) {
                    $data['errors']['main_image'] = 'Failed to upload image. Please try a different file.';
                } else {
                    $data['main_image'] = $newImage;

                    // Delete old image if it exists
                    $oldImage = $this->designModel->getDesignById($id)->main_image;
                    if (!empty($oldImage)) {
                        $oldImagePath = ROOTPATH . '/public/img/uploads/designs/' . $oldImage;
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                }
            }
            if (empty($data['errors'])) {
                $this->designModel->beginTransaction();
                try {
                    // Update basic design info
                    if (!$this->designModel->updateDesign($data)) {
                        throw new Exception("Failed to update design basic information");
                    }

                    if (isset($_POST['existing_choices'])) {
                        $this->designModel->removeUnselectedCustomizationChoices($id, $_POST['existing_choices']);
                    } else {
                        $this->designModel->removeAllCustomizationChoices($id);
                    }

                    // Process customization choices
                    if (isset($_POST['choice_name'])) {
                        foreach ($_POST['choice_name'] as $type_id => $names) {
                            foreach ($names as $index => $name) {
                                // Skip empty names
                                if (empty($name)) continue;

                                // Check if image exists for this choice
                                if (
                                    !isset($_FILES['choice_image']['name'][$type_id][$index]) ||
                                    empty($_FILES['choice_image']['name'][$type_id][$index])
                                ) {
                                    continue;
                                }

                                // Setup file data for this choice
                                $fileData = [
                                    'name' => $_FILES['choice_image']['name'][$type_id][$index],
                                    'type' => $_FILES['choice_image']['type'][$type_id][$index],
                                    'tmp_name' => $_FILES['choice_image']['tmp_name'][$type_id][$index],
                                    'error' => $_FILES['choice_image']['error'][$type_id][$index],
                                    'size' => $_FILES['choice_image']['size'][$type_id][$index]
                                ];

                                // Upload choice image
                                $choiceImage = FileUploader::uploadImage(
                                    $fileData,
                                    'customizations',
                                    'custom_' . $type_id . '_'
                                );

                                if (!$choiceImage) {
                                    throw new Exception("Failed to upload image for customization option");
                                }

                                // Get additional price
                                $price = !empty($_POST['choice_price'][$type_id][$index])
                                    ? floatval($_POST['choice_price'][$type_id][$index])
                                    : 0;

                                // Add the customization choice
                                $choiceData = [
                                    'design_id' => $id,
                                    'type_id' => $type_id,
                                    'name' => $name,
                                    'image' => $choiceImage,
                                    'price_adjustment' => $price
                                ];

                                if (!$this->designModel->addDesignCustomizationChoice($choiceData)) {
                                    throw new Exception("Failed to add customization choice");
                                }
                            }
                        }
                    }
                    // Process selected fabrics
                    $this->designModel->removeAllDesignFabrics($id);

                    if (isset($_POST['fabrics']) && is_array($_POST['fabrics'])) {
                        foreach ($_POST['fabrics'] as $fabricId) {
                            $priceAdjustment = isset($_POST['fabric_price'][$fabricId])
                                ? floatval($_POST['fabric_price'][$fabricId])
                                : 0;

                            $fabricData = [
                                'design_id' => $id,
                                'fabric_id' => $fabricId,
                                'price_adjustment' => $priceAdjustment
                            ];

                            if (!$this->designModel->addDesignFabric($fabricData)) {
                                throw new Exception("Failed to add design fabric");
                            }
                        }
                    }

                    // Process measurements
                    $this->designModel->removeAllDesignMeasurements($id);
                    if (isset($_POST['measurements']) && is_array($_POST['measurements'])) {
                        $measurementRequired = $_POST['measurement_required'] ?? [];
                        if (!$this->designModel->addDesignMeasurements($id, $_POST['measurements'], $measurementRequired)) {
                            throw new Exception("Failed to save design measurements");
                        }
                    }
                    if (isset($_POST['custom_measurement_id']) && is_array($_POST['custom_measurement_id'])) {
                        $existingIds = $_POST['custom_measurement_id'];
                        for ($i = 0; $i < count($existingIds); $i++) {
                            // Skip if no ID (shouldn't happen)
                            if (empty($existingIds[$i])) continue;

                            $customMeasurementData = [
                                'id' => $existingIds[$i],
                                'design_id' => $id,
                                'name' => $_POST['custom_name'][$i] ?? '',
                                'display_name' => $_POST['custom_display_name'][$i] ?? '',
                                'description' => $_POST['custom_description'][$i] ?? null,
                                'is_required' => $_POST['custom_required'][$i] ?? 1,
                                'unit_type' => $_POST['custom_unit_type'][$i] ?? 'length'
                            ];

                            if (!$this->designModel->updateCustomDesignMeasurement($customMeasurementData)) {
                                throw new Exception("Failed to update custom measurement");
                            }
                        }
                    }
                    $savedCustomIds = isset($_POST['custom_measurement_id']) ? count($_POST['custom_measurement_id']) : 0;
                    $totalCustom = isset($_POST['custom_name']) ? count($_POST['custom_name']) : 0;
                    if ($totalCustom > $savedCustomIds) {
                        for ($i = $savedCustomIds; $i < $totalCustom; $i++) {
                            if (empty($_POST['custom_name'][$i])) continue;

                            $customMeasurementData = [
                                'design_id' => $id,
                                'name' => $_POST['custom_name'][$i],
                                'display_name' => $_POST['custom_display_name'][$i] ?? $_POST['custom_name'][$i],
                                'description' => $_POST['custom_description'][$i] ?? null,
                                'is_required' => $_POST['custom_required'][$i] ?? 1,
                                'unit_type' => $_POST['custom_unit_type'][$i] ?? 'length'
                            ];

                            if (!$this->designModel->addCustomDesignMeasurement($customMeasurementData)) {
                                throw new Exception("Failed to add custom measurement");
                            }
                        }
                    }
                    $this->designModel->commitTransaction();
                    flash('design_success', 'Design updated successfully', 'alert alert-success');
                    redirect('tailors/displayCustomizeItems');
                } catch (Exception $e) {
                    // ...
                }
            }
        } else {
            $categories = $this->designModel->getCategories();
            $subcategories = $this->designModel->getSubcategoriesByCategoryId($design->category_id);
            $customization_types = $this->designModel->getCustomizationTypesByCategoryId($design->category_id);
            $design_choices = $this->designModel->getDesignCustomizationChoices($id);
            $design_fabrics = $this->designModel->getDesignFabrics($id);
            $fabrics = $this->designModel->getFabricsByUserId($_SESSION['user_id']);
            $category_measurements = $this->designModel->getCategoryMeasurements($design->category_id);
            $design_measurements = $this->designModel->getDesignMeasurements($id);
            $custom_measurements = $this->designModel->getCustomDesignMeasurements($id);

            $selected_measurement_ids = [];
            $measurement_required = [];
            foreach ($design_measurements as $measurement) {
                $selected_measurement_ids[] = $measurement->measurement_id;
                $measurement_required[$measurement->measurement_id] = $measurement->is_required;
            }
            $data = [
                'title' => 'Edit Design',
                'design' => $design,
                'categories' => $categories,
                'subcategories' => $subcategories,
                'customization_types' => $customization_types,
                'design_choices' => $design_choices,
                'design_fabrics' => $design_fabrics,
                'fabrics' => $fabrics,
                'category_measurements' => $category_measurements,
                'selected_measurement_ids' => $selected_measurement_ids,
                'measurement_required' => $measurement_required,
                'custom_measurements' => $custom_measurements,
                'errors' => []
            ];


            $this->view('users/Tailor/v_t_customize_edit', $data);
        }
    }
}
