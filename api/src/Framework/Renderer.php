<?php
namespace cavernos\bascode_api\Framework;

use cavernos\bascode_api\Framework\Renderer\RendererInterface;

class Renderer implements RendererInterface
{


    const DEFAULT_NAMESPACE = '__MAIN';
    
    /**
     * paths
     *
     * @var array
     */
    private $paths = [];

    
    /**
     * globals
     *
     * @var array
     */
    private $globals = [];
    
    /**
     * addPath ajoute le chemin vers les vues
     *
     * @param  string $namespace
     * @param  string $path
     * @return void
     */
    public function addPath(string $namespace, ?string $path = null): void
    {
        if (is_null($path)) {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        } else {
            $this->paths[$namespace] = $path;
        }
    }
    
    /**
     * addGlobal ajoute une variable global a passé à la vue
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function addGlobal(string $key, mixed $value): void
    {
        $this->globals[$key] = $value;
    }
    
    
    /**
     * render rend la vue spécifié par le chemin
     *
     * @param  string $view
     * @param  array $params
     * @return string
     */
    public function render(string $view, array $params = []): string
    {
        if ($this->hasNamespace($view)) {
            $path = $this->replaceNamespace($view) . '.php';
        } else {
            $path = $this->paths[self::DEFAULT_NAMESPACE] . DIRECTORY_SEPARATOR . $view . '.php';
        }
        ob_start();
        extract($this->globals);
        extract($params);
        require($path);
        return ob_get_clean();
    }
    
    /**
     * hasNamespace
     *
     * @param  string $view
     * @return bool
     */
    private function hasNamespace(string $view): bool
    {
        return $view[0] ==='@';
    }
    
    /**
     * getNamespace
     *
     * @param  string $view
     * @return string
     */
    private function getNamespace(string $view): string
    {
        return substr($view, 1, strpos($view, '/') - 1);
    }
    
    /**
     * replaceNamespace
     *
     * @param  string $view
     * @return string
     */
    private function replaceNamespace(string $view): string
    {
        $namespace = $this->getNamespace($view);
        return str_replace('@' . $namespace, $this->paths[$namespace], $view);
    }
}
