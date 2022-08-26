<?php

use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\RendererFactory;
use cavernos\bascode_api\Framework\Router;

use function DI\create;
use function DI\factory;

return[
    'database.host' => '192.168.0.6',
    "database.username" => 'bascode',
    "database.password" => 'ELECKBOINMAK',
    "database.name" => 'Bascode',


    'view.path' => dirname(__DIR__) . '/views',
    Router::class => create(),
    RendererInterface::class => factory(RendererFactory::class)
];