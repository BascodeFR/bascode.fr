<?php
namespace Cavernos\BascodeFR;

use AltoRouter;

/**
 * Router
 */
class Router {
        
    /**
     * viewPath
     *
     * @var string
     */
    private $viewPath;
    
    /**
     * router
     *
     * @var AltoRouter
     */
    private $router;
    
    /**
     * __construct
     *
     * @param  string $viewPath
     * @return void
     */
    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new AltoRouter();
    }

    
    /**
     * get
     *
     * @param  string $url
     * @param  string $view
     * @param  string $name ?? null
     * @return self
     */
    public function get(string $url, string $view, ?string $name = null) :self{
        $this->router->map('GET', $url, $view, $name);
        return $this;
    }
    
    /**
     * run
     *
     * @return self
     */
    public function run() : self{
        $match = $this->router->match();
        $view = $match['target'];
        require $this->viewPath . DIRECTORY_SEPARATOR . $view;
        return $this;
    }
}