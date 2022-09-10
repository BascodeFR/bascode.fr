<?php
namespace cavernos\bascode_api\API\Auth;

use cavernos\bascode_api\Framework\Auth\ForbiddenException;
use cavernos\bascode_api\Framework\Response\RedirectResponse;
use cavernos\bascode_api\Framework\Session\FlashService;
use cavernos\bascode_api\Framework\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ForbiddenMiddleware implements MiddlewareInterface
{

    private $loginPath;

    private $session;

    public function __construct(string $loginPath, SessionInterface $session)
    {
        $this->loginPath = $loginPath;
        $this->session = $session;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (ForbiddenException $e) {
            $this->session->set('auth.redirect', $request->getUri()->getPath());
            (new FlashService($this->session))
            ->error('Il est impératif de posséder un compte Administrateur pour voir cette page');
            return new RedirectResponse($this->loginPath);
        }
    }
}
