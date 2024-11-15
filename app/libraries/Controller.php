<?php  

class Controller{
    //to load model
    public function model($model){
        require_once '../app/models/' . $model . '.php';

        //instantiate model and return it to the controller
        return new $model();
    }

    //to load view
    public function view($view, $data = []){
        if(file_exists('../app/views/' . $view . '.php')){
            require_once '../app/views/' . $view . '.php';
        }else{
            die('View does not exist');
        }
    }
}