<?php
namespace cavernos\bascode_api\API\Forum\Table;

use cavernos\bascode_api\API\Forum\Entity\Post;
use cavernos\bascode_api\Framework\Database\PaginatedQuery;
use cavernos\bascode_api\Framework\Database\Query;
use cavernos\bascode_api\Framework\Database\Table;
use Pagerfanta\Pagerfanta;

class PostTable extends Table
{
    
    protected $table = 'posts';

    protected $entity = Post::class;

    public function findPublic(): Query
    {
        return $this->makeQuery()
        ->select('p.*')
        ->order('p.created_at DESC');
    }
    /**public function findIn2Table(int $id, string $table2, string $joinCol)
    {
        $query = $this->pdo->prepare("SELECT $table2.* FROM $this->table
        LEFT JOIN $table2 ON $joinCol = $this->table.id WHERE $this->table.id = :id");
        $query->execute(['id' => $id]);
        if ($this->entity) {
            $query->setFetchMode(PDO::FETCH_CLASS, $this->entity);
        }
        return $query->fetch() ?: null;
    }*/
}
