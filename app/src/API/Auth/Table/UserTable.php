<?php
namespace cavernos\bascode_api\API\Auth\Table;

use cavernos\bascode_api\API\Auth\Entity\User;
use cavernos\bascode_api\Framework\Database\Table;

class UserTable extends Table
{

    protected $table = 'users';

    protected $entity = User::class;
}
