<?php
namespace cavernos\bascode_api\API\Forum;

use cavernos\bascode_api\API\Admin\AdminWidgetInterface;
use cavernos\bascode_api\API\Forum\Table\PostTable;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;

class ForumWidget implements AdminWidgetInterface {

    private RendererInterface $renderer;
    private PostTable $postTable;

    public function __construct(RendererInterface $renderer, PostTable $postTable)
    {

        $this->renderer = $renderer;
        $this->postTable = $postTable;
    }

    public function render(): string
    {
        $count = $this->postTable->count();
        return $this->renderer->render('@forum/admin/widget', compact('count'));
    }

    public function renderMenu(): string
    {
        return $this->renderer->render('@forum/admin/menu');
    }
}