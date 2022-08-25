<?php
namespace cavernos\bascode_api\API\Post;

use cavernos\bascode_api\API\Post\Actions\PostAction;
use cavernos\bascode_api\Framework\Module;
use cavernos\bascode_api\Framework\Renderer;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostModule extends Module
{

    const DEFINITIONS = __DIR__ . '/config.php';
    
    /**
     * renderer
     *
     * @var Renderer
     */
    private $renderer;

    public function __construct(string $prefix, Router $router, RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer->addPath('post', __DIR__ . '/views');

        $router->get($prefix, PostAction::class, 'post.index');
        $router->get($prefix . '/{id}', PostAction::class, 'post.first');
    }
}
