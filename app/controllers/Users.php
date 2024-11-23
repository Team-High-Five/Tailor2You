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
    // public function register()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         //process form
    //         //sanitize post data

    //         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    //         //input data
    //         $data = [
    //             'name' => trim($_POST['name']),
    //             'email' => trim($_POST['email']),
    //             'password' => trim($_POST['password']),
    //             'confirm_password' => trim($_POST['confirm_password']),

    //             'name_err' => '',
    //             'email_err' => '',
    //             'password_err' => '',
    //             'confirm_password_err' => ''
    //         ];
    //         //Validate inputs

    //         //validate email
    //         if (empty($data['email'])) {
    //             $data['email_err'] = 'Please enter email';
    //         } else {
    //             //check email
    //             if ($this->userModel->findUserByEmail($data['email'])) {
    //                 $data['email_err'] = 'Email is already taken';
    //             }
    //         }

    //         //validate name
    //         if (empty($data['name'])) {
    //             $data['name_err'] = 'Please enter name';
    //         }

    //         //validate password
    //         if (empty($data['password'])) {
    //             $data['password_err'] = 'Please enter password';
    //         } elseif (strlen($data['password']) < 6) {
    //             $data['password_err'] = 'Password must be at least 6 characters';
    //         }

    //         //validate confirm password
    //         if (empty($data['confirm_password'])) {
    //             $data['confirm_password_err'] = 'Please confirm password';
    //         } else {
    //             if ($data['password'] != $data['confirm_password']) {
    //                 $data['confirm_password_err'] = 'Passwords do not match';
    //             }
    //         }
    //         //make sure errors are empty
    //         if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
    //             //hash password
    //             $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

    //             //register user
    //             if ($this->userModel->register($data)) {
    //                 //redirect to login page
    //                 //create flash message
    //                 flash('register_success', 'You are registered and can log in');
    //                 redirect('users/login');

    //             } else {
    //                 die('Something went wrong');
    //             }
    //         } else {
    //             //load view with errors
    //             $this->view('users/v_register', $data);
    //         }
    //         $this->view('users/v_register', $data);
    //     } else {
    //         $data = [
    //             'name' => '',
    //             'email' => '',
    //             'password' => '',
    //             'confirm_password' => '',
    //             'name_err' => '',
    //             'email_err' => '',
    //             'password_err' => '',
    //             'confirm_password_err' => ''
    //         ];

    //         //load view
    //         $this->view('users/v_register', $data);
    //     }
    // }


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
                redirect('customers/index');
                break;
            case 'shopkeeper':
                redirect('shopkeepers/index');
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

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('users/login');
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
