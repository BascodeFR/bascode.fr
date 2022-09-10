<?php
namespace cavernos\bascode_api\API\Auth;

use cavernos\bascode_api\API\Auth\Table\UserTable;
use cavernos\bascode_api\API\Auth\Entity\User as AuthUser;
use cavernos\bascode_api\Framework\Auth;
use cavernos\bascode_api\Framework\Auth\User;
use cavernos\bascode_api\Framework\Database\NoRecordException;
use cavernos\bascode_api\Framework\Session\SessionInterface;

class DatabaseAuth implements Auth
{

    private $userTable;

    private $session;

    private $user;

    public function __construct(UserTable $userTable, SessionInterface $session)
    {
        $this->userTable = $userTable;
        $this->session = $session;
    }

    public function getUser(): ?User
    {
        if ($this->user) {
            return $this->user;
        }
        $userId = $this->session->get('auth.user');
        if ($userId) {
            try {
                $this->user = $this->userTable->find($userId);
                return $this->user;
            } catch (NoRecordException $e) {
                $this->session->delete('auth.user');
                return null;
            }
        }
        return null;
    }

    public function login(string $username, string $password): ?User
    {
        if (empty($username) || empty($password)) {
            return null;
        }

        /** @var AuthUser $user */
        $user = $this->userTable->makeQuery()
            ->where('username = :username OR email =:username')
            ->params(['username' => $username])->fetchOrFail();
        if ($user && password_verify($password, $user->password)) {
            $this->session->set('auth.user', $user->id);
            return $user;
        }
        return null;
    }

    public function logout(): void
    {
        $this->session->delete('auth.user');
    }
}
