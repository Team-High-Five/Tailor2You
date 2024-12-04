<?php

require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
class admin extends controller
{
    public function __construct()
    {

    }
    public function index()
    {
        $this->admindashboard();
    }

    public function admindashboard()
    {
        $data = [];

        $this->view('users/Admin/v_a_dashboard');
    }
    public function dashboard()
    {
        $userModel = $this->model('M_Users');
        $userCount = $userModel->getUserCount();
        $orderCount = $userModel->getOrderCount();
        $inventoryCount = $userModel->getInventoryCount();
        $reviewCount = $userModel->getReviewCount();

        $data = [
            'userCount' => $userCount,
            'orderCount' => $orderCount,
            'inventoryCount' => $inventoryCount,
            'reviewCount' => $reviewCount
        ];

        $this->view('users/Admin/v_a_dashboard', $data);
    }
    public function manageCustomer()
    {
        $userModel = $this->model('M_Users');
        $customers = $userModel->getAllCustomers();
        $data = ['customers' => $customers];

        $this->view('users/Admin/v_a_manageCustomer', $data);
    }

    public function addCustomer()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Handle file upload
            if (!empty($_FILES['profile_pic']['name'])) {
                $profilePic = file_get_contents($_FILES['profile_pic']['tmp_name']);
            } else {
                $profilePic = null; // No image uploaded
            }

            $data = [
                'user_type' => 'customer',
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
                'status' => trim($_POST['status']),
                'password' => password_hash('defaultpassword', PASSWORD_DEFAULT), // Set a default password
                'profile_pic' => $profilePic // Set profile picture
            ];

