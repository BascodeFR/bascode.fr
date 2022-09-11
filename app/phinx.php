<?php
include 'public/index.php';

$migrations = [];
$seeds = [];

foreach ($api->getModules() as $module) {
    if($module::MIGRATIONS){
        $migrations[] = $module::MIGRATIONS;
    }
}

foreach ($api->getModules() as $module) {
    if($module::SEEDS){
        $seeds[] = $module::SEEDS;
    }
}

return
[
    'paths' => [
        'migrations' => $migrations,
        'seeds' => $seeds
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => $api->getContainer()->get('database.host'),
            'name' => $api->getContainer()->get('database.name'),
            'user' => $api->getContainer()->get('database.username'),
            'pass' => $api->getContainer()->get('database.password'),
            'port' => '3306',
            'charset' => 'utf8',
        ],
    ],
    'version_order' => 'creation'
];
