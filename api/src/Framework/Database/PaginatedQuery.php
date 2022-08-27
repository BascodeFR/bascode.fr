<?php
namespace cavernos\bascode_api\Framework\Database;

use cavernos\bascode_api\API\Post\Entity\Post;
use Pagerfanta\Adapter\AdapterInterface;
use PDO;

class PaginatedQuery implements AdapterInterface
{
    
        
    /**
     * pdo
     *
     * @var PDO
     */
    private $pdo;
    
    /**
     * query
     *
     * @var string
     */
    private $query;
    
    /**
     * countQuery
     *
     * @var string
     */
    private $countQuery;
    
    /**
     * entity
     *
     * @var string
     */
    private $entity;
    
    /**
     * __construct
     *
     * @param  PDO $pdo
     * @param  string $query Requête qui récupère x résultat
     * @param  string $countQuery requête qui comtpe le nombre de résultat total
     * @param  string $entity
     * @return void
     */
    public function __construct(PDO $pdo, string $query, string $countQuery, string $entity)
    {
        $this->pdo = $pdo;
        $this->query = $query;
        $this->countQuery = $countQuery;
        $this->entity = $entity;
    }
    
    /**
     * getNbResults
     *
     * @return int
     */
    public function getNbResults(): int
    {
        return $this->pdo->query($this->countQuery)->fetchColumn();
    }

    public function getSlice(int $offset, int $length): iterable
    {
        $statement =  $this->pdo->prepare($this->query . ' LIMIT :offset, :length');
        $statement->bindParam('offset', $offset, PDO::PARAM_INT);
        $statement->bindParam('length', $length, PDO::PARAM_INT);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_CLASS, $this->entity);
        return $statement->fetchAll();
    }
}
