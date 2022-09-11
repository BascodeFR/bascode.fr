<?php 
namespace Tests\Framework;

use cavernos\bascode_api\Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase {

    
    /**
     * router
     *
     * @var Router
     */
    private $router;
         
    /**
     * setUp
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->router = new Router();
    }

    public function testGetMethod(){
        $request = new ServerRequest('GET', '/post');
        $this->router->get('/post', function (){ return 'hello';},'post');
        $route = $this->router->match($request);
        $this->assertEquals('post', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
    }

    public function testGetMethodIfURLNotExist(){
        $request = new ServerRequest('GET', '/post');
        $this->router->get('/postdxnj', function (){ return 'hello';},'post');
        $route = $this->router->match($request);
        $this->assertEquals(null, $route);
    }

    public function testGetMethodWithParams(){
        $request = new ServerRequest('GET', '/post/slug-9');
        $this->router->get('/post', function (){ return 'hdf';},'posts');
        $this->router->get('/post/{slug:[a-z0-9\-]+}-{id:\d+}', function (){ return 'hello';},'post.show');
        $route = $this->router->match($request);
        $this->assertEquals('post.show', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
        $this->assertEquals(['slug' => 'slug', 'id' => '9'], $route->getParams());
        // Test URL invalide

        $route = $this->router->match(new ServerRequest('GET', '/post/slu_g-8'));
        $this->assertEquals(null, $route);
    }

    public function testGenerateURI(){
        $this->router->get('/post', function (){ return 'hdf';},'posts');
        $this->router->get('/post/{slug:[a-z0-9\-]+}-{id:\d+}', function (){ return 'hello';},'post.show');
        $uri = $this->router->generateUri('post.show', ['slug' => 'article', 'id' => 18]);
        $this->assertEquals('/post/article-18', $uri);
    }

    public function testGenerateURIWithQueryParams(){
        $this->router->get('/post', function (){ return 'hdf';},'posts');
        $this->router->get('/post/{slug:[a-z0-9\-]+}-{id:\d+}', function (){ return 'hello';},'post.show');
        $uri = $this->router->generateUri('post.show', ['slug' => 'article', 'id' => 18], ['p'=> 2]);
        $this->assertEquals('/post/article-18?p=2', $uri);
    }

    

}