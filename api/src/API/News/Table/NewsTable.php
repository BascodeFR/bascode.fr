<?php
namespace cavernos\bascode_api\API\News\Table;

use cavernos\bascode_api\API\News\Entity\News;
use cavernos\bascode_api\Framework\Database\Table;

class NewsTable extends Table
{
    
    protected $table = 'news';

    protected $entity = News::class;
    
    protected function paginationQuery()
    {
        return  parent::paginationQuery(). " ORDER BY created_at DESC";
    }
}
