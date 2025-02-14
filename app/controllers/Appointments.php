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
}
