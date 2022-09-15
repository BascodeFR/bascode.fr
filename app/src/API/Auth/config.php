<?php

use cavernos\bascode_api\API\Auth\AuthTwigExtension;
use cavernos\bascode_api\API\Auth\AuthWidget;
use cavernos\bascode_api\API\Auth\DatabaseAuth;
use cavernos\bascode_api\API\Auth\ForbiddenMiddleware;
use cavernos\bascode_api\Framework\Auth;

use function DI\add;
use function DI\autowire;
use function DI\get;

return [

    'auth.register' => '/register',
    'auth.login' => '/login',
    'auth.index' => '/users',

    'admin.widgets' => add([
        get(AuthWidget::class),
    ]),

    'twig.extensions' => add([
        get(AuthTwigExtension::class)
    ]),

    Auth::class => get(DatabaseAuth::class),
    ForbiddenMiddleware::class => autowire()->constructorParameter('loginPath', '/login')
];
