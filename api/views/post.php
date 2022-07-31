<?php

use cavernos\bascode_api\API;
use cavernos\bascode_api\Helpers\PDOHelpers;
use cavernos\bascode_api\Helpers\QueryBuilder;

 $pdo = PDOHelpers::getPDO('Bascode', '192.168.0.6', 'minecraft', 'mak2Mak!', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

header('Content-Type: application/json'); 
$api = new API($pdo, new QueryBuilder());
if (array_key_exists("id", $params)) { 
    $p = explode('/', $params['id']);
    if($p[0] === 'desc' ||  $p[0] === 'asc'){
        echo $api->getPostsWithOrderBy($p[0]);
    }
    if($p[1]){
        $p[0] == "";
        echo $api->getPostsWithLimit($p[1]);
    }
    /*if($p[0]){
        echo $api->getPost($p[0]);
    }*/
} else {
   echo $api->getPosts();
}
    
?>
