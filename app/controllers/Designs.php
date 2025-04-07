<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
require_once APPROOT . '/controllers/Users.php';

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
            redirect('designs/addCustomizeItem');
        }

        $design_data = $_SESSION['design_data'];
        $category = $this->designModel->getCategoryById($design_data['category_id']);
        $subcategory = $this->designModel->getSubcategoryById($design_data['subcategory_id']);
        $customization_types = $this->designModel->getCustomizationTypes();

        // Try to get user-specific fabrics
        $fabrics = $this->designModel->getFabricsByUserId($_SESSION['user_id']);

        // If no fabrics found, use the general fabrics method as fallback
        if (empty($fabrics)) {
            error_log("No user-specific fabrics found, using general fabrics");
            $fabrics = $this->designModel->getFabrics();
        }

        $data = [
            'title' => 'Customize Design',
            'design_data' => $design_data,
            'category' => $category,
            'subcategory' => $subcategory,
            'customization_types' => $customization_types,
            'fabrics' => $fabrics
        ];

        $this->view('users/Tailor/v_t_customize_add_new_continue', $data);
    }

    public function saveDesign()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST array
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Retrieve design data from session
            if (!isset($_SESSION['design_data'])) {
                redirect('designs/addCustomizeItem');
                return;
            }
            $design_data = $_SESSION['design_data'];

            // Handle image upload
            $main_image = $this->uploadImage($_FILES['main_image']);

            if (!$main_image) {
                $data = [
                    'design_data' => $design_data,
                    'customization_types' => $this->designModel->getCustomizationTypes(),
                    'fabrics' => $this->designModel->getFabricsByUserId($_SESSION['user_id']),
                    'image_error' => 'Image upload failed'
                ];
                $this->view('users/Tailor/v_t_customize_add_new_continue', $data);
                return;
            }

            $data = [
                'user_id' => $_SESSION['user_id'],
                'gender' => $design_data['gender'],
                'category_id' => $design_data['category_id'],
                'subcategory_id' => $design_data['subcategory_id'],
                'name' => $design_data['design_name'],
                'description' => $_POST['description'] ?? '', // Add a description field in the form
                'main_image' => $main_image,
                'base_price' => $design_data['base_price']
            ];

            // Add design to database
            $designId = $this->designModel->addDesign($data);

            if ($designId) {
                // Handle customization choices and fabrics (implementation needed)
                // ...

                // Clear session data
                unset($_SESSION['design_data']);

                // Redirect to success page or design listing
                redirect('designs/displayCustomizeItemDetails');
            } else {
                // Handle error
                $data = [
                    'design_data' => $design_data,
                    'customization_types' => $this->designModel->getCustomizationTypes(),
                    'fabrics' => $this->designModel->getFabrics(),
                    'error' => 'Failed to save design'
                ];
                $this->view('users/Tailor/v_t_customize_add_new_continue', $data);
            }
        } else {
            redirect('designs/addCustomizeItem');
        }
    }

    private function uploadImage($file)
    {
        if ($file['error'] == 0) {
            $uploadDir = 'public/img/';
            $filename = uniqid() . '_' . basename($file['name']);
            $targetPath = $uploadDir . $filename;

            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                return $filename; // Store only the filename in the database
            }
        }
        return false;
    }
}
