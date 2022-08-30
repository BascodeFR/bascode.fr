<?php
namespace cavernos\bascode_api\Framework\Renderer;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRenderer implements RendererInterface
{
    
    /**
     * twig
     *
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
    
    /**
     * addPath ajoute le chemin vers les vues
     *
     * @param  string $namespace
     * @param  string $path
     * @return void
     */
    public function addPath(string $namespace, ?string $path = null): void
    {
        $this->twig->getLoader()->addPath($path, $namespace);
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
        $this->twig->addGlobal($key, $value);
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
        return $this->twig->render($view . '.twig', $params);
    }

    /**
     * Get twig
     *
     * @return  Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }
}
