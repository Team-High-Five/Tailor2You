<?php
require_once APPROOT . '/helpers/url_helper.php';

require_once APPROOT . '/helpers/session_helper.php';

class Tailors extends Controller
{
    private $tailorModel;
    public function __construct()
    {
        $this->tailorModel = $this->model('M_Tailors');
    }

    public function index()
    {

        $data = [
            'title' => 'Dashboard'
        ];

        $this->view('users/Tailor/v_t_dashboard', $data);
    }

public function profileUpdate()
{
    // Check if the user is logged in
    if (!isset($_SESSION['tailor_id'])) {
        redirect('users/login');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Process form
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Handle file upload
        $profilePic = null;
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
            $profilePic = file_get_contents($_FILES['profile_pic']['tmp_name']);
        }

        $data = [
            'tailor_id' => $_SESSION['tailor_id'],
            'first_name' => trim($_POST['first_name']),
            'last_name' => trim($_POST['last_name']),
            'email' => trim($_POST['email']),
            'phone_number' => trim($_POST['phone_number']),
            'nic' => trim($_POST['nic']),
            'birth_date' => trim($_POST['birth_date']),
            'home_town' => trim($_POST['home_town']),
            'address' => trim($_POST['address']),
            'bio' => trim($_POST['bio']),
            'category' => trim($_POST['category']),
            'profile_pic' => $profilePic
        ];

        // Update tailor details
        if ($this->tailorModel->updateTailor($data)) {
            flash('profile_message', 'Profile updated successfully');
            redirect('tailors/profileUpdate');
        } else {
            die('Something went wrong');
        }
    } else {
        // Get tailor details
        $tailor = $this->tailorModel->getTailorById($_SESSION['tailor_id']);

        // Check if tailor exists
        if (!$tailor) {
            flash('profile_message', 'Tailor not found', 'alert alert-danger');
            redirect('tailors/index');
        }

        $data = [
            'title' => 'Profile Update',
            'tailor' => $tailor
        ];

        $this->view('users/Tailor/v_t_profile', $data);
    }
}

    public function displayFabricStock()
    {

        $data = [
            'title' => 'Fabric Stock'
        ];
        $this->view('users/Tailor/v_t_fabric_stock', $data);
    }

    public function addNewFabric()
    {
        $data = [
            'title' => 'Add New Fabric'
        ];
        $this->view('users/Tailor/v_t_add_new_fabric', $data);
    }

    public function displayOrders()
    {

        $data = [
            'title' => 'Orders'
        ];
        $this->view('users/Tailor/v_t_order_list', $data);
    }

    public function displayOrderProgress()
    {

        $data = [
            'title' => 'Order Progress'
        ];
        $this->view('users/Tailor/v_t_order_progress', $data);
    }

    public function displayOrderDetails()
    {

        $data = [
            'title' => 'Order Details'
        ];
        $this->view('users/Tailor/v_t_order_item_details', $data);
    }

    public function tailorRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Input data
            $data = [
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'email' => trim($_POST['email']),
                'phone_number' => trim($_POST['phone_number']),
                'nic' => trim($_POST['NIC']),
                'birth_date' => trim($_POST['birth_date']),
                'home_town' => trim($_POST['home_town']),
                'address' => trim($_POST['address']),
                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'phone_number_err' => '',
                'nic_err' => '',
                'birth_date_err' => '',
                'home_town_err' => '',
                'address_err' => ''
            ];

            // Validate inputs
            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                // Check email
                if ($this->model('M_Tailors')->findTailorByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';
                }
            }

            // Validate first name
            if (empty($data['first_name'])) {
                $data['first_name_err'] = 'Please enter first name';
            }

            // Validate last name
            if (empty($data['last_name'])) {
                $data['last_name_err'] = 'Please enter last name';
            }

            // Validate phone number
            if (empty($data['phone_number'])) {
                $data['phone_number_err'] = 'Please enter phone number';
            }

            // Validate NIC
            if (empty($data['nic'])) {
                $data['nic_err'] = 'Please enter NIC number';
            }

            // Validate birth date
            if (empty($data['birth_date'])) {
                $data['birth_date_err'] = 'Please enter birth date';
            }

            // Validate home town
            if (empty($data['home_town'])) {
                $data['home_town_err'] = 'Please enter home town';
            }

            // Validate address
            if (empty($data['address'])) {
                $data['address_err'] = 'Please enter address';
            }

            // Make sure errors are empty
            if (empty($data['email_err']) && empty($data['first_name_err']) && empty($data['last_name_err']) && empty($data['phone_number_err']) && empty($data['nic_err']) && empty($data['birth_date_err']) && empty($data['home_town_err']) && empty($data['address_err'])) {
                // Store validated data in session
                $_SESSION['tailor_register_data'] = $data;

                // Redirect to create password page
                redirect('tailors/createPassword');
            } else {
                // Load view with errors
                $this->view('users/v_t_register', $data);
            }
        } else {
            // Init data
            $data = [
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'phone_number' => '',
                'nic' => '',
                'birth_date' => '',
                'home_town' => '',
                'address' => '',
                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'phone_number_err' => '',
                'nic_err' => '',
                'birth_date_err' => '',
                'home_town_err' => '',
                'address_err' => ''
            ];

            // Load view
            $this->view('users/v_t_register', $data);
        }
    }

    public function createPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Input data
            $data = [
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            // Validate confirm password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            // Make sure errors are empty
            if (empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Get the rest of the data from the session
                $tailorData = $_SESSION['tailor_register_data'];
                $tailorData['password'] = $data['password'];

                // Register tailor
                if ($this->tailorModel->register($tailorData)) {
                    flash('register_success', 'You are registered and can log in');
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('users/v_createpassword', $data);
            }
        } else {
            // Init data
            $data = [
                'password' => '',
                'confirm_password' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Load view
            $this->view('users/v_createpassword', $data);
        }
    }
}