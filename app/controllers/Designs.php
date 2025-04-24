<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
require_once APPROOT . '/controllers/Users.php';
require_once APPROOT . '/helpers/FileUploader.php';

class Designs extends Controller
{
    private $designModel;
    private $fabricModel;

    public function __construct()
    {
        $this->designModel = $this->model('M_Designs');
        $this->fabricModel = $this->model('M_Fabrics');
    }

    public function index() {}
    // Customer Views of Designs
    public function selectFabric()
    {
        $data = [
            'title' => 'Select Fabric '
        ];
        $this->view('Designs/v_d_select_fabric', $data);
    }

    public function selectColor()
    {
        $data = [
            'title' => 'Select Color '
        ];
        $this->view('Designs/v_d_select_color', $data);
    }

    public function enterMeasurement()
    {
        $data = [
            'title' => 'Enter Measurement '
        ];
        $this->view('Designs/v_d_enter_measurement', $data);
    }

    public function collarDesigns()
    {
        $data = [
            'title' => 'Collar Designs '
        ];
        $this->view('Designs/v_d_collar_designs', $data);
    }

    public function cuffDesigns()
    {
        $data = [
            'title' => 'Cuff Designs '
        ];
        $this->view('Designs/v_d_cuff_designs', $data);
    }

    public function appointment()
    {
        // Check if the user is logged in
        if (!isLoggedIn()) {
            $_SESSION['redirect_url'] = 'designs/appointment';
            redirect('users/login');
            exit();
        }
        $data = [
            'title' => 'Appointment'
        ];
        $this->view('Designs/v_d_appointment', $data);
    }
    public function placedOrder()
    {
        $data = [
            'title' => 'Placed Order '
        ];
        $this->view('Designs/v_d_placed_order', $data);
    }

    public function payments()
    {
        $data = [
            'title' => 'Payments '
        ];
        $this->view('Designs/v_d_payments', $data);
    }

    // Tailor Views of Designs


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
            redirect('designs/addCustomizeItem'); // Redirect to the first step
            return; // Stop execution
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

        // Log if no customization types are found for the category
        if (empty($customization_types)) {
            error_log("No specific customization types found for category ID: " . $categoryId . ". Consider adding associations or a fallback.");
            // Optional: You could fall back to general types if needed
            // $customization_types = $this->designModel->getCustomizationTypes();
        }


        // Try to get user-specific fabrics (or general)
        $fabrics = $this->designModel->getFabricsByUserId($_SESSION['user_id']);
        if (empty($fabrics)) {
            error_log("No user-specific fabrics found for user ID: " . $_SESSION['user_id'] . ", using general fabrics");
            $fabrics = $this->designModel->getFabrics(); // Assuming getFabrics() exists and gets all fabrics
        }

        $data = [
            'title' => 'Customize Design',
            'design_data' => $design_data,
            'category' => $category,
            'subcategory' => $subcategory,
            'customization_types' => $customization_types, // Use the category-specific types
            'fabrics' => $fabrics
        ];

        // Load the view
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
                    'main_image' => $main_image, // Store filename, not binary data
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

                // Commit transaction
                $this->designModel->commitTransaction();

                // Clear session design data
                unset($_SESSION['design_data']);

                // Success message and redirect
                flash('design_success', 'Design has been successfully saved!', 'alert alert-success');
                redirect('Tailors/displayCustomizeItems');
            } catch (Exception $e) {
                // Rollback transaction on error
                $this->designModel->rollbackTransaction();

                // Log the error
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
        // Check if user is logged in
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

                    // Handle existing choices
                    if (isset($_POST['existing_choices'])) {
                        $this->designModel->removeUnselectedCustomizationChoices($id, $_POST['existing_choices']);
                    } else {
                        $this->designModel->removeAllCustomizationChoices($id);
                    }

                    // ADD THIS CODE: Process new customization choices
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

                    // ADD THIS CODE: Handle fabrics
                    $this->designModel->removeAllDesignFabrics($id);

                    // Then add the selected fabrics
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

            $data = [
                'title' => 'Edit Design',
                'design' => $design,
                'categories' => $categories,
                'subcategories' => $subcategories,
                'customization_types' => $customization_types,
                'design_choices' => $design_choices,
                'design_fabrics' => $design_fabrics,
                'fabrics' => $fabrics,
                'errors' => []
            ];

            $this->view('users/Tailor/v_t_customize_edit', $data);
        }
    }
}
