<?php
namespace cavernos\bascode_api\API\Forum\Table;

use cavernos\bascode_api\API\Forum\Entity\Post;
use cavernos\bascode_api\Framework\Database\Table;

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
}
