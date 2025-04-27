<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';

class Feedback extends Controller
{
    private $feedbackModel;

    public function __construct()
    {
        // Load the feedback model
        $this->feedbackModel = $this->model('M_Reviews');
    }

    // Submit feedback from the home page
    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Prepare data
            $data = [
                'user_id' => isLoggedIn() ? $_SESSION['user_id'] : null, // Use logged-in user ID if available
                'review_text' => trim($_POST['feedback']),
                'rating' => trim($_POST['rating']),
                'errors' => []
            ];

            // Validate data
            if (empty($data['review_text'])) {
                $data['errors']['review_text'] = 'Feedback cannot be empty.';
            }
            if (empty($data['rating'])) {
                $data['errors']['rating'] = 'Rating is required.';
            }

            // If no errors, save the feedback
            if (empty($data['errors'])) {
                if ($this->feedbackModel->addReview($data)) {
                    flash('feedback_message', 'Thank you for your feedback!');
                    redirect('pages/index#feedback');
                } else {
                    die('Something went wrong while submitting your feedback.');
                }
            } else {
                // Reload the page with errors
                $this->view('pages/v_home_page', $data);
            }
        } else {
            redirect('pages/index');
        }
    }

    // Fetch all reviews for the admin panel
    public function adminView()
    {
        $reviews = $this->feedbackModel->getAllReviews();

        $data = [
            'reviews' => $reviews
        ];

        $this->view('users/Admin/v_a_reviewSection', $data);
    }

    // Update review status (accept, reject, etc.)
    public function updateStatus($reviewId)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $status = trim($_POST['status']);
            
            if ($this->adminModel->updateReviewStatus($reviewId, $status, "")) {
                flash('review_message', 'Review status updated successfully');
            } else {
                flash('review_message', 'Failed to update review status', 'alert alert-danger');
            }
        }
        redirect('admin/reviewSection');
    }

    // Update review notes
    public function updateNotes($reviewId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $notes = trim($_POST['admin_notes']);
            $status = trim($_POST['status']);
            
            $success = $this->adminModel->updateReviewStatus($reviewId, $status, $notes);
            
            header('Content-Type: application/json');
            echo json_encode(['success' => $success]);
            exit;
        }
    }
}