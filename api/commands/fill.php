<?php

use cavernos\bascode_api\Helpers\PDOHelpers;


require dirname(__DIR__) . '/vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

$pdo = PDOHelpers::getPDO('Bascode', '192.168.0.6', 'bascode', 'ELECKBOINMAK', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE messages');
$pdo->exec('TRUNCATE TABLE post_messages');
$pdo->exec('TRUNCATE TABLE actu');
$pdo->exec('TRUNCATE TABLE user');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

$posts =[];
$messages =[];

for($i = 0; $i < 50; $i++){
    $pdo->exec("INSERT INTO post SET name ='{$faker->sentence()}', slug='{$faker->slug}', created_at='{$faker->date} {$faker->time}', author = false, created_by='Cavernos', total_messages='{$faker->randomDigitNotNull}'");
    $posts[] = $pdo->lastInsertId();
}

for($i = 0; $i < 200; $i++){
    $pdo->exec("INSERT INTO messages SET name ='{$faker->sentence()}', created_at='{$faker->date} {$faker->time}', created_by='Cavernos', content ='{$faker->paragraphs(rand(3, 15), true)}'");
    $messages[] = $pdo->lastInsertId();
}

foreach($messages as $m){
    $post = $faker->randomElement($posts, rand(0, count($posts)));
    $pdo->exec("INSERT INTO post_messages SET post_id = $post, message_id = $m");
}
$password = password_hash('test', PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO user SET name = 'Louis', username ='Test', email = 'louisdescavernes@gmail.com', password='{$password}'");
    
