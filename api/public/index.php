<?php
require __DIR__.'/../vendor/autoload.php';

use cavernos\bascode_api\Router;


$router = new Router(dirname(__DIR__));

$router->get('/', '/index', 'home')
        ->get('/post', '/views/post', 'posts')
        ->get('/post/[*:id]', '/views/post', 'post')
        ->run();

