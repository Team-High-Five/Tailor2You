<?php

class Tailors extends Controller{
    public function __construct()
    {
        $this->tailorModel = $this->model('M_Tailors');
    }
   
    public function index(){
        $data = [];

        $this->view('users/Tailor/v_t_dashboard', $data);   
    }

}