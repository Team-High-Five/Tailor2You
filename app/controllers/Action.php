<?php

require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
class Action extends controller
{
    public function __construct() {}

    public function index()
    {
        $data = [
            'title' => 'messages'
        ];
        $this->view('users/Action/v_s_message', $data);
    }
    public function messageGroup()
    {
        $data = [
            'title' => 'messages'
        ];
        $this->view('users/Action/v_s_message_group',$data);
    }
    public function messageConv()
    {
        $this->view('users/Action/v_s_message_conv');
    }
    public function messageConvDlt()
    {
        $this->view('users/Action/v_s_message_conv_dlt');
    }
    public function messageGrpPeople()
    {
        $this->view('users/Action/v_s_message_conv_dlt');
    }
}
