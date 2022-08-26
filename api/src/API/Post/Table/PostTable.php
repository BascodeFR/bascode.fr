<?php
namespace cavernos\bascode_api\API\Post\Table;

use cavernos\bascode_api\Framework\Database\PaginatedQuery;
use Pagerfanta\Pagerfanta;
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
     * @param  int $perPage
     * @return Pagerfanta
     */
    public function findPaginated(int $perPage, int $currentPage): Pagerfanta
    {
        $query = new PaginatedQuery(
            $this->pdo,
            'SELECT * FROM posts',
            'SELECT COUNT(id) FROM posts'
        );
        return (new Pagerfanta($query))
        ->setMaxPerPage($perPage)
        ->setCurrentPage($currentPage);
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
