<?php

namespace cavernos\bascode_api;

use cavernos\bascode_api\Helpers\Bases;
use cavernos\bascode_api\Helpers\QueryBuilder;
use PDO;
/**
 * API est la class qui permet de faire fonctionner l'API
 * 
 * @package cavernos\bascode_api\Helpers
 * @author Cavernos <louisdescavernes@gmail.com>
 * @version 1.0
 * @access private
 * 
 */

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
    
    /**
     * getPostWithParams
     *
     * @param  int $limit
     * @param  string $order
     * @param  string $field
     * @return string
     */
    public function getPostWithParams(int $limit, string $order, string $field): string{
        $query = $this->sql->from('post')->orderBy($field, $order)->limit($limit)->toSQL();
        $result = $this->pdo->query($query);
        $json  = $result->fetchAll(PDO::FETCH_OBJ);
        return Bases::toJSON($json);
    }

    
    /**
     * getPostsWithOrderBy
     *
     * @param  string $field
     * @param  string $value
     * @return string
     */
    public function getPostsWithOrderBy(string $field, $value): string{
        $query = $this->sql->from('post')->orderBy($field, $value)->toSQL();
        $result = $this->pdo->query($query);
        $json  = $result->fetchAll(PDO::FETCH_OBJ);
        return Bases::toJSON($json);
    }
    
    /**
     * getPostsWithLimit
     *
     * @param  int $value
     * @return void
     */
    public function getPostsWithLimit(int $value): string{
        $query = $this->sql->from('post')->limit($value)->toSQL();
        $result = $this->pdo->query($query);
        $json  = $result->fetchAll(PDO::FETCH_OBJ);
        return Bases::toJSON($json);
    }
    
    /**
     * getSlug
     *
     * @param  int $id
     * @return string
     */
    public function getSlug(int $id): string{
            $result = $this->sql
            ->from('post')
            ->setParam('id', $id)
            ->where('id = :id')
            ->fetch($this->pdo, 'slug');
            $json  = $result;
            return Bases::toJSON($json);

    }
    
    /**
     * getMessages
     *
     * @param  int $postId
     * @param  string $field
     * @param  string $order
     * @param  int $limit
     * @return string
     */
    public function getMessages(int $postId, string $field, string $order, int $limit): string{
        $query = $this->pdo->prepare("SELECT *
        FROM post_messages pm
        JOIN messages m on pm.message_id = m.id
        WHERE pm.post_id = :id ORDER BY $field $order LIMIT $limit
        ");
        $query->execute(['id' => $postId]);
        $result = $query->fetchAll();
        $json  = $result;
        return Bases::toJSON($json);

    }

}