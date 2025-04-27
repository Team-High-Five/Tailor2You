<?php
require_once APPROOT . '/helpers/url_helper.php';

require_once APPROOT . '/helpers/session_helper.php';

require_once APPROOT . '/controllers/Fabrics.php';
require_once APPROOT . '/helpers/FileUploader.php';


class Api extends Controller
{
    private $tailorModel;

    public function __construct()
    {
        $this->tailorModel = $this->model('M_Tailors');

        // Check if user is logged in as tailor
        if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'tailor') {
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        // Set content type to JSON
        header('Content-Type: application/json');
    }
}
