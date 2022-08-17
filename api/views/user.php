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
    case 'POST':
        if(!empty($_GET['name']) && isset($_GET["password"]) && !empty($_GET["password"]))
        {
            $name = htmlentities($_GET['name']);
            $password = htmlentities($_GET['password']);
            header('Content-Type: application/json'); 
            echo $api->getUser($name, $password);
        }
        break;
        default:
          // Requête invalide
          header("HTTP/1.0 405 Method Not Allowed");
          break;
}
?>