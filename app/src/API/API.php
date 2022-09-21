<?php /** @noinspection PhpInconsistentReturnPointsInspection */

namespace cavernos\bascode_api\API;

use cavernos\bascode_api\Framework\Middleware\RoutePrefixedMiddleware;
use DI\ContainerBuilder;
use Doctrine\Common\Cache\ApcuCache;
use Doctrine\Common\Cache\FilesystemCache;
use Exception;
use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class API implements RequestHandlerInterface
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
     * liste des middlewares
     *
     * @var array
     */
    private $middlewares = [];
    
    /**
     * index
     *
     * @var int
     */
    private $index = 0;
    
    /**
     * definition
     *
     * @var array
     */
    private $definition;

    public function addModule(string $module): self
    {
        $this->modules[] = $module;
        return $this;
    }
    
    /**
     * pipe
     *
     * @param  string $routePrefix
     * @param  string $middleware
     * @return self
     */
    public function pipe(string $routePrefix, ?string $middleware = null): self
    {
        if ($middleware == null) {
            $this->middlewares[] = $routePrefix;
        } else {
            $this->middlewares[] = new RoutePrefixedMiddleware($this->getContainer(), $routePrefix, $middleware);
        }
        
        return $this;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = $this->getMiddleware();
        if (is_callable($middleware)) {
            return call_user_func_array($middleware, [$request, [$this, 'handle']]);
        } elseif ($middleware instanceof MiddlewareInterface) {
            return $middleware->process($request, $this);
        }
        if (is_null($middleware)) throw new Exception("Aucun middleware n'a intercepté cette requête");
    }
        
    /**
     * __construct
     *
     * @param  ContainerInterface $container
     * @param  array $modules
     * @return void
     */
    public function __construct(string $definition)
    {
        $this->definition = $definition;
    }
    
    /**
     * run
     *
     * @param  ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        foreach ($this->modules as $module) {
            $this->getContainer()->get($module);
        }
        return $this->handle($request);
    }
    
    /**
     * getContainer
     *
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        if ($this->container === null) {
            $builder = new ContainerBuilder();
            $env = getenv('ENV') ?: 'production';
            if ($env === 'production') {
                $builder->enableDefinitionCache(FilesystemCache::class);
                $builder->writeProxiesToFile(true, 'tmp/proxies');
            }
            $builder->addDefinitions($this->definition);
            foreach ($this->modules as $module) {
                if ($module::DEFINITIONS) {
                    $builder->addDefinitions($module::DEFINITIONS);
                }
            }
            $this->container = $builder->build();
        }
        
        return $this->container;
    }

    private function getMiddleware()
    {
        if (array_key_exists($this->index, $this->middlewares)) {
            if (is_string($this->middlewares[$this->index])) {
                $middleware = $this->container->get($this->middlewares[$this->index]);
            } else {
                $middleware = $this->middlewares[$this->index];
            }
            
            $this->index++;
            return $middleware;
        }
        return null;
    }

    /**
     * Get liste des modules
     *
     * @return  array
     */
    public function getModules()
    {
        return $this->modules;
    }
}
