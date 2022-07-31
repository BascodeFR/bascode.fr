<?php

namespace cavernos\bascode_api\Helpers;

use PDO;

/**
 * PDO est une classe qui permet de générer la connexion à la bdd MySQL
 * 
 * @package cavernos\bascode_api
 * @author Cavernos <louisdescavernes@gmail.com>
 * @version 1.0
 * @access private
 * 
 */
class PDOHelpers{    
    /**
     * getPDO Renvoie une instance de PDO
     *
     * @param  string $dbName
     * @param  string $host
     * @param  string $user
     * @param  string $password
     * @param  array $attributes
     * @return PDO
     */
    public static function getPDO(string $dbName, string $host,string $user, string $password, array $attributes) : PDO{
        return new PDO('mysql:dbname='.$dbName.';host='.$host, $user, $password, $attributes);
        
    }
}