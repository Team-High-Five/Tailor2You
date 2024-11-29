<?php
class admin extends controller{
    public function __construct() {

    }
    public function admindashboard(){
        $data = [];

        $this->view('users/Admin/v_a_dashboard');
    }

    public function manageCustomer(){
        $data = [];

        $this->view('users/Admin/v_a_manageCustomer');
    }
    public function manageShopkeeper(){
        $data = [];

        $this->view('users/Admin/v_a_manageShopkeeper');
    }
    public function manageTailor(){
        $data = [];

        $this->view('users/Admin/v_a_manageTailor');
    }
    public function complaintsSection(){
        $data = [];

        $this->view('users/Admin/v_a_complaintsSection');
    } 
    public function generateReports(){
        $data = [];

        $this->view('users/Admin/v_a_generateReports');
    } 
    public function editProfile(){
        $data = [];

        $this->view('users/Admin/v_a_editProfile');
    }   
}
?>