<?php
namespace cavernos\bascode_api\API\Forum;

use cavernos\bascode_api\API\Forum\Actions\ForumAction;
use cavernos\bascode_api\API\Forum\Actions\MessagesCrudAction;
use cavernos\bascode_api\API\Forum\Actions\PostCrudAction;
use cavernos\bascode_api\Framework\Module;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\Router;
use Psr\Container\ContainerInterface;

class ForumModule extends Module
{

    const DEFINITIONS = __DIR__ . '/config.php';

    const MIGRATIONS = __DIR__ . '/db/migrations';

    const SEEDS = __DIR__ . '/db/seeds';
    

    public function __construct(ContainerInterface $container)
    {
        
        $container->get(RendererInterface::class)->addPath('forum', __DIR__ . '/views');

        $router = $container->get(Router::class);
        $router->get($container->get('forum.prefix'), ForumAction::class, 'forum.index');
        $router->get($container->get('forum.prefix')
        . '/{slug:[a-z\-0-9]+}-{id:[0-9]+}', ForumAction::class, 'forum.show');

        if ($container->has('admin.prefix')) {
            $prefix = $container->get('admin.prefix');
            $router->crud("$prefix/forum", PostCrudAction::class, 'admin.forum');
            $router->crud("$prefix/forum/messages", MessagesCrudAction::class, 'admin.forum.messages');
        }
    }
}
