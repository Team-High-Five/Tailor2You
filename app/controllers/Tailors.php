<?php
require_once APPROOT . '/helpers/url_helper.php';

require_once APPROOT . '/helpers/session_helper.php';

class Tailors extends Controller
{
    private $tailorModel;
    private $userModel;
    public function __construct()
    {
        $this->tailorModel = $this->model('M_Tailors');
        $this->userModel = $this->model('M_Users');
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
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'tailor') {
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

            // Get tailor details
            $tailor = $this->userModel->getUserById($_SESSION['user_id']);

            $data = [
                'title' => 'Profile Update',
                'user_id' => $_SESSION['user_id'],
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
                'profile_pic' => $profilePic,
                'user' => $tailor,
                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'phone_number_err' => '',
                'nic_err' => '',
                'birth_date_err' => '',
                'home_town_err' => '',
                'address_err' => '',
                'bio_err' => '',
                'category_err' => '',
                'profile_pic_err' => ''
            ];

            // Validate NIC
            if (!preg_match('/^\d{12}$/', $data['nic']) && !preg_match('/^\d{9}[VXvx]$/', $data['nic'])) {
                $data['nic_err'] = 'NIC must be either 12 digits long with only numbers, or 10 digits with V or X at the end.';
            }

            // Check for errors
            if (empty($data['nic_err'])) {
                // Update tailor details
                if ($this->userModel->updateUser($data)) {
                    flash('profile_message', 'Profile updated successfully');
                    $tailor = $this->userModel->getUserById($_SESSION['user_id']);
                    $this->updateTailorSession($tailor);
                    redirect('tailors/profileUpdate');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('users/Tailor/v_t_profile', $data);
            }
        } else {
            // Get tailor details
            $tailor = $this->userModel->getUserById($_SESSION['user_id']);

            // Check if tailor exists
            if (!$tailor) {
                flash('profile_message', 'Tailor not found', 'alert alert-danger');
                redirect('tailors/index');
            }

            $data = [
                'title' => 'Profile Update',
                'user' => $tailor,
                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'phone_number_err' => '',
                'nic_err' => '',
                'birth_date_err' => '',
                'home_town_err' => '',
                'address_err' => '',
                'bio_err' => '',
                'category_err' => '',
                'profile_pic_err' => ''
            ];

            $this->view('users/Tailor/v_t_profile', $data);
        }
    }


    private function updateTailorSession($tailor)
    {
        $_SESSION['user_id'] = $tailor->user_id;
        $_SESSION['user_profile_pic'] = $tailor->profile_pic;
        $_SESSION['user_first_name'] = $tailor->first_name;
        $_SESSION['user_last_name'] = $tailor->last_name;
        $_SESSION['user_email'] = $tailor->email;
        $_SESSION['user_phone_number'] = $tailor->phone_number;
        $_SESSION['user_nic'] = $tailor->nic;
        $_SESSION['user_birth_date'] = $tailor->birth_date;
        $_SESSION['user_home_town'] = $tailor->home_town;
        $_SESSION['user_address'] = $tailor->address;
        $_SESSION['user_bio'] = $tailor->bio;
        $_SESSION['user_category'] = $tailor->category;
        // Add any other session variables you want to update
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

    public function displayOrderMeasurements()
    {
        $data = [
            'title' => 'Order Meassurements'
        ];
        $this->view('users/Tailor/v_t_order_item_measurements', $data);
    }

    public function displayAppointments()
    {
        $data = [
            'title' => 'Appointments'
        ];
        $this->view('users/Tailor/v_t_appointment_list', $data);
    }

    public function displayAppointmentDetails()
    {
        $data = [
            'title' => 'Appointment Details'
        ];
        $this->view('users/Tailor/v_t_appointment_card', $data);
    }

    public function displayCalendar()
    {
        $data = [
            'title' => 'Calendar'
        ];
        $this->view('users/Tailor/v_t_appointment_calendar', $data);
    }

    public function displayCustomizeItems()
    {
        $data = [
            'title' => 'Customize Items'
        ];
        $this->view('users/Tailor/v_t_customize_item_list', $data);
    }

    public function displayCustomizeItemDetails()
    {
        $data = [
            'title' => 'Customize Item Details'
        ];
        $this->view('users/Tailor/v_t_customize_item_details', $data);
    }

    public function addCustomizeItem()
    {
        $data = [
            'title' => 'Add Customize Item'
        ];
        $this->view('users/Tailor/v_t_customize_add_new', $data);
    }

    public function displayPortfolio()
    {
        $posts = $this->userModel->getPostsByUserId($_SESSION['user_id']);
        $data = [
            'title' => 'Portfolio',
            'posts' => $posts
        ];
        $this->view('users/Tailor/v_t_portfolio', $data);
    }
    public function addNewPost()
    {
        $data = [
            'title' => 'Add New Post'
        ];

        $this->view('users/Tailor/v_t_add_new_post', $data);
    }

    public function addPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Handle file upload
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = file_get_contents($_FILES['image']['tmp_name']);
            }

            // Input data
            $data = [
                'user_id' => $_SESSION['user_id'],
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'image' => $image
            ];

            // Add post
            if ($this->userModel->addPost($data)) {
                flash('post_message', 'Post added successfully');
                redirect('tailors/displayPortfolio');
            } else {
                die('Something went wrong');
            }
        } else {
            $data = [
                'title' => 'Add New Post'
            ];
            $this->view('users/Tailor/v_t_add_new_post', $data);
        }
    }

    public function addNewCustomizeItem()
    {
        // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //     // Process form
        //     $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        //     // Input data
        //     $data = [
        //         'gender' => trim($_POST['gender']),
        //         'category' => trim($_POST['category']),
        //         'sub_category' => trim($_POST['sub_category']),
        //         'title' => 'Add New Customize Item'
        //     ];

        //     // Load the next view with the data
        //     $this->view('users/Tailor/v_t_customize_add_new_continue', $data);
        // } else {
        //     // Redirect to the customize items page if not a POST request
        //     redirect('tailors/displayCustomizeItems');
        // }
        // Load the next view with the data
        $data = [
            'title' => 'Add New Customize Item'
        ];
        $this->view('users/Tailor/v_t_customize_add_new_continue', $data);
    }
    public function tailorRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Input data
            $data = [
                'user_type' => 'tailor',
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
                if ($this->userModel->findUserByEmail($data['email'])) {
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
                $this->view('users/Tailor/v_t_register', $data);
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
            $this->view('users/Tailor/v_t_register', $data);
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
                if ($this->userModel->register($tailorData)) {
                    flash('register_success', 'You are registered and can log in');
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('users/Tailor/v_t_createpassword', $data);
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
            $this->view('users/Tailor/v_t_createpassword', $data);
        }
    }
}
