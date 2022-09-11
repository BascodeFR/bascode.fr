<?php
namespace cavernos\bascode_api\API\Home;

use cavernos\bascode_api\API\Home\Actions\HomeAction;
use cavernos\bascode_api\Framework\Module;
use cavernos\bascode_api\Framework\Renderer;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\Router;

class HomeModule extends Module
{

    const DEFINITIONS = __DIR__ . '/config.php';

    const MIGRATIONS = __DIR__ . '/db/migrations';

    const SEEDS = __DIR__ . '/db/seeds';
    
    /**
     * renderer
     *
     * @var Renderer
     */
    private $renderer;

    public function __construct(string $prefix, Router $router, RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer->addPath('home', __DIR__ . '/views');

        $router->get($prefix, HomeAction::class, 'home.index');
    }
}
