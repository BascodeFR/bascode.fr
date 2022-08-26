<?php
namespace cavernos\bascode_api\API\Post\Actions;

use cavernos\bascode_api\API\Post\Table\PostTable;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use PDO;
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

    public function __construct(RendererInterface $renderer, PostTable $postTable)
    {
        $this->renderer = $renderer;
        $this->postTable = $postTable;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        if ($request->getAttribute('id')) {
            return $this->post($request);
        }
        return $this->posts();
    }

    /**
     * posts
     *
     * @return string
     */
    public function posts(): string
    {
        $posts = $this->postTable->findPaginated();

        return $this->renderer->render('@post/index', compact('posts'));
    }
    
    /**
     * post
     *
     * @param  ServerRequestInterface $request
     * @return string
     */
    public function post(ServerRequestInterface $request): string
    {
        $post = $this->postTable->find($request->getAttribute('id'));
        return $this->renderer->render('@post/show', compact('post'));
    }
}
