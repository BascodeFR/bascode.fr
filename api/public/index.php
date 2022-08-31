<?php

use cavernos\bascode_api\API\Admin\AdminModule;
use cavernos\bascode_api\API\API;
use cavernos\bascode_api\API\Forum\ForumModule;
use cavernos\bascode_api\API\Home\HomeModule;
use cavernos\bascode_api\API\News\NewsModule;
use cavernos\bascode_api\Framework\Middleware\CsrfMiddleware;
use cavernos\bascode_api\Framework\Middleware\DispatcherMiddleware;
use cavernos\bascode_api\Framework\Middleware\MethodMiddleware;
use cavernos\bascode_api\Framework\Middleware\NotFoundMiddleware;
use cavernos\bascode_api\Framework\Middleware\RouterMiddleware;
use cavernos\bascode_api\Framework\MiddleWare\TrailingSlashMidleware;
use GuzzleHttp\Psr7\ServerRequest;
use Middlewares\Whoops;
use function Http\Response\send;

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

$modules = [
    HomeModule::class,
    AdminModule::class,
    ForumModule::class,
    NewsModule::class
];

$api = (new API(dirname(__DIR__) . '/config/config.php'))
            ->addModule(HomeModule::class)
            ->addModule(AdminModule::class)
            ->addModule(ForumModule::class)
            ->addModule(NewsModule::class)
            ->pipe(Whoops::class)
            ->pipe(TrailingSlashMidleware::class)
            ->pipe(MethodMiddleware::class)
            ->pipe(CsrfMiddleware::class)
            ->pipe(RouterMiddleware::class)
            ->pipe(DispatcherMiddleware::class)
            ->pipe(NotFoundMiddleware::class);


if (php_sapi_name() !== 'cli') {
    $response = $api->run(ServerRequest::fromGlobals());
    send($response);
}
