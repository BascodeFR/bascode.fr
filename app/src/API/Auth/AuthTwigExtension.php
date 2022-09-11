<?php
namespace cavernos\bascode_api\API\Auth;

use cavernos\bascode_api\Framework\Auth;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AuthTwigExtension extends AbstractExtension
{

    private $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('current_user', [$this->auth, 'getUser']),
        ];
    }
}
