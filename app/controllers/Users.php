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
    public function index()
    {
        // Redirect to a default method or view
        $this->viewAllUsers();
    }

    public function viewAllUsers()
    {
        $users = $this->userModel->getAllUsers();
        $data = ['users' => $users];

        $this->view('users/Admin/v_a_viewAllUsers', $data);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } elseif (!$this->userModel->findUserByEmail($data['email'])) {

                $data['email_err'] = 'No user found';
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

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

    public function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Input data
            $data = [
                'current_password' => trim($_POST['current_password']),
                'new_password' => trim($_POST['new_password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'current_password_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => '',
                'succeed_password' => '',
                'title' => 'Change Password'
            ];

            // Validate current password
            if (empty($data['current_password'])) {
                $data['current_password_err'] = 'Please enter current password';
            } elseif (!$this->userModel->checkPassword($_SESSION['user_id'], $data['current_password'])) {
                $data['current_password_err'] = 'Current password is incorrect';
            }

            // Validate new password
            if (empty($data['new_password'])) {
                $data['new_password_err'] = 'Please enter new password';
            } elseif (strlen($data['new_password']) < 6) {
                $data['new_password_err'] = 'Password must be at least 6 characters long';
            }

            // Validate confirm password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } elseif ($data['new_password'] != $data['confirm_password']) {
                $data['confirm_password_err'] = 'Passwords do not match';
            }

            // Check for errors
            if (empty($data['current_password_err']) && empty($data['new_password_err']) && empty($data['confirm_password_err'])) {
                // Update the password in the database
                if ($this->userModel->updatePassword($_SESSION['user_id'], $data['new_password'])) {
                    flash('user_message', 'Password changed successfully');
                    redirect('/Customers/changePassword');
                } else {
                    flash('user_message', 'Something went wrong, please try again', 'alert alert-danger');
                    redirect('/Customers/changePassword');
                }
            } else {
                // Load view with errors
                $this->view('users/Customer/v_c_changepassword', $data);
            }
        } else {
            // Init data
            $data = [
                'current_password' => '',
                'new_password' => '',
                'confirm_password' => '',
                'current_password_err' => '',
                'new_password_err' => '',
                'confirm_password_err' => '',
            ];

            // Load view
            $this->view('/Customers/changePassword', $data);
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


        if (isset($_SESSION['redirect_url']) && $_SESSION['user_type'] == 'customer') {
            $redirect = $_SESSION['redirect_url'];
            unset($_SESSION['redirect_url']);
            // Use the clean path
            redirect($redirect); // Your redirect helper will add URLROOT correctly
        } else {
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
    public function validateInput($data) {}

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
    public function deleteUser($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Check if the user exists
            $user = $this->userModel->getUserById($id);

            if ($user) {
                // Delete the user
                if ($this->userModel->deleteUserById($id)) {
                    // Log the user out and destroy the session
                    $this->logout();
                    flash('user_message', 'User profile deleted successfully');
                    redirect('pages/index');
                } else {
                    flash('user_message', 'Something went wrong, please try again', 'alert alert-danger');
                    redirect('users/profile');
                }
            } else {
                flash('user_message', 'User not found', 'alert alert-danger');
                redirect('users/profile');
            }
        } else {
            redirect('users/profile');
        }
    }
}
