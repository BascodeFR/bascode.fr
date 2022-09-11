<?php

use cavernos\bascode_api\API\Admin\AdminModule;
use cavernos\bascode_api\API\Admin\AdminTwigExtension;
use cavernos\bascode_api\API\Admin\DashboardAction;

use function DI\add;
use function DI\autowire;
use function DI\get;

return [

    'admin.prefix' => '/admin',
    'admin.widgets' => [],
    AdminTwigExtension::class => autowire()->constructor(get('admin.widgets')),
    AdminModule::class => autowire()->constructorParameter('prefix', get('admin.prefix')),
    DashboardAction::class => autowire()->constructorParameter('widgets', get('admin.widgets')),
];
