<?php
namespace cavernos\bascode_api\API\Forum\Table;

use cavernos\bascode_api\API\Forum\Entity\Post;
use cavernos\bascode_api\Framework\Database\PaginatedQuery;
use Pagerfanta\Pagerfanta;
use PDO;

class PostTable
{
    
    /**
     * pdo
     *
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
       
    /**
     * findPaginated Pagine les articles
     *
     * @param  int $perPage
     * @return Pagerfanta
     */
    public function findPaginated(int $perPage, int $currentPage): Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->pdo,
            'SELECT * FROM posts ORDER BY created_at DESC',
            'SELECT COUNT(id) FROM posts',
            Post::class
        );
        return (new Pagerfanta($query))
        ->setMaxPerPage($perPage)
        ->setCurrentPage($currentPage);
    }
    
    /**
     * find Récupère un article à partir de son id
     *
     * @param  int $id
     * @return Post|null
     */
    public function find(int $id): ?Post
    {
        $query = $this->pdo->prepare("SELECT * FROM posts WHERE id = :id");
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, Post::class);
        return $query->fetch() ?: null;
    }
    
    /**
     * update met à jour un enregistrement dans la db
     *
     * @param  int $id
     * @param  array $params
     * @return bool
     */
    public function update(int $id, array $params): bool
    {
        $fieldQuery = $this->buildFieldQuery($params);
        $params["id"] = $id;
        $statement = $this->pdo->prepare("UPDATE posts SET $fieldQuery WHERE id = :id");
        return $statement->execute($params);
    }

    /**
     * update met à jour un enregistrement dans la db
     *
     * @param  int $id
     * @param  array $params
     * @return bool
     */
    public function insert(array $params): bool
    {
        $fields = array_keys($params);
        $values = array_map(function ($field) {
            return ':' . $field;
        }, $fields);
        $statement = $this->pdo->prepare("INSERT INTO posts 
        (". join(',', $fields).") 
        VALUES 
        (". join(',', $values) .")");
        return $statement->execute($params);
    }
    
    /**
     * delete supprime un enregistrement
     *
     * @param  int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        
        $statement = $this->pdo->prepare("DELETE FROM posts WHERE id = ?");
        return $statement->execute([$id]);
    }
    
    /**
     * buildFieldQuery
     *
     * @param  array $params
     * @return string
     */
    private function buildFieldQuery(array $params): string
    {
        return  join(', ', array_map(function ($field) {
            return "$field = :$field";
        }, array_keys($params)));
    }
}
