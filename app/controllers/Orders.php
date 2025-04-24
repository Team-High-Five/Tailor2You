<?php

require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
require_once APPROOT . '/controllers/Users.php';
require_once APPROOT . '/helpers/FileUploader.php';
class Orders extends Controller
{
    private $orderModel;
    private $appointModel;

    public function __construct()
    {
        $this->orderModel = $this->model('M_Orders');
        $this->appointModel = $this->model('M_Appointments');
    }

    public function index()
    {
        // Reset any existing order in progress
        if (isset($_SESSION['order_details'])) {
            unset($_SESSION['order_details']);
        }

        $filters = [];
        if (isset($_SESSION['user_id'])) {
        }

        $designs = $this->orderModel->getDesigns(12, $filters);

        $data = [
            'title' => 'Browse Designs',
            'designs' => $designs
        ];

        $this->view('designs/v_d_browse', $data);
    }

    public function processSelection()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('designs');
            return;
        }

        // Determine which type of selection is being processed
        $selection_type = $_POST['selection_type'] ?? '';

        switch ($selection_type) {
            case 'fabric':
                $fabricId = $_POST['selected_fabric_id'] ?? null;
                if ($fabricId) {
                    // Get fabric details - pass the design ID to get price adjustment
                    $fabric = $this->orderModel->getFabricById(
                        $fabricId,
                        $_SESSION['order_details']['design']->design_id
                    );

                    if ($fabric) {
                        // Store in session
                        $_SESSION['order_details']['fabric'] = $fabric;

                        $customizationIds = [];
                        if (isset($_SESSION['order_details']['customizations'])) {
                            foreach ($_SESSION['order_details']['customizations'] as $customization) {
                                $customizationIds[] = $customization->choice_id;
                            }
                        }

                        $_SESSION['order_details']['total_price'] = $this->orderModel->calculateDesignPrice(
                            $_SESSION['order_details']['design']->design_id,
                            $fabricId,
                            $customizationIds
                        );

                        redirect('Orders/selectColor');
                        return;
                    }
                }
                flash('fabric_error', 'Unable to select fabric. Please try again.', 'alert alert-danger');
                redirect('Orders/selectFabric');
                break;

            case 'color':
                $colorId = $_POST['selected_color_id'] ?? null;
                if ($colorId) {
                    $color = $this->orderModel->getColorById($colorId);

                    if ($color) {
                        $_SESSION['order_details']['color'] = $color;
                        redirect('Orders/customizations');
                        return;
                    }
                }

                flash('color_error', 'Unable to select color. Please try again.', 'alert alert-danger');
                redirect('Orders/selectColor');
                break;

            default:
                redirect('designs');
        }
    }

    public function selectFabric($designId = null)
    {
        // If no design ID provided, check if one exists in the session
        if ($designId === null && !isset($_SESSION['order_details']['design'])) {
            redirect('Pages/index');
            return;
        }

        // If design ID provided but not in session, fetch and store it
        if ($designId !== null && (!isset($_SESSION['order_details']['design']) || $_SESSION['order_details']['design']->design_id != $designId)) {
            $design = $this->orderModel->getDesignById($designId);

            if (!$design) {
                redirect('Pages/index');
                return;
            }

            $_SESSION['order_details'] = [
                'design' => $design,
                'total_price' => $design->base_price
            ];
        }

        $fabrics = $this->orderModel->getFabricsByDesignId($_SESSION['order_details']['design']->design_id);

        $data = [
            'title' => 'Select Fabric',
            'fabrics' => $fabrics
        ];

        $this->view('designs/v_d_select_fabric', $data);
    }

    public function selectColor($fabricId = null)
    {
        // If no fabric ID provided, check if one exists in the session
        if ($fabricId === null && !isset($_SESSION['order_details']['fabric'])) {
            redirect('designs/selectFabric');
            return;
        }

        // If fabric ID provided but not in session, fetch and store it
        if ($fabricId !== null && (!isset($_SESSION['order_details']['fabric']) || $_SESSION['order_details']['fabric']->fabric_id != $fabricId)) {
            $fabric = $this->orderModel->getFabricById(
                $fabricId,
                $_SESSION['order_details']['design']->design_id
            );

            if (!$fabric) {
                redirect('designs/selectFabric');
                return;
            }

            $_SESSION['order_details']['fabric'] = $fabric;

            //Matter only when back button is clicked
            // If customizations are already selected, recalculate the price
            $customizationIds = [];
            if (isset($_SESSION['order_details']['customizations'])) {
                foreach ($_SESSION['order_details']['customizations'] as $customization) {
                    $customizationIds[] = $customization->choice_id;
                }
            }

            $_SESSION['order_details']['total_price'] = $this->orderModel->calculateDesignPrice(
                $_SESSION['order_details']['design']->design_id,
                $fabricId,
                $customizationIds
            );
        }

        $colors = $this->orderModel->getColorsByFabricId($_SESSION['order_details']['fabric']->fabric_id);

        $data = [
            'title' => 'Select Color',
            'colors' => $colors
        ];

        $this->view('designs/v_d_select_color', $data);
    }

    public function customizations()
    {
        if (!isset($_SESSION['order_details']['design']) || !isset($_SESSION['order_details']['fabric'])) {
            redirect('Orders/selectFabric');
            return;
        }

        if (!isset($_SESSION['order_details']['color'])) {
            redirect('Orders/selectColor');
            return;
        }

        $designId = $_SESSION['order_details']['design']->design_id;

        $customizationTypes = $this->orderModel->getCustomizationTypesByDesignId($designId);

        // For each type, get the available choices
        $customizationData = [];
        foreach ($customizationTypes as $type) {
            $choices = $this->orderModel->getDesignCustomizationChoices($designId, $type->type_id);
            if (!empty($choices)) {
                $customizationData[$type->type_id] = [
                    'type' => $type,
                    'choices' => $choices
                ];
            }
        }
        $data = [
            'title' => 'Select Customizations',
            'customizations' => $customizationData
        ];

        $this->view('designs/v_d_customizations', $data);
    }

    public function processCustomizations()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('Orders/customizations');
            return;
        }

        if (!isset($_SESSION['order_details']['customizations'])) {
            $_SESSION['order_details']['customizations'] = [];
        }

        // Get selected customizations from form
        $selectedCustomizations = [];
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'customization_') === 0) {
                $typeId = substr($key, 14);
                $choiceId = $value;

                // Get choice details to store in session
                $choice = $this->orderModel->getCustomizationChoiceById($choiceId);
                if ($choice) {
                    $selectedCustomizations[$typeId] = $choice;
                }
            }
        }


        $_SESSION['order_details']['customizations'] = $selectedCustomizations;

        $choiceIds = [];
        foreach ($selectedCustomizations as $customization) {
            $choiceIds[] = $customization->choice_id;
        }
        $_SESSION['order_details']['total_price'] = $this->orderModel->calculateDesignPrice(
            $_SESSION['order_details']['design']->design_id,
            $_SESSION['order_details']['fabric']->fabric_id,
            $choiceIds
        );

        redirect('Orders/enterMeasurements');
    }


    public function enterMeasurements()
    {
        // Check if design, fabric and color are selected
        if (!isset($_SESSION['order_details']['design']) || !isset($_SESSION['order_details']['fabric'])) {
            redirect('Orders/selectFabric');
            return;
        }

        if (!isset($_SESSION['order_details']['color'])) {
            redirect('Orders/selectColor');
            return;
        }

        if (!isset($_SESSION['order_details']['customizations'])) {
            redirect('Orders/customizations');
            return;
        }

        // Get necessary design info
        $designId = $_SESSION['order_details']['design']->design_id;

        // Get required measurements for this design
        $measurementsData = $this->orderModel->getMeasurementsByDesignId($designId);

        // Get user's existing measurements if logged in
        $userMeasurements = [];
        if (isset($_SESSION['user_id'])) {
            $userMeasurements = $this->orderModel->getUserMeasurements($_SESSION['user_id']);
        }

        $data = [
            'title' => 'Enter Measurements',
            'measurements' => $measurementsData['measurements'],
            'customMeasurements' => $measurementsData['customMeasurements'],
            'ranges' => $measurementsData['ranges'],
            'userMeasurements' => $userMeasurements
        ];

        $this->view('designs/v_d_enter_measurement', $data);
    }

    public function processMeasurements()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('Orders/enterMeasurements');
            return;
        }

        // Store measurements in session for now
        $_SESSION['order_details']['measurements'] = $_POST;

        // Redirect to appointment booking
        redirect('Orders/bookAppointment');
    }
    public function processAppointment()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            flash('appointment_error', 'Please login to book an appointment', 'alert alert-danger');
            redirect('Users/login');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('Orders/bookAppointment');
            return;
        }

        $appointmentDate = trim($_POST['appointment_date'] ?? '');
        $appointmentTime = trim($_POST['appointment_time'] ?? '');
        $locationType = trim($_POST['location_type'] ?? 'shop');

        if (empty($appointmentDate) || empty($appointmentTime)) {
            flash('appointment_error', 'Please select both date and time', 'alert alert-danger');
            redirect('Orders/bookAppointment');
            return;
        }

        // Store appointment in session
        $_SESSION['order_details']['appointment'] = [
            'date' => $appointmentDate,
            'time' => $appointmentTime,
            'location_type' => $locationType
        ];

        // Redirect to order review page
        redirect('Orders/reviewOrder');
    }

    public function bookAppointment()
    {
        $_SESSION['redirect_url'] = 'Orders/bookAppointment';
        // Check authentication first
        if (!isset($_SESSION['user_id'])) {
            redirect('Users/login');
            return;
        }


        // Check if previous steps are completed
        if (
            !isset($_SESSION['order_details']['design']) ||
            !isset($_SESSION['order_details']['fabric']) ||
            !isset($_SESSION['order_details']['color']) ||
            !isset($_SESSION['order_details']['measurements'])
        ) {
            redirect('Orders/enterMeasurements');
            return;
        }

        // Get the tailor ID from the design
        $tailorId = $_SESSION['order_details']['design']->user_id;

        // Get selected date (from form submission or default to 3 days from now)
        $selectedDate = $_POST['appointment_date'] ?? date('Y-m-d', strtotime('+1 day'));

        // Get booked slots for the selected date
        $bookedSlots = $this->appointModel->getBookedTimeSlots($tailorId, $selectedDate);

        $data = [
            'title' => 'Book Appointment',
            'booked_slots' => $bookedSlots,
            'selected_date' => $selectedDate
        ];

        $this->view('designs/v_d_appointment', $data);
    }
    public function skipAppointment()
    {
        $_SESSION['order_details']['appointment'] = [
            'skipped' => true,
            'date' => null,
            'time' => null,
            'location_type' => null
        ];
        flash('appointment_info', 'Appointment booking was skipped. You can schedule an appointment later.', 'alert alert-info');

        redirect('Orders/reviewOrder');
    }
    public function reviewOrder()
    {
        // Check if all necessary details are in session
        if (
            !isset($_SESSION['order_details']['design']) ||
            !isset($_SESSION['order_details']['fabric']) ||
            !isset($_SESSION['order_details']['color']) ||
            !isset($_SESSION['order_details']['measurements'])
        ) {
            redirect('Orders/enterMeasurements');
            return;
        }

        // Check if appointment exists OR was explicitly skipped
        if (!isset($_SESSION['order_details']['appointment'])) {
            redirect('Orders/bookAppointment');
            return;
        }

        // Get measurement names from the database for better display
        if (isset($_SESSION['order_details']['measurements'])) {
            $_SESSION['order_details']['measurement_names'] =
                $this->orderModel->getMeasurementNames();
        }

        $data = [
            'title' => 'Review Order',
            'order_details' => $_SESSION['order_details']
        ];

        $this->view('designs/v_d_review_order', $data);
    }

    public function placeOrder()
    {
        // Check user authentication
        if (!isset($_SESSION['user_id'])) {
            flash('order_error', 'Please login to complete your order', 'alert alert-danger');
            redirect('Users/login');
            return;
        }

        // Check if order details exist
        if (!isset($_SESSION['order_details'])) {
            redirect('Orders');
            return;
        }

        flash('order_success', 'Your order has been placed successfully!', 'alert alert-success');

        // Redirect to a confirmation page
        redirect('Orders/payment');
    }



    public function payment()
    {
        // Check if session contains order details
        if (!isset($_SESSION['order_details']) || !isset($_SESSION['order_details']['total_price'])) {
            redirect('Orders/reviewOrder');
            return;
        }

        $data = [
            'title' => 'Payment',
        ];

        $this->view('designs/v_d_payments', $data);
    }

    public function processPayment()
    {
        if (!isset($_SESSION['user_id'])) {
            flash('order_error', 'You must be logged in to complete your order', 'alert alert-danger');
            redirect('Users/login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('Orders/payment');
            return;
        }

        $paymentMethod = $_POST['payment_method'] ?? 'cod';
        $orderNumber = $this->orderModel->generateOrderId();

        // Log payment details
        $paymentDetails = [
            'order_number' => $orderNumber,
            'payment_method' => $paymentMethod,
            'amount' => $_SESSION['order_details']['total_price'],
            'status' => 'completed',
            'date' => date('Y-m-d H:i:s')
        ];

        $_SESSION['order_details']['payment'] = $paymentDetails;


        // Get user information including address
        $user = $this->orderModel->getUserAddress($_SESSION['user_id']);

        $deliveryAddress = $user ? $user->address : 'Default Address';

        // Prepare the order data for database storage
        $orderData = [
            'customer_id' => $_SESSION['user_id'],
            'tailor_id' => $_SESSION['order_details']['design']->user_id,
            'total_amount' => $_SESSION['order_details']['total_price'],
            'delivery_address' => $deliveryAddress,
            'notes' => $_POST['notes'] ?? null,
            'items' => $this->prepareOrderItems()
        ];

        // If appointment was scheduled, include it
        if (isset($_SESSION['order_details']['appointment']) && !isset($_SESSION['order_details']['appointment']['skipped'])) {
            // Create the appointment record first
            $appointmentId = $this->createAppointment($_SESSION['order_details']['appointment'], $orderData['tailor_id']);
            if ($appointmentId) {
                $orderData['appointment_id'] = $appointmentId;
            }
        } else {
            // If appointment was skipped, explicitly set it to null
            $orderData['appointment_id'] = null;
        }

        // Save to database
        $createdOrderId = $this->orderModel->createOrder($orderData);


        if ($createdOrderId) {
            // Store the order ID in session for the confirmation page
            $_SESSION['order_details']['order_id'] = $createdOrderId;

            flash('order_success', 'Your order has been placed successfully!', 'alert alert-success');
            redirect('Orders/orderConfirmation');
        } else {
            flash('order_error', 'There was an error placing your order. Please try again.', 'alert alert-danger');
            redirect('Orders/payment');
        }
    }
    public function orderConfirmation()
    {
        // Check if order details exist in session
        if (!isset($_SESSION['order_details'])) {
            redirect('Orders');
            return;
        }

        $data = [
            'title' => 'Order Confirmation',
            'order_details' => $_SESSION['order_details']
        ];

        $this->view('designs/v_d_order_confirmation', $data);

        // Clear the order session data if flag is set
        if (isset($_SESSION['clear_order_after_confirmation']) && $_SESSION['clear_order_after_confirmation']) {
            unset($_SESSION['order_details']);
            unset($_SESSION['clear_order_after_confirmation']);
        }
    }

    private function prepareOrderItems()
    {
        $items = [];

        // Currently we have just one item in the system, but this is designed for multiple items
        $items[] = [
            'design_id' => $_SESSION['order_details']['design']->design_id,
            'fabric_id' => $_SESSION['order_details']['fabric']->fabric_id,
            'color_id' => $_SESSION['order_details']['color']->color_id,
            'quantity' => 1, // Default to 1 for now
            'base_price' => $_SESSION['order_details']['design']->base_price,
            'fabric_price' => $_SESSION['order_details']['fabric']->price_adjustment ?? 0,
            'customization_price' => $this->calculateCustomizationPrice(),
            'total_price' => $_SESSION['order_details']['total_price'],
            'customizations' => $this->prepareCustomizations(),
            'measurements' => $_SESSION['order_details']['measurements'] ?? []
        ];

        return $items;
    }

    private function calculateCustomizationPrice()
    {
        $total = 0;
        if (isset($_SESSION['order_details']['customizations']) && is_array($_SESSION['order_details']['customizations'])) {
            foreach ($_SESSION['order_details']['customizations'] as $customization) {
                $total += $customization->price_adjustment ?? 0;
            }
        }
        return $total;
    }

    private function prepareCustomizations()
    {
        $customizations = [];
        if (isset($_SESSION['order_details']['customizations']) && is_array($_SESSION['order_details']['customizations'])) {
            foreach ($_SESSION['order_details']['customizations'] as $typeId => $customization) {
                $customizations[$typeId] = $customization->choice_id;
            }
        }
        return $customizations;
    }

    private function createAppointment($appointmentData, $tailorId)
    {
        // Skip if this is a skipped appointment
        if (isset($appointmentData['skipped']) && $appointmentData['skipped']) {
            return null;
        }

        $appointment = [
            'customer_id' => $_SESSION['user_id'],
            'tailor_shopkeeper_id' => $tailorId,
            'appointment_date' => $appointmentData['date'],
            'appointment_time' => $appointmentData['time'],
            'location_type' => $appointmentData['location_type'],
            'status' => 'scheduled'
        ];

        return $this->orderModel->createAppointment($appointment);
    }

    private function clearOrderSession()
    {
        // Don't immediately clear - we need this for the confirmation page
        // Instead we'll set a flag to clear it after showing the confirmation
        $_SESSION['clear_order_after_confirmation'] = true;
    }
}
