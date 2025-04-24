<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
require_once APPROOT . '/controllers/Users.php';
require_once APPROOT . '/helpers/FileUploader.php';
class Notifications extends Controller
{
    private $notificationModel;
    private $customerModel;

    public function __construct()
    {

        $this->notificationModel = $this->model('M_Notifications');
        $this->customerModel = $this->model('M_Customers');
    }

    /**
     * Get notifications for the current user
     */
    public function getNotifications()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('Pages'); // Redirect to home if not a POST request
            return;
        }

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Authentication required'
            ]);
            return;
        }

        $userType = $_SESSION['user_type'];
        $userId = $_SESSION['user_id'];
        $notifications = [];

        // Get notifications based on user type
        if ($userType === 'customer') {
            // Get appointment reschedule requests
            $rescheduleRequests = $this->customerModel->getRescheduleRequests($userId);

            // Format the notifications
            foreach ($rescheduleRequests as $appointmentId => $request) {
                // Get additional details about the tailor
                $appointment = $this->customerModel->getAppointmentDetails($appointmentId);

                if ($appointment) {
                    $notifications[] = [
                        'id' => 'reschedule_' . $request->request_id,
                        'type' => 'reschedule_request',
                        'title' => 'Appointment Reschedule Request',
                        'message' => 'Your tailor ' . $appointment->tailor_first_name . ' ' . $appointment->tailor_last_name . ' has requested to reschedule your appointment.',
                        'date' => date('Y-m-d H:i:s', strtotime($request->created_at)),
                        'timestamp' => strtotime($request->created_at),
                        'is_read' => false,
                        'appointment_id' => $appointmentId,
                        'details' => [
                            'proposed_date' => $request->proposed_date,
                            'proposed_time' => $request->proposed_time,
                            'reason' => $request->reason,
                            'tailor_name' => $appointment->tailor_first_name . ' ' . $appointment->tailor_last_name,
                        ]
                    ];
                }
            }
        }

        // Sort by timestamp (newest first)
        usort($notifications, function ($a, $b) {
            return $b['timestamp'] - $a['timestamp'];
        });

        echo json_encode([
            'status' => 'success',
            'count' => count($notifications),
            'notifications' => $notifications
        ]);
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead()
    {
        // To be implemented for actual database storage of read status
    }
}
