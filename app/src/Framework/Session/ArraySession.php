<?php
namespace cavernos\bascode_api\Framework\Session;

class ArraySession implements SessionInterface
{


    private $session = [];
    
    /**
     * get Récupération d'une information en Session
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, $this->session)) {
            return $this->session[$key];
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
        $this->session[$key] = $value;
    }

        
    /**
     * delete Suppression d'une information en Session
     *
     * @param  string $key
     * @return void
     */
    public function delete(string $key): void
    {
        unset($this->session[$key]);
    }
}
