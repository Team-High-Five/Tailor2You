<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';

class Fabrics extends Controller
{
    private $fabricModel;

    public function __construct()
    {
        $this->fabricModel = $this->model('M_Fabrics');
    }

    public function displayFabricStock($user_id, $view)
    {
        $fabrics = $this->fabricModel->getFabricsByUserId($user_id);

        $data = [
            'title' => 'Fabric Stock',
            'fabrics' => $fabrics
        ];

        $this->view($view, $data);
    }

    public function addNewFabric($user_id, $view, $controller)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = file_get_contents($_FILES['image']['tmp_name']);
            }

            $data = [
                'user_id' => $user_id,
                'fabric_name' => trim($_POST['fabric_name']),
                'price' => trim($_POST['price']),
                'colors' => $_POST['colors'],
                'stock' => trim($_POST['stock']),
                'image' => $image,
                'fabric_name_err' => '',
                'price_err' => '',
                'color_err' => '',
                'stock_err' => '',
                'image_err' => ''
            ];

            $errors = $this->validateFabricData($data);
            $data = array_merge($data, $errors);

            if (empty($errors)) {
                if ($this->fabricModel->addFabric($data)) {
                    flash('fabric_message', 'Fabric added successfully');
                    redirect($controller . '/displayFabricStock');
                } else {
                    die('Something went wrong');
                }
            } else {
                $data['colors'] = $this->fabricModel->getColors();
                $this->view($view, $data);
            }
        } else {
            $data = [
                'fabric_name' => '',
                'price' => '',
                'colors' => $this->fabricModel->getColors(),
                'stock' => '',
                'image' => '',
                'fabric_name_err' => '',
                'price_err' => '',
                'color_err' => '',
                'stock_err' => '',
                'image_err' => ''
            ];

            $this->view($view, $data);
        }
    }
    public function editFabric($fabric_id, $user_id, $view, $controller)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = file_get_contents($_FILES['image']['tmp_name']);
            } else {
                $fabric = $this->fabricModel->getFabricById($fabric_id);
                $image = $fabric->image;
            }

            $data = [
                'fabric_id' => $fabric_id,
                'fabric_name' => trim($_POST['fabric_name']),
                'price' => trim($_POST['price']),
                'colors' => $_POST['colors'],
                'stock' => trim($_POST['stock']),
                'image' => $image,
                'fabric_name_err' => '',
                'price_err' => '',
                'color_err' => '',
                'stock_err' => '',
                'image_err' => ''
            ];

            $errors = $this->validateFabricData($data);
            $data = array_merge($data, $errors);

            if (empty($errors)) {
                if ($this->fabricModel->updateFabric($data)) {
                    flash('fabric_message', 'Fabric updated successfully');
                    redirect($controller . '/displayFabricStock');
                } else {
                    die('Something went wrong');
                }
            } else {
                $data['colors'] = $this->fabricModel->getColors();
                $this->view($view, $data);
            }
        } else {
            $fabric = $this->fabricModel->getFabricById($fabric_id);

            if (!$fabric) {
                flash('fabric_message', 'Fabric not found', 'alert alert-danger');
                redirect($controller . '/displayFabricStock');
            }

            $data = [
                'fabric_id' => $fabric->fabric_id,
                'fabric_name' => $fabric->fabric_name,
                'price' => $fabric->price_per_meter,
                'colors' => $this->fabricModel->getColors(),
                'selected_colors' => explode(', ', $fabric->colors),
                'stock' => $fabric->stock,
                'image' => $fabric->image,
                'fabric_name_err' => '',
                'price_err' => '',
                'color_err' => '',
                'stock_err' => '',
                'image_err' => ''
            ];

            $this->view($view, $data);
        }
    }

    public function deleteFabric($fabric_id, $user_id, $view, $controller)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->fabricModel->deleteFabric($fabric_id)) {
                flash('fabric_message', 'Fabric deleted successfully');
                redirect($controller . '/displayFabricStock');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect($controller . '/displayFabricStock');
        }
    }

    private function validateFabricData($data)
    {
        $errors = [];

        if (empty($data['fabric_name'])) {
            $errors['fabric_name_err'] = 'Please enter fabric name';
        }

        if (empty($data['price'])) {
            $errors['price_err'] = 'Please enter price';
        } elseif ($data['price'] < 0) {
            $errors['price_err'] = 'Price cannot be negative';
        }

        if (empty($data['stock'])) {
            $errors['stock_err'] = 'Please enter stock quantity';
        } elseif ($data['stock'] < 0) {
            $errors['stock_err'] = 'Stock cannot be negative';
        }

        if (empty($data['colors'])) {
            $errors['color_err'] = 'Please select available colors';
        }

        if (empty($data['image'])) {
            $errors['image_err'] = 'Please upload an image';
        } elseif (strlen($data['image']) > 1048576) { // 1MB = 1048576 bytes
            $errors['image_err'] = 'Image size cannot exceed 1MB';
        }

        return $errors;
    }
}
