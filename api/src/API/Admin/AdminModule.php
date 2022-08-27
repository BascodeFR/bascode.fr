<?php
namespace cavernos\bascode_api\API\Admin;

use cavernos\bascode_api\Framework\Module;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;

class AdminModule extends Module
{

    const DEFINITIONS = __DIR__ . '/config.php';

    public function __construct(RendererInterface $renderer)
    {
        $renderer->addPath('admin', __DIR__ . '/views');
    }
}
