<?php
namespace cavernos\bascode_api\API\News;

use cavernos\bascode_api\API\News\Actions\NewsCrudAction;
use cavernos\bascode_api\API\News\Actions\NewsAction;
use cavernos\bascode_api\Framework\Module;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\Router;
use Psr\Container\ContainerInterface;

class NewsModule extends Module
{

    const DEFINITIONS = __DIR__ . '/config.php';

    const MIGRATIONS = __DIR__ . '/db/migrations';

    const SEEDS = __DIR__ . '/db/seeds';
    

    public function __construct(ContainerInterface $container)
    {
        
        $container->get(RendererInterface::class)->addPath('news', __DIR__ . '/views');

        $router = $container->get(Router::class);
        $router->get($container->get('news.prefix'), NewsAction::class, 'news.index');
        $router->get($container->get('news.prefix')
        . '/{slug:[a-z\-0-9]+}-{id:[0-9]+}', NewsAction::class, 'news.show');

        if ($container->has('admin.prefix')) {
            $prefix = $container->get('admin.prefix');
            $router->crud("$prefix/news", NewsCrudAction::class, 'admin.news');
        }
    }
}
