<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
require_once APPROOT . '/controllers/Users.php';

class Designs extends Controller
{
    private $designModel;

    public function __construct()
    {
        $this->designModel = $this->model('M_Designs');
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
        $data = ['categories' => $categories];

        $this->view('users/Tailor/v_t_customize_add_new', $data);
    }
    public function getSubcategories($categoryId)
    {
        $subcategories = $this->designModel->getSubcategoriesByCategoryId($categoryId);

        if (!empty($subcategories)) {
            foreach ($subcategories as $subcategory) {
                echo "<option value='" . $subcategory->subcategory_id . "'>" . htmlspecialchars($subcategory->name) . "</option>";
            }
        } else {
            echo "<option value=''>No subcategories found</option>";
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
}
