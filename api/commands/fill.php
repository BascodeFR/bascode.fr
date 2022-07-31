<?php

use cavernos\bascode_api\Helpers\PDOHelpers;
use PDO;

require dirname(__DIR__) . '/vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

$pdo = PDOHelpers::getPDO('Bascode', '192.168.0.6', 'minecraft', 'mak2Mak!', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE actu');
$pdo->exec('TRUNCATE TABLE user');

for($i = 0; $i < 50; $i++){
    $pdo->exec("INSERT INTO post SET name ='{$faker->sentence()}', slug='{$faker->slug}', created_at='{$faker->date} {$faker->time}', created_by='Cavernos', total_messages='{$faker->randomDigitNotNull}'");

}