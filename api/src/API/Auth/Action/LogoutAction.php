<?php
namespace cavernos\bascode_api\API\Auth\Action;

use cavernos\bascode_api\API\Auth\DatabaseAuth;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\Response\RedirectResponse;
use cavernos\bascode_api\Framework\Session\FlashService;
use Psr\Http\Message\ServerRequestInterface;

class LogoutAction
{

    private $auth;

    private $flashService;


    public function __construct(DatabaseAuth $auth, FlashService $flashService)
    {
        $this->auth = $auth;
        $this->flashService = $flashService;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $this->flashService->success('Déconnexion réussi avec succès');
        $this->auth->logout();
        return new RedirectResponse('/');
    }
}
