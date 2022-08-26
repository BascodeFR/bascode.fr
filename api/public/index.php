<?php

use cavernos\bascode_api\API\API;
use cavernos\bascode_api\API\Home\HomeModule;
use cavernos\bascode_api\API\Post\PostModule;
use \DI\ContainerBuilder;
use GuzzleHttp\Psr7\ServerRequest;

use function Http\Response\send;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$modules = [
    HomeModule::class,
    PostModule::class
];

$builder = new ContainerBuilder();
$builder->addDefinitions(dirname(__DIR__) . '/config/config.php');
$builder->addDefinitions(dirname(__DIR__) . '/config.php');
foreach ($modules as $module) {
    if ($module::DEFINITIONS) {
        $builder->addDefinitions($module::DEFINITIONS);
    }
}
$container = $builder->build();

$api = new API($container, $modules);


if (php_sapi_name() !== 'cli') {
    $response = $api->run(ServerRequest::fromGlobals());
    send($response);
}
