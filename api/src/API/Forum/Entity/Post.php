<?php
namespace cavernos\bascode_api\API\Forum\Entity;

use DateTime;

class Post
{

    public $id;

    public $name;

    public $slug;
    
    public $created_by;
    
    public $created_at;
    
    public $updated_at;

    public $total_messages;

    public function __construct()
    {
        if ($this->created_at) {
            $this->created_at = new DateTime($this->created_at);
        }

        if ($this->updated_at) {
            $this->updated_at = new DateTime($this->updated_at);
        }
    }
}
