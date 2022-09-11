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

    public $public;

    public $createdAt;
    
    public $updatedAt;

    public $userId;
    
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
        if ($this->avatar) {
            ['filename' => $filename, 'extension' => $extension] =pathinfo($this->avatar);
            return '/upload/news/'. $filename .'_thumb.' . $extension;
        }
        return null;
    }

    public function getImageURL()
    {
        return '/upload/news/'. $this->avatar;
    }
}
