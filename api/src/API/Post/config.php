<?php

use cavernos\bascode_api\API\Post\PostModule;

use function DI\autowire;
use function DI\get;

return [
    'post.prefix' => '/forum',
    PostModule::class => autowire()->constructorParameter('prefix', get('post.prefix'))
];
