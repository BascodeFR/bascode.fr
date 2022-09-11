<?php
namespace cavernos\bascode_api\Framework\Renderer;

interface RendererInterface
{
    /**
     * addPath ajoute le chemin vers les vues
     *
     * @param  string $namespace
     * @param  string $path
     * @return void
     */
    public function addPath(string $namespace, ?string $path = null): void;
    
    /**
     * addGlobal ajoute une variable global a passé à la vue
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function addGlobal(string $key, mixed $value): void;
    
    
    /**
     * render rend la vue spécifié par le chemin
     *
     * @param  string $view
     * @param  array $params
     * @return string
     */
    public function render(string $view, array $params = []): string;
}
