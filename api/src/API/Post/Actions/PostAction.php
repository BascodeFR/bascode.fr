<?php
namespace cavernos\bascode_api\API\Post\Actions;

use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostAction
{
    
    /**
     * renderer
     *
     * @var RendererInterface
     */
    private $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $id  = $request->getAttribute('id');
        if ($id) {
            return $this->post($id);
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
        return $this->renderer->render('@post/index');
    }
    
    /**
     * post
     *
     * @param  ServerRequestInterface $request
     * @return string
     */
    public function post(string $id): string
    {
        $this->renderer->addGlobal('id', $id);
        return $this->renderer->render('@post/show', ['id' => $id]);
    }
}
