<?php
namespace cavernos\bascode_api\API\Auth\Entity;

use cavernos\bascode_api\Framework\Auth\User as AuthUser;

class User implements AuthUser
{

    public $id;

    public $username;

    public $email;

    public $password;

    public $roles;

    public $avatar;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

        /**
     * Get the value of avatar
     */
    public function getThumb()
    {
        if ($this->avatar) {
            ['filename' => $filename, 'extension' => $extension] =pathinfo($this->avatar);
            return '/upload/avatar/'. $filename .'_thumb.' . $extension;
        }
        return null;
    }

    public function getImageURL()
    {
        return '/upload/avatar/'. $this->avatar;
    }
}
