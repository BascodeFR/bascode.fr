<?php
namespace cavernos\bascode_api\Framework\Router;

use cavernos\bascode_api\Framework\Router;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RouterTwigExtension extends AbstractExtension
{
        
    /**
     * router
     *
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }
    
    /**
     * getFunctions
     *
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('path', [$this, 'pathFor'])
        ];
    }
    
    /**
     * pathFor
     *
     * @param  string $path
     * @param  array $params
     * @return string
     */
    public function pathFor(string $path, array $params = []): string
    {
        return $this->router->generateUri($path, $params);
    }
}
