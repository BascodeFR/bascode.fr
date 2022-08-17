<?php
require __DIR__.'/../vendor/autoload.php';

use cavernos\bascode_api\Router;


$router = new Router(dirname(__DIR__). '/views');

$router->get('/', '../index', 'home')
        ->get('/post', 'post', 'posts')
        ->get('/message', 'messages', 'messages')
        ->post('/user', 'user', 'user')
        ->run();

