<?php
namespace cavernos\bascode_api;

use AltoRouter;

/**
 * Router est une classe qui permet de personnaliser les router AltoRouter
 * 
 * @package cavernos\bascode_api
 * @author Cavernos <louisdescavernes@gmail.com>
 * @version 1.0
 * @access private
 * 
 */
class Router{
    
        
    /**
     * @var string
     */
    private $viewPath;    

    /**
     * @var AltoRouteur
     */
    private $routeur;

    
    /**
     * __construct
     *
     * @param  string $view
     * @return void
     */
    public function __construct(string $viewPath){
        $this->viewPath = $viewPath;
        $this->routeur = new AltoRouter();
    }
      
    /**
     * get va rechercher l'url demandé en fonction de la route
     *
     * @param  string $url
     * @param  string $view
     * @param  ?string $name = null
     * @return self
     */
    public function get(string $url, string $view, ?string $name = null): self{
        $this->routeur->map('GET', $url,  $view, $name);
        return $this;

    }
    
    /**
     * run va recherché le fichier et le charger.
     *
     * @return self
     */
    public function run() : self
    {
        $match = $this->routeur->match();
        $view = $match['target'];
        if(is_callable($view)){
            call_user_func_array($view, $match['params']);
        } else{
            $params = $match['params'];
            require $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php';
        }
        return $this;
    }

}
