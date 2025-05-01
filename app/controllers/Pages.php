<?php
require_once APPROOT . '/helpers/url_helper.php';
require_once APPROOT . '/helpers/session_helper.php';
class Pages extends Controller
{
    private $pageModel;
    private $userModel;
    public function __construct()
    {
        //load the model
        $this->pageModel = $this->model('M_Pages');
        $this->userModel = $this->model('M_Users');
    }
    public function index()
    {
        $featuredDesigns = $this->pageModel->getFeaturedDesigns(6);

        // Load the M_Reviews model
        $reviewModel = $this->model('M_Reviews');

        // Fetch the latest accepted reviews (limit to 5 or any number you prefer)
        $reviews = $reviewModel->getLatestReviews(5);

        // Pass both designs and reviews to the view
        $data = [
            'title' => 'Home Page',
            'designs' => $featuredDesigns,
            'reviews' => $reviews
        ];

        $this->view('pages/v_home_page', $data);
    }
    public function notFound()
    {
        $this->view('pages/404');
    }

    public function about()
    {

        $users = $this->pageModel->getUsers();
        $data = [
            'users' => $users
        ];
        $this->view('v_about', $data);
    }

    public function womensPage()
    {
        $_SESSION['redirect_url'] = 'pages/womensPage';
        $featuredDesigns = $this->pageModel->getDesignsByGender('ladies');
        $data = [
            'gender' => 'ladies',
            'title' => 'Womens Page',
            'designs' => $featuredDesigns
        ];
        $this->view('pages/v_womens_page', $data);
    }
    public function womensDressCategories()
    {
        $category_id = $this->pageModel->getCategoryByName('Dress');
        $featuredDesigns = $this->pageModel->getDesignsByCategory($category_id);
        $data = [
            'designs' => $featuredDesigns,
            'category' => 'dresses',
            'gender' => 'ladies',
        ];
        $this->view('pages/v_womens_dress_category', $data);
    }
    public function womenSareeJacketCategories()
    {
        $_SESSION['redirect_url'] = 'pages/womenSareeJacketCategories';
        $category_id = $this->pageModel->getCategoryByName('Saree Jacket');
        $featuredDesigns = $this->pageModel->getDesignsByCategory($category_id);
        $data = [
            'designs' => $featuredDesigns,
            'category' => 'saree-jackets',
            'gender' => 'ladies',
        ];
        $this->view('pages/v_womens_SareeJacket_category', $data);
    }

    public function womenSkirtCategories()
    {
        $_SESSION['redirect_url'] ='pages/womenSkirtCategories';
        $category_id = $this->pageModel->getCategoryByName('Skirt');
        $featuredDesigns = $this->pageModel->getDesignsByCategory($category_id);
        $data = [
            'designs' => $featuredDesigns,
            'category' => 'skirts',
            'gender' => 'ladies',
        ];
        $this->view('pages/v_womens_Skirt_category', $data);
    }
    public function womenBlouseCategories()
    {
        $category_id = $this->pageModel->getCategoryByName('Blouse');
        $featuredDesigns = $this->pageModel->getDesignsByCategory($category_id);
        $data = [
            'designs' => $featuredDesigns,
            'category' => 'blouses',
            'gender' => 'ladies',
        ];
        $this->view('pages/v_womens_Blouse_category', $data);
    }
    public function mensPage()
    {
        $_SESSION['redirect_url'] = 'pages/mensPage';
        $featuredDesigns = $this->pageModel->getDesignsByGender('gents');
        $data = [
            'gender' => 'gents',
            'title' => 'Mens Page',
            'designs' => $featuredDesigns
        ];
        $this->view('pages/v_mens_page', $data);
    }
    public function menShirtCategories()
    {
        $_SESSION['redirect_url'] = 'pages/menShirtCategories';
        $category_id = $this->pageModel->getCategoryByName('Shirt');
        $featuredDesigns = $this->pageModel->getDesignsByCategory($category_id);
        $data = [
            'designs' => $featuredDesigns,
            'category' => 'shirts',
            'gender' => 'gents',
        ];
        $this->view('pages/v_mens_Shirt_category', $data);
    }
    public function menSuitCategories()
    {
        $_SESSION['redirect_url'] = 'pages/menSuitCategories';
        $category_id = $this->pageModel->getCategoryByName('Suit');
        $featuredDesigns = $this->pageModel->getDesignsByCategory($category_id);
        $data = [
            'designs' => $featuredDesigns,
            'category' => 'suits',
            'gender' => 'gents',
        ];
        $this->view('pages/v_mens_Suit_category', $data);
    }

