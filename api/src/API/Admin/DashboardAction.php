<?php
namespace cavernos\bascode_api\API\Admin;

use cavernos\bascode_api\Framework\Renderer\RendererInterface;

class DashboardAction
{
    
    /**
     * renderer
     *
     * @var RendererInterface
     */
    private $renderer;
    
    /**
     * widgets
     *
     * @var AdminWidgetInterface[]
     */
    private $widgets;

    public function __construct(RendererInterface $renderer, array $widgets)
    {
        $this->renderer = $renderer;
        $this->widgets = $widgets;
    }

    public function __invoke()
    {
        $widgets = array_reduce($this->widgets, function (string $html, AdminWidgetInterface $widget) {
            return $html . $widget->render();
        }, '');
        return $this->renderer->render('@admin/dashboard', compact('widgets'));
        ;
    }
}
