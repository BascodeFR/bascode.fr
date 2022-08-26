<?php
namespace cavernos\bascode_api\API\Post\Actions;

use cavernos\bascode_api\API\Post\Table\PostTable;
use cavernos\bascode_api\Framework\Actions\RouterAwareAction;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\Router;
use PDO;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostAction
{
    
    /**
     * renderer
     *
     * @var RendererInterface
     */
    private $renderer;

    /**
     * postTable
     *
     * @var PostTable
     */
    private $postTable;
    
    /**
     * router
     *
     * @var Router
     */
    private $router;

    use RouterAwareAction;

    public function __construct(RendererInterface $renderer, PostTable $postTable, Router $router)
    {
        $this->router = $router;
        $this->renderer = $renderer;
        $this->postTable = $postTable;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        if ($request->getAttribute('id')) {
            return $this->show($request);
        }
        return $this->index($request);
    }

    /**
     * posts
     *
     * @return string
     */
    public function index(ServerRequestInterface $request): string
    {
        $params = $request->getQueryParams();
        $posts = $this->postTable->findPaginated(10, $params['p'] ?? 1);

        return $this->renderer->render('@post/index', compact('posts'));
    }
    
    /**
     * show
     *
     * @param  ServerRequestInterface $request
     * @return string
     */
    public function show(ServerRequestInterface $request): string
    {
        $slug = $request->getAttribute('slug');

        $post = $this->postTable->find($request->getAttribute('id'));
        if ($post->slug !== $slug) {
        }
        return $this->renderer->render('@post/show', compact('post'));
    }
}
