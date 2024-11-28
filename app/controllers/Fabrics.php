<?php
require_once APPROOT . '/helpers/url_helper.php';

require_once APPROOT . '/helpers/session_helper.php';
class Fabrics extends Controller
{
    public $userModel;
    public $tailorModel;

    public function __construct()
    {
        $this->tailorModel = $this->model('M_Tailors');
        $this->userModel = $this->model('M_Users');
    }
    public function ValidateFabricData($data)
    {
        $errors = [];

        // Validate fabric name
        if (empty($data['fabric_name'])) {
            $errors['fabric_name_err'] = 'Please enter fabric name';
        }

        // Validate price
        if (empty($data['price'])) {
            $errors['price_err'] = 'Please enter price';
        } elseif ($data['price'] < 0) {
            $errors['price_err'] = 'Price cannot be negative';
        }

        // Validate stock
        if (empty($data['stock'])) {
            $errors['stock_err'] = 'Please enter stock quantity';
        } elseif ($data['stock'] < 0) {
            $errors['stock_err'] = 'Stock cannot be negative';
        }

        // Validate colors
        if (empty($data['colors'])) {
            $errors['color_err'] = 'Please select available colors';
        }

        // Validate image
        if (empty($data['image'])) {
            $errors['image_err'] = 'Please upload an image';
        } elseif (strlen($data['image']) > 1048576) { // 1MB = 1048576 bytes
            $errors['image_err'] = 'Image size cannot exceed 1MB';
        }

        return $errors;
    }
}
