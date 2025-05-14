<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';

class Feedback extends Controller
{
    private $feedbackModel;

    public function __construct()
    {
        // Make sure we're loading the right model
        $this->feedbackModel = $this->model('M_Reviews');
    }

    public function index()
    {
        // Get reviews to display
        $reviews = $this->feedbackModel->getLatestReviews(5); // Get 5 latest reviews

        $data = [
            'reviews' => $reviews
        ];

        $this->view('pages/v_home_page', $data);
    }

    public function submit()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            flash('feedback_error', 'You must be logged in to submit feedback');
            redirect('users/login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_id' => $_SESSION['user_id'],
                'feedback' => trim($_POST['feedback']), // This is mapped to review_text in the model
                'rating' => trim($_POST['rating']),
                'rating_err' => '',
                'feedback_err' => ''
            ];

            // Validate data
            if (empty($data['rating'])) {
                $data['rating_err'] = 'Please select a rating';
            }

            if (empty($data['feedback'])) {
                $data['feedback_err'] = 'Please enter your feedback';
            }

            // Make sure no errors
            if (empty($data['rating_err']) && empty($data['feedback_err'])) {
                // Submit feedback
                if ($this->feedbackModel->addFeedback($data)) {
                    flash('feedback_success', 'Your feedback has been submitted successfully');
                    redirect('pages/index');
                } else {
                    flash('feedback_error', 'Something went wrong, please try again');
                    // Get reviews to display
                    $reviews = $this->feedbackModel->getLatestReviews(5);
                    $data['reviews'] = $reviews;
                    $this->view('pages/v_home_page', $data);
                }
            } else {
                // Load view with errors
                flash('feedback_error', 'Please fix the errors in your submission');
                // Get reviews to display
                $reviews = $this->feedbackModel->getLatestReviews(5);
                $data['reviews'] = $reviews;
                $this->view('pages/v_home_page', $data);
            }
        } else {
            // Redirect to homepage if not POST request
            redirect('pages/index');
        }
    }
}
