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

    public function manageCustomer()
    {
        $userModel = $this->model('M_Users');
        $customers = $userModel->getAllCustomers();
        $data = ['customers' => $customers];

        $this->view('users/Admin/v_a_manageCustomer', $data);
    }
    public function manageShopkeeper()
    {
        $userModel = $this->model('M_Users');
        $shopkeepers = $userModel->getAllShopkeepers();
        $data = ['shopkeepers' => $shopkeepers];

        $this->view('users/Admin/v_a_manageShopkeeper', $data);
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

            // Handle file upload
            if (!empty($_FILES['profile_pic']['name'])) {
                $profilePic = file_get_contents($_FILES['profile_pic']['tmp_name']);
            } else {
                $profilePic = null; // No new image uploaded
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
            if ($userModel->updateTailor($data)) {
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
    public function complaintsSection()
    {
        $data = [];

        $this->view('users/Admin/v_a_complaintsSection');
    }
    public function generateReports()
    {
        $data = [];

        $this->view('users/Admin/v_a_generateReports');
    }
    public function editCustomer($id)
    {
        $userModel = $this->model('M_Users');
        $customer = $userModel->getUserById($id);
        $data = ['customer' => $customer];

        $this->view('users/Admin/v_a_editCustomer', $data);
    }
    public function reviewSection()
    {
        $data = [];

        $this->view('users/Admin/v_a_reviewSection');
    }
    public function refundPayments()
    {
        $data = [];

        $this->view('users/Admin/v_a_refundPayments');

    }
    public function editShopkeeper($id)
    {
        $userModel = $this->model('M_Users');
        $shopkeeper = $userModel->getUserById($id);
        $data = ['shopkeeper' => $shopkeeper];

        $this->view('users/Admin/v_a_editShopkeeper', $data);
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
                'profile_pic' => trim($_POST['profile_pic']),
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
    public function updateShopkeeper()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_id' => trim($_POST['user_id']),
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'email' => trim($_POST['email']),
                'phone_number' => trim($_POST['phone_number']),
                'address' => trim($_POST['address']),
                'status' => trim($_POST['status'])
            ];

            $userModel = $this->model('M_Users');
            if ($userModel->updateShopkeeper($data)) {
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

}
?>