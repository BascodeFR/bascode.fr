<?php
namespace cavernos\bascode_api\API\News\Table;

use cavernos\bascode_api\API\News\Entity\News;
use cavernos\bascode_api\Framework\Database\Query;
use cavernos\bascode_api\Framework\Database\Table;

class NewsTable extends Table
{
    
    protected $table = 'news';

    protected $entity = News::class;
    
    public function findPublic(): Query
    {
        return $this->makeQuery()
        ->select('n.*', 'u.username', 'u.id')
        ->join("users as u", "u.id = n.user_id")
        ->where('n.created_at < NOW()')
        ->where('n.public = 1')
        ->order('n.created_at DESC');
    }
}
