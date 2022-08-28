<?php
namespace cavernos\bascode_api\Framework\Session;

class FlashService
{
    
    /**
     * session
     *
     * @var SessionInterface
     */
    private $session;

    private $sessionKey = 'flash';

    private $message = null;
    
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function success(string $message)
    {
        $this->session->get($this->sessionKey, []);
        $flash['success'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }

    public function error(string $message)
    {
        $this->session->get($this->sessionKey, []);
        $flash['error'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }

    public function get(string $type): ?string
    {

        if (is_null($this->message)) {
            $this->message = $this->session->get($this->sessionKey, []);
            $this->session->delete($this->sessionKey);
        }
       
        if (array_key_exists($type, $this->message)) {
            return $this->message[$type];
        }
        return null;
    }
}
