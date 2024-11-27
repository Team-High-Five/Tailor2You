<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';

class Shopkeepers extends Controller
{
    private $shopkeeperModel;

    public function __construct()
    {
        $this->shopkeeperModel = $this->model('M_Shopkeepers');
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard'
        ];

        $this->view('users/Shopkeeper/v_s_dashboard', $data);
    }

    public function profileUpdate()
    {
        if (!isset($_SESSION['shopkeeper_id'])) {
            redirect('users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $profilePic = null;
            if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
                $profilePic = file_get_contents($_FILES['profile_pic']['tmp_name']);
            }

            $shopkeeper = $this->shopkeeperModel->getShopkeeperById($_SESSION['shopkeeper_id']);

            $data = [
                'title' => 'Profile Update',
                'shopkeeper_id' => $_SESSION['shopkeeper_id'],
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
                'shopkeeper' => $shopkeeper,
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

            if (!preg_match('/^\d{12}$/', $data['nic']) && !preg_match('/^\d{9}[VXvx]$/', $data['nic'])) {
                $data['nic_err'] = 'NIC must be either 12 digits long with only numbers, or 10 digits with V or X at the end.';
            }

            if (empty($data['nic_err'])) {
                if ($this->shopkeeperModel->updateShopkeeper($data)) {
                    flash('profile_message', 'Profile updated successfully');
                    $this->updateShopkeeperSession($data);
                    redirect('shopkeepers/profileUpdate');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('users/Shopkeeper/v_s_profile', $data);
            }
        } else {
            $shopkeeper = $this->shopkeeperModel->getShopkeeperById($_SESSION['shopkeeper_id']);

            if (!$shopkeeper) {
                flash('profile_message', 'Shopkeeper not found', 'alert alert-danger');
                redirect('shopkeepers/index');
            }

            $data = [
                'title' => 'Profile Update',
                'shopkeeper' => $shopkeeper,
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

            $this->view('users/Shopkeeper/v_s_profile', $data);
        }
    }

    private function updateShopkeeperSession($data)
    {
        $_SESSION['shopkeeper_profile_pic'] = $data['profile_pic'];
        $_SESSION['shopkeeper_first_name'] = $data['first_name'];
        $_SESSION['shopkeeper_last_name'] = $data['last_name'];
        $_SESSION['shopkeeper_email'] = $data['email'];
    }

    public function displayStock()
    {
        $data = [
            'title' => 'Stock'
        ];
        $this->view('users/Shopkeeper/v_s_stock', $data);
    }

    public function addNewItem()
    {
        $data = [
            'title' => 'Add New Item'
        ];
        $this->view('users/Shopkeeper/v_s_add_new_item', $data);
    }

    public function displayOrders()
    {
        $data = [
            'title' => 'Orders'
        ];
        $this->view('users/Shopkeeper/v_s_order_list', $data);
    }

    public function displayOrderDetails()
    {
        $data = [
            'title' => 'Order Details'
        ];
        $this->view('users/Shopkeeper/v_s_order_item_details', $data);
    }

    public function displayAppointments()
    {
        $data = [
            'title' => 'Appointments'
        ];
        $this->view('users/Shopkeeper/v_s_appointment_list', $data);
    }

    public function displayAppointmentDetails()
    {
        $data = [
            'title' => 'Appointment Details'
        ];
        $this->view('users/Shopkeeper/v_s_appointment_card', $data);
    }

    public function displayCalendar()
    {
        $data = [
            'title' => 'Calendar'
        ];
        $this->view('users/Shopkeeper/v_s_calendar', $data);
    }

    public function shopkeeperRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

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

            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                if ($this->model('M_Shopkeepers')->findShopkeeperByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';
                }
            }

            if (empty($data['first_name'])) {
                $data['first_name_err'] = 'Please enter first name';
            }

            if (empty($data['last_name'])) {
                $data['last_name_err'] = 'Please enter last name';
            }

            if (empty($data['phone_number'])) {
                $data['phone_number_err'] = 'Please enter phone number';
            }

            if (empty($data['nic'])) {
                $data['nic_err'] = 'Please enter NIC number';
            }

            if (empty($data['birth_date'])) {
                $data['birth_date_err'] = 'Please enter birth date';
            }

            if (empty($data['home_town'])) {
                $data['home_town_err'] = 'Please enter home town';
            }

            if (empty($data['address'])) {
                $data['address_err'] = 'Please enter address';
            }

            if (empty($data['email_err']) && empty($data['first_name_err']) && empty($data['last_name_err']) && empty($data['phone_number_err']) && empty($data['nic_err']) && empty($data['birth_date_err']) && empty($data['home_town_err']) && empty($data['address_err'])) {
                $_SESSION['shopkeeper_register_data'] = $data;
                redirect('shopkeepers/createPassword');
            } else {
                $this->view('users/v_s_register', $data);
            }
        } else {
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

            $this->view('users/v_s_register', $data);
        }
    }

    public function createPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            if (empty($data['password_err']) && empty($data['confirm_password_err'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                $shopkeeperData = $_SESSION['shopkeeper_register_data'];
                $shopkeeperData['password'] = $data['password'];

                if ($this->shopkeeperModel->register($shopkeeperData)) {
                    flash('register_success', 'You are registered and can log in');
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('users/v_createpassword', $data);
            }
        } else {
            $data = [
                'password' => '',
                'confirm_password' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            $this->view('users/v_createpassword', $data);
        }
    }
}