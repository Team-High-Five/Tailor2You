<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';

class Customers extends Controller
{
    private $userModel;
    private $customerModel;

    public function __construct()
    {
        $this->userModel = $this->model('M_Users');
        $this->customerModel = $this->model('M_Customers');
    }
    public function index()
    {
        $data = [
            'title' => 'Home Page'
        ];
        $this->view('pages/v_home_page', $data);
    }
    public function customerRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Input data
            $data = [
                'user_type' => 'customer',
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
                $_SESSION['customer_register_data'] = $data;

                // Redirect to create password page
                redirect('Customers/createPassword');
            } else {
                // Load view with errors
                $this->view('users/Customer/v_c_register', $data);
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
            $this->view('users/Customer/v_c_register', $data);
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
                $customerData = $_SESSION['customer_register_data'];
                $customerData['password'] = $data['password'];

                // Register customer
                if ($this->userModel->register($customerData)) {
                    flash('register_success', 'You are registered and can log in');
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('users/Customer/v_c_createpassword', $data);
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
            $this->view('users/Customer/v_c_createpassword', $data);
        }
    }

    public function viewProfile()
    {
        $customer = $this->userModel->getUserById($_SESSION['user_id']);

        if (!$customer) {
            flash('profile_message', 'Customer not found', 'alert alert-danger');
            redirect('customers/index');
        }

        $data = [
            'title' => 'Profile',
            'user' => $customer,
            'first_name_err' => '',
            'last_name_err' => '',
            'email_err' => '',
            'phone_number_err' => '',
            'nic_err' => '',
            'birth_date_err' => '',
            'home_town_err' => '',
            'address_err' => '',
            'profile_pic_err' => ''
        ];

        $this->view('users/Customer/v_c_user_info', $data);
    }


