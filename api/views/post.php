<?php

use cavernos\bascode_api\API;
use cavernos\bascode_api\Helpers\PDOHelpers;
use cavernos\bascode_api\Helpers\QueryBuilder;

 $pdo = PDOHelpers::getPDO('Bascode', '192.168.0.6', 'bascode', 'ELECKBOINMAK', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

$builder = new QueryBuilder();


header('Access-Control-Allow-Origin: *');
$request_method = $_SERVER['REQUEST_METHOD'];
$api = new API($pdo, $builder);

switch($request_method)
{
    case 'GET':
        if(!empty($_GET['id']) && empty($_GET['slug']))
        {
            $id = intval($_GET['id']);
            header('Content-Type: application/json'); 
            echo $api->getPost($id);
        } else if(!empty($_GET['id']) && !empty($_GET['slug'] && intval($_GET['slug']) === 1))
        {
            $id = intval($_GET['id']);
            header('Content-Type: application/json'); 
            echo $api->getSlug($id);
            
        }
        else if(!empty($_GET['limit']) && empty($_GET['field']) && empty($_GET['order']))
        {
            $limit = intval($_GET['limit']);
            header('Content-Type: application/json'); 
            echo $api->getPostsWithLimit($limit);
            
        }
        else if(!empty($_GET['field']) && !empty($_GET['order']) && empty($_GET['limit']) ){
            $field = htmlentities($_GET['field']);
            $order = htmlentities($_GET['order']);
            header('Content-Type: application/json'); 
            echo $api->getPostsWithOrderBy( $field , $order);
        }
        else if(!empty($_GET['field']) && !empty($_GET['order']) && !empty($_GET['limit'])){
            $field = htmlentities($_GET['field']);
            $order = htmlentities($_GET['order']);
            $limit = intval($_GET['limit']);
            header('Content-Type: application/json'); 
            echo $api->getPostWithParams($limit,  $order, $field );
        }
        else {
            header('Content-Type: application/json'); 
            echo $api->getPosts();
        }
        break;
        default:
          // Requête invalide
          header("HTTP/1.0 405 Method Not Allowed");
          break;
}
    
?>
