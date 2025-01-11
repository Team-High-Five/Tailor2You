<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
require_once APPROOT . '/controllers/Users.php';

class Designs extends Controller
{
    private $designModel;

    public function __construct()
    {
        $this->designModel = $this->model('M_Designs');
    }

    public function index() {}

    public function selectFabric()
    {
        $data = [
            'title' => 'Select Fabric '
        ];
        $this->view('Designs/v_d_select_fabric', $data);
    }

    public function selectColor()
    {
        $data = [
            'title' => 'Select Color '
        ];
        $this->view('Designs/v_d_select_color', $data);
    }

    public function enterMeasurement()
    {
        $data = [
            'title' => 'Enter Measurement '
        ];
        $this->view('Designs/v_d_enter_measurement', $data);
    }

    public function collarDesigns()
    {
        $data = [
            'title' => 'Collar Designs '
        ];
        $this->view('Designs/v_d_collar_designs', $data);
    }

    public function cuffDesigns()
    {
        $data = [
            'title' => 'Cuff Designs '
        ];
        $this->view('Designs/v_d_cuff_designs', $data);
    }

    public function appointment()
    {
        // Check if the user is logged in
        if (!isLoggedIn()) {
            $_SESSION['redirect_url'] = 'designs/appointment';
            redirect('users/login');
            exit();
        }
        $data = [
            'title' => 'Appointment'
        ];
        $this->view('Designs/v_d_appointment', $data);
    }
    public function placedOrder()
    {
        $data = [
            'title' => 'Placed Order '
        ];
        $this->view('Designs/v_d_placed_order', $data);
    }

    public function payments()
    {
        $data = [
            'title' => 'Payments '
        ];
        $this->view('Designs/v_d_payments', $data);
    }
}