    public function profileUpdate()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'customer') {
            redirect('users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $profilePic = null;
            if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
                $profilePic = file_get_contents($_FILES['profile_pic']['tmp_name']);
            }

            $customer = $this->userModel->getUserById($_SESSION['user_id']);

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
                'status' => trim($_POST['status']),
                'category' => trim($_POST['category']),
                'profile_pic' => $profilePic,
                'user' => $customer,
                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'phone_number_err' => '',
                'nic_err' => '',
                'birth_date_err' => '',
                'home_town_err' => '',
                'address_err' => '',
                'profile_pic_err' => '',
            ];

            if (!preg_match('/^\d{12}$/', $data['nic']) && !preg_match('/^\d{9}[VXvx]$/', $data['nic'])) {
                $data['nic_err'] = 'NIC must be either 12 digits long with only numbers, or 10 digits with V or X at the end.';
            }

            if (empty($data['nic_err'])) {
                if ($this->userModel->updateUser($data)) {
                    flash('profile_message', 'Profile updated successfully');
                    $customer = $this->userModel->getUserById($_SESSION['user_id']);
                    $this->updateCustomerSession($customer);
                    redirect('customers/profileUpdate');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('users/Customer/v_c_profile', $data);
            }
        } else {
            $customer = $this->userModel->getUserById($_SESSION['user_id']);

            if (!$customer) {
                flash('profile_message', 'Customer not found', 'alert alert-danger');
                redirect('customers/index');
            }

            $data = [
                'title' => 'Profile Update',
                'user' => $customer,
                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'phone_number_err' => '',
                'nic_err' => '',
                'birth_date_err' => '',
                'home_town_err' => '',
                'address_err' => '',
                'profile_pic_err' => ''
            ];

            $this->view('users/Customer/v_c_profile', $data);
        }
    }

    private function updateCustomerSession($customer)
    {
        $_SESSION['user_id'] = $customer->user_id;
        $_SESSION['user_profile_pic'] = $customer->profile_pic;
        $_SESSION['user_first_name'] = $customer->first_name;
        $_SESSION['user_last_name'] = $customer->last_name;
        $_SESSION['user_email'] = $customer->email;
        $_SESSION['user_phone_number'] = $customer->phone_number;
        $_SESSION['user_nic'] = $customer->nic;
        $_SESSION['user_birth_date'] = $customer->birth_date;
        $_SESSION['user_home_town'] = $customer->home_town;
        $_SESSION['user_address'] = $customer->address;
        $_SESSION['user_bio'] = $customer->bio;
        $_SESSION['user_category'] = $customer->category;
    }




    public function orders()
    {
        $data = [
            'title' => 'orders'
        ];
        $this->view('users/Customer/v_c_orders', $data);
    }

    public function addPants() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $measurementData = [];
            foreach ($_POST['measurements'] as $id => $value) {
                if (!empty($value)) {
                    $cm_value = ($_POST['measurement_unit'] === 'inch') ? 
                               $value * 2.54 : $value;
                    $inch_value = ($_POST['measurement_unit'] === 'cm') ? 
                                 $value * 0.393701 : $value;

                    $measurementData[] = [
                        'id' => $id,
                        'cm' => $cm_value,
                        'inch' => $inch_value
                    ];
                }
            }
            $data = [
                'user_id' => $_SESSION['user_id'],
                'measurements' => $measurementData
            ];

            if ($this->customerModel->updateUserMeasurements($data)) {
                flash('measurement_message', 'Measurements updated successfully');
                redirect('Customers/addPants');
            } else {
                die('Something went wrong');
            }
        } else {
            $measurements = $this->customerModel->getPantMeasurements($_SESSION['user_id']);

            $data = [
                'title' => 'Add Pant Measurements',
                'measurements' => $measurements
            ];

            $this->view('users/Customer/v_c_addpants', $data);
        }
    }

            

    public function addShirts() {
        if (!isset($_SESSION['user_id'])) {
            redirect('Users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $measurementData = [];
            foreach ($_POST['measurements'] as $id => $value) {
                if (!empty($value)) {
                    $cm_value = ($_POST['measurement_unit'] === 'inch') ? 
                               $value * 2.54 : $value;
                    $inch_value = ($_POST['measurement_unit'] === 'cm') ? 
                                 $value * 0.393701 : $value;

                    $measurementData[] = [
                        'id' => $id,
                        'cm' => $cm_value,
                        'inch' => $inch_value
                    ];
                }
            }

            $data = [
                'user_id' => $_SESSION['user_id'],
                'measurements' => $measurementData
            ];

            if ($this->customerModel->updateUserMeasurements($data)) {
                flash('measurement_message', 'Measurements updated successfully');
                redirect('Customers/addShirts');
            } else {
                die('Something went wrong');
            }
        } else {
            $measurements = $this->customerModel->getShirtMeasurements($_SESSION['user_id']);

            $data = [
                'title' => 'Add Shirt Measurements',
                'measurements' => $measurements
            ];

            $this->view('users/Customer/v_c_addshirt', $data);
        }
    }

    public function changepassword()
    {
        $data = [
            'title' => 'Change Password'
        ];
        $this->view('users/Customer/v_c_changepassword', $data);
    }

    public function updateDetails()
    {
        $data = [
            'title' => 'Update details'
        ];
        $this->view('users/Customer/v_c_updateDetails', $data);
    }
    public function cart()
    {
        $data = [
            'title' => 'Cart'
        ];
        $this->view('users/Customer/v_c_cart', $data);
    }
    public function displayAppointments()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $appointments = $this->customerModel->getCustomerAppointments($_SESSION['user_id']);

        $data = [
            'title' => 'Appointments',
            'appointments' => $appointments
        ];

        $this->view('users/Customer/v_c_appointments', $data);
    }

    public function displayOrders()
    {
        $data = [
            'title' => 'Orders'
        ];
        $this->view('users/Customer/v_c_orders', $data);
    }

    public function ordersViews()
    {
        $data = [
            'title' => 'OrdersView'
        ];
        $this->view('users/Customer/v_c_order_details', $data);
    }
}