            $userModel = $this->model('M_Users');
            if ($userModel->addUser($data)) {
                flash('customer_message', 'Customer Added');
                redirect('admin/manageCustomer');
            } else {
                die('Something went wrong');
            }
        } else {
            $this->view('users/Admin/v_a_addCustomer');
        }
    }
    public function editCustomer($id)
    {
        $userModel = $this->model('M_Users');
        $customer = $userModel->getUserById($id);
        $data = ['customer' => $customer];

        $this->view('users/Admin/v_a_editCustomer', $data);
    }
    public function deleteCustomer($id)
    {
        $userModel = $this->model('M_Users');
        if ($userModel->deleteCustomerById($id)) {
            flash('customer_message', 'Customer Removed');
            redirect('admin/manageCustomer');
        } else {
            die('Something went wrong');
        }
    }

    public function updateCustomer()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $profilePic = null;
            if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
                $profilePic = file_get_contents($_FILES['profile_pic']['tmp_name']);
            }

            
            $data = [
                'user_id' => trim($_POST['user_id']),
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
                'status' => trim($_POST['status'])
            ];

            $userModel = $this->model('M_Users');
            if ($userModel->updateUser($data)) {
                flash('customer_message', 'Customer Updated');
                redirect('admin/manageCustomer');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('admin/manageCustomer');
        }
    }
    
    public function manageTailor()
    {
        $userModel = $this->model('M_Users');
        $tailors = $userModel->getAllTailors();
        $data = ['tailors' => $tailors];

        $this->view('users/Admin/v_a_manageTailor', $data);
    }

    public function editTailor($id)
    {
        $userModel = $this->model('M_Users');
        $tailor = $userModel->getUserById($id);
        $data = ['tailor' => $tailor];

        $this->view('users/Admin/v_a_editTailor', $data);
    }

    public function updateTailor()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $profilePic = null;
            if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
                $profilePic = file_get_contents($_FILES['profile_pic']['tmp_name']);
            }
            $data = [
                'user_id' => trim($_POST['user_id']),
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
                'status' => trim($_POST['status'])
            ];

            $userModel = $this->model('M_Users');
            if ($userModel->updateUser($data)) {
                flash('tailor_message', 'Tailor Updated');
                redirect('admin/manageTailor');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('admin/manageTailor');
        }
    }

    public function deleteTailor($id)
    {
        $userModel = $this->model('M_Users');
        if ($userModel->deleteTailorById($id)) {
            flash('tailor_message', 'Tailor Removed');
            redirect('admin/manageTailor');
        } else {
            die('Something went wrong');
        }
    }
    public function addTailor()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Handle file upload
        if (!empty($_FILES['profile_pic']['name'])) {
            $profilePic = file_get_contents($_FILES['profile_pic']['tmp_name']);
        } else {
            $profilePic = null; // No image uploaded
        }

            $data = [
                'user_type' => 'tailor',
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
                'status' => trim($_POST['status']),
                'password' => password_hash('defaultpassword', PASSWORD_DEFAULT), // Set a default password
                'profile_pic' => $profilePic // Set profile picture
            ];

            $userModel = $this->model('M_Users');
            if ($userModel->addUser($data)) {
                flash('tailor_message', 'Tailor Added');
                redirect('admin/manageTailor');
            } else {
                die('Something went wrong');
            }
        } else {
            $this->view('users/Admin/v_a_addTailor');
        }
    }
    public function manageShopkeeper()
    {
        $userModel = $this->model('M_Users');
        $shopkeepers = $userModel->getAllShopkeepers();
        $data = ['shopkeepers' => $shopkeepers];

        $this->view('users/Admin/v_a_manageShopkeeper', $data);
    }
    public function editShopkeeper($id)
    {
        $userModel = $this->model('M_Users');
        $shopkeeper = $userModel->getUserById($id);
        $data = ['shopkeeper' => $shopkeeper];

        $this->view('users/Admin/v_a_editShopkeeper', $data);
    }
    public function updateShopkeeper()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $profilePic = null;
            if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
                $profilePic = file_get_contents($_FILES['profile_pic']['tmp_name']);
            }
            $data = [
                'user_id' => trim($_POST['user_id']),
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
                'status' => trim($_POST['status'])
            ];
            $userModel = $this->model('M_Users');
            if ($userModel->updateUser($data)) {
                flash('shopkeeper_message', 'Shopkeeper Updated');
                redirect('admin/manageShopkeeper');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('admin/manageShopkeeper');
        }
    }
    public function deleteShopkeeper($id)
    {
        $userModel = $this->model('M_Users');
        if ($userModel->deleteShopkeeperById($id)) {
            flash('shopkeeper_message', 'Shopkeeper Removed');
            redirect('admin/manageShopkeeper');
        } else {
            die('Something went wrong');
        }
    }
    public function addShopkeeper()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
            // Handle file upload
            if (!empty($_FILES['profile_pic']['name'])) {
                $profilePic = file_get_contents($_FILES['profile_pic']['tmp_name']);
            } else {
                $profilePic = null; // No image uploaded
            }
            $data = [
                'user_type' => 'shopkeeper',
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
                'status' => trim($_POST['status']),
                'password' => password_hash('defaultpassword', PASSWORD_DEFAULT), // Set a default password
                'profile_pic' => $profilePic // Set profile picture
            ];

            $userModel = $this->model('M_Users');
            if ($userModel->addUser($data)) {
                flash('shopkeeper_message', 'Shopkeeper Added');
                redirect('admin/manageShopkeeper');
            } else {
                die('Something went wrong');
            }
        } else {
            $this->view('users/Admin/v_a_addShopkeeper');
        }
    }
    public function viewComplaints()
    {
        $data = [];

        $this->view('users/Admin/v_a_viewComplaints');
    }

    public function viewRefunds()
    {
        $data = [];

        $this->view('users/Admin/v_a_viewRefunds');
    }

    public function viewReviews()
    {
        $data = [];

        $this->view('users/Admin/v_a_viewReviews');
    }
    public function complaintsSection()
    {
        $this->view('users/Admin/v_a_complaintsSection');
    }

    public function generateReports()
    {
        $this->view('users/Admin/v_a_generateReports');
    }

    

    public function reviewSection()
    {
        $this->view('users/Admin/v_a_reviewSection');
    }

    public function refundPayments()
    {
        $this->view('users/Admin/v_a_refundPayments');
    }

}
?>