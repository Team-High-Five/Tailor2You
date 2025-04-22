<?php

require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';

class Admin extends Controller
{
    private $orderModel;
    private $adminModel;

    public function __construct()
    {
        $this->userModel = $this->model('M_Users');
        $this->adminModel = $this->model('M_Admin');
        $this->orderModel = $this->model('M_Orders');
       // $this->inventoryModel = $this->model('M_Inventory');
        // $this->reviewModel = $this->model('M_Reviews');
    }

    public function index()
    {
        $this->admindashboard();
    }

    public function admindashboard()
    {
        $adminModel = $this->model('M_Admin');
        $data = [
            'userCount' => $adminModel->getUserCount(),
            'orderCount' => $adminModel->getOrderCount(),
            'inventoryCount' => $adminModel->getInventoryCount(),
            'reviewCount' => $adminModel->getReviewCount(),
            'userCounts' => $adminModel->getUserCountsByType()
        ];
        $this->view('users/Admin/v_a_dashboard', $data);
    }

   /*  public function dashboard() {
        $adminModel = $this->model('M_Admin');

        $data = [
            'userCount' => $adminModel->getUserCount(),
            'orderCount' => $adminModel->getOrderCount(),
            'inventoryCount' => $adminModel->getInventoryCount(),
            'reviewCount' => $adminModel->getReviewCount(),
            'userCounts' => $adminModel->getUserCountsByType()
        ];

        $this->view('users/Admin/v_a_dashboard', $data);
    }*/

    public function manageCustomer()
    {
        $customers = $this->adminModel->getAllCustomers();
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
                'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT), // Set a default password
                'profile_pic' => $profilePic // Set profile picture
            ];

            if ($this->adminModel->addUser($data)) {
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
        $customer = $this->adminModel->getUserById($id);
        $data = ['customer' => $customer];

        $this->view('users/Admin/v_a_editCustomer', $data);
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

            if ($this->adminModel->updateUser($data)) {
                flash('customer_message', 'Customer Updated');
                redirect('admin/manageCustomer');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('admin/manageCustomer');
        }
    }

    public function deleteCustomer($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->deleteCustomerById($id)) {
                flash('customer_message', 'Customer Removed');
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
        $tailors = $this->adminModel->getAllTailors();
        $data = ['tailors' => $tailors];

        $this->view('users/Admin/v_a_manageTailor', $data);
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

            if ($this->adminModel->addUser($data)) {
                flash('tailor_message', 'Tailor Added');
                redirect('admin/manageTailor');
            } else {
                die('Something went wrong');
            }
        } else {
            $this->view('users/Admin/v_a_addTailor');
        }
    }

    public function editTailor($id) {
        $tailor = $this->adminModel->getUserById($id); // Fetch tailor by ID
        if (!$tailor) {
            flash('tailor_message', 'Tailor not found', 'alert alert-danger');
            redirect('admin/manageTailor');
        }

        $data = ['tailor' => $tailor];
        $this->view('users/Admin/v_a_editTailor', $data);
    }

    public function updateTailor()
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

            if ($this->adminModel->updateUser($data)) {
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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->deleteTailorById($id)) {
                flash('tailor_message', 'Tailor Removed');
                redirect('admin/manageTailor');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('admin/manageTailor');
        }
    }

    public function manageShopkeeper()
    {
        $shopkeepers = $this->adminModel->getAllShopkeepers();
        $data = ['shopkeepers' => $shopkeepers];

        $this->view('users/Admin/v_a_manageShopkeeper', $data);
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

            if ($this->adminModel->addUser($data)) {
                flash('shopkeeper_message', 'Shopkeeper Added');
                redirect('admin/manageShopkeeper');
            } else {
                die('Something went wrong');
            }
        } else {
            $this->view('users/Admin/v_a_addShopkeeper');
        }
    }

    public function editShopkeeper($id)
    {
        $shopkeeper = $this->adminModel->getUserById($id);
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

            if ($this->adminModel->updateUser($data)) {
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
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->deleteShopkeeperById($id)) {
                flash('shopkeeper_message', 'Shopkeeper Removed');
                redirect('admin/manageShopkeeper');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('admin/manageShopkeeper');
        }
    }

    public function viewAllUsers() {
        // Fetch all users using the M_Admin model
        $users = $this->adminModel->getAllUsers();

        // Pass the data to the view
        $data = ['users' => $users];

        $this->view('users/Admin/v_a_viewAllUsers', $data);
    }

    public function editUser($id)
    {
        $user = $this->adminModel->getUserById($id);
        $data = ['user' => $user];

        $this->view('users/Admin/v_a_editUser', $data);
    }

    public function updateUser()
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

            if ($this->adminModel->updateUser($data)) {
                flash('user_message', 'User Updated');
                redirect('admin/viewAllUsers');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('admin/viewAllUsers');
        }
    }

    public function deleteUser($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->deleteUserById($id)) {
                flash('user_message', 'User Removed');
                redirect('admin/viewAllUsers');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('admin/viewAllUsers');
        }
    }

    public function displayAllOrders() {
        // Fetch orders from the database
        $orders = $this->orderModel->getOrders();

        // Pass orders to the view
        $data = [
            'orders' => $orders
        ];

        $this->view('users/Admin/v_a_viewAllOrders', $data);
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
        // Fetch reviews from the model
        $reviews = $this->adminModel->getAllReviews();

        // Pass reviews to the view
        $data = [
            'reviews' => $reviews
        ];

        $this->view('users/Admin/v_a_reviewSection', $data);
    }

    public function refundPayments()
    {
        $this->view('users/Admin/v_a_refundPayments');
    }

    public function testConnection() {
        if ($this->adminModel->testDatabaseConnection()) {
            echo "Database connection is working.";
        } else {
            echo "Database connection failed.";
        }
    }

    public function viewReview($review_id) {
        // Fetch review details from the model
        $review = $this->adminModel->getReviewById($review_id);

        // Check if the review exists
        if (!$review) {
            flash('review_message', 'Review not found', 'alert alert-danger');
            redirect('admin/reviewSection');
        }

        // Pass the review data to the view
        $data = [
            'review_id' => $review->review_id,
            'review_text' => $review->review_text,
            'rating' => $review->rating,
            'created_at' => $review->created_at,
            'status' => $review->status,
            'admin_notes' => $review->admin_notes,
            'user_id' => $review->user_id,
            'user_name' => $review->user_name,
            'email' => $review->email,
            'phone' => $review->phone
        ];

        $this->view('users/Admin/v_a_viewReviews', $data);
    }

    public function updateReviewStatus($review_id, $status) {
        // Validate the status
        if (!in_array($status, ['accepted', 'rejected'])) {
            flash('review_message', 'Invalid status', 'alert alert-danger');
            redirect('admin/reviewSection');
        }

        // Get admin notes from the form
        $admin_notes = isset($_POST['notes']) ? trim($_POST['notes']) : '';

        // Update the status and notes in the database
        if ($this->adminModel->updateReviewStatus($review_id, $status, $admin_notes)) {
            flash('review_message', 'Review status and notes updated successfully');
        } else {
            flash('review_message', 'Something went wrong', 'alert alert-danger');
        }

        redirect('admin/reviewSection');
    }

}
?>
