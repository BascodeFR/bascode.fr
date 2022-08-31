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

    /**
     * Get the value of avatar
     */
    public function getThumb()
    {
        return '/upload/news/'. $this->avatar;
    }
}
