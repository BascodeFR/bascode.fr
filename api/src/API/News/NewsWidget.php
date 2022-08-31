<?php
namespace cavernos\bascode_api\API\News;

use cavernos\bascode_api\API\Admin\AdminWidgetInterface;
use cavernos\bascode_api\API\News\Table\NewsTable;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use Pagerfanta\Pagerfanta;

class NewsWidget implements AdminWidgetInterface, NewsWidgetInterface
{
    
    /**
     * renderer
     *
     * @var RendererInterface
     */
    private $renderer;
    
    /**
     * newsTable
     *
     * @var NewsTable
     */
    private $newsTable;
    
    public function __construct(RendererInterface $renderer, NewsTable $newsTable)
    {
        $this->renderer = $renderer;
        $this->newsTable = $newsTable;
    }

    public function render(): string
    {
        $count = $this->newsTable->count();
        return $this->renderer->render('@news/admin/widget', compact('count'));
    }

    public function renderMenu(): string
    {
        return $this->renderer->render('@news/admin/menu');
    }

    public function renderHome(Pagerfanta $news): string
    {
        return $this->renderer->render('@news/home/index', compact('news'));
    }

    public function renderLink(): string
    {
        return $this->renderer->render('@news/home/link');
    }
}
