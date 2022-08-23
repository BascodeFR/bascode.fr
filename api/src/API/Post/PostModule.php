<?php
namespace cavernos\bascode_api\API\Post;

use cavernos\bascode_api\Framework\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostModule
{

    public function __construct(Router $router)
    {
        $router->get('/post', [$this, 'posts'], 'post.index');
        $router->get('/post/{id}', [$this, 'post'], 'post.first');
    }

    public function posts(ServerRequestInterface $request): string
    {
        return '<h1>Bienvenue sur les Posts</h1>';
    }

    public function post(ServerRequestInterface $request): string
    {
        return '<h1>Bienvenue sur le Post ' . $request->getAttribute('id') .'</h1>';
    }
}
