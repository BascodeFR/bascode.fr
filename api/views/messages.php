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
        if(!empty($_GET['id']))
        {
            $id = intval($_GET['id']);
            header('Content-Type: application/json'); 
            echo $api->getMessages($id);
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