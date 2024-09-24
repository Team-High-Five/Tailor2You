<?php

$app = new application();

$app->router->get('/', function() {
    return 'Hello World';
});

$app->run();
?>