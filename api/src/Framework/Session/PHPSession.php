<?php
namespace cavernos\bascode_api\Framework\Session;

use ArrayAccess;

class PHPSession implements SessionInterface, ArrayAccess
{

    
    /**
     * ensureStarted Assure que la Session est démarée
     *
     * @return void
     */
    private function ensureStarted()
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     * get Récupération d'une information en Session
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $this->ensureStarted();
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }
        return $default;
    }
    
    /**
     * set Ajout d'une information en Session
     *
     * @param  string $key
     * @param  mixed $default
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $this->ensureStarted();
        $_SESSION[$key] = $value;
    }

        
    /**
     * delete Suppression d'une information en Session
     *
     * @param  string $key
     * @return void
     */
    public function delete(string $key): void
    {
        $this->ensureStarted();
        unset($_SESSION[$key]);
    }

    public function offsetExists(mixed $offset): bool
    {
        $this->ensureStarted();
        return array_key_exists($offset, $_SESSION);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->delete($offset);
    }
}
