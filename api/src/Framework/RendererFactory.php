<?php
namespace cavernos\bascode_api\Framework;

use cavernos\bascode_api\Framework\Renderer\TwigRenderer;
use cavernos\bascode_api\Framework\Router\RouterTwigExtension;
use Psr\Container\ContainerInterface;
use Twig\Environment;
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
        $viewPath = $container->get('view.path');
        $loader = new FilesystemLoader($viewPath);
        $twig = new Environment($loader);
        if ($container->has('twig.extensions')) {
            foreach ($container->get('twig.extensions') as $extension) {
                $twig ->addExtension($extension);
            }
        }
        
        return new TwigRenderer($twig);
    }
}
