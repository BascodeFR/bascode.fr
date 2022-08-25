<?php
namespace cavernos\bascode_api\Framework;

use Psr\Container\ContainerInterface;

class RendererFactory
{
    
    /**
     * __invoke
     *
     * @param  ContainerInterface $container
     * @return Renderer
     */
    public function __invoke(ContainerInterface $container): Renderer
    {
        return new Renderer($container->get('view.path'));
    }
}
