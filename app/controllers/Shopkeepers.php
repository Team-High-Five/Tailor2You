<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
class Shopkeepers extends Controller{
    private $shopkeeperModel;
    private $userModel;
    public function __construct()
    {
        $this->shopkeeperModel = $this->model('M_Shopkeepers');
        $this->userModel = $this->model('M_Users');
    }

    public function index(){
        $data = [
            'title' => 'Dashboard'
        ];
        $this->view('users/Shopkeeper/v_s_dashboard', $data);
    }
    public function shopkeeperRegister(){
        $data = [
            'title' => 'Shopkeeper Register'
        ];
        $this->view('users/Shopkeeper/v_s_register', $data);
    }
}