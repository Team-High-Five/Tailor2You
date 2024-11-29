<?php

require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
class admin extends controller
{
    public function __construct()
    {

    }
    public function index()
    {
        $this->admindashboard();
    }

    public function admindashboard()
    {
        $data = [];

        $this->view('users/Admin/v_a_dashboard');
    }

    public function manageCustomer()
    {
        $userModel = $this->model('M_Users');
        $customers = $userModel->getAllCustomers();
        $data = ['customers' => $customers];

        $this->view('users/Admin/v_a_manageCustomer', $data);
    }
    public function manageShopkeeper()
    {
        $data = [];

        $this->view('users/Admin/v_a_manageShopkeeper');
    }
    public function manageTailor()
    {
        $data = [];

        $this->view('users/Admin/v_a_manageTailor');
    }
    public function complaintsSection()
    {
        $data = [];

        $this->view('users/Admin/v_a_complaintsSection');
    }
    public function generateReports()
    {
        $data = [];

        $this->view('users/Admin/v_a_generateReports');
    }
    public function editProfile()
    {
        $data = [];

        $this->view('users/Admin/v_a_editProfile');

    } 
    public function reviewSection()
    {
        $data = [];

        $this->view('users/Admin/v_a_reviewSection');
    }
    public function refundPayments()
    {
        $data = [];

        $this->view('users/Admin/v_a_refundPayments');

    }
    public function editShopkeeper()
    {
        $data = [];

        $this->view('users/Admin/v_a_editShopkeeper');

    }
    public function viewComplaints()
    {
        $data = [];

        $this->view('users/Admin/v_a_viewComplaints');

    }
    public function viewRefunds()
    {
        $data = [];

        $this->view('users/Admin/v_a_viewRefunds');
    }
    public function viewReviews()
    {
        $data = [];

        $this->view('users/Admin/v_a_viewReviews');

    }

}
?>