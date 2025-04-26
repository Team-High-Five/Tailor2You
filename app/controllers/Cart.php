
<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
class Cart extends Controller
{
    private $cartModel;

    public function __construct()
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $this->cartModel = $this->model('M_Cart');
    }

    public function index()
    {
        // Get cart items for the logged-in user
        $cartItems = $this->cartModel->getCartItems($_SESSION['user_id']);

        $data = [
            'cart_items' => $cartItems
        ];

        $this->view('users/Customer/v_c_cart', $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $designId = isset($_POST['design_id']) ? trim($_POST['design_id']) : null;
            $fabricId = isset($_POST['fabric_id']) ? trim($_POST['fabric_id']) : null;
            $colorId = isset($_POST['color_id']) ? trim($_POST['color_id']) : null;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

            // Validate inputs
            if (!$designId || !$fabricId || !$colorId) {
                flash('cart_error', 'Invalid product details', 'alert alert-danger');
                redirect($_SERVER['HTTP_REFERER'] ?? 'designs');
                return;
            }

            // Add to cart
            if ($this->cartModel->addToCart($_SESSION['user_id'], $designId, $fabricId, $colorId, $quantity)) {
                flash('cart_message', 'Item added to cart', 'alert alert-success');
            } else {
                flash('cart_error', 'Failed to add item to cart', 'alert alert-danger');
            }

            // Redirect back or to cart
            redirect($_SERVER['HTTP_REFERER'] ?? 'cart');
        } else {
            redirect('designs');
        }
    }

    public function remove($id = null)
    {
        if (!$id) {
            flash('cart_error', 'No item specified', 'alert alert-danger');
            redirect('cart');
            return;
        }

        if ($this->cartModel->removeFromCart($id, $_SESSION['user_id'])) {
            flash('cart_message', 'Item removed from cart', 'alert alert-success');
        } else {
            flash('cart_error', 'Failed to remove item', 'alert alert-danger');
        }

        redirect('cart');
    }

    public function clear()
    {
        if ($this->cartModel->clearCart($_SESSION['user_id'])) {
            flash('cart_message', 'Cart cleared', 'alert alert-success');
        } else {
            flash('cart_error', 'Failed to clear cart', 'alert alert-danger');
        }

        redirect('cart');
    }
    public function quickAdd($designId = null)
    {
        // Check if design ID is provided
        if (!$designId) {
            flash('cart_error', 'Invalid design ID', 'alert alert-danger');
            redirect($_SERVER['HTTP_REFERER'] ?? 'pages');
            return;
        }

        // Get default fabric and color (using your fixed IDs)
        $fabricId = 1; // Default fabric ID
        $colorId = 1; // Default color ID

        // Add to cart
        if ($this->cartModel->addToCart($_SESSION['user_id'], $designId, $fabricId, $colorId)) {
            flash('cart_message', 'Item added to cart successfully', 'alert alert-success');

            // CHANGE THIS LINE: Redirect to cart page to see the item
            redirect('cart');
        } else {
            flash('cart_error', 'Failed to add item to cart', 'alert alert-danger');
            redirect($_SERVER['HTTP_REFERER'] ?? 'pages');
        }
    }
}
