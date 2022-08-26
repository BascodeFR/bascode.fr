<?php
namespace cavernos\bascode_api\API\Post\Table;

use PDO;
use stdClass;

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
     * @return stdClass[]
     */
    public function findPaginated(): array
    {
        return $this->pdo
                ->query("SELECT * FROM posts ORDER BY created_at DESC LIMIT 10")
                ->fetchAll();
    }
    
    /**
     * find Récupère un article à partir de son id
     *
     * @param  int $id
     * @return stdClass
     */
    public function find(int $id): stdClass
    {
        $query = $this->pdo->prepare("SELECT * FROM posts WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query->fetch();
    }
}
