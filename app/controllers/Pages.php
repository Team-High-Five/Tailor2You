<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
class Pages extends Controller{
    private $pageModel;
    private $userModel;
    public function __construct(){
        //load the model
        $this->pageModel = $this->model('M_Pages');
        $this->userModel = $this->model('M_Users');
    }
    public function index(){
        $data = [
            'title' => 'Home Page'
        ];
        $this->view('pages/v_home_page', $data);
    }
    public function about(){
      
        $users = $this->pageModel->getUsers();
        $data = [
            'users' => $users
        ];
        $this->view('v_about', $data);
    }
    public function mensPage(){
        $data = [
            'title' => 'Mens Page'
        ];
        $this->view('pages/v_mens_page', $data);
    }
    
    public function mensCategories(){
        
        $data = [
            
        ];
        $this->view('pages/v_mens_category', $data);
    }
    public function genderSel(){
        $users = $this->pageModel->getUsers();
        $data = [
            'users' => $users
            
        ];
        $this->view('pages/v_genderSelect', $data);
    }
}