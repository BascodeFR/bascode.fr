<?php

use cavernos\bascode_api\Framework\Middleware\CsrfMiddleware;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\RendererFactory;
use cavernos\bascode_api\Framework\Router;
use cavernos\bascode_api\Framework\Router\RouterFactory;
use cavernos\bascode_api\Framework\Router\RouterTwigExtension;
use cavernos\bascode_api\Framework\Session\PHPSession;
use cavernos\bascode_api\Framework\Session\SessionInterface;
use cavernos\bascode_api\Framework\Twig\CsrfExtension;
use cavernos\bascode_api\Framework\Twig\FlashExtension;
use cavernos\bascode_api\Framework\Twig\FormExtension;
use cavernos\bascode_api\Framework\Twig\PagerFantaExtension;
use cavernos\bascode_api\Framework\Twig\TextExtension;
use cavernos\bascode_api\Framework\Twig\TimeExtension;
use Psr\Container\ContainerInterface;

use function DI\autowire;
use function DI\env;
use function DI\factory;
use function DI\get;

return[
    #'env' => env('ENV', 'production'),
    'env' => env('ENV', 'dev'),
    'database.host' => '192.168.0.6',
    "database.username" => 'bascode',
    "database.password" => 'ELECKBOINMAK',
    "database.name" => 'Bascode',
    "version" => "1.0",


    'view.path' => dirname(__DIR__) . '/views',
    'twig.extensions' => [
        get(RouterTwigExtension::class),
        get(PagerFantaExtension::class),
        get(TextExtension::class),
        get(TimeExtension::class),
        get(FlashExtension::class),
        get(FormExtension::class),
        get(CsrfExtension::class)
    ],
    SessionInterface::class => autowire(PHPSession::class),
    CsrfMiddleware::class => autowire()->constructor(get(SessionInterface::class)),
    Router::class => factory(RouterFactory::class),
    RendererInterface::class => factory(RendererFactory::class),
    PDO::class => function (ContainerInterface $c){
       return new PDO('mysql:host=' . $c->get('database.host') . ';dbname=' . $c->get('database.name'), $c->get('database.username'), $c->get('database.password'),
    [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION    
    ]);
    }
];