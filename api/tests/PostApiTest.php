<?php

use cavernos\bascode_api\API;
use cavernos\bascode_api\Helpers\Bases;
use cavernos\bascode_api\Helpers\PDOHelpers;
use cavernos\bascode_api\Helpers\QueryBuilder;
use PHPUnit\Framework\TestCase;

class PostApiTest extends TestCase{

    public function getAPI(){
        return new API($this->getPDO(), $this->getBuilder());
    }
    public function getPDO(){
        return PDOHelpers::getPDO('Bascode', '192.168.0.6', 'minecraft', 'mak2Mak!', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    }

    public function getBuilder(){
        return new QueryBuilder();
    }

}
?>