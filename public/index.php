<?php

require '../vendor/autoload.php';

use Cavernos\BascodeFR\Router;



$routeur = new Router(dirname(__DIR__). '/views');
$routeur
    ->get('/', 'home/index.html', 'home')
    ->run();
    