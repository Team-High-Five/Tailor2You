<?php

require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
require_once APPROOT . '/controllers/Users.php';
require_once APPROOT . '/helpers/FileUploader.php';
class Orders extends Controller
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = $this->model('M_Orders');
    }

    public function index()
    {
        // Reset any existing order in progress
        if (isset($_SESSION['order_details'])) {
            unset($_SESSION['order_details']);
        }

        $filters = [];

        // Get user gender if logged in
        if (isset($_SESSION['user_id'])) {
            // You may want to add user gender to your users table 
            // and fetch it here to filter designs
        }

        // Fetch designs with filters
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

                        // Recalculate total price
                        $_SESSION['order_details']['total_price'] = $this->orderModel->calculateDesignPrice(
                            $_SESSION['order_details']['design']->design_id,
                            $fabricId,
                            isset($_SESSION['order_details']['customizations']) ? array_values($_SESSION['order_details']['customizations']) : []
                        );

                        // Redirect to next step
                        redirect('Orders/selectColor');
                        return;
                    }
                }

                // If we reached here, something went wrong
                flash('fabric_error', 'Unable to select fabric. Please try again.', 'alert alert-danger');
                redirect('Orders/selectFabric');
                break;

            case 'color':
                // Similar logic for color selection
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

    // Select fabric for a design
    public function selectFabric($designId = null)
    {
        // If no design ID provided, check if one exists in the session
        if ($designId === null && !isset($_SESSION['order_details']['design'])) {
            redirect('designs');
            return;
        }

        // If design ID provided but not in session, fetch and store it
        if ($designId !== null && (!isset($_SESSION['order_details']['design']) || $_SESSION['order_details']['design']->design_id != $designId)) {
            $design = $this->orderModel->getDesignById($designId);

            if (!$design) {
                redirect('designs');
                return;
            }

            $_SESSION['order_details'] = [
                'design' => $design,
                'total_price' => $design->base_price
            ];
        }

        // Get available fabrics for this design
        $fabrics = $this->orderModel->getFabricsByDesignId($_SESSION['order_details']['design']->design_id);

        $data = [
            'title' => 'Select Fabric',
            'fabrics' => $fabrics
        ];

        $this->view('designs/v_d_select_fabric', $data);
    }

    // Update fabric selection via AJAX
    public function updateFabricSelection($fabricId = null)
    {
        // Only process AJAX requests
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
            redirect('designs');
            return;
        }

        if ($fabricId === null || !isset($_SESSION['order_details']['design'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        // Get fabric details
        $fabric = $this->orderModel->getFabricById($fabricId);

        if (!$fabric) {
            echo json_encode(['success' => false, 'message' => 'Fabric not found']);
            return;
        }

        // Update session
        $_SESSION['order_details']['fabric'] = $fabric;

        // Recalculate total price
        $_SESSION['order_details']['total_price'] = $this->orderModel->calculateDesignPrice(
            $_SESSION['order_details']['design']->design_id,
            $fabricId,
            isset($_SESSION['order_details']['customizations']) ? array_values($_SESSION['order_details']['customizations']) : []
        );

        echo json_encode([
            'success' => true,
            'fabric' => $fabric,
            'total_price' => $_SESSION['order_details']['total_price']
        ]);
    }

    // Select color for the chosen fabric
    public function selectColor($fabricId = null)
    {
        // If no fabric ID provided, check if one exists in the session
        if ($fabricId === null && !isset($_SESSION['order_details']['fabric'])) {
            redirect('designs/selectFabric');
            return;
        }

        // If fabric ID provided but not in session, fetch and store it
        if ($fabricId !== null && (!isset($_SESSION['order_details']['fabric']) || $_SESSION['order_details']['fabric']->fabric_id != $fabricId)) {
            // Pass design ID to get price adjustment
            $fabric = $this->orderModel->getFabricById(
                $fabricId,
                $_SESSION['order_details']['design']->design_id
            );

            if (!$fabric) {
                redirect('designs/selectFabric');
                return;
            }

            $_SESSION['order_details']['fabric'] = $fabric;
            // Recalculate total price
            $_SESSION['order_details']['total_price'] = $this->orderModel->calculateDesignPrice(
                $_SESSION['order_details']['design']->design_id,
                $fabricId,
                isset($_SESSION['order_details']['customizations']) ? array_values($_SESSION['order_details']['customizations']) : []
            );
        }

        // Get available colors for this fabric
        $colors = $this->orderModel->getColorsByFabricId($_SESSION['order_details']['fabric']->fabric_id);

        $data = [
            'title' => 'Select Color',
            'colors' => $colors
        ];

        $this->view('designs/v_d_select_color', $data);
    }

    // Update color selection via AJAX
    public function updateColorSelection($colorId = null)
    {
        // Only process AJAX requests
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
            redirect('designs');
            return;
        }

        if ($colorId === null || !isset($_SESSION['order_details']['fabric'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        // Get color details
        $color = $this->orderModel->getColorById($colorId);

        if (!$color) {
            echo json_encode(['success' => false, 'message' => 'Color not found']);
            return;
        }

        // Update session
        $_SESSION['order_details']['color'] = $color;

        echo json_encode(['success' => true, 'color' => $color]);
    }

    // Show customization options
    public function customizations()
    {
        // Check if fabric and color are selected
        if (!isset($_SESSION['order_details']['fabric']) || !isset($_SESSION['order_details']['color'])) {
            redirect('designs/selectFabric');
            return;
        }

        // Get customization types for this design
        $customizationTypes = $this->orderModel->getCustomizationTypesByDesignId($_SESSION['order_details']['design']->design_id);

        // Get customization choices for each type
        $customizationData = [];
        foreach ($customizationTypes as $type) {
            $choices = $this->orderModel->getDesignCustomizationChoices($_SESSION['order_details']['design']->design_id, $type->type_id);
            if (!empty($choices)) {
                $customizationData[$type->type_id] = [
                    'type' => $type,
                    'choices' => $choices
                ];
            }
        }

        $data = [
            'title' => 'Customize Your Design',
            'customizations' => $customizationData
        ];

        $this->view('designs/customization/v_d_customizations', $data);
    }

    // Update customization selection via AJAX

    // Show measurements form
    public function enterMeasurement()
    {
        // Check if prior steps are completed
        if (!isset($_SESSION['order_details']['design']) || !isset($_SESSION['order_details']['fabric']) || !isset($_SESSION['order_details']['color'])) {
            redirect('designs');
            return;
        }

        // Get required measurements for this design
        $standardMeasurements = $this->orderModel->getDesignRequiredMeasurements($_SESSION['order_details']['design']->design_id);
        $customMeasurements = $this->orderModel->getCustomDesignMeasurements($_SESSION['order_details']['design']->design_id);

        // Check if user has saved measurements and pre-fill if available
        $userMeasurements = [];
        if (isset($_SESSION['user_id'])) {
            // Fetch user measurements if the model supports it
            // $userMeasurements = $this->orderModel->getUserMeasurements($_SESSION['user_id']);
        }

        $data = [
            'title' => 'Enter Measurements',
            'standardMeasurements' => $standardMeasurements,
            'customMeasurements' => $customMeasurements,
            'userMeasurements' => $userMeasurements
        ];

        $this->view('designs/v_d_enter_measurement', $data);
    }

    // Process measurement submission
    public function saveMeasurements()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('designs/enterMeasurement');
            return;
        }

        // Validate input
        $measurements = [];

        // Extract and sanitize standard measurements
        if (isset($_POST['standard']) && is_array($_POST['standard'])) {
            foreach ($_POST['standard'] as $id => $value) {
                if (is_numeric($value)) {
                    $measurements['standard'][$id] = (float)$value;
                }
            }
        }

        // Extract and sanitize custom measurements
        if (isset($_POST['custom']) && is_array($_POST['custom'])) {
            foreach ($_POST['custom'] as $id => $value) {
                if (is_numeric($value)) {
                    $measurements['custom'][$id] = (float)$value;
                }
            }
        }

        // Save to session
        $_SESSION['order_details']['measurements'] = $measurements;

        // Redirect to appointment
        redirect('designs/appointment');
    }

    // Show appointment scheduling
    public function appointment()
    {
        // Check if prior steps are completed
        if (!isset($_SESSION['order_details']['measurements'])) {
            redirect('designs/enterMeasurement');
            return;
        }

        $data = [
            'title' => 'Schedule Appointment'
        ];

        $this->view('designs/v_d_appointment', $data);
    }

    // Final order review
    public function reviewOrder()
    {
        // Check if all steps are completed
        if (
            !isset($_SESSION['order_details']['design']) ||
            !isset($_SESSION['order_details']['fabric']) ||
            !isset($_SESSION['order_details']['color']) ||
            !isset($_SESSION['order_details']['measurements'])
        ) {
            redirect('designs');
            return;
        }

        $data = [
            'title' => 'Review Your Order',
            'order' => $_SESSION['order_details']
        ];

        $this->view('designs/v_d_review_order', $data);
    }

    // Place the final order
    public function placeOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('designs/reviewOrder');
            return;
        }

        // Validate that user is logged in
        if (!isset($_SESSION['user_id'])) {
            flash('order_error', 'You must be logged in to place an order', 'alert alert-danger');
            redirect('users/login');
            return;
        }

        // Validate that all order details exist
        if (
            !isset($_SESSION['order_details']['design']) ||
            !isset($_SESSION['order_details']['fabric']) ||
            !isset($_SESSION['order_details']['color']) ||
            !isset($_SESSION['order_details']['measurements'])
        ) {
            flash('order_error', 'Please complete all order steps', 'alert alert-danger');
            redirect('designs');
            return;
        }

        // Implement order saving logic...
        // This would involve inserting into the orders and order_items tables

        // Clear the session order details
        unset($_SESSION['order_details']);

        // Redirect to order confirmation
        flash('order_success', 'Your order has been placed successfully!', 'alert alert-success');
        redirect('users/orders');
    }
}
