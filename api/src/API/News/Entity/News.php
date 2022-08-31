<?php
namespace cavernos\bascode_api\API\News\Entity;

use DateTime;

class News
{

    public $id;

    public $name;

    public $slug;
    
    public $avatar;

    public $content;

    public $createdAt;
    
    public $updatedAt;

    public function __construct()
    {
        if ($this->created_at) {
            $this->created_at = new DateTime($this->created_at);
        }

        if ($this->updated_at) {
            $this->updated_at = new DateTime($this->updated_at);
        }
    }

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
