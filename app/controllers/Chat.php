<?php

require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';

class Chat extends Controller
{
    private $chatModel; // Declare the property

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            redirect('Users/login');
        }

        // Initialize the M_Chat model
        $this->chatModel = $this->model('M_Chat');
    }

    public function index($receiver_id = null)
    {
        $users = $this->chatModel->getAllUsersExcept($_SESSION['user_id']); // Fetch all users except the logged-in user
        $conversations = $this->chatModel->getConversations($_SESSION['user_id']); // Fetch conversations for the logged-in user
        $data = [
            'users' => $users,
            'receiver_id' => $receiver_id,
            'receiver' => $receiver_id ? $this->chatModel->getReceiver($receiver_id) : null,
            'messages' => $receiver_id ? $this->chatModel->getMessages($_SESSION['user_id'], $receiver_id) : [],
            'conversations' => $conversations
        ];

        $this->view('users/Chat/v_s_message', $data);
    }

    public function sendMessage()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sender_id = $_SESSION['user_id'];
            $receiver_id = $_POST['receiver_id'];
            $message = trim($_POST['message']);

            if (!empty($message)) {
                $this->chatModel->saveMessage($sender_id, $receiver_id, $message);
            }

            redirect('Chat/index/' . $receiver_id);
        }
    }

    public function newConversation()
    {
        // Fetch all users except the logged-in user
        $users = $this->chatModel->getAllUsersExcept($_SESSION['user_id']);

        // Ensure $users is an array even if no users are found
        $users = $users ?? [];

        $data = [
            'users' => $users
        ];

        // Load the view with the data
        $this->view('users/Chat/v_newConversation', $data);
    }

    public function fetchNewConversation()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Fetch all users except the logged-in user
            $users = $this->chatModel->getAllUsersExcept($_SESSION['user_id']);

            // Check if users are fetched properly
            if (!$users) {
                $users = [];
            }

            $data = [
                'users' => $users
            ];

            // Load the contact list view as a partial
            $this->view('users/Chat/v_newConversation', $data);
        } else {
            redirect('Chat/index');
        }
    }
}
