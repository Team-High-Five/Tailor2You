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

    public function refundPayments()
    {
        // Fetch data from the model (assuming you have a model method to get refund data)
        $users = $this->model('UserModel')->getRefundData(); // Adjust according to your model structure

        // Pass data to the view
        $data = ['users' => $users];

        $this->view('users/Admin/v_a_refundPayments', $data);
    }
    public function reviewSection()
    {
        $data = [];

        $this->view('users/Admin/v_a_reviewSection');
    }

}
?>