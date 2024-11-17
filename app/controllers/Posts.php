<?php
    class Posts extends Controller{
        public function __construct()
        {
            echo 'Posts loaded';
        }
        public function create(){
            $data =[];

            $this->view('posts/create', $data);
        }
    }