<?php

namespace cavernos\bascode_api;

use cavernos\bascode_api\Helpers\Bases;
use cavernos\bascode_api\Helpers\QueryBuilder;
use PDO;

class API {
    
    /**
     * pdo
     *
     * @var PDO
     */
    private $pdo;
    
    /**
     * sql
     *
     * @var QueryBuilder
     */
    private $sql;
    
    /**
     * __construct
     *
     * @param  PDO $pdo
     * @param  QueryBuilder $sql
     * @return void
     */
    public function __construct(PDO $pdo, QueryBuilder $sql)
    {
        $this->pdo = $pdo;
        $this->sql = $sql;
    }
    
    /**
     * getPosts Récupère tout les postes dans la base de données
     *
     * @return string
     */
    public function getPosts() : string
    {
        $query = $this->sql->from('post')->toSQL();
        $result = $this->pdo->query($query);
        $json = $result->fetchAll(PDO::FETCH_OBJ);
        return Bases::toJSON($json);
        
    }
    
    /**
     * getPost Récupère un post en fonction de l'id
     *
     * @param  string $id
     * @return string 
     */
    public function getPost(string $id) : string
    {
        $query = $this->sql->from('post')->where('id = '.$id)->toSQL();
        $result = $this->pdo->query($query);
        $json  = $result->fetch(PDO::FETCH_OBJ);
        return Bases::toJSON($json);

    }

    public function getPostWithParams(int $limit, string $order, string $field){
        $query = $this->sql->from('post')->orderBy($field, $order)->limit($limit)->toSQL();
        $result = $this->pdo->query($query);
        $json  = $result->fetchAll(PDO::FETCH_OBJ);
        return Bases::toJSON($json);
    }


    public function getPostsWithOrderBy(string $field, $value){
        $query = $this->sql->from('post')->orderBy($field, $value)->toSQL();
        $result = $this->pdo->query($query);
        $json  = $result->fetchAll(PDO::FETCH_OBJ);
        return Bases::toJSON($json);
    }

    public function getPostsWithLimit($value){
        $query = $this->sql->from('post')->limit($value)->toSQL();
        $result = $this->pdo->query($query);
        $json  = $result->fetchAll(PDO::FETCH_OBJ);
        return Bases::toJSON($json);
    }

    public function getSlug(int $id): string{
            $result = $this->sql
            ->from('post')
            ->setParam('id', $id)
            ->where('id = :id')
            ->fetch($this->pdo, 'slug');
            $json  = $result;
            return Bases::toJSON($json);

    }

}