<?php
namespace cavernos\bascode_api\API\News\Actions;

use cavernos\bascode_api\API\News\Table\NewsTable;
use cavernos\bascode_api\Framework\Actions\RouterAwareAction;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\Router;
use Michelf\Markdown;
use Psr\Http\Message\ServerRequestInterface;

class NewsAction
{
    
    /**
     * renderer
     *
     * @var RendererInterface
     */
    private $renderer;

    /**
     * newsTable
     *
     * @var NewsTable
     */
    private $newsTable;
    
    /**
     * router
     *
     * @var Router
     */
    private $router;

    use RouterAwareAction;

    public function __construct(RendererInterface $renderer, NewsTable $newsTable, Router $router)
    {
        $this->router = $router;
        $this->renderer = $renderer;
        $this->newsTable = $newsTable;
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
        $news = $this->newsTable->findPaginated(10, $params['p'] ?? 1);

        return $this->renderer->render('@news/index', compact('news'));
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

        $new = $this->newsTable->find($request->getAttribute('id'));
        if ($new->slug !== $slug) {
        }
        return $this->renderer->render('@news/show', compact('new'));
    }
}
