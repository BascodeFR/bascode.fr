<?php
namespace cavernos\bascode_api\API\Forum\Entity;

use DateTime;

class Messages
{

    public $id;
    
    public $user_id;
    
    public $created_at;
    
    public $updated_at;

    public $thread_id;

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
