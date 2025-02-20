<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
require_once APPROOT . '/controllers/Fabrics.php';

class Shopkeepers extends Controller
{
    private $shopkeeperModel;
    private $userModel;
    private $fabricController;

    public function __construct()
    {
        $this->shopkeeperModel = $this->model('M_Shopkeepers');
        $this->userModel = $this->model('M_Users');
        $this->fabricController = new Fabrics();
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
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'shopkeeper') {
            redirect('users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $profilePic = null;
            if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
                $profilePic = file_get_contents($_FILES['profile_pic']['tmp_name']);
            }

            $shopkeeper = $this->userModel->getUserById($_SESSION['user_id']);

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
                'user' => $shopkeeper,
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
                if ($this->userModel->updateUser($data)) {
                    flash('profile_message', 'Profile updated successfully');
                    $shopkeeper = $this->userModel->getUserById($_SESSION['user_id']);
                    $this->updateShopkeeperSession($shopkeeper);
                    redirect('shopkeepers/profileUpdate');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('users/Shopkeeper/v_s_profile', $data);
            }
        } else {
            $shopkeeper = $this->userModel->getUserById($_SESSION['user_id']);

            if (!$shopkeeper) {
                flash('profile_message', 'Shopkeeper not found', 'alert alert-danger');
                redirect('shopkeepers/index');
            }

            $data = [
                'title' => 'Profile Update',
                'user' => $shopkeeper,
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

    private function updateShopkeeperSession($shopkeeper)
    {
        $_SESSION['user_id'] = $shopkeeper->user_id;
        $_SESSION['user_profile_pic'] = $shopkeeper->profile_pic;
        $_SESSION['user_first_name'] = $shopkeeper->first_name;
        $_SESSION['user_last_name'] = $shopkeeper->last_name;
        $_SESSION['user_email'] = $shopkeeper->email;
        $_SESSION['user_phone_number'] = $shopkeeper->phone_number;
        $_SESSION['user_nic'] = $shopkeeper->nic;
        $_SESSION['user_birth_date'] = $shopkeeper->birth_date;
        $_SESSION['user_home_town'] = $shopkeeper->home_town;
        $_SESSION['user_address'] = $shopkeeper->address;
        $_SESSION['user_bio'] = $shopkeeper->bio;
        $_SESSION['user_category'] = $shopkeeper->category;
    }

    public function displayFabricStock()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'shopkeeper') {
            redirect('users/login');
        }

        $this->fabricController->displayFabricStock($_SESSION['user_id'], 'users/Shopkeeper/v_s_fabric');
    }