    public function menPantCategories()
    {
        $_SESSION['redirect_url'] = 'pages/menPantCategories';
        $category_id = $this->pageModel->getCategoryByName('Pants');
        $featuredDesigns = $this->pageModel->getDesignsByCategory($category_id);
        $data = [
            'designs' => $featuredDesigns,
            'category' => 'pants',
            'gender' => 'gents',
        ];
        $this->view('pages/v_mens_Pant_category', $data);
    }

    public function genderSel()
    {
        $_SESSION['redirect_url'] ='pages/genderSel';
        $users = $this->pageModel->getUsers();
        $data = [
            'users' => $users

        ];
        $this->view('pages/v_genderSelect', $data);
    }

    public function tailorPage()
    {
        $sellers = $this->pageModel->getAllSellers();

        // Add like counts and like status for each seller
        foreach ($sellers as $seller) {
            $seller->likeCount = $this->pageModel->getLikeCountByUserId($seller->user_id);
            $seller->hasLiked = false;
            if (isLoggedIn()) {
                $seller->hasLiked = $this->pageModel->hasUserLikedTailor($_SESSION['user_id'], $seller->user_id);
            }
        }

        $data = [
            'sellers' => $sellers
        ];
        $this->view('pages/v_meet_tailor', $data);
    }
    public function tailorProfile($id = null)
    {
        // If no ID is provided, redirect to the tailor list page
        if ($id === null) {
            redirect('pages/tailorPage');
        }

        // Get specific tailor data by ID
        $tailor = $this->pageModel->getSellerById($id);

        // If tailor doesn't exist, redirect to 404 page
        if (!$tailor) {
            redirect('pages/notFound');
        }

        // Get tailor's posts count
        $postCount = $this->pageModel->getPostCountByUserId($id);

        // Get tailor's likes count
        $likeCount = $this->pageModel->getLikeCountByUserId($id);

        // Get tailor's posts for display
        $posts = $this->pageModel->getPostsByUserId($id);

        // Get tailor's designs for display
        $designs = $this->pageModel->getDesignsByUserId($id);
        $posts = $this->pageModel->getPostsByUserId($id);

        // Get posts that the logged-in user has liked
        $likedPosts = [];
        if (isLoggedIn()) {
            $likedPosts = $this->pageModel->getLikedPostsByUser($_SESSION['user_id']);
        }

        // Check if logged-in user has liked this tailor
        $hasLiked = false;
        if (isLoggedIn()) {
            $hasLiked = $this->pageModel->hasUserLikedTailor($_SESSION['user_id'], $id);
        }

        $data = [
            'tailor' => $tailor,
            'postCount' => $postCount,
            'likeCount' => $likeCount,
            'posts' => $posts,
            'designs' => $designs,
            'hasLiked' => $hasLiked,
            'liked_posts' => $likedPosts
        ];


        $this->view('pages/v_tailor_profile', $data);
    }
    public function likeTailor($id = null)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            flash('login_required', 'You must be logged in to like a tailor');
            redirect('users/login');
            return;
        }

        // If no ID provided, redirect back
        if ($id === null) {
            redirect('pages/tailorPage');
            return;
        }

        // Get current user ID
        $customerId = $_SESSION['user_id'];

        // Toggle like status
        $this->pageModel->toggleLike($customerId, $id);

        // Redirect back to the tailor's profile page
        redirect('pages/tailorProfile/' . $id);
    }

    public function likePost($id = null)
    {
        // Check if user is logged in
        if (!isLoggedIn()) {
            flash('login_required', 'You must be logged in to like a post');
            redirect('users/login');
            return;
        }

        // If no post ID provided, redirect back
        if ($id === null) {
            redirect($_SERVER['HTTP_REFERER'] ?? 'pages/index');
            return;
        }

        // Get the post to determine the owner - FIX: Use model instead of direct DB access
        $post = $this->pageModel->getPostById($id);

        if (!$post) {
            flash('post_error', 'Post not found');
            redirect($_SERVER['HTTP_REFERER'] ?? 'pages/index');
            return;
        }

        // Get current user ID
        $userId = $_SESSION['user_id'];

        // Toggle like status
        $this->pageModel->togglePostLike($userId, $id);


        // Redirect back to the tailor's profile page
        redirect('pages/tailorProfile/' . $post->user_id);
    }
    
}
