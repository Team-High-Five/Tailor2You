<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';

class Feedback extends Controller
{
    private $feedbackModel;
    
    public function __construct()
    {
        $this->feedbackModel = $this->model('M_Feedback');
    }
    
    // Public method to handle feedback submission from homepage
    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'rating' => trim($_POST['rating']),
                'feedback_text' => trim($_POST['feedback']),
                'name_err' => '',
                'email_err' => '',
                'rating_err' => '',
                'feedback_text_err' => ''
            ];
            
            // Validate inputs
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter your name';
            }
            
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter your email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Please enter a valid email';
            }
            
            if (empty($data['rating']) || !in_array($data['rating'], ['1', '2', '3', '4', '5'])) {
                $data['rating_err'] = 'Please select a rating';
            }
            
            if (empty($data['feedback_text'])) {
                $data['feedback_text_err'] = 'Please enter your feedback';
            }
            
            // Make sure there are no errors
            if (empty($data['name_err']) && empty($data['email_err']) && 
                empty($data['rating_err']) && empty($data['feedback_text_err'])) {
                
                // Save feedback
                if ($this->feedbackModel->addFeedback($data)) {
                    flash('feedback_message', 'Thank you for your feedback!');
                    redirect('pages');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Return to form with errors
                $this->view('pages/v_home_page', $data);
            }
        } else {
            // Redirect to homepage if not a POST request
            redirect('pages');
        }
    }
    
    // Get published feedback for public display (AJAX endpoint)
    public function getPublished()
    {
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
        $feedback = $this->feedbackModel->getPublishedFeedback($limit);
        
        header('Content-Type: application/json');
        echo json_encode($feedback);
    }
    
    // Admin methods below require authentication
    
    // Display all feedback for admin review
    public function index()
    {
        // Check if admin is logged in
        if (!isLoggedIn() || $_SESSION['user_type'] !== 'admin') {
            redirect('users/login');
        }
        
        $feedback = $this->feedbackModel->getAllFeedback();
        $data = [
            'title' => 'Feedback Management',
            'feedback' => $feedback
        ];
        
        $this->view('admin/feedback/index', $data);
    }
    
    // Change feedback status (publish or reject)
    public function updateStatus($id)
    {
        // Check if admin is logged in
        if (!isLoggedIn() || $_SESSION['user_type'] !== 'admin') {
            redirect('users/login');
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            
            $status = trim($_POST['status']);
            if (in_array($status, ['published', 'pending', 'rejected'])) {
                if ($this->feedbackModel->updateFeedbackStatus($id, $status)) {
                    flash('feedback_message', 'Feedback status updated');
                    redirect('feedback');
                } else {
                    die('Something went wrong');
                }
            } else {
                flash('feedback_message', 'Invalid status', 'alert alert-danger');
                redirect('feedback');
            }
        } else {
            redirect('feedback');
        }
    }
    
    // Delete feedback
    public function delete($id)
    {
        // Check if admin is logged in
        if (!isLoggedIn() || $_SESSION['user_type'] !== 'admin') {
            redirect('users/login');
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->feedbackModel->deleteFeedback($id)) {
                flash('feedback_message', 'Feedback deleted');
                redirect('feedback');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('feedback');
        }
    }
    
    // Display feedback statistics
    public function stats()
    {
        // Check if admin is logged in
        if (!isLoggedIn() || $_SESSION['user_type'] !== 'admin') {
            redirect('users/login');
        }
        
        $stats = [
            'total' => $this->feedbackModel->countFeedbackByStatus(),
            'published' => $this->feedbackModel->countFeedbackByStatus('published'),
            'pending' => $this->feedbackModel->countFeedbackByStatus('pending'),
            'rejected' => $this->feedbackModel->countFeedbackByStatus('rejected'),
            'average_rating' => $this->feedbackModel->getAverageRating()
        ];
        
        $data = [
            'title' => 'Feedback Statistics',
            'stats' => $stats
        ];
        
        $this->view('admin/feedback/stats', $data);
    }
}
