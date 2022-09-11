<?php
namespace cavernos\bascode_api\Framework\Database;

use cavernos\bascode_api\API\Post\Entity\Post;
use Pagerfanta\Adapter\AdapterInterface;
use PDO;

class PaginatedQuery implements AdapterInterface
{
    
    
    /**
     * query
     *
     * @var Query
     */
    private $query;

    
    /**
     * __construct
     *
     * @param  Query $query
     * @return void
     */
    public function __construct(Query $query)
    {
        $this->query = $query;
    }
    
    /**
     * getNbResults
     *
     * @return int
     */
    public function getNbResults(): int
    {
        return $this->query->count();
    }

    public function getSlice(int $offset, int $length): QueryResult
    {
        $query = clone $this->query;
        return $query->limit($length, $offset)->fetchAll();
    }
}
