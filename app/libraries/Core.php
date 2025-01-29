<?php

class Core
{
    // URL format: controller/method/params
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

        // Check if the controller exists
        if (isset($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        } else {
            // Controller does not exist, load 404 page
            $this->currentController = 'Pages';
            $this->currentMethod = 'notFound';
            $this->params = [];
            $this->loadController();
            return;
        }

        // Require the controller
        require_once '../app/controllers/' . $this->currentController . '.php';
        $this->currentController = new $this->currentController;

        // Check if the method exists
        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            } else {
                // Method does not exist, load 404 page
                $this->currentController = 'Pages';
                $this->currentMethod = 'notFound';
                $this->params = [];
                $this->loadController();
                return;
            }
        }

        // Get params
        $this->params = $url ? array_values($url) : [];

        // Call a method with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }

    private function loadController()
    {
        require_once '../app/controllers/' . $this->currentController . '.php';
        $this->currentController = new $this->currentController;
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }
}
