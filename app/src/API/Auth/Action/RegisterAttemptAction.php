<?php
namespace cavernos\bascode_api\API\Auth\Action;

use cavernos\bascode_api\API\Auth\DatabaseAuth;
use cavernos\bascode_api\Framework\Actions\RouterAwareAction;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\Response\RedirectResponse;
use cavernos\bascode_api\Framework\Router;
use cavernos\bascode_api\Framework\Session\FlashService;
use cavernos\bascode_api\Framework\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface;

class RegisterAttemptAction
{

    public $renderer;

    private $auth;

    private $session;

    private $router;

    use RouterAwareAction;


    public function __construct(
        RendererInterface$renderer,
        DatabaseAuth $auth,
        SessionInterface $session,
        Router $router
    ) {
        $this->session = $session;
        $this->renderer = $renderer;
        $this->auth = $auth;
        $this->router = $router;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $params = $request->getParsedBody();
        $user = $this->auth->register($params);
        if ($user) {
            $path = $this->session->get('auth.redirect') ?:
            $this->router->generateUri('auth.index', ['id' => $user->id]);
            $this->session->delete('auth.redirect');
            return new RedirectResponse($path);
        } else {
            (new FlashService($this->session))->error('Identifiants Invalides');
            return $this->redirect('auth.login');
        }
    }
}
