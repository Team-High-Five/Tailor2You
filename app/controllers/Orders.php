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
                $typeId = substr($key, 14); // Remove 'customization_' to get type ID
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
}
