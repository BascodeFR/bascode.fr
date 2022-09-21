<?php
namespace cavernos\bascode_api\API\Auth\Action;

use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginAction
{

    /**
     * @var RendererInterface
     */
    private RendererInterface $renderer;


    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request): string
    {
        return $this->renderer->render('@auth/login');
    }
}
