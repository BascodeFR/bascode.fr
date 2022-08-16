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
        if(!empty($_GET['id']) && !empty($_GET['field']) && !empty($_GET['order']) && !empty($_GET['limit']))
        {
            $id = intval($_GET['id']);
            $field = htmlentities($_GET['field']);
            $order = htmlentities($_GET['order']);
            $limit = intval($_GET['limit']);
            header('Content-Type: application/json'); 
            echo $api->getMessages($id, $field, $order, $limit);
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