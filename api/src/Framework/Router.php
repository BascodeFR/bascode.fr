<?php
namespace cavernos\bascode_api\Framework;

use cavernos\bascode_api\Framework\Router\Route;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route as ZendRoute;

/**
 * Router est une classe qui permet de personnaliser les router AltoRouter
 *
 * @package cavernos\bascode_api
 * @author Cavernos <louisdescavernes@gmail.com>
 * @version 1.0
 * @access private
 *
 */
class Router
{
    
    /**
     *
     * @var FastRouteRouter
     */
    private $router;

    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

      
  /**
   * get récupère la route en méthode get
   *
   * @param  string $path
   * @param  callable|string $callable
   * @param  string $name
   * @return void
   */
    public function get(string $path, callable|string $callable, string $name)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['GET'], $name));
    }

    /**
   * get récupère la route en méthode post
   *
   * @param  string $path
   * @param  callable $callable
   * @param  string $name
   * @return void
   */
    public function post(string $path, callable $callable, string $name)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['POST'], $name));
    }
  
  /**
   * match renvoie une route si elle correspond a une route valide
   *
   * @param  ServerRequestInterface $request
   * @return Route
   */
    public function match(ServerRequestInterface $request): ?Route
    {
        $result = $this->router->match($request);
        if ($result->isSuccess()) {
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedMiddleware(),
                $result->getMatchedParams()
            );
        } else {
            return null;
        }
    }
  
  /**
   * generateUri génère l'url
   *
   * @param  string $routeName
   * @param  array $params
   * @param  array $queryParams
   * @return string
   */
    public function generateUri(string $routeName, array $params = [], array $queryParams = []): ?string
    {
        $uri = $this->router->generateUri($routeName, $params);
        if (!empty($queryParams)) {
            return $uri . '?' . http_build_query($queryParams);
        }
        return $uri;
    }
}
