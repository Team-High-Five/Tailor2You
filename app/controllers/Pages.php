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

        $data = [
            'title' => 'Home Page',
            'designs' => $featuredDesigns
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
    public function mensPage()
    {
        $data = [
            'title' => 'Mens Page'
        ];
        $this->view('pages/v_mens_page', $data);
    }
    public function womensPage()
    {
        $data = [
            'title' => 'womens Page'
        ];
        $this->view('pages/v_womens_page', $data);
    }
    public function womensDressCategories()
    {

        $data = [];
        $this->view('pages/v_womens_dress_category', $data);
    }
    public function womenSareeJacketCategories()
    {

        $data = [];
        $this->view('pages/v_womens_SareeJacket_category', $data);
    }
    public function womenSkirtCategories()
    {

        $data = [];
        $this->view('pages/v_womens_Skirt_category', $data);
    }
    public function womenBlouseCategories()
    {

        $data = [];
        $this->view('pages/v_womens_Blouse_category', $data);
    }
    public function mensCategories()
    {

        $data = [];
        $this->view('pages/v_mens_Shirt_category', $data);
    }
    public function genderSel()
    {
        $users = $this->pageModel->getUsers();
        $data = [
            'users' => $users

        ];
        $this->view('pages/v_genderSelect', $data);
    }

    public function tailorPage()
    {
        $tailors = $this->pageModel->getAllTailors();
        $data = [
            'tailors' => $tailors
        ];
        $this->view('pages/v_meet_tailor', $data);
    }
    public function tailorProfile()
    {
        $users = $this->pageModel->getUsers();
        $data = [
            'users' => $users

        ];
        $this->view('pages/v_tailor_profile', $data);
    }
}
