<?php

use cavernos\bascode_api\API\News\NewsWidget;

use function DI\add;
use function DI\get;

return [
    'news.prefix' => '/news',
    'admin.widgets' => add([
        get(NewsWidget::class)
    ]),
];
