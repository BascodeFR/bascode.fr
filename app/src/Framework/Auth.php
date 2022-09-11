<?php
namespace cavernos\bascode_api\Framework;

use cavernos\bascode_api\Framework\Auth\User;

interface Auth
{
    
    /**
     * getUser
     *
     * @return User
     */
    public function getUser(): ?User;
}
