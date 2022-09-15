<?php
namespace cavernos\bascode_api\API\Auth;

use cavernos\bascode_api\API\Admin\AdminWidgetInterface;
use cavernos\bascode_api\API\Auth\Table\UserTable;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;

class AuthWidget implements AdminWidgetInterface
{

    private $userTable;

    private $renderer;

    public function __construct(RendererInterface $renderer, UserTable $userTable)
    {
        $this->userTable = $userTable;
        $this->renderer = $renderer;
    }

    public function render(): string
    {
        $count = $this->userTable->count();
        return $this->renderer->render('@auth/admin/widget', compact('count'));
    }

    public function renderMenu(): string
    {
        // TODO
        return '';
    }
}
