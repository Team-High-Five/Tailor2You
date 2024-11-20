<?php
    
class Login extends Controller{
    
    public function index()
    {

        $this->view('/users/v_login');
    }

    public function login()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Process form
        // Sanitize post data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Input data
        $data = [
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'email_err' => '',
            'password_err' => ''
        ];

        // Validate email
        if (empty($data['email'])) {
            $data['email_err'] = 'Please enter email';
        }

        // Validate password
        if (empty($data['password'])) {
            $data['password_err'] = 'Please enter password';
        }

        // Check if email exists
        if (empty($data['email_err']) && $this->customerModel->findTailorByEmail($data['email']) === false) {
            $data['email_err'] = 'No user found with this email';
        }

        // Make sure errors are empty
        if (empty($data['email_err']) && empty($data['password_err'])) {
            // Attempt to log the user in
            $loggedInUser = $this->customerModel->login($data['email'], $data['password']);

            if ($loggedInUser) {
                // Create session
                $_SESSION['user_id'] = $loggedInUser->id;
                $_SESSION['user_email'] = $loggedInUser->email;
                $_SESSION['user_name'] = $loggedInUser->first_name . ' ' . $loggedInUser->last_name;

                // Redirect to dashboard
                redirect('customer/index');
            } else {
                $data['password_err'] = 'Password incorrect';

                // Load view with errors
                $this->view('users/v_login', $data);
            }
        } else {
            // Load view with errors
            $this->view('users/v_login', $data);
        }
    } else {
        // Init data
        $data = [
            'email' => '',
            'password' => '',
            'email_err' => '',
            'password_err' => ''
        ];

        // Load view
        $this->view('users/v_login', $data);
    }
}


    

}