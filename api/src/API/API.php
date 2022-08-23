<?php
namespace cavernos\bascode_api\API;

use cavernos\bascode_api\Framework\Router;
use Exception;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class API
{

    
    /**
     * router
     *
     * @var Router
     */
    private $router;
    
    
    /**
     * liste des modules
     *
     * @var array
     */
    private $modules = [];
    
    public function __construct(array $modules = [])
    {
        $this->router = new Router();
        foreach ($modules as $module) {
            $this->modules[] = new $module($this->router);
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
        $route = $this->router->match($request);
        if (is_null($route)) {
            $response = new Response(404, [], '<h1>Erreur 404</h1>');
            return $response;
        }

        $params = $route->getParams();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);
        $response = call_user_func_array($route->getCallback(), [$request]);
        if (is_string($response)) {
            return new Response(200, ['Content' => 'application/json'], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new Exception("La réponse est ni une string ni une instance de la ResponseInterface");
        }
    }
}
