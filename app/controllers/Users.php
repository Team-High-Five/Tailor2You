<?php

class Users extends Controller
{

    public function __construct()
    {
        $this->userModel = $this->model('M_Users');
    }
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //process form
            //sanitize post data

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //input data
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),

                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            //Validate inputs

            //validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                //check email
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already taken';
                }
            }

            //validate name
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }

            //validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            //validate confirm password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }
            //make sure errors are empty
            if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                //hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                //register user
                if ($this->userModel->register($data)) {
                    //redirect to login page
                    //create flash message
                    flash('register_success', 'You are registered and can log in');
                    redirect('users/login');
                    
                } else {
                    die('Something went wrong');
                }
            } else {
                //load view with errors
                $this->view('users/v_register', $data);
            }
            $this->view('users/v_register', $data);
        } else {
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            //load view
            $this->view('users/v_register', $data);
        }
    }
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //process form
            //sanitize post data

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //input data
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),

                'email_err' => '',
                'password_err' => ''
            ];
            //Validate inputs

            //validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }

            //check for user/email
            else if ($this->userModel->findUserByEmail($data['email'])) {
                //user found
            } else {
                //user not found
                $data['email_err'] = 'No user found';
            }

            //validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

            
            

            //make sure errors are empty
            if (empty($data['email_err']) && empty($data['password_err'])) {
                //check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                if ($loggedInUser) {
                    //create session
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->view('users/v_login', $data);
                }
            } else {
                //load view with errors
                $this->view('users/v_login', $data);
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            //load view
            $this->view('users/v_login', $data);
        }
    }
    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        redirect('pages/index');
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