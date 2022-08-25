<?php
namespace cavernos\bascode_api\Framework\Router;

/**
 * Route représente une route
 *
 * @package cavernos\bascode_api
 * @author Cavernos <louisdescavernes@gmail.com>
 * @version 1.0
 * @access private
 *
 */
class Route
{
    
    /**
     * name
     *
     * @var string
     */
    protected $name;
    
    /**
     * callback
     *
     * @var callable
     */
    protected $callback;
    
    /**
     * params
     *
     * @var string[]
     */
    protected $params;
    
    /**
     * __construct
     *
     * @param  string $name
     * @param  callable|string $callback
     * @param  array $params
     * @return void
     */
    public function __construct(string $name, callable|string $callback, array $params)
    {
        
        $this->name = $name;
        $this->callback = $callback;
        $this->params = $params;
    }

    
        
    /**
     * getName renvoie le nom de la route
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * getCallback renvoie le callback de la route
     *
     * @return callable|string
     */
    public function getCallback(): callable|string
    {
        return $this->callback;
    }
    
    /**
     * getParams renvoie les paramètres de la route
     *
     * @return string[]
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
