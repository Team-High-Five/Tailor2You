<?php
require_once APPROOT . '/helpers/url_helper.php';

require_once APPROOT . '/helpers/session_helper.php';

require_once APPROOT . '/controllers/Fabrics.php';
require_once APPROOT . '/helpers/FileUploader.php';





class Tailors extends Controller
{
    private $tailorModel;
    private $userModel;
    private $fabricController;
    private $designModel;

    public function __construct()
    {
        $this->tailorModel = $this->model('M_Tailors');
        $this->userModel = $this->model('M_Users');
        $this->designModel = $this->model('M_Designs');
        $this->fabricController = new Fabrics();
    }

    public function index()
    {
        // Check if user is logged in as tailor
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'tailor') {
            redirect('users/login');
        }

        // Get dashboard statistics
        $dashboardStats = $this->tailorModel->getDashboardStats($_SESSION['user_id']);

        // Get monthly sales data for the chart
        $monthlySalesData = $this->tailorModel->getMonthlySalesData($_SESSION['user_id']);

        // Prepare the data for the chart
        $months = [];
        $salesValues = [];

        // Initialize all 12 months with 0 values
        $allMonths = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];

        foreach ($allMonths as $month) {
            $months[] = $month;
            $salesValues[] = 0;
        }

        // Fill in the actual data
        foreach ($monthlySalesData as $data) {
            // Month is 1-indexed, array is 0-indexed
            $salesValues[$data->month - 1] = (int)$data->monthly_sales;
        }

        // Get order status counts for the pie chart
        $orderStatusData = $this->tailorModel->getOrderStatusCounts($_SESSION['user_id']);

        // Prepare the data for the pie chart
        $statusLabels = [];
        $statusCounts = [];
        $statusColors = [
            'order_placed' => 'rgba(106, 90, 205, 0.6)',
            'fabric_cutting' => 'rgba(123, 104, 238, 0.6)',
            'stitching' => 'rgba(65, 105, 225, 0.6)',
            'ready_for_delivery' => 'rgba(46, 139, 87, 0.6)',
            'delivered' => 'rgba(60, 179, 113, 0.6)',
            'cancelled' => 'rgba(255, 99, 132, 0.6)',
        ];

        $displayLabels = [
            'order_placed' => 'Order Placed',
            'fabric_cutting' => 'Fabric Cutting',
            'stitching' => 'Stitching',
            'ready_for_delivery' => 'Ready for Delivery',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
        ];

        $pieChartColors = [];
        $pieBorderColors = [];

        foreach ($orderStatusData as $status) {
            $statusLabels[] = $displayLabels[$status->status] ?? $status->status;
            $statusCounts[] = $status->count;
            $color = $statusColors[$status->status] ?? 'rgba(169, 169, 169, 0.6)';
            $pieChartColors[] = $color;
            $pieBorderColors[] = str_replace('0.6', '1', $color);
        }

        $data = [
            'title' => 'Dashboard',
            'stats' => $dashboardStats,
            'chart_data' => [
                'months' => $months,
                'sales_values' => $salesValues,
                'status_labels' => $statusLabels,
                'status_counts' => $statusCounts,
                'pie_colors' => $pieChartColors,
                'pie_border_colors' => $pieBorderColors
            ]
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
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'tailor') {
            redirect('users/login');
        }

        $this->fabricController->displayFabricStock($_SESSION['user_id'], 'users/Tailor/v_t_fabric_stock');
    }

    public function addNewFabric()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'tailor') {
            redirect('users/login');
        }

        $this->fabricController->addNewFabric($_SESSION['user_id'], 'users/Tailor/v_t_add_new_fabric', 'tailors');
    }

    public function editFabric($fabric_id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'tailor') {
            redirect('users/login');
        }

        $this->fabricController->editFabric($fabric_id, $_SESSION['user_id'], 'users/Tailor/v_t_edit_fabric', 'tailors');
    }

    public function deleteFabric($fabric_id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'tailor') {
            redirect('users/login');
        }

        $this->fabricController->deleteFabric($fabric_id, $_SESSION['user_id'], 'users/Tailor/v_t_fabric_stock', 'tailors');
    }
    public function displayOrders()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'tailor') {
            redirect('users/login');
            return;
        }

        // Process filters
        $filters = [];
        if (isset($_GET['date']) && !empty($_GET['date'])) {
            $filters['date'] = $_GET['date'];
        }

        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $filters['status'] = $_GET['status'];
        }

        // Get orders for the logged-in tailor
        $orders = $this->tailorModel->getOrdersByTailorId($_SESSION['user_id'], $filters);

        // Get status options for the dropdown
        $statusOptions = $this->tailorModel->getOrderStatusOptions();

        $data = [
            'title' => 'Orders',
            'orders' => $orders,
            'statusOptions' => $statusOptions,
            'filters' => $filters
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

    public function displayOrderDetails($order_id = null)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'tailor') {
            redirect('users/login');
            return;
        }

        if ($order_id === null) {
            flash('order_error', 'Invalid order ID', 'alert alert-danger');
            redirect('Tailors/displayOrders');
            return;
        }

        // Get order details
        $order = $this->tailorModel->getOrderById($order_id);

        // Check if order exists and belongs to this tailor
        if (!$order || $order->tailor_id != $_SESSION['user_id']) {
            flash('order_error', 'Order not found or you do not have permission to view it', 'alert alert-danger');
            redirect('Tailors/displayOrders');
            return;
        }

        // Get status options for dropdown
        $statusOptions = $this->tailorModel->getOrderStatusOptions();

        $data = [
            'title' => 'Order Details',
            'order' => $order,
            'statusOptions' => $statusOptions
        ];

        $this->view('users/Tailor/v_t_order_item_details', $data);
    }
    public function updateOrderStatus($order_id = null)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'tailor') {
            redirect('users/login');
            return;
        }

        if ($order_id === null) {
            flash('order_error', 'Invalid order ID', 'alert alert-danger');
            redirect('Tailors/displayOrders');
            return;
        }

        // Check if the order belongs to this tailor
        $order = $this->tailorModel->getOrderById($order_id);
        if (!$order || $order->tailor_id != $_SESSION['user_id']) {
            flash('order_error', 'You do not have permission to update this order', 'alert alert-danger');
            redirect('Tailors/displayOrders');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'order_id' => $order_id,
                'status' => trim($_POST['status']),
                'notes' => trim($_POST['notes'] ?? ''),
                'updated_by' => $_SESSION['user_id']
            ];

            // Add method to M_Tailors:
            if ($this->tailorModel->updateOrderStatus($data)) {
                flash('order_success', 'Order status updated successfully', 'alert alert-success');
                redirect('Tailors/displayOrderDetails/' . $order_id);
            } else {
                flash('order_error', 'Error updating order status', 'alert alert-danger');
                redirect('Tailors/displayOrderDetails/' . $order_id);
            }
        } else {
            redirect('Tailors/displayOrderDetails/' . $order_id);
        }
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
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'tailor') {
            redirect('users/login');
        }

        $appointments = $this->tailorModel->getAppointmentsByTailorId($_SESSION['user_id']);

        $data = [
            'title' => 'Appointments',
            'appointments' => $appointments
        ];

        $this->view('users/Tailor/v_t_appointment_list', $data);
    }

    public function displayAppointmentDetails($appointment_id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'tailor') {
            redirect('users/login');
        }

        $appointment = $this->tailorModel->getAppointmentById($appointment_id);

        if (!$appointment) {
            flash('appointment_message', 'Appointment not found', 'alert alert-danger');
            redirect('tailors/displayAppointments');
        }

        // Convert the profile picture to a base64-encoded string
        $appointment->profile_pic = base64_encode($appointment->profile_pic);

        $data = [
            'title' => 'Appointment Details',
            'appointment' => $appointment
        ];

        $this->view('users/Tailor/v_t_appointment_card', $data);
    }
    public function requestRescheduleAppointment($appointment_id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'tailor') {
            redirect('users/login');
            return;
        }

        $appointment = $this->tailorModel->getAppointmentById($appointment_id);

        if (!$appointment) {
            flash('appointment_message', 'Appointment not found', 'alert alert-danger');
            redirect('tailors/displayAppointments');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'appointment_id' => $appointment_id,
                'proposed_date' => trim($_POST['appointment_date']),
                'proposed_time' => trim($_POST['appointment_time']),
                'reason' => trim($_POST['reschedule_reason'])
            ];

            // Create reschedule request
            if ($this->tailorModel->createRescheduleRequest($data)) {
                // Send notification to customer (through notification system if implemented, or email)
                // This would be implemented in a Notifications class

                flash('appointment_message', 'Reschedule request sent to customer successfully');
                redirect('tailors/displayAppointments');
            } else {
                die('Something went wrong');
            }
        } else {
            $data = [
                'title' => 'Request Reschedule',
                'appointment' => $appointment
            ];

            $this->view('users/Tailor/v_t_reschedule_appointment', $data);
        }
    }
    public function rescheduleAppointment($appointment_id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'tailor') {
            redirect('users/login');
        }

        $appointment = $this->tailorModel->getAppointmentById($appointment_id);

        if (!$appointment) {
            flash('appointment_message', 'Appointment not found', 'alert alert-danger');
            redirect('tailors/displayAppointments');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'appointment_id' => $appointment_id,
                'appointment_date' => trim($_POST['appointment_date']),
                'appointment_time' => trim($_POST['appointment_time']),
                'status' => 'pending'
            ];

            // Update appointment
            if ($this->tailorModel->updateAppointment($data)) {
                flash('appointment_message', 'Appointment rescheduled successfully');
                redirect('tailors/displayAppointments');
            } else {
                die('Something went wrong');
            }
        } else {
            $data = [
                'title' => 'Reschedule Appointment',
                'appointment' => $appointment
            ];

            $this->view('users/Tailor/v_t_reschedule_appointment', $data);
        }
    }
    public function acceptAppointment($appointment_id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'tailor') {
            redirect('users/login');
        }

        $appointment = $this->tailorModel->getAppointmentById($appointment_id);

        if (!$appointment) {
            flash('appointment_message', 'Appointment not found', 'alert alert-danger');
            redirect('tailors/displayAppointments');
        }

        $data = [
            'appointment_id' => $appointment_id,
            'status' => 'accepted'
        ];

        // Update appointment status
        if ($this->tailorModel->updateAppointmentStatus($data)) {
            flash('appointment_message', 'Appointment accepted successfully');
            redirect('tailors/displayAppointments');
        } else {
            die('Something went wrong');
        }
    }

    public function displayCalendar($year = null, $month = null)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'tailor') {
            redirect('users/login');
        }

        // Get the current year and month if not provided
        if ($year === null || $month === null) {
            $year = date('Y');
            $month = date('m');
        } else {
            $year = (int)$year;
            $month = str_pad((int)$month, 2, '0', STR_PAD_LEFT);
        }

        // Adjust the year and month if the month goes out of bounds
        if ($month < 1) {
            $month = 12;
            $year--;
        } elseif ($month > 12) {
            $month = 1;
            $year++;
        }

        // Get appointments for the current month
        $appointments = $this->tailorModel->getAppointmentsByMonth($_SESSION['user_id'], $year, $month);

        $data = [
            'title' => 'Calendar',
            'year' => $year,
            'month' => $month,
            'appointments' => $appointments
        ];

        $this->view('users/Tailor/v_t_appointment_calendar', $data);
    }
    public function displayCustomizeItems()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            redirect('users/login');
            return;
        }

        // Get all designs for the current user
        $designs = $this->designModel->getDesignsByUserId($_SESSION['user_id']);

        $data = [
            'title' => 'Your Designs',
            'designs' => $designs
        ];

        $this->view('users/Tailor/v_t_customize_item_list', $data);
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
    public function editPost($post_id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = file_get_contents($_FILES['image']['tmp_name']);
            } else {
                $post = $this->userModel->getPostById($post_id);
                $image = $post->image;
            }

            // Input data
            $data = [
                'post_id' => $post_id,
                'user_id' => $_SESSION['user_id'],
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'image' => $image
            ];

            // Update post
            if ($this->userModel->updatePost($data)) {
                flash('post_message', 'Post updated successfully');
                redirect('tailors/displayPortfolio');
            } else {
                die('Something went wrong');
            }
        } else {
            // Get post details
            $post = $this->userModel->getPostById($post_id);

            // Check if post exists
            if (!$post) {
                flash('post_message', 'Post not found', 'alert alert-danger');
                redirect('tailors/displayPortfolio');
            }

            $data = [
                'post_id' => $post->id,
                'title' => $post->title,
                'description' => $post->description,
                'image' => $post->image
            ];

            $this->view('users/Tailor/v_t_edit_post', $data);
        }
    }

    public function deletePost($post_id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Delete post
            if ($this->userModel->deletePost($post_id)) {
                flash('post_message', 'Post deleted successfully');
                redirect('tailors/displayPortfolio');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('tailors/displayPortfolio');
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
