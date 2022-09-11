<?php
namespace cavernos\bascode_api\API\Forum\Entity;

use DateTime;

class Post
{

    public $id;

    public $name;

    public $slug;
    
    public $userId;
    
    public $createdAt;
    
    public $updatedAt;

    public $numberOfPosts;

    /**
     * Set the value of createdAt
     *
     * @return  self
     */
    public function setCreatedAt(string $createdAt)
    {
        if (is_string($createdAt)) {
            $this->createdAt = new DateTime($createdAt);
        }
        return $this;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */
    public function setUpdatedAt($updatedAt)
    {
        if (is_string($updatedAt)) {
            $this->updatedAt = new DateTime($updatedAt);
        }
        return $this;
    }
}
