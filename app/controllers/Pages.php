<?php

class Pages extends Controller{
    private $pageModel;
    public function __construct(){
        //load the model
        $this->pageModel = $this->model('M_Pages');
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
    public function genderSel(){
       
        $data = [
            'users' => $users,
            
        ];
        $this->view('pages/v_genderSelect', $data);
    }
}