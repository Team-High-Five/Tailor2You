<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';

class Designs extends Controller {
    
    private $designModel;

    public function __construct() {
        $this->designModel = $this->model('M_Designs');
    }
    
    public function index() {
    }

    public function selectFabric() {
        $data=[
           'title' => 'Select Fabric '
        ];
        $this->view('Designs/v_d_select_fabric', $data);
    }

    public function selectColor() {
        $data=[
           'title' => 'Select Color '
        ];
        $this->view('Designs/v_d_select_color', $data);
    }
}

