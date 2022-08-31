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

    public function __construct(?string $cache = null)
    {
        $this->router = new FastRouteRouter(null, null, [
            FastRouteRouter::CONFIG_CACHE_ENABLED => !is_null($cache),
            FastRouteRouter::CONFIG_CACHE_FILE => $cache
        ]);
    }

      
  /**
   * get récupère la route en méthode get
   *
   * @param  string $path
   * @param  callable|string $callable
   * @param  ?string $name
   * @return void
   */
    public function get(string $path, callable|string $callable, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['GET'], $name));
    }

    /**
   * post récupère la route en méthode post
   *
   * @param  string $path
   * @param  callable|string $callable
   * @param  ?string $name
   * @return void
   */
    public function post(string $path, callable|string $callable, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['POST'], $name));
    }

    /**
   * delete récupère la route en méthode delete
   *
   * @param  string $path
   * @param  callable|string $callable
   * @param  ?string $name
   * @return void
   */
    public function delete(string $path, callable|string $callable, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['DELETE'], $name));
    }
  
  /**
   * crud
   *
   * @param  string $prefixPath
   * @param  mixed $callable
   * @param  string $prefixName
   * @return void
   */
    public function crud(string $prefixPath, mixed $callable, string $prefixName)
    {
        $this->get("$prefixPath", $callable, "$prefixName.index");
        $this->get("$prefixPath/new", $callable, "$prefixName.create");
        $this->post("$prefixPath/new", $callable);
        $this->get("$prefixPath/{id:\d+}", $callable, "$prefixName.edit");
        $this->post("$prefixPath/{id:\d+}", $callable);
        $this->delete("$prefixPath/{id:\d+}", $callable, "$prefixName.delete");
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
