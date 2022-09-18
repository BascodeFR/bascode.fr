<?php
namespace cavernos\bascode_api\API\Home\Actions;

use cavernos\bascode_api\API\Forum\Table\MessagesTable;
use cavernos\bascode_api\API\Forum\Table\PostTable;
use cavernos\bascode_api\API\News\Table\NewsTable;
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
    
    /**
     * newsTable
     *
     * @var NewsTable
     */
    private $newsTable;

    private $messagesTable;

    public function __construct(
        RendererInterface $renderer,
        PostTable $postTable,
        NewsTable $newsTable,
        MessagesTable $messagesTable
    ) {
        $this->renderer = $renderer;
        $this->postTable = $postTable;
        $this->newsTable = $newsTable;
        $this->messagesTable = $messagesTable;
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
        $threads = $this->postTable->findPublic()->paginate(5, 1);
        $news = $this->newsTable->findPublic()->paginate(100, 1);
        return $this->renderer->render('@home/index', compact('threads', 'news'));
    }
}
