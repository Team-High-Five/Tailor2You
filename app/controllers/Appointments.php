<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
class Appointments extends Controller
{
    private $appointmentModel;
    public function __construct()
    {

        $this->appointmentModel = $this->model('M_Appointments');
    }
    public function index()
    {
        $this->view('pages/v_appointment');
    }


    public function makeAppointment($tailor_id = null)
    {
        if (!isLoggedIn()) {
            // Store only the relative path for redirect
            $_SESSION['redirect_url'] = 'appointments/makeAppointment/' . $tailor_id;
            redirect('users/login');
            exit();
        }
        if ($tailor_id === null) {
            redirect('pages/meetTailor');
        }

        $tailor = $this->appointmentModel->getTailorById($tailor_id);
        if (!$tailor) {
            redirect('pages/meetTailor');
        }

        // Get booked slots for today
        $date = isset($_POST['appointment_date']) ? $_POST['appointment_date'] : date('Y-m-d');
        $bookedSlots = $this->appointmentModel->getBookedTimeSlots($tailor_id, $date);

        $data = [
            'tailor' => $tailor,
            'booked_slots' => $bookedSlots,
            'date_err' => '',
            'time_err' => ''
        ];

        $this->view('pages/v_appointment', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('pages/meetTailor');
        }

        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        // Get form data
        $data = [
            'tailor_id' => trim($_POST['tailor_id']),
            'appointment_date' => trim($_POST['appointment_date']),
            'appointment_time' => trim($_POST['appointment_time']),
            'date_err' => '',
            'time_err' => ''
        ];

        // Validate Date
        if (empty($data['appointment_date'])) {
            $data['date_err'] = 'Please select a date';
        } elseif (strtotime($data['appointment_date']) < strtotime(date('Y-m-d'))) {
            $data['date_err'] = 'Please select a future date';
        }

        // Validate Time
        if (empty($data['appointment_time'])) {
            $data['time_err'] = 'Please select a time slot';
        }

        // Make sure errors are empty
        if (empty($data['date_err']) && empty($data['time_err'])) {
            // Create Appointment
            if ($this->appointmentModel->createAppointment($data)) {
                flash('appointment_success', 'Your appointment request has been sent successfully');
                redirect('Customers/displayAppointments');
            } else {
                flash('appointment_error', 'This time slot is already booked. Please select another time.', 'alert alert-danger');
                redirect('appointments/makeAppointment/' . $data['tailor_id']);
            }
        } else {
            // Load view with errors
            $tailor = $this->appointmentModel->getTailorById($data['tailor_id']);
            $bookedSlots = $this->appointmentModel->getBookedTimeSlots($data['tailor_id'], $data['appointment_date']);

            $data['tailor'] = $tailor;
            $data['booked_slots'] = $bookedSlots;

            $this->view('pages/v_appointment', $data);
        }
    }
}
