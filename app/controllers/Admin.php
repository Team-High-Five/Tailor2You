<?php

require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';

class Admin extends Controller
{
    private $orderModel;
    private $adminModel;
    private $userModel;

    public function __construct()
    {
        $this->adminModel = $this->model('M_Admin'); // Load the M_Admin model
        $this->orderModel = $this->model('M_Orders');
        $this->fabricModel = $this->model('M_Fabrics');
        $this->reviewModel = $this->model('M_Reviews');
    }

    public function index()
    {
        $this->admindashboard();
    }

    public function admindashboard()
    {
        if (!isset($_SESSION['admin_id'])) {
            redirect('users/login'); // Redirect to login page if not logged in
        }

        $adminId = $_SESSION['admin_id'];
        $adminDetails = $this->adminModel->getUserById($adminId);

        // Fetch counts
        $userCount = $this->adminModel->getUserCount();
        $orderCount = $this->adminModel->getOrderCount();
        $inventoryCount = $this->adminModel->getInventoryCount();
        $reviewCount = $this->adminModel->getReviewCount();

        // Get user counts by type (needed for Chart 3)
        $userCounts = $this->adminModel->getUserCountsByType();

        // Pass data to the view
        $data = [
            'adminDetails' => $adminDetails,
            'userCount' => $userCount,
            'orderCount' => $orderCount,
            'inventoryCount' => $inventoryCount,
            'reviewCount' => $reviewCount,
            'userCounts' => $userCounts
        ];

        $this->view('users/Admin/v_a_dashboard', $data);
    }
    public function dashboard()
    {
        // Fetch admin details using the admin ID stored in the session
        $adminId = $_SESSION['admin_id'];
        $adminDetails = $this->userModel->getUserById($adminId);

        // Pass admin details to the view
        $data = [
            'adminDetails' => $adminDetails
        ];

        $this->view('admin/dashboard', $data);
    }

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

    public function editTailor($id)
    {
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
                'bio' => isset($_POST['bio']) ? trim($_POST['bio']) : '',  // Check if exists
                'category' => isset($_POST['category']) ? trim($_POST['category']) : '',
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

    public function viewAllUsers()
    {
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

    public function displayAllOrders()
    {
        // Load the M_Orders model
        $this->orderModel = $this->model('M_Orders');

        // Fetch all orders
        $orders = $this->orderModel->getOrders();

        // Pass the orders to the view
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
        $reviewModel = $this->model('M_Reviews');
        $reviews = $reviewModel->getAllReviews();

        $data = [
            'reviews' => $reviews
        ];

        $this->view('users/Admin/v_a_reviewSection', $data);
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

    public function testConnection()
    {
        if ($this->adminModel->testDatabaseConnection()) {
            echo "Database connection is working.";
        } else {
            echo "Database connection failed.";
        }
    }

    public function viewReview($reviewId)
    {
        $review = $this->reviewModel->getReviewById($reviewId);

        if ($review) {
            // Create user name from first_name and last_name
            $userName = isset($review->first_name) ? $review->first_name : '';
            if (isset($review->last_name)) {
                $userName .= ' ' . $review->last_name;
            }
            
            $data = [
                'review_id' => $review->review_id,
                'review_text' => $review->review_text,
                'rating' => $review->rating,
                'created_at' => $review->created_at,
                'status' => $review->status,
                'user_name' => $userName ? $userName : 'Unknown User',
                'user_id' => $review->user_id,
                'email' => isset($review->email) ? $review->email : 'Not available',
                'phone' => isset($review->phone_number) ? $review->phone_number : 'Not available',
                'admin_notes' => isset($review->admin_notes) ? $review->admin_notes : ''
            ];

            $this->view('users/Admin/v_a_viewReviews', $data);
        } else {
            flash('review_message', 'Review not found.');
            redirect('admin/reviewSection');
        }
    }

    public function updateReviewStatus($review_id, $status = null)
    {
        // If status is not provided directly, get it from POST
        if ($status === null && isset($_POST['status'])) {
            $status = $_POST['status'];
        }
        
        // Validate the status
        if (!in_array($status, ['accepted', 'pending', 'rejected'])) {
            flash('review_message', 'Invalid status', 'alert alert-danger');
            redirect('admin/reviewSection');
        }

        // Get admin notes from the form
        $admin_notes = isset($_POST['notes']) ? trim($_POST['notes']) : 
                      (isset($_POST['admin_notes']) ? trim($_POST['admin_notes']) : '');

        // Update the status and notes in the database
        if ($this->adminModel->updateReviewStatus($review_id, $status, $admin_notes)) {
            flash('review_message', 'Review status and notes updated successfully');
        } else {
            flash('review_message', 'Something went wrong', 'alert alert-danger');
        }

        redirect('admin/reviewSection');
    }

    public function updateReviewNotes()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $review_id = $_POST['review_id'];
            $admin_notes = trim($_POST['admin_notes']);
            $status = isset($_POST['status']) ? trim($_POST['status']) : null;
            
            $currentReview = $this->reviewModel->getReviewById($review_id);
            
            // If status is not provided, keep the current status
            if ($status === null && $currentReview) {
                $status = $currentReview->status;
            }
            
            $success = $this->adminModel->updateReviewStatus($review_id, $status, $admin_notes);
            
            // For AJAX requests
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                header('Content-Type: application/json');
                echo json_encode(['success' => $success]);
                exit;
            }
            
            // For regular form submissions
            if ($success) {
                flash('review_message', 'Review notes updated successfully');
            } else {
                flash('review_message', 'Failed to update notes', 'alert alert-danger');
            }
            redirect('admin/reviewSection');
        }
    }

    public function inventoryManagement()
    {
        // Load the M_Fabrics model
        $fabricModel = $this->model('M_Fabrics');

        // Fetch all fabrics
        $fabrics = $fabricModel->getAllFabrics(); // Assuming a method exists to fetch all fabrics

        // Pass data to the view
        $data = [
            'fabrics' => $fabrics
        ];

        // Load the inventory management view
        $this->view('users/Admin/v_a_inventoryManagement', $data);
    }

    public function editFabric($fabricId)
    {
        $fabricModel = $this->model('M_Fabrics');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle form submission
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'fabric_id' => $fabricId,
                'fabric_name' => trim($_POST['fabric_name']),
                'price_per_meter' => trim($_POST['price_per_meter']),
                'stock' => trim($_POST['stock']),
                'colors' => $_POST['colors'] ?? []
            ];

            if ($fabricModel->updateFabric($data)) {
                flash('fabric_message', 'Fabric updated successfully');
                redirect('admin/inventoryManagement');
            } else {
                die('Something went wrong');
            }
        } else {
            // Fetch fabric details
            $fabric = $fabricModel->getFabricById($fabricId);
            $colors = $fabricModel->getColors();

            $data = [
                'fabric' => $fabric,
                'colors' => $colors
            ];

            $this->view('users/Admin/v_a_editFabric', $data);
        }
    }

    public function deleteFabric($fabricId)
    {
        $fabricModel = $this->model('M_Fabrics');

        if ($fabricModel->deleteFabric($fabricId)) {
            flash('fabric_message', 'Fabric deleted successfully');
            redirect('admin/inventoryManagement');
        } else {
            die('Something went wrong');
        }
    }

}
?>