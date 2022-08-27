<?php
namespace cavernos\bascode_api\API\Home\Actions;

use cavernos\bascode_api\API\Forum\Table\PostTable;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomeAction
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

    public function __construct(RendererInterface $renderer, PostTable $postTable)
    {
        $this->renderer = $renderer;
        $this->postTable = $postTable;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        return $this->index($request);
    }

    /**
     * posts
     *
     * @return string
     */
    public function index(): string
    {
        $posts = $this->postTable->findPaginated(5, 1);
        return $this->renderer->render('@home/index', compact('posts'));
    }
}
