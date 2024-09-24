<?php

class Router
{
    public function get($path, $callback)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === $path) {
            echo $callback();
        }
    }
}