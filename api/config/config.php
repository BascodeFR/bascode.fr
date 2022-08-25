<?php

use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\RendererFactory;
use cavernos\bascode_api\Framework\Router;

use function DI\create;
use function DI\factory;

return[
    'view.path' => dirname(__DIR__) . '/views',
    Router::class => create(),
    RendererInterface::class => factory(RendererFactory::class)
];