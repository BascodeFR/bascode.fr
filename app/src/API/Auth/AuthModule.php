<?php
namespace cavernos\bascode_api\API\Auth;

use cavernos\bascode_api\API\Auth\Action\DeleteAction;
use cavernos\bascode_api\API\Auth\Action\LoginAction;
use cavernos\bascode_api\API\Auth\Action\LoginAttemptAction;
use cavernos\bascode_api\API\Auth\Action\LogoutAction;
use cavernos\bascode_api\API\Auth\Action\ProfileAction;
use cavernos\bascode_api\API\Auth\Action\RegisterAction;
use cavernos\bascode_api\API\Auth\Action\RegisterAttemptAction;
use cavernos\bascode_api\Framework\Module;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\Router;
use Psr\Container\ContainerInterface;

class AuthModule extends Module
{

    const DEFINITIONS = __DIR__ . '/config.php';

    const MIGRATIONS = __DIR__ . '/db/migrations';

    const SEEDS = __DIR__ . '/db/seeds';

    public function __construct(ContainerInterface $container, Router $router, RendererInterface $renderer)
    {
        $renderer->addPath('auth', __DIR__ . '/views');
        $router->get($container->get('auth.login'), LoginAction::class, 'auth.login');
        $router->get($container->get('auth.register'), RegisterAction::class, 'auth.register');
        $router->get($container->get('auth.index'). '/{id:[0-9]+}', ProfileAction::class, 'auth.index');
        $router->post($container->get('auth.login'), LoginAttemptAction::class);
        $router->post($container->get('auth.register'), RegisterAttemptAction::class);
        $router->post('/logout', LogoutAction::class, 'auth.logout');
        $router->post('/delete/{id:[0-9]+}', DeleteAction::class, 'auth.delete');
    }
}
