<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
require_once APPROOT . '/controllers/Users.php';
require_once APPROOT . '/helpers/FileUploader.php';
class Notifications extends Controller
{
    private $notificationModel;
    private $customerModel;
    private $tailorModel;

    public function __construct()
    {

        $this->notificationModel = $this->model('M_Notifications');
        $this->customerModel = $this->model('M_Customers');
        $this->tailorModel = $this->model('M_Tailors');
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
    public function getTailorNotifications()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('Pages');
            return;
        }

        // Check if user is logged in as tailor
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'tailor') {
            echo json_encode([
                'status' => 'error',
                'message' => 'Authentication required'
            ]);
            return;
        }

        try {
            $userId = $_SESSION['user_id'];
            $notifications = [];

            // Get new appointment notifications
            $appointments = $this->tailorModel->getRecentAppointments($userId, 'pending');

            foreach ($appointments as $appointment) {
                $notifications[] = [
                    'id' => 'appointment_' . $appointment->appointment_id,
                    'type' => 'new_appointment',
                    'title' => 'New Appointment Request',
                    'message' => $appointment->customer_first_name . ' ' . $appointment->customer_last_name . ' has requested an appointment.',
                    'date' => $appointment->created_at,
                    'timestamp' => strtotime($appointment->created_at),
                    'is_read' => false,
                    'details' => [
                        'appointment_id' => $appointment->appointment_id,
                        'date' => $appointment->appointment_date,
                        'time' => $appointment->appointment_time,
                        'customer_name' => $appointment->customer_first_name . ' ' . $appointment->customer_last_name
                    ]
                ];
            }

            // Get new order notifications
            $orders = $this->tailorModel->getRecentOrders($userId, 'order_placed');

            foreach ($orders as $order) {
                $notifications[] = [
                    'id' => 'order_' . $order->order_id,
                    'type' => 'order_placed',
                    'title' => 'New Order Placed',
                    'message' => 'You have received a new order from ' . $order->customer_name,
                    'date' => $order->order_date,
                    'timestamp' => strtotime($order->order_date),
                    'is_read' => false,
                    'details' => [
                        'order_id' => $order->order_id,
                        'customer_name' => $order->customer_name,
                        'amount' => number_format($order->total_amount, 2)
                    ]
                ];
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
        } catch (Exception $e) {
            // Log the error
            error_log('Notification error: ' . $e->getMessage());

            // Return a more helpful error response
            echo json_encode([
                'status' => 'error',
                'message' => 'Error loading notifications: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('Pages');
            return;
        }

        // In a real implementation, you would update your database
        // For now, we'll just return success
        echo json_encode([
            'status' => 'success',
            'message' => 'All notifications marked as read'
        ]);
    }
}
