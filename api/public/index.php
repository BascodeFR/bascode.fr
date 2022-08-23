<?php

use cavernos\bascode_api\API\API;
use cavernos\bascode_api\API\Post\PostModule;
use GuzzleHttp\Psr7\ServerRequest;

use function Http\Response\send;

require __DIR__.'/../vendor/autoload.php';

$api = new API([
    PostModule::class
]);
$response = $api->run(ServerRequest::fromGlobals());
send($response);
