<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
class Appointments extends Controller{
    private $appointmentModel;
    public function __construct()
    {
        $this->appointmentModel = $this->model('M_Appointments');
    }
}