<?php
namespace cavernos\bascode_api\Framework\Session;

interface SessionInterface
{
    
    /**
     * get Récupération d'une information en Session
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;
    
    /**
     * set Ajout d'une information en Session
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void;

    /**
     * Suppression d'une information en Session
     *
     * @param string $key
     * @return void
     */
    public function delete(string $key): void;
}