    public function addNewFabric()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'shopkeeper') {
            redirect('users/login');
        }

        $this->fabricController->addNewFabric($_SESSION['user_id'], 'users/Shopkeeper/v_s_fabric_add_new', 'shopkeepers');
    }

    public function editFabric($fabric_id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'shopkeeper') {
            redirect('users/login');
        }

        $this->fabricController->editFabric($fabric_id, $_SESSION['user_id'], 'users/Shopkeeper/v_s_fabric_edit', 'shopkeepers');
    }

    public function deleteFabric($fabric_id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'shopkeeper') {
            redirect('users/login');
        }

        $this->fabricController->deleteFabric($fabric_id, $_SESSION['user_id'], 'users/Shopkeeper/v_s_fabric', 'shopkeepers');
    }

    public function addNewItem()
    {
        $data = [
            'title' => 'Add New Item'
        ];
        $this->view('users/Shopkeeper/v_s_fabric_add_new', $data);
    }

    public function displayOrders()
    {
        $data = [
            'title' => 'Orders'
        ];
        $this->view('users/Shopkeeper/v_s_order_list', $data);
    }

    public function displayOrderProgress()
    {

        $data = [
            'title' => 'Order Progress'
        ];
        $this->view('users/Shopkeeper/v_s_order_progress', $data);
    }

    public function displayOrderDetails()
    {
        $data = [
            'title' => 'Order Details'
        ];
        $this->view('users/Shopkeeper/v_s_order_item_details', $data);
    }

    public function displayOrderMeasurements()
    {
        $data = [
            'title' => 'Order Meassurements'
        ];
        $this->view('users/Shopkeeper/v_s_order_item_measurements', $data);
    }


    public function displayAppointments()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'shopkeeper') {
            redirect('users/login');
        }

        $appointments = $this->shopkeeperModel->getAppointmentsByShopkeeperId($_SESSION['user_id']);
        $data = [
            'title' => 'Appointments',
            'appointments' => $appointments
        ];
        $this->view('users/Shopkeeper/v_s_appointment_list', $data);
    }

    public function displayAppointmentDetails($appointment_id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'shopkeeper') {
            redirect('users/login');
        }

        $appointment = $this->shopkeeperModel->getAppointmentById($appointment_id);
        if (!$appointment) {
            flash('appointment_message', 'Appointment not found', 'alert alert-danger');
            redirect('shopkeepers/displayAppointments');
        }

        $appointment->profile_pic = base64_encode($appointment->profile_pic);
        $data = [
            'title' => 'Appointment Details',
            'appointment' => $appointment
        ];
        $this->view('users/Shopkeeper/v_s_appointment_card', $data);
    }

    public function rescheduleAppointment($appointment_id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'shopkeeper') {
            redirect('users/login');
        }

        $appointment = $this->shopkeeperModel->getAppointmentById($appointment_id);
        if (!$appointment) {
            flash('appointment_message', 'Appointment not found', 'alert alert-danger');
            redirect('shopkeepers/displayAppointments');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'appointment_id' => $appointment_id,
                'appointment_date' => trim($_POST['appointment_date']),
                'appointment_time' => trim($_POST['appointment_time']),
                'status' => 'pending'
            ];

            if ($this->shopkeeperModel->updateAppointment($data)) {
                flash('appointment_message', 'Appointment rescheduled successfully');
                redirect('shopkeepers/displayAppointments');
            } else {
                die('Something went wrong');
            }
        } else {
            $data = [
                'title' => 'Reschedule Appointment',
                'appointment' => $appointment
            ];
            $this->view('users/Shopkeeper/v_s_reschedule_appointment', $data);
        }
    }

    public function acceptAppointment($appointment_id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'shopkeeper') {
            redirect('users/login');
        }

        $appointment = $this->shopkeeperModel->getAppointmentById($appointment_id);
        if (!$appointment) {
            flash('appointment_message', 'Appointment not found', 'alert alert-danger');
            redirect('shopkeepers/displayAppointments');
        }

        $data = [
            'appointment_id' => $appointment_id,
            'status' => 'accepted'
        ];

        if ($this->shopkeeperModel->updateAppointmentStatus($data)) {
            flash('appointment_message', 'Appointment accepted successfully');
            redirect('shopkeepers/displayAppointments');
        } else {
            die('Something went wrong');
        }
    }

    public function displayCalendar($year = null, $month = null)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'shopkeeper') {
            redirect('users/login');
        }

        if ($year === null || $month === null) {
            $year = date('Y');
            $month = date('m');
        } else {
            $year = (int)$year;
            $month = str_pad((int)$month, 2, '0', STR_PAD_LEFT);
        }

        if ($month < 1) {
            $month = 12;
            $year--;
        } elseif ($month > 12) {
            $month = 1;
            $year++;
        }

        $appointments = $this->shopkeeperModel->getAppointmentsByMonth($_SESSION['user_id'], $year, $month);
        $data = [
            'title' => 'Calendar',
            'year' => $year,
            'month' => $month,
            'appointments' => $appointments
        ];
        $this->view('users/Shopkeeper/v_s_appointment_calendar', $data);
    }

    public function displayPortfolio()
    {
        $posts = $this->userModel->getPostsByUserId($_SESSION['user_id']);
        $data = [
            'title' => 'Portfolio',
            'posts' => $posts
        ];
        $this->view('users/Shopkeeper/v_s_portfolio', $data);
    }

    public function addNewPost()
    {
        $data = [
            'title' => 'Add New Post'
        ];

        $this->view('users/Shopkeeper/v_s_add_new_post', $data);
    }

    public function addPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = file_get_contents($_FILES['image']['tmp_name']);
            }

            $data = [
                'user_id' => $_SESSION['user_id'],
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'image' => $image
            ];

            if ($this->userModel->addPost($data)) {
                flash('post_message', 'Post added successfully');
                redirect('shopkeepers/displayPortfolio');
            } else {
                die('Something went wrong');
            }
        } else {
            $data = [
                'title' => 'Add New Post'
            ];
            $this->view('users/Shopkeeper/v_s_add_new_post', $data);
        }
    }

    public function displayCustomizeItems()
    {
        $data = [
            'title' => 'Customize Items'
        ];
        $this->view('users/Shopkeeper/v_s_customize_item_list', $data);
    }

    public function displayCustomizeItemDetails()
    {
        $data = [
            'title' => 'Customize Item Details'
        ];
        $this->view('users/Shopkeeper/v_s_customize_add_new_continue', $data);
    }

    public function addCustomizeItem()
    {
        $data = [
            'title' => 'Add Customize Item'
        ];
        $this->view('users/Shopkeeper/v_s_customize_add_new', $data);
    }

    public function displayEmployees()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'shopkeeper') {
            redirect('users/login');
        }

        $employees = $this->shopkeeperModel->getEmployeesByUserId($_SESSION['user_id']);

        $data = [
            'title' => 'Employees',
            'employees' => $employees
        ];

        $this->view('users/ShopKeeper/v_s_employees', $data);
    }

    public function addNewEmployee()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_id' => $_SESSION['user_id'],
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'phone_number' => trim($_POST['phone_number']),
                'email' => trim($_POST['email']),
                'home_town' => trim($_POST['home_town']),
                'image' => null,
                'first_name_err' => '',
                'last_name_err' => '',
                'phone_number_err' => '',
                'email_err' => '',
                'home_town_err' => '',
                'image_err' => ''
            ];

            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                $image = file_get_contents($_FILES['image']['tmp_name']);
                $data['image'] = $image;
            }

            if (empty($data['first_name_err']) && empty($data['last_name_err']) && empty($data['phone_number_err']) && empty($data['email_err']) && empty($data['home_town_err']) && empty($data['image_err'])) {
                if ($this->shopkeeperModel->addEmployee($data)) {
                    flash('employee_message', 'Employee added successfully');
                    redirect('Shopkeepers/displayEmployees');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('users/Shopkeeper/v_s_employee_add_new', $data);
            }
        } else {
            $data = [
                'first_name' => '',
                'last_name' => '',
                'phone_number' => '',
                'email' => '',
                'home_town' => '',
                'first_name_err' => '',
                'last_name_err' => '',
                'phone_number_err' => '',
                'email_err' => '',
                'home_town_err' => '',
                'image_err' => ''
            ];

            $this->view('users/Shopkeeper/v_s_employee_add_new', $data);
        }
    }


    public function editEmployee($id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'shopkeeper') {
            redirect('users/login');
        }

        $employee = $this->shopkeeperModel->getEmployeeById($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'employee_id' => $id,
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'phone_number' => trim($_POST['phone_number']),
                'email' => trim($_POST['email']),
                'home_town' => trim($_POST['home_town']),
                'image' => $employee->image,
                'first_name_err' => '',
                'last_name_err' => '',
                'phone_number_err' => '',
                'email_err' => '',
                'home_town_err' => '',
                'image_err' => ''
            ];

            // Handle image upload
            if (!empty($_FILES['image']['name'])) {
                $image = file_get_contents($_FILES['image']['tmp_name']);
                $data['image'] = $image;
            }

            if (empty($data['first_name_err']) && empty($data['last_name_err']) && empty($data['phone_number_err']) && empty($data['email_err']) && empty($data['home_town_err']) && empty($data['image_err'])) {
                if ($this->shopkeeperModel->updateEmployee($data)) {
                    flash('employee_message', 'Employee updated successfully');
                    redirect('Shopkeepers/displayEmployees');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('users/Shopkeeper/v_s_employee_edit', $data);
            }
        } else {
            $data = [
                'employee' => $employee
            ];

            $this->view('users/Shopkeeper/v_s_employee_edit', $data);
        }
    }

    public function deleteEmployee($id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'shopkeeper') {
            redirect('users/login');
        }

        if ($this->shopkeeperModel->deleteEmployee($id)) {
            flash('employee_message', 'Employee removed successfully');
            redirect('Shopkeepers/displayEmployees');
        } else {
            die('Something went wrong');
        }
    }
    public function shopkeeperRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_type' => 'shopkeeper',
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
                if ($this->userModel->findUserByEmail($data['email'])) {
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
                $this->view('users/Shopkeeper/v_s_register', $data);
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

            $this->view('users/Shopkeeper/v_s_register', $data);
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

                if ($this->userModel->register($shopkeeperData)) {
                    flash('register_success', 'You are registered and can log in');
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('users/Shopkeeper/v_s_createpassword', $data);
            }
        } else {
            $data = [
                'password' => '',
                'confirm_password' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            $this->view('users/Shopkeeper/v_s_createpassword', $data);
        }
    }
}
