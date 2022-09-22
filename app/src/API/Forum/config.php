<?php

use cavernos\bascode_api\API\Forum\ForumWidget;
use function DI\get;

return [
    'forum.prefix' => '/forum',
    "admin.widgets" => [
        get(ForumWidget::class)
    ]
];
