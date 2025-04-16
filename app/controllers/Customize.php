<?php
// Include required helper files at the top of the controller
require_once '../app/helpers/Session_Helper.php';
require_once '../app/helpers/URL_Helper.php';

class Customize extends Controller {
    private $customizationModel;
    
    public function __construct() {
        // Check if user is logged in
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        
        // Initialize model
        $this->customizationModel = $this->model('M_Customization');
    }
    
    // Main page for customization
    public function index() {
        // Get all categories
        $categories = $this->customizationModel->getCategories();
        
        // Get subcategories for the first category (if any)
        $subcategories = [];
        if (!empty($categories)) {
            $subcategories = $this->customizationModel->getSubcategories($categories[0]->category_id);
        }
        
        // Get button, collar, and pocket types
        $buttonTypes = $this->customizationModel->getButtonTypes();
        $collarTypes = $this->customizationModel->getCollarTypes();
        $pocketTypes = $this->customizationModel->getPocketTypes();
        
        // Get all subcategories with category names for the management interface
        $allSubcategories = $this->customizationModel->getAllSubcategories();
        
        // Get product image if categories and subcategories exist
        $productImage = null;
        if (!empty($categories) && !empty($subcategories)) {
            $productImage = $this->customizationModel->getProductImage(
                $categories[0]->category_id, 
                $subcategories[0]->subcategory_id
            );
        }
        
        // Prepare data for the view
        $data = [
            'categories' => $categories,
            'subcategories' => $subcategories,
            'buttonTypes' => $buttonTypes,
            'collarTypes' => $collarTypes,
            'pocketTypes' => $pocketTypes,
            'allSubcategories' => $allSubcategories,
            'productImage' => $productImage
        ];
        
        // Load view
        $this->view('users/ShopKeeper/v_s_customize_add_new', $data);
    }
    
    // API endpoint to get subcategories for a category
    public function getSubcategories($categoryId) {
        // Validate input
        if (!$categoryId) {
            echo json_encode(['error' => 'Invalid category ID']);
            return;
        }
        
        $subcategories = $this->customizationModel->getSubcategories($categoryId);
        echo json_encode($subcategories);
    }
    
    // API endpoint to get product image for category/subcategory combination
    public function getProductImage($categoryId, $subcategoryId) {
        // Validate input
        if (!$categoryId || !$subcategoryId) {
            echo json_encode(['error' => 'Invalid category or subcategory ID']);
            return;
        }
        
        $productImage = $this->customizationModel->getProductImage($categoryId, $subcategoryId);
        echo json_encode($productImage);
    }
    
    // API endpoint to upload product image
    public function uploadProductImage() {
        // Check if it's a POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }
        
        // Validate inputs
        if (!isset($_POST['category_id']) || !isset($_POST['subcategory_id']) || !isset($_FILES['image'])) {
            echo json_encode(['success' => false, 'message' => 'Missing required data']);
            return;
        }
        
        $categoryId = $_POST['category_id'];
        $subcategoryId = $_POST['subcategory_id'];
        $file = $_FILES['image'];
        
        // Basic validation
        if ($file['error'] !== 0) {
            echo json_encode(['success' => false, 'message' => 'Error uploading file']);
            return;
        }
        
        // Create uploads directory if it doesn't exist
        $uploadDir = APPROOT . '/../public/img/products/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'product_' . $categoryId . '_' . $subcategoryId . '_' . uniqid() . '.' . $extension;
        $targetPath = $uploadDir . $filename;
        $dbPath = '/public/img/products/' . $filename;
        
        // Move the uploaded file
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            // TODO: Update database with the new image path
            // For now, we'll just return success
            echo json_encode(['success' => true, 'image_path' => $dbPath]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save the uploaded file']);
        }
    }
    
