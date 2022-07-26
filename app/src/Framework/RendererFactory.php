<?php
namespace cavernos\bascode_api\Framework;

use cavernos\bascode_api\Framework\Renderer\TwigRenderer;
use cavernos\bascode_api\Framework\Router\RouterTwigExtension;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class RendererFactory
{
    
    /**
     * __invoke
     *
     * @param  ContainerInterface $container
     * @return TwigRenderer
     */
    public function __invoke(ContainerInterface $container): TwigRenderer
    {
        $debug = $container->get('env') !== 'production';
        
        $viewPath = $container->get('view.path');
        $loader = new FilesystemLoader($viewPath);
        $twig = new Environment($loader, [
            'debug' =>  $debug,
            'cache' => $debug ? false : 'tmp/views',
            'auto_reload' => $debug
        ]);
        $twig->addExtension(new DebugExtension());
        if ($container->has('twig.extensions')) {
            foreach ($container->get('twig.extensions') as $extension) {
                $twig ->addExtension($extension);
            }
        }
        
        return new TwigRenderer($twig);
    }
}
