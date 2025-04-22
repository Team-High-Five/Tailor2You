<?php

require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
require_once '../app/models/M_Chat.php'; // Include the M_Chat model directly

class Chat extends Controller
{
    public function __construct()
    {
        // Directly instantiate the M_Chat class
        $this->chatModel = new M_Chat();
    }

    public function index()
    {
        $data = [
            'title' => 'messages'
        ];
        $this->view('users/Chat/v_s_message', $data);
    }

    public function messageGroup()
    {
        $data = [
            'title' => 'messages'
        ];
        $this->view('users/Chat/v_s_message_group', $data);
    }

    public function messageConv()
    {
        $this->view('users/Chat/v_s_message_conv');
    }

    public function messageConvDlt()
    {
        $this->view('users/Chat/v_s_message_conv_dlt');
    }

    public function messageGrpPeople()
    {
        $this->view('users/Chat/v_s_message_conv_dlt');
    }

    public function sendMessage()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $message = $data['message'];

            // Save the message using the M_Chat model
            if ($this->chatModel->saveMessage($message)) {
                echo json_encode(['status' => 'success', 'message' => 'Message sent']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to send message']);
            }
        }
    }

    public function getMessages()
    {
        $messages = $this->chatModel->getMessages();
        echo json_encode(['messages' => $messages]);
    }
}
