<?php
namespace cavernos\bascode_api\API;

use cavernos\bascode_api\Framework\Router;
use Exception;
use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class API
{

    
    /**
     * container
     *
     * @var ContainerInterface
     */
    private $container;
    
    
    /**
     * liste des modules
     *
     * @var array
     */
    private $modules = [];
        
    /**
     * __construct
     *
     * @param  ContainerInterface $container
     * @param  array $modules
     * @return void
     */
    public function __construct(ContainerInterface $container, array $modules = [])
    {
        $this->container = $container;
        foreach ($modules as $module) {
            $this->modules[] = $container->get($module);
        }
    }
    
    /**
     * run
     *
     * @param  ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri[-1] === '/' && $uri !== '/') {
            return (new Response())
                    ->withStatus(301)
                    ->withHeader('Location', substr($uri, 0, -1));
        }
        $route = $this->container->get(Router::class)->match($request);
        if (is_null($route)) {
            $response = new Response(404, [], '<h1>Erreur 404</h1>');
            return $response;
        }

        $params = $route->getParams();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);
        $callback = $route->getCallback();
        if (is_string($callback)) {
            $callback = $this->container->get($callback);
        }
        $response = call_user_func_array($callback, [$request]);
        if (is_string($response)) {
            #return new Response(200, ['Content-Type' => 'application/json'], $response);
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new Exception("La réponse est ni une string ni une instance de la ResponseInterface");
        }
    }
    
    /**
     * getContainer
     *
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }
}
