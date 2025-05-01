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
            $_SESSION['redirect_url'] = 'appointments/makeAppointment/' . $tailor_id;
            redirect('users/login');
            exit();
        }
        if ($tailor_id === null) {
            redirect('pages/tailorPages');
        }

        $tailor = $this->appointmentModel->getSellerById($tailor_id);
        if (!$tailor) {
            redirect('pages/tailorPages');
        }
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

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'tailor_id' => trim($_POST['tailor_id']),
            'appointment_date' => trim($_POST['appointment_date']),
            'appointment_time' => trim($_POST['appointment_time']),
            'date_err' => '',
            'time_err' => ''
        ];

        if (empty($data['appointment_date'])) {
            $data['date_err'] = 'Please select a date';
        } elseif (strtotime($data['appointment_date']) < strtotime(date('Y-m-d'))) {
            $data['date_err'] = 'Please select a future date';
        }

        if (empty($data['appointment_time'])) {
            $data['time_err'] = 'Please select a time slot';
        }

        if (empty($data['date_err']) && empty($data['time_err'])) {
            if ($this->appointmentModel->createAppointment($data)) {
                flash('appointment_success', 'Your appointment request has been sent successfully');
                redirect('Customers/displayAppointments');
            } else {
                flash('appointment_error', 'This time slot is already booked. Please select another time.', 'alert alert-danger');
                redirect('appointments/makeAppointment/' . $data['tailor_id']);
            }
        } else {
            $tailor = $this->appointmentModel->getSellerById($data['tailor_id']);
            $bookedSlots = $this->appointmentModel->getBookedTimeSlots($data['tailor_id'], $data['appointment_date']);

            $data['tailor'] = $tailor;
            $data['booked_slots'] = $bookedSlots;

            $this->view('pages/v_appointment', $data);
        }
    }
}
