<?php
namespace cavernos\bascode_api\Framework\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RoutePrefixedMiddleware implements MiddlewareInterface
{
    
    /**
     * container
     *
     * @var ContainerInterface
     */
    private $container;
    
    /**
     * prefix
     *
     * @var string
     */
    private $prefix;
    
    /**
     * middleware
     *
     * @var string
     */
    private $middleware;

    public function __construct(ContainerInterface $container, string $prefix, string $middleware)
    {
        $this->container = $container;
        $this->prefix = $prefix;
        $this->middleware = $middleware;
    }


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        if (strpos($path, $this->prefix) === 0) {
            return $this->container->get($this->middleware)->process($request, $handler);
        }
        return $handler->handle($request);
    }
}
