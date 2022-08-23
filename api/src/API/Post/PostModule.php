<?php
namespace cavernos\bascode_api\API\Post;

use cavernos\bascode_api\Framework\Renderer;
use cavernos\bascode_api\Framework\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostModule
{
    
    /**
     * renderer
     *
     * @var Renderer
     */
    private $renderer;

    public function __construct(Router $router)
    {
        $this->renderer = new Renderer();
        $this->renderer->addPath('post', __DIR__ . '/views');

        $router->get('/post', [$this, 'posts'], 'post.index');
        $router->get('/post/{id}', [$this, 'post'], 'post.first');
    }
    
    /**
     * posts
     *
     * @param  ServerRequestInterface $request
     * @return string
     */
    public function posts(ServerRequestInterface $request): string
    {
        return $this->renderer->render('@post/index');
    }
    
    /**
     * post
     *
     * @param  ServerRequestInterface $request
     * @return string
     */
    public function post(ServerRequestInterface $request): string
    {
        return $this->renderer->render('@post/show', ['id' => $request->getAttribute('id')]);
    }
}
