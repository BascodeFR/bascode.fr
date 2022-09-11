<?php

use cavernos\bascode_api\API\News\NewsTwigExtension;
use cavernos\bascode_api\API\News\NewsUpload;
use cavernos\bascode_api\API\News\NewsWidget;

use function DI\add;
use function DI\autowire;
use function DI\get;

return [
    'news.prefix' => '/news',
    'admin.widgets' => add([
        get(NewsWidget::class)
    ]),
    NewsTwigExtension::class => autowire()->constructor(get('admin.widgets')),
];
