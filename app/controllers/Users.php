<?php
require_once APPROOT . '/helpers/url_helper.php';

require_once APPROOT . '/helpers/session_helper.php';
class Users extends Controller
{
    public $userModel;
    public $tailorModel;

    public function __construct()
    {
        $this->tailorModel = $this->model('M_Tailors');
        $this->userModel = $this->model('M_Users');
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
                'password_err' => '',
            ];

            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } elseif (!$this->userModel->findUserByEmail($data['email'])) {
                $data['email_err'] = 'No user found';
            }

            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

            // Check for user/email
            if (empty($data['email_err']) && empty($data['password_err'])) {
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                if (!$loggedInUser) {
                    $data['password_err'] = 'Password incorrect';
                } else {
                    $this->createUserSession($loggedInUser);
                }
            }

            // Load view with errors
            $this->view('users/v_login', $data);
        } else {
            // Init data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];

            // Load view
            $this->view('users/v_login', $data);
        }
    }


    public function createUserSession($user)
    {
        // Set session variables for the logged-in user
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['user_type'] = $user->user_type;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_first_name'] = $user->first_name;
        $_SESSION['user_last_name'] = $user->last_name;
        $_SESSION['user_profile_pic'] = $user->profile_pic;

        // Redirect to the user's dashboard based on user type
        switch ($user->user_type) {
            case 'tailor':
                redirect('tailors/index');
                break;
            case 'customer':
                redirect('pages/index');
                break;
            case 'shopkeeper':
                redirect('shopkeepers/index');
                break;
            case 'admin':
                redirect('admin/index');
                break;
            default:

                redirect('users/login');
                break;
        }
    }

    public function createTailorSession($tailor)
    {
        // Set session variables for the logged-in tailor
        $_SESSION['user_id'] = $tailor->user_id;
        $_SESSION['user_type'] = 'tailor';
        $_SESSION['user_email'] = $tailor->email;
        $_SESSION['user_first_name'] = $tailor->first_name;
        $_SESSION['user_last_name'] = $tailor->last_name;
        $_SESSION['user_profile_pic'] = $tailor->profile_pic;

        // Redirect to the tailor's dashboard
        redirect('tailors/index');
    }
    public function validateInput($data)
    {

    }

    public function selectCreateAccount()
    {
        $this->view('users/v_create_account');
    }
    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('pages/index');
    }
    public function isLoggedIn()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
}
