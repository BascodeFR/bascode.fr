<?php
namespace cavernos\bascode_api\Framework\Database;

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
     * __construct
     *
     * @param  PDO $pdo
     * @param  string $query Requête qui récupère x résultat
     * @param  string $countQuery requête qui comtpe le nombre de résultat total
     * @return void
     */
    public function __construct(PDO $pdo, string $query, string $countQuery)
    {
        $this->pdo = $pdo;
        $this->query = $query;
        $this->countQuery = $countQuery;
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
        return $statement->fetchAll();
    }
}
