<?php
namespace cavernos\bascode_api\Framework\Router;

use cavernos\bascode_api\Framework\Router;
use InvalidArgumentException;
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
            new TwigFunction('path', [$this, 'pathFor']),
            new TwigFunction('is_subpath', [$this, 'isSubPath'])
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
        try {
            return $this->router->generateUri($path, $params);
        } catch (InvalidArgumentException $e) {
            return '';
        }
    }
    
    /**
     * isSubPath
     *
     * @param  string $path
     * @return bool
     */
    public function isSubPath(string $path): bool
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        try {
            $expectedUri = $this->router->generateUri($path);
            return str_contains($uri, $expectedUri);
        } catch (InvalidArgumentException $e) {
            return false;
        }

    }
}
