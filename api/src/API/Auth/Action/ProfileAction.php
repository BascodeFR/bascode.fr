<?php
namespace cavernos\bascode_api\API\Auth\Action;

use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class ProfileAction
{

    private $renderer;


    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        
        return $this->renderer->render('@auth/profile/index');
    }
}
