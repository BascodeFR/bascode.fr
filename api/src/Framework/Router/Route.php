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

    public function __construct(string $name, callable $callback, array $params)
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
     * @return callable
     */
    public function getCallback(): callable
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