    // API endpoint to add new customization option (button, collar, pocket)
    public function addOption() {
        // Check if it's a POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }
        
        // Validate inputs
        if (!isset($_POST['name']) || !isset($_POST['option_type']) || !isset($_FILES['image'])) {
            echo json_encode(['success' => false, 'message' => 'Missing required data']);
            return;
        }
        
        $name = $_POST['name'];
        $optionType = $_POST['option_type'];
        $file = $_FILES['image'];
        $userId = $_SESSION['user_id'] ?? null;
        
        // Basic validation
        if ($file['error'] !== 0) {
            echo json_encode(['success' => false, 'message' => 'Error uploading file']);
            return;
        }
        
        // Create uploads directory if it doesn't exist
        $uploadDir = APPROOT . '/../public/img/options/' . $optionType . 's/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $optionType . '_' . preg_replace('/[^a-z0-9]/i', '_', strtolower($name)) . '_' . uniqid() . '.' . $extension;
        $targetPath = $uploadDir . $filename;
        $dbPath = '/public/img/options/' . $optionType . 's/' . $filename;
        
        // Move the uploaded file
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            // Add to database based on option type
            $result = false;
            switch ($optionType) {
                case 'button':
                    $result = $this->customizationModel->addButtonType($name, $dbPath, $userId);
                    break;
                case 'collar':
                    $result = $this->customizationModel->addCollarType($name, $dbPath, $userId);
                    break;
                case 'pocket':
                    $result = $this->customizationModel->addPocketType($name, $dbPath, $userId);
                    break;
            }
            
            if ($result) {
                echo json_encode(['success' => true, 'id' => $result]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add new option to database']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save the uploaded file']);
        }
    }
    
    // Category CRUD operations
    public function addCategory() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('customize');
        }
        
        $name = trim($_POST['name'] ?? '');
        
        if (empty($name)) {
            flash('category_error', 'Category name is required');
            redirect('customize');
        }
        
        $userId = $_SESSION['user_id'] ?? null;
        $result = $this->customizationModel->addCategory($name, $userId);
        
        if ($result) {
            flash('category_success', 'Category added successfully');
        } else {
            flash('category_error', 'Failed to add category');
        }
        
        redirect('customize');
    }
    
    public function updateCategory() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('customize');
        }
        
        $categoryId = $_POST['category_id'] ?? '';
        $name = trim($_POST['name'] ?? '');
        
        if (empty($categoryId) || empty($name)) {
            flash('category_error', 'Category ID and name are required');
            redirect('customize');
        }
        
        $userId = $_SESSION['user_id'] ?? null;
        $result = $this->customizationModel->updateCategory($categoryId, $name, $userId);
        
        if ($result) {
            flash('category_success', 'Category updated successfully');
        } else {
            flash('category_error', 'Failed to update category');
        }
        
        redirect('customize');
    }
    
    public function deleteCategory($categoryId) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }
        
        if (!$categoryId) {
            echo json_encode(['success' => false, 'message' => 'Invalid category ID']);
            return;
        }
        
        $userId = $_SESSION['user_id'] ?? null;
        $result = $this->customizationModel->deleteCategory($categoryId, $userId);
        
        echo json_encode(['success' => $result]);
    }
    
    // Subcategory CRUD operations
    public function addSubcategory() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('customize');
        }
        
        $categoryId = $_POST['category_id'] ?? '';
        $name = trim($_POST['name'] ?? '');
        
        if (empty($categoryId) || empty($name)) {
            flash('subcategory_error', 'Category and name are required');
            redirect('customize');
        }
        
        $userId = $_SESSION['user_id'] ?? null;
        $result = $this->customizationModel->addSubcategory($categoryId, $name, $userId);
        
        if ($result) {
            flash('subcategory_success', 'Subcategory added successfully');
        } else {
            flash('subcategory_error', 'Failed to add subcategory');
        }
        
        redirect('customize');
    }
    
    public function updateSubcategory() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('customize');
        }
        
        $subcategoryId = $_POST['subcategory_id'] ?? '';
        $categoryId = $_POST['category_id'] ?? '';
        $name = trim($_POST['name'] ?? '');
        
        if (empty($subcategoryId) || empty($categoryId) || empty($name)) {
            flash('subcategory_error', 'Subcategory ID, category ID, and name are required');
            redirect('customize');
        }
        
        $userId = $_SESSION['user_id'] ?? null;
        $result = $this->customizationModel->updateSubcategory($subcategoryId, $categoryId, $name, $userId);
        
        if ($result) {
            flash('subcategory_success', 'Subcategory updated successfully');
        } else {
            flash('subcategory_error', 'Failed to update subcategory');
        }
        
        redirect('customize');
    }
    
    public function deleteSubcategory($subcategoryId) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }
        
        if (!$subcategoryId) {
            echo json_encode(['success' => false, 'message' => 'Invalid subcategory ID']);
            return;
        }
        
        $userId = $_SESSION['user_id'] ?? null;
        $result = $this->customizationModel->deleteSubcategory($subcategoryId, $userId);
        
        echo json_encode(['success' => $result]);
    }
    
    // Button Type CRUD operations
    public function addButtonType() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('customize');
        }
        
        $name = trim($_POST['name'] ?? '');
        
        if (empty($name) || !isset($_FILES['image'])) {
            flash('button_error', 'Button type name and image are required');
            redirect('customize');
        }
        
        $file = $_FILES['image'];
        if ($file['error'] !== 0) {
            flash('button_error', 'Error uploading image');
            redirect('customize');
        }
        
        // Upload handling code (reusing existing logic)
        $uploadDir = APPROOT . '/../public/img/options/buttons/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'button_' . preg_replace('/[^a-z0-9]/i', '_', strtolower($name)) . '_' . uniqid() . '.' . $extension;
        $targetPath = $uploadDir . $filename;
        $dbPath = '/public/img/options/buttons/' . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $userId = $_SESSION['user_id'] ?? null;
            $result = $this->customizationModel->addButtonType($name, $dbPath, $userId);
            
            if ($result) {
                flash('button_success', 'Button type added successfully');
            } else {
                flash('button_error', 'Failed to add button type');
            }
        } else {
            flash('button_error', 'Failed to save uploaded image');
        }
        
        redirect('customize');
    }
    
    public function updateButtonType() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('customize');
        }
        
        $buttonId = $_POST['button_id'] ?? '';
        $name = trim($_POST['name'] ?? '');
        
        if (empty($buttonId) || empty($name)) {
            flash('button_error', 'Button type ID and name are required');
            redirect('customize');
        }
        
        $userId = $_SESSION['user_id'] ?? null;
        $dbPath = null;
        
        // Handle image upload if a new image was provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $file = $_FILES['image'];
            $uploadDir = APPROOT . '/../public/img/options/buttons/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'button_' . preg_replace('/[^a-z0-9]/i', '_', strtolower($name)) . '_' . uniqid() . '.' . $extension;
            $targetPath = $uploadDir . $filename;
            $dbPath = '/public/img/options/buttons/' . $filename;
            
            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                flash('button_error', 'Failed to upload button image');
                redirect('customize');
            }
        }
        
        $result = $this->customizationModel->updateButtonType($buttonId, $name, $dbPath, $userId);
        
        if ($result) {
            flash('button_success', 'Button type updated successfully');
        } else {
            flash('button_error', 'Failed to update button type');
        }
        
        redirect('customize');
    }
    
    // Collar Type CRUD operations
    public function addCollarType() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('customize');
        }
        
        $name = trim($_POST['name'] ?? '');
        
        if (empty($name) || !isset($_FILES['image'])) {
            flash('collar_error', 'Collar type name and image are required');
            redirect('customize');
        }
        
        $file = $_FILES['image'];
        if ($file['error'] !== 0) {
            flash('collar_error', 'Error uploading image');
            redirect('customize');
        }
        
        // Upload handling code
        $uploadDir = APPROOT . '/../public/img/options/collars/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'collar_' . preg_replace('/[^a-z0-9]/i', '_', strtolower($name)) . '_' . uniqid() . '.' . $extension;
        $targetPath = $uploadDir . $filename;
        $dbPath = '/public/img/options/collars/' . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $userId = $_SESSION['user_id'] ?? null;
            $result = $this->customizationModel->addCollarType($name, $dbPath, $userId);
            
            if ($result) {
                flash('collar_success', 'Collar type added successfully');
            } else {
                flash('collar_error', 'Failed to add collar type');
            }
        } else {
            flash('collar_error', 'Failed to save uploaded image');
        }
        
        redirect('customize');
    }
    
    public function updateCollarType() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('customize');
        }
        
        $collarId = $_POST['collar_id'] ?? '';
        $name = trim($_POST['name'] ?? '');
        
        if (empty($collarId) || empty($name)) {
            flash('collar_error', 'Collar type ID and name are required');
            redirect('customize');
        }
        
        $userId = $_SESSION['user_id'] ?? null;
        $dbPath = null;
        
        // Handle image upload if a new image was provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $file = $_FILES['image'];
            $uploadDir = APPROOT . '/../public/img/options/collars/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'collar_' . preg_replace('/[^a-z0-9]/i', '_', strtolower($name)) . '_' . uniqid() . '.' . $extension;
            $targetPath = $uploadDir . $filename;
            $dbPath = '/public/img/options/collars/' . $filename;
            
            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                flash('collar_error', 'Failed to upload collar image');
                redirect('customize');
            }
        }
        
        $result = $this->customizationModel->updateCollarType($collarId, $name, $dbPath, $userId);
        
        if ($result) {
            flash('collar_success', 'Collar type updated successfully');
        } else {
            flash('collar_error', 'Failed to update collar type');
        }
        
        redirect('customize');
    }
    
    // Pocket Type CRUD operations
    public function addPocketType() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('customize');
        }
        
        $name = trim($_POST['name'] ?? '');
        
        if (empty($name) || !isset($_FILES['image'])) {
            flash('pocket_error', 'Pocket type name and image are required');
            redirect('customize');
        }
        
        $file = $_FILES['image'];
        if ($file['error'] !== 0) {
            flash('pocket_error', 'Error uploading image');
            redirect('customize');
        }
        
        // Upload handling code
        $uploadDir = APPROOT . '/../public/img/options/pockets/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'pocket_' . preg_replace('/[^a-z0-9]/i', '_', strtolower($name)) . '_' . uniqid() . '.' . $extension;
        $targetPath = $uploadDir . $filename;
        $dbPath = '/public/img/options/pockets/' . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $userId = $_SESSION['user_id'] ?? null;
            $result = $this->customizationModel->addPocketType($name, $dbPath, $userId);
            
            if ($result) {
                flash('pocket_success', 'Pocket type added successfully');
            } else {
                flash('pocket_error', 'Failed to add pocket type');
            }
        } else {
            flash('pocket_error', 'Failed to save uploaded image');
        }
        
        redirect('customize');
    }
    
    public function updatePocketType() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('customize');
        }
        
        $pocketId = $_POST['pocket_id'] ?? '';
        $name = trim($_POST['name'] ?? '');
        
        if (empty($pocketId) || empty($name)) {
            flash('pocket_error', 'Pocket type ID and name are required');
            redirect('customize');
        }
        
        $userId = $_SESSION['user_id'] ?? null;
        $dbPath = null;
        
        // Handle image upload if a new image was provided
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $file = $_FILES['image'];
            $uploadDir = APPROOT . '/../public/img/options/pockets/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = 'pocket_' . preg_replace('/[^a-z0-9]/i', '_', strtolower($name)) . '_' . uniqid() . '.' . $extension;
            $targetPath = $uploadDir . $filename;
            $dbPath = '/public/img/options/pockets/' . $filename;
            
            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                flash('pocket_error', 'Failed to upload pocket image');
                redirect('customize');
            }
        }
        
        $result = $this->customizationModel->updatePocketType($pocketId, $name, $dbPath, $userId);
        
        if ($result) {
            flash('pocket_success', 'Pocket type updated successfully');
        } else {
            flash('pocket_error', 'Failed to update pocket type');
        }
        
        redirect('customize');
    }
    
    // Delete methods for collar and pocket types
    public function deleteCollarType($collarId) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }
        
        if (!$collarId) {
            echo json_encode(['success' => false, 'message' => 'Invalid collar type ID']);
            return;
        }
        
        $userId = $_SESSION['user_id'] ?? null;
        $result = $this->customizationModel->deactivateCollarType($collarId, $userId);
        
        echo json_encode(['success' => $result]);
    }
    
    public function deletePocketType($pocketId) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }
        
        if (!$pocketId) {
            echo json_encode(['success' => false, 'message' => 'Invalid pocket type ID']);
            return;
        }
        
        $userId = $_SESSION['user_id'] ?? null;
        $result = $this->customizationModel->deactivatePocketType($pocketId, $userId);
        
        echo json_encode(['success' => $result]);
    }
    
    public function deleteButtonType($buttonId) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }
        
        if (!$buttonId) {
            echo json_encode(['success' => false, 'message' => 'Invalid button type ID']);
            return;
        }
        
        $userId = $_SESSION['user_id'] ?? null;
        $result = $this->customizationModel->deactivateButtonType($buttonId, $userId);
        
        echo json_encode(['success' => $result]);
    }
}
?>
