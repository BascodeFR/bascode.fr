<?php
namespace Tests\API;

use cavernos\bascode_api\API\API;
use cavernos\bascode_api\API\Post\PostModule;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class APITest extends TestCase {
    public function testPost(){
        $api = new API([
            PostModule::class
        ]);
        $request = new ServerRequest('GET', '/post');
        $response = $api->run($request);
        $this->assertEquals('<h1>Bienvenue sur les Posts</h1>', (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());

        $requestSingle = new ServerRequest('GET', '/post/1');
        $responseSingle = $api->run($requestSingle);
        $this->assertEquals('<h1>Bienvenue sur le Post 1</h1>', (string)$responseSingle->getBody());
    }

    public function test404Error(){
        $api = new API();
        $request = new ServerRequest('GET', '/gwses');
        $response = $api->run($request);
        $this->assertEquals('<h1>Erreur 404</h1>', (string)$response->getBody());
        $this->assertEquals(404, $response->getStatusCode());
    }
}