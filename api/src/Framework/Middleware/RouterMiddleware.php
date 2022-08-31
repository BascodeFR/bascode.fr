<?php
namespace cavernos\bascode_api\Framework\Middleware;

use cavernos\bascode_api\Framework\Router;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RouterMiddleware
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
    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        $route = $this->router->match($request);
        if (is_null($route)) {
            return $next($request);
        }

        $params = $route->getParams();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);
        $request = $request->withAttribute(get_class($route), $route);
        return $next($request);
    }
}
