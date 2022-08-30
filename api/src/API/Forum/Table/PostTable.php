<?php
namespace cavernos\bascode_api\API\Forum\Table;

use cavernos\bascode_api\API\Forum\Entity\Post;
use cavernos\bascode_api\Framework\Database\PaginatedQuery;
use cavernos\bascode_api\Framework\Database\Table;
use Pagerfanta\Pagerfanta;

class PostTable extends Table
{
    
    protected $table = 'posts';

    protected $entity = Post::class;
    
    protected function paginationQuery()
    {
        return  "SELECT posts.*, 
        count(messages.post_id) as 
        number_of_messages from posts 
        left join messages 
        on (messages.post_id = posts.id) group by posts.id";
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

    public function findPaginatedPublic(int $perPage, int $currentPage)
    {
        $query = new PaginatedQuery(
            $this->getPdo(),
            "SELECT m.* FROM messages as m JOIN posts ON m.post_id = posts.id WHERE posts.id = 1",
            "SELECT count(messages.post_id) 
            from posts 
            left join messages 
            on (messages.post_id = posts.id) WHERE posts.id = 1",
            $this->entity
        );
        return (new Pagerfanta($query))
        ->setMaxPerPage($perPage)
        ->setCurrentPage($currentPage);
    }
}
