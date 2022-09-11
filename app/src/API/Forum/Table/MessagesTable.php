<?php
namespace cavernos\bascode_api\API\Forum\Table;

use cavernos\bascode_api\API\Forum\Entity\Messages;
use cavernos\bascode_api\API\Forum\Entity\Post;
use cavernos\bascode_api\Framework\Database\Table;

class MessagesTable extends Table
{
    
    protected $table = 'posts';

    protected $entity = Messages::class;
}
